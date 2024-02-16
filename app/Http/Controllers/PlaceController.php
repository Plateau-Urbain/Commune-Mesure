<?php

namespace App\Http\Controllers;

use App\Events\PlaceUpdate;
use App\Models\Place;
use App\Models\PlaceEnvironment;
use App\Models\Section;
use App\Services\Batiment;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Http\Redirector;

class PlaceController extends Controller
{
    const export = ['image', 'pdf'];

    private $batiment;

    public function __construct(Batiment $batiment)
    {
        $this->batiment = $batiment;
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

    public function list(Place $place)
    {
        $paginatedPlaces = Place::retrievePlacesPaginated('latest');

        $places = $paginatedPlaces->map(function ($place, $key) {
            $hasEnvironmentalPart = $place->place_id !== null;
            $place = Place::find($place->slug, false);
            $place["hasEnvironmentalPart"] = $hasEnvironmentalPart;

            return $place;
        });

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        return view('places', compact('places', 'paginatedPlaces', 'coordinates'));
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

        // Pour indiquer à la vue que c'est en mode édition
        $edit = true;

        $batiment = $this->batiment;
        $batiment->init($place);

        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections', 'isEmpty', 'batiment'));
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
