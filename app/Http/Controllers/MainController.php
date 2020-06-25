<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        [$coordinates,$cities] = $place->withPopup()->all();
        return view('home', compact('coordinates', 'cities'));
    }

    public function places(Place $place)
    {
        [$coordinates,$cities] = $place->all();
        return view('places', compact('coordinates', 'cities'));
    }
}
