<?php

namespace App\Http\Controllers;

use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;

class PlaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function show($slug)
    {
        $json = getenv('STORAGE_PATH').'places/'.$slug.'.json';
        if (! file_exists($json)) {
            abort(404);
        }

        $file = getenv('STORAGE_PATH').'sentences.json';
        $sentences = json_decode(file_get_contents($file));

        if(get_class($sentences) !== "stdClass"){
          throw new \Exception("Invalid json $file", 1);

        }

        $place = json_decode(file_get_contents($json));

        $plots[] = (new PopulationChart('chart-pop', 'radar'))->build(
            (array) $place->data->population
        );

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        $plots[] = (new ActivitiesChart('chart-activities', 'polarArea'))->build(
            (array) $place->data->activites
        );

        $plots[] = (new ActivitiesChart('chart-activities2', 'doughnut'))->build(
            (array) $place->data->activites
        );

        $plots[] = (new PopulationChart('chart-pop-bar', 'bar'))->build(
           (array) $place->data->population
        );
        $plots[] = (new LogementChart('chart-logement-radar', 'doughnut'))->build(
           (array) $place->data->logement
        );
        $plots[] = (new ActivitiesOverlayChart('chart-overlay', 'bar'))->build(
           (array) [$place->data->population, $place->data->population]
        );
        return view('place.show', compact('place', 'plots', 'sentences'));
    }
}
