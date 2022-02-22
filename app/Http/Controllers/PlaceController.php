<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Section;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
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

        $type = $request->input('type', null);
        $inputs = $request->all();
        $dirty = [];

        foreach ($inputs as $chemin => $value) {
            if ($chemin === 'type') {
                continue;
            }

            // TODO: ne plus utiliser $hash.
            // TODO: fix espaces dans $chemin
            //$to_edit = $place->get(str_replace('__', '->', $chemin));
            $to_edit = $place->get(urldecode($hash));

            if ($type === 'select') {
                $dirty = (array) $to_edit;
                array_walk($dirty, function (&$v) {
                    $v = 0;
                });

                $dirty[$value] = 1;
                $dirty = (object) $dirty;
            } elseif (is_array($to_edit)) {
                $dirty = array_values(array_filter(array_unique($value), 'strlen'));
            } elseif (is_object($to_edit)) {
                $dirty = array_merge((array) $to_edit, array_filter($value, 'strlen'));

                if ($type === 'checkbox') {
                    array_walk($dirty, function (&$v) {
                        $v = ($v === "on") ? 1 : 0;
                    });
                }

                $dirty = (object) $dirty;
            } else {
                $dirty = $value;
            }

            $place->set(urldecode($hash), $dirty);
        }

        $place->save();

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

        $insee = $place->blocs->data_territoire->donnees->insee;
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
