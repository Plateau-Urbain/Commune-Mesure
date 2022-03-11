<?php

namespace App\Http\Controllers;

use App\Events\PlaceUpdate;
use App\Models\Place;
use App\Models\Section;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Http\Redirector;

class PlaceController extends Controller
{
    const export = ['image', 'pdf'];

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

        return view('place.show', compact('place', 'sections', 'isEmpty'));
    }

    public function list(Place $place)
    {
        $places = Place::retrievePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        return view('places', compact('places', 'coordinates'));
    }

    public function search(Request $request, Place $place)
    {
        if ($request->filled('q') === false) {
            return response()->json([
                'success' => true, 'count' => 0, 'results' => []
            ]);
        }

        $this->validate($request, [
            'q' => 'required|filled|string|min:1|max:255'
        ]);

        $search_results = Place::search($request->input('q'));
        $search_results->transform(function ($item) {
                $item->url = route('place.show', ['slug' => $item->slug]);
                return $item;
        });

        $response = ['success' => true, 'request' => $request->input('q'), 'count' => count($search_results), 'results' => $search_results];
        return response()->json($response);
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


        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections', 'isEmpty'));
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
