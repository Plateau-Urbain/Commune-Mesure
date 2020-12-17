<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;
use App\Place;

class ImpactsController extends Controller
{
    public function show(Place $place)
    {
        $place->build();
        $place->sortPlacesBy('name');
        $compares = $place->getCompares();
        $places = $place->getPlaces();

        return view('impacts.show', compact('places', 'compares'));
    }
}
