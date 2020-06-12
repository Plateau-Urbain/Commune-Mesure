<?php

namespace App\Http\Controllers;

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

        $plots = [];
        foreach ($place->data->population as $label => $value) {
            $tranche = explode("_", $label, 2);
            if (count($tranche) === 2) {
                [$sex, $age] = $tranche;
                $plots["population"][$sex][$age] = $value;
                ksort($plots["population"][$sex]);
            }
        }
        if(property_exists($place->data, 'activites') === true)
          //throw new \LogicException("Pas de données sur les activitiés. Verifiez le json.", 1);
          $plots["activites"] = get_object_vars($place->data->activites);

        return view('place.show', compact('place', 'plots'));
    }
}
