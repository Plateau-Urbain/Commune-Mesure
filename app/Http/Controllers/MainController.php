<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        $places = $place->withPopup()->build();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        $stats = $place->getStats();
        $popup = $place->getPopup();

        return view('home', compact('coordinates', 'stats', 'popup'));
    }
}
