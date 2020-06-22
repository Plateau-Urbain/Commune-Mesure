<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;

class ImpactsController extends Controller
{
  public function show(){
      [$coordinates,$cities, $places] = MainController::getAllPlaces();

      return view('impacts.show', compact('coordinates', 'cities', 'places'));
  }

  public function statistics(){
      [$coordinates,$cities, $places] = MainController::getAllPlaces();
      $plots[] = (new ActivitiesOverlayChart('chart-overlay', 'bar'))->build(
         (array) [$cities['Paris'][0]['data_chart']->population, $cities['Paris'][1]['data_chart']->population]
      );
      return view('impacts.statistics', compact('coordinates', 'cities', 'plots', 'places'));
  }

  public function datas(){
      [$coordinates,$cities, $places] = MainController::getAllPlaces();
      return view('impacts.datas', compact('coordinates', 'cities', 'places'));
  }

}
