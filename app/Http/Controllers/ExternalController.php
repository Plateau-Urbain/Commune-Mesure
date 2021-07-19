<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    public function chiffres(Place $place)
    {
        $places= $place->retrivePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        $stats = $place->getStats();

        $popup = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getInfoPopup($item);
        });

        return view('chiffres_iframe', compact('coordinates', 'stats'));
    }

}
