<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;

class StatisticController extends Controller
{
  public function places(){
      [$coordinates,$cities] = MainController::getAllPlaces();
      $plots[] = (new ActivitiesOverlayChart('chart-overlay', 'bar'))->build(
         (array) [$cities['Paris'][0]['data_chart']->population, $cities['Paris'][1]['data_chart']->population]
      );
      return view('statistics', compact('coordinates', 'cities', 'plots'));
  }
}
