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

        return view('chiffres_iframe', compact('coordinates', 'stats'));
    }
}
