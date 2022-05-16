<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;
use App\Models\Place;

class LabController extends Controller
{
    public function show(Place $place)
    {
        $places = Place::retrievePlaces();
        $compares = $place->getCompares($places);
        return view('lab.show', compact('places', 'compares'));
    }
}
