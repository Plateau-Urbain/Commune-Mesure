<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Events\PlaceUpdate;
use App\Models\Place;
use App\Models\PlaceEnvironment;
use App\Models\Region;
use App\Models\Section;
use App\Services\Batiment;
use App\Services\PlaceService;
use App\Services\TypeformUpdateService;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Lumen\Http\Redirector;
use Symfony\Component\Console\Output\BufferedOutput;

class PlaceController extends Controller
{
    const export = ['image', 'pdf'];

    private $batiment;
    private $placeService;
    private $typeformUpdateService;

    public function __construct(Batiment $batiment, PlaceService $placeService, TypeformUpdateService $typeformUpdateService)
    {
        $this->batiment = $batiment;
        $this->placeService = $placeService;
        $this->typeformUpdateService = $typeformUpdateService;
    }

    public function show($slug)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->isPublish() === false) {
            return view('place.unpublished', compact('place'));
        }

        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();
        $this->sortDataInsee($place->getData());

        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();
        $hasEnvironmentalPart = $placeEnvironment !== null;

        $batiment = $this->batiment;
        $batiment->init($place);

        return view('place.show', compact('place', 'sections', 'isEmpty', 'batiment', 'hasEnvironmentalPart'));
    }

    public function list(Place $place, Request $request)
    {
        $query = DB::table('places')
        ->select('places.place as slug', 'place_environment.place_id')
        ->leftJoin('place_environment', function ($join) {
            $join->on('places.id', '=', 'place_environment.place_id');
        })
        ->where('places.deleted_at', null);

        if ($request->has('location') && $request->location != '') {
            $location = $request->location;
            if (strpos($location, 'region_') === 0) {
                // Filtrer par région
                $regionId = str_replace('region_', '', $location);
                $departements = Departement::where('region_id', $regionId)->get();
                $query->where(function($query) use ($departements) {
                    foreach ($departements as $departement) {
                        $query->orWhereBetween('zipcode', [$departement->zipcode_start, $departement->zipcode_end]);
                    }
                });
            } elseif (strpos($location, 'departement_') === 0) {
                // Filtrer par département
                $departementId = str_replace('departement_', '', $location);
                $departement = Departement::find($departementId);
                if ($departement) {
                    $query->whereBetween('zipcode', [$departement->zipcode_start, $departement->zipcode_end]);
                }
            }
        }

        // Filtre sur lieux qui ont une partie environnementale
        if ($request->has('environmental') && $request->environmental !== null) {
            $query->whereNotNull('place_id');
        }

        // Filtre sur lieux qui ont une partie impact social
        if ($request->has('social_effect') && $request->social_effect !== null) {
            $query->where('places.data', 'LIKE', '%"impact_social"%');
        }

        $query->orderBy("places.created_at", 'desc');

        $paginatedPlaces = $query->paginate(80)->appends($request->all());

        $places = $paginatedPlaces->map(function ($place, $key) use ($request) {
            $hasEnvironmentalPart = $place->place_id !== null;
            $place = Place::find($place->slug, false);
            $place["hasEnvironmentalPart"] = $hasEnvironmentalPart;

            return $place;
        });

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        // Récupérer toutes les régions et départements pour les filtres
        $regions = Region::all();
        $departements = Departement::all();

        return view('places', compact('places', 'paginatedPlaces', 'coordinates', 'regions', 'departements'));
    }

    public function edit($slug, $auth)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();
        $this->sortDataInsee($place->getData());

        if (env('APP_DEBUG')) {
            Debugbar::debug($place->getData());
        }

        $edit = true;

        $batiment = $this->batiment;
        $batiment->init($place);

        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();
        $hasEnvironmentalPart = $placeEnvironment !== null;

        $questionAnswer = $this->placeService->getCleanedTypeformQuestionForPlace($place);
        $placeData = $place->getData();
        if (isset($placeData->activites) && is_array($placeData->activites)) {
            $activitesArray = [];
            foreach ($questionAnswer["activites"] as $key => $activite) {
                $questionAnswer["activites"][$key]["answer"] = 'Non';

                if (in_array($key, $placeData->activites)) {
                    $questionAnswer["activites"][$key]["answer"] = 'Oui';
                }
            }
        }

        if (isset($placeData->blocs->valeurs->donnees)) {
            $donnees = (array)$placeData->blocs->valeurs->donnees;

            $enabledValues = array_keys(
                array_filter($donnees, function($v) {
                    return $v == 1;
                })
            );

            $questionAnswer['valeurs']['Accueil']['answer'] = implode(', ', $enabledValues);
            $questionAnswer['valeurs']['Accueil']['choices'] = (array)$placeData->blocs->valeurs->donnees;
        }

        if (isset($placeData->blocs->accessibilite->donnees->transports)) {
            $donnees = (array)$placeData->blocs->accessibilite->donnees->transports;

            $enabledValues = array_keys(
                array_filter($donnees, function($v) {
                    return $v == 1;
                })
            );

            $questionAnswer['accessibilite']['transports->Bus']['answer'] = implode(', ', $enabledValues);
            $questionAnswer['accessibilite']['transports->Bus']['choices'] = (array)$placeData->blocs->accessibilite->donnees->transports;
        }

        if (isset($placeData->blocs->accessibilite->donnees->publics)) {
            $donnees = (array)$placeData->blocs->accessibilite->donnees->publics;

            $enabledValues = array_keys(
                array_filter($donnees, function($v) {
                    return $v == 1;
                })
            );

            $questionAnswer['accessibilite']['publics->Chercheurs d\'emplois']['answer'] = implode(', ', $enabledValues);
            $questionAnswer['accessibilite']['publics->Chercheurs d\'emplois']['choices'] = (array)$placeData->blocs->accessibilite->donnees->publics;
        }


        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections', 'isEmpty', 'batiment', 'hasEnvironmentalPart', 'questionAnswer'));
    }


    public function updateGeneral(Request $request, $slug, $auth, $hash, $id_section = null)
    {
        $place = Place::find($slug);
        if ($place === false) {
            abort(404);
        }
        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }
        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }
        $this->validate($request, [
            'id' => 'required|filled|string|min:1|max:255'
        ]);
        $requestData = $request->all();
        $dataKey = $this->typeformUpdateService->getFirstKey($requestData);
        $data = json_decode(json_encode($place->getData()), true);
        $questionAnswer = $this->placeService->getCleanedTypeformQuestionForPlace($place, $requestData["id"]);

        if (!isset($questionAnswer["title"])) {
            throw new \Exception('Question not found');
        }

        // Activités
        if (strpos($dataKey, 'blocs__activites__donnees') === 0) {
            $label = substr($dataKey, strrpos($dataKey, '__') + 2);

            if (!isset($data['activites'])) {
                $data['activites'] = [];
            }

            if ($requestData[$dataKey] === 'Yes' || $requestData[$dataKey] === true || $requestData[$dataKey] === 1) {
                if (!in_array($label, $data['activites'])) {
                    $data['activites'][] = $label;
                }
            } else {
                $key = array_search($label, $data['activites']);
                if ($key !== false) {
                    unset($data['activites'][$key]);
                    $data['activites'] = array_values($data['activites']);
                }
            }
            $result = true;
        }
        elseif (strpos($dataKey, 'blocs__valeurs__donnees') === 0) {
            $values = array_keys($requestData[$dataKey]);
            foreach($data['blocs']['valeurs']['donnees'] as $valeur => $val) {
                $data['blocs']['valeurs']['donnees'][$valeur] = 0;
                if (in_array($valeur, $values)) {
                    $data['blocs']['valeurs']['donnees'][$valeur] = 1;
                }
            }
            $result = true;
        }
        elseif (strpos($dataKey, 'blocs__accessibilite__donnees__publics') === 0) {
            $values = array_keys($requestData[$dataKey]);
            foreach($data['blocs']['accessibilite']['donnees']['publics'] as $public => $val) {
                $data['blocs']['accessibilite']['donnees']['publics'][$public] = 0;
                if (in_array($public, $values)) {
                    $data['blocs']['accessibilite']['donnees']['publics'][$public] = 1;
                }
            }
            $result = true;
        }
        elseif (strpos($dataKey, 'blocs__accessibilite__donnees__transports') === 0) {
            $values = array_keys($requestData[$dataKey]);
            foreach($data['blocs']['accessibilite']['donnees']['transports'] as $transport => $val) {
                $data['blocs']['accessibilite']['donnees']['transports'][$transport] = 0;
                if (in_array($transport, $values)) {
                    $data['blocs']['accessibilite']['donnees']['transports'][$transport] = 1;
                }
            }
            $result = true;
        }
        elseif(strpos($dataKey, 'blocs__evenements__donnees') === 0) {
            $value = $requestData[$dataKey];
            $dbKey = str_replace('donnees__', '', $dataKey);
            $dbKey = str_replace('blocs__', '', $dbKey);
            $dbKey = str_replace('personnes_accueillies', 'personnes accueillies', $dbKey);
            $this->typeformUpdateService->updateArrayValueWithKeys($data, $dbKey, $value);
            $result = true;
        } else {
            $result = $this->typeformUpdateService->handleUpdate($requestData, $data, $questionAnswer, $dataKey, $this->placeService);
        }

        if ($result) {
            $place->setData(json_encode($data));
            $place->save();
        } else {
            throw new \Exception('Question key does not exists');
        }
        $sections = $place->getVisibility();
        $isEmpty = $place->getIsEmpty();
        $this->sortDataInsee($place->getData());

        $batiment = $this->batiment;
        $batiment->init($place);

        $edit = true;

        $placeEnvironment = PlaceEnvironment::where('place_id', $place->getId())->first();
        $hasEnvironmentalPart = $placeEnvironment !== null;

        return redirect(route('place.edit', compact('place', 'auth', 'slug', 'edit', 'sections', 'isEmpty', 'batiment', 'hasEnvironmentalPart', 'questionAnswer')) . ($id_section ? ('#' . $id_section) : ''));
    }

    /**
     * Toggle visibility of a section
     *
     * @param Request $request The request
     * @param string $slug The place name sluggified
     * @param string $auth The authentication string
     * @param string $section The section name
     *
     * @return RedirectResponse|Redirector
     */
    public function toggle(Request $request, $slug, $auth, $section)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $place->toggleVisibility($section);
        $res = $place->save();

        $flash = ['success' => $res, 'section' => $section];
        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$section);
    }

    public function update(Request $request, $slug, $auth, $hash, $id_section)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $validateAgainst = $place->getValidator($request->all(), $hash);
        $this->validate($request, $validateAgainst);

        $old = $place->get(urldecode($hash));
        $new = $place->updateData($hash, $request->all());
        $place->save();

        Event::dispatch(new PlaceUpdate($place, urldecode($hash), $old, $new));

        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
    }

    public function updateLatLon(Request $request, $slug, $auth, $id_section)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $this->validate($request, [
            'lat' => 'required|string',
            'lon' => 'required|string',
        ]);

        $requestData = $request->all();
        foreach ($requestData as $key => $value) {
            $path = 'blocs->data_territoire->donnees->geo->'.$key;
            $old = $place->get($path);
            $new = $place->updateData($path, [$value]);

            Event::dispatch(new PlaceUpdate($place, urldecode($path), $old, $new));
        }
        $place->save();

        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
    }

    public function updateAddress(Request $request, $slug, $auth, $id_section)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $this->validate($request, [
            'address' => 'required|string',
            'city' => 'required|string',
            'postalcode' => 'required|string',
        ]);

        $requestData = $request->all();
        foreach ($requestData as $key => $value) {
            $path = 'address->'.$key;
            $old = $place->get($path);
            $new = $place->updateData($path, [$value]);

            Event::dispatch(new PlaceUpdate($place, urldecode($path), $old, $new));
        }

        $output = new BufferedOutput();
        try {
            Artisan::call('iris:load', [
                'adresse' => $requestData['address']." ".$requestData['city'],
                'code_postal' => $requestData['postalcode']
            ], $output);

            $placeData = $place->getData();
            $placeData->blocs->data_territoire->donnees = json_decode($output->fetch());
            $place->setData(json_encode($placeData), true);
            $place->zipcode = $requestData['postalcode'];
            $place->save();
        } catch (\Exception $e) {
            throw new \Exception('Error during address update : ' . $e->getMessage());
        }

        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$id_section);
    }

    public function publish(Request $request, $slug, $auth)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $place->set('publish', !$place->get('publish'));
        $place->save();
        return redirect(route('place.edit', compact('slug', 'auth')));
    }

    /**
     * @param $to string image|pdf
     *
     */
    public function export(Request $request, $slug, $to = 'image')
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->isPublish() === false) {
            return view('place.unpublished', compact('place'));
        }

        if (in_array($to, self::export) === false) {
            abort(400, 'Export type not supported');
        }

        $file = $place->export($to);

        return Storage::download($file);
    }

    public function jsonToCsv(Request $request, $slug, $auth)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        header("Content-type: text/csv");
        header("Content-disposition: attachment; filename =".$slug.".csv");

        $csv = fopen('php://output', 'w');
        fputcsv($csv, ['url', 'nom', 'clé', 'valeur']);

        foreach ($place->exportCsv($auth) as $line) {
            fputcsv($csv, $line);
        }

        fclose($csv);
        exit;
    }

    protected function sortDataInsee($place)
    {
        //Sort insee object data on each zone map
        if (property_exists($place->blocs, 'data_territoire') === false) {
            return;
        }

        $insee = $place->blocs->data_territoire->donnees->insee ?? [];
        foreach ($insee as $zone => $datas) {
            foreach ($datas as $key => $data) {
                $inseeDataArray = (array) $data;
                usort($inseeDataArray, function ($a, $b) {
                    return strcasecmp($a->title, $b->title);
                });
                $place->blocs->data_territoire->donnees->insee->{$zone}->{$key} = $inseeDataArray;
            }
        }
    }

    protected function sortComposition($composition)
    {
        $compositionArray = (array) $composition;
        $keys = array_keys($compositionArray);
        usort($compositionArray, function ($a, $b) {
            if ($a->nombre == $b->nombre) {
                return 0;
            }
            return ($a->nombre > $b->nombre) ? -1 : 1;
        });
        return (object)$compositionArray;
    }
}
