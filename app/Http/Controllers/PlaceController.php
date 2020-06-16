<?php

namespace App\Http\Controllers;

use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;

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
        $json = getenv('STORAGE_PATH').$slug.'.json';
        if (! file_exists($json)) {
            abort(404);
        }

        $place = json_decode(file_get_contents($json));

        $plots['population'] = (new PopulationChart())->build(
            (array) $place->data->population
        );

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        $plots["activites"] = (new ActivitiesChart())->build(
            (array) $place->data->activites
        );

        return view('place.show', compact('place', 'plots'));
    }
}
