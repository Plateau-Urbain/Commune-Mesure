<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        $place->withPopup()->build();
        $coordinates = $place->getCoordinates();
        $cities = $place->getCities();
        $places = $place->getPlaces();
        $total_surface = $place->getMeters();
        $total_etp = $place->getETP();

        return view('home', compact('coordinates', 'cities', 'total_surface','total_etp'));
    }

    public function places(Place $place, $sortBy = null)
    {
        $place->build();

        if(isset($sortBy)){
          $place->sortNumericPlacesBy($sortBy);
          $selected = explode('-', $sortBy)[1];
        }else{
          $place->sortPlacesBy('name');
          $selected = "default_az";
        }

        $places = $place->getPlaces();
        $coordinates = $place->getCoordinates();

        return view('places', compact('coordinates', 'places', 'selected'));
    }
}
