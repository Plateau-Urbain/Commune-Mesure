<?php

namespace App\Http\Controllers;

use App\Place;
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


        //Sort insee object data on each zone map
        $insee = $place->data->insee;
        foreach ($insee as $zone => $datas) {
          foreach ($datas as $key => $data) {
            $place->data->insee->{$zone}->{$key} = $this->sortDataInsee($data);
          }
        }

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        return view('place.show', compact('place'));
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

        return view('place.edit', compact('place', 'auth', 'slug'));
    }

    public function update(Request $request, $slug, $auth)   //écrire la fonction qui met à jour le lieu
    {

      $placeClient = new Place();

      if ($placeClient->check($slug, $auth) === false) {
          abort(403, 'Wrong authentication string');
      }

      if ($auth === str_repeat('a', 64)) {
          throw new \LogicException('Exiting, default admin hash');
      }

      $place = $placeClient->getOne($slug);

      $json_field =$request->json_field;
      if(!strpos($json_field, 'show')){
        $place->$json_field->show = !$place->$json_field->show;
      }
      else{
        $place->$json_field=!$place->$json_field;
      }
      $result=$placeClient->save($slug,$place);

      if($result==0){
        echo('Pas de modif');
      }
      if($result==1){
        echo('Modification prise en compte');
      }
      else{
        echo('Problème');
      }
      return redirect()->route('place.edit', compact('slug', 'auth'));
    }


    protected function sortDataInsee($inseeData){
      $inseeDataArray = (array) $inseeData;
      $keys = array_keys($inseeDataArray);
      usort($inseeDataArray, function($a, $b)
      {
        return strcasecmp($a->title, $b->title);
      });
      return (object)$inseeDataArray;
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
