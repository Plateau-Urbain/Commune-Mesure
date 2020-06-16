<?php

namespace App\Http\Controllers;

use App\Charts\PopulationChart;

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

        $pop = new PopulationChart();
        $pop->build((array) $place->data->population);
        $plots['population'] = $pop;

        if(property_exists($place->data, 'activites') === false) {
            throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
        }

        $plots["activites"] = get_object_vars($place->data->activites);

        return view('place.show', compact('place', 'plots'));
    }
}
