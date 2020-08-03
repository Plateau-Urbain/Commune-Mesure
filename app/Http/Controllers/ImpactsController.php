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
        $resiliences = $place->getResiliences();
        $places = $place->getPlaces();

        //[$coordinates,$cities, $places] = $place->all();

        return view('impacts.show', compact('places', 'resiliences'));
    }

    public function statistics(Place $place)
    {
        [$coordinates,$cities, $places] = $place->all();
        return view('impacts.statistics', compact('coordinates', 'cities', 'places'));
    }

    public function datas(Place $place)
    {
        [$coordinates,$cities, $places] = $place->all();
        return view('impacts.datas', compact('coordinates', 'cities', 'places'));
    }
}
