<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        [$coordinates,$cities,$meters, $totalmeters,$total_etp,$total_events,$total_visiteurs] = $place->withPopup()->all();
        return view('home', compact('coordinates', 'cities','meters','totalmeters','total_etp','total_events','total_visiteurs'));
    }

    public function places(Place $place)
    {
        [$coordinates,$cities] = $place->all();
        return view('places', compact('coordinates', 'cities'));
    }
}
