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
}
