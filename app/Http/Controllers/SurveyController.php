<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;
use App\Place;

class SurveyController extends Controller
{
    public function show(Place $place)
    {
      $file = getenv('STORAGE_PATH').'sentences.json';
      $sentences = json_decode(file_get_contents($file));

      if(get_class($sentences) !== "stdClass"){
        throw new \Exception("Invalid json $file", 1);

      }
        [$coordinates,$cities, $places] = $place->all();
        return view('documentation', compact('coordinates', 'cities', 'places', 'sentences'));
    }



}
