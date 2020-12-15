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
        $total_evenements = $place ->getEvents();
        $total_visiteurs = $place->getVisiteurs();

        return view('home', compact('coordinates', 'cities', 'total_surface','total_etp','total_evenements','total_visiteurs'));
    }
}
