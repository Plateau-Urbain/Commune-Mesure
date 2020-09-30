<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        [$coordinates,$cities,$meters, $totalmeters,$total_etp] = $place->withPopup()->all();
        return view('home', compact('coordinates', 'cities','meters','totalmeters','total_etp'));
    }

    public function places($slug = null, Place $place)
    {
        [$coordinates] = $place->all();
        if(isset($slug)){
          $place->sortNumericPlacesBy($slug);
          $selected = explode('-', $slug)[1];
        }else{
          $place->sortPlacesBy('name');
          $selected = "default_az";
        }

        $places = $place->getPlaces();

        return view('places', compact('coordinates', 'places', 'selected'));
    }
}
