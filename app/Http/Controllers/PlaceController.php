<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Section;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function show($slug)
    {
        $place = Place::find($slug);

        if ($place === false) {
            abort(404);
        }

        if ($place->isPublish() === false) {
            return view('place.unpublished', compact('place'));
        }

        $sections = $place->getSections();
        $this->sortDataInsee($place->getData());

        return view('place.show', compact('place', 'sections'));
    }

    public function list(Place $place, $sortBy = null)
    {
        $places = $place->list();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        // if(isset($sortBy)){
        //   $place->sortNumericPlacesBy($sortBy);
        //   $selected = explode('-', $sortBy)[1];
        // }else{
        //   $place->sortPlacesBy('name');
        //   $selected = "default_az";
        // }

        return view('places', compact('places', 'coordinates'));
    }

    public function edit($slug, $auth)
    {
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        if ($place === false) {
            abort(404);
        }

        $sections = $place->getSections();
        $this->sortDataInsee($place->getData());

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
        $place = Place::find($slug);

        if ($place->check($auth) === false) {
            abort(403, 'Wrong authentication string');
        }

        if ($auth === str_repeat('a', 64)) {
            throw new \LogicException('Exiting, default admin hash');
        }

        $s = $place->toggleVisibility($section);
        $res = $s->save();

        $flash = ['success' => $res, 'section' => $section];
        return redirect(route('place.edit', compact('slug', 'auth')).'#'.$section);
    }

    public function update(Request $request,$slug,$auth){
       $place = Place::find($slug);

       if ($place->check($auth) === false) {
         abort(403, 'Wrong authentication string');
       }
       if ($auth === str_repeat('a', 64)) {
           throw new \LogicException('Exiting, default admin hash');
       }

       $place->set($request->chemin,$request->champ);

       $place->save();

       return redirect(route('place.edit', compact('slug', 'auth')));
    }

    public function publish(Request $request,$slug,$auth){
      $place = Place::find($slug);
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
