<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function map(Place $place)
    {
        $places= Place::retrievePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        $stats = $place->getStats();

        $popup = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getInfoPopup($item);
        });

        return view('home', compact('coordinates', 'stats', 'popup'));
    }

    public function search(Request $request, Place $place)
    {
        $search = $request->input('q', null);
        return view('search', compact('search'));
    }
}
