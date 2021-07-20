<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    public function chiffres(Place $place)
    {
        $coordinates = Place::retrievePlaces();
        $stats = $place->getStats();

        $partial = 'partials.external.chiffres';
        $params = compact('coordinates', 'stats');

        return view('iframe_layout', compact('partial', 'params'));
    }

    public function map(Place $place)
    {
        $places= Place::retrievePlaces();

        $coordinates = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getCoordinates($item);
        });

        $popup = $places->mapWithKeys(function ($item, $key) use ($place) {
            return $place->getInfoPopup($item);
        });

        $partial = 'partials.external.map';
        $params = compact('coordinates', 'popup');

        return view('iframe_layout', compact('partial', 'params'));
    }
}
