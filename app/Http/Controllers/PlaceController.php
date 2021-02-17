<?php

namespace App\Http\Controllers;

use App\Place;
use App\Models\Place as PlaceModel;
use App\Models\Section;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function show($slug)
    {
        $place = (new Place())->getOne($slug);

        if ($place === false) {
            abort(404);
        }

        $place->slug = $slug;
        $sections = PlaceModel::where('place', $slug)->with('sections')->firstOrFail()->sections()->pluck('visible', 'section');

        $this->sortDataInsee($place);

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        return view('place.show', compact('place', 'sections'));
    }

    public function list(Place $place, $sortBy = null)
    {
        $places = $place->getList();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        if(isset($sortBy)){
          $place->sortNumericPlacesBy($sortBy);
          $selected = explode('-', $sortBy)[1];
        }else{
          $place->sortPlacesBy('name');
          $selected = "default_az";
        }

        return view('places', compact('places', 'coordinates', 'selected'));
    }

    public function edit($slug, $auth)
    {
        $place = new Place();

        if ($place->check($slug, $auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $place = $place->getOne($slug);

        if ($place === false) {
            abort(404);
        }

        $this->sortDataInsee($place);
        $sections = PlaceModel::where('place', $slug)->with('sections')->firstOrFail()->sections()->pluck('visible', 'section');

        // Pour indiquer à la vue que c'est en mode édition
        $edit = true;

        return view('place.show', compact('place', 'auth', 'slug', 'edit', 'sections'));
    }

    /**
     * Toggle visibility of a section
     *
     * @param Request $request The request
     * @param string $slug The place name sluggified
     * @param string $auth The authentication string
     * @param string $section The section name
     *
     * @return Response
     */
    public function toggle(Request $request, $slug, $auth, $section)
    {
        $place = new Place();

        if ($place->check($slug, $auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $place_id = PlaceModel::where('place', $slug)->value('id');

        $s = Section::where('section', $section)->firstOrFail();
        $visibility = $s->places()->where('place_id', $place_id)->value('visible');
        $s->places()->updateExistingPivot($place_id, [
            'visible' => ! $visibility
        ]);

        $res = $s->save();

        $flash = ['success' => $res, 'section' => $section];

        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$section);
    }


    protected function sortDataInsee($place){
        //Sort insee object data on each zone map
        $insee = $place->data->insee;
        foreach ($insee as $zone => $datas) {
            foreach ($datas as $key => $data) {
                $inseeDataArray = (array) $data;
                usort($inseeDataArray, function($a, $b) {
                    return strcasecmp($a->title, $b->title);
                });
                $place->data->insee->{$zone}->{$key} = $inseeDataArray;
            }
        }
    }

    protected function sortComposition($composition){
      $compositionArray = (array) $composition;
      $keys = array_keys($compositionArray);
      usort($compositionArray, function($a, $b)
      {
        if ($a->nombre == $b->nombre) {
            return 0;
        }
        return ($a->nombre > $b->nombre) ? -1 : 1;


      });
      return (object)$compositionArray;
    }
}
