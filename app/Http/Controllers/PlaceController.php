<?php

namespace App\Http\Controllers;

use App\Charts\PopulationChart;
use App\Charts\ActivitiesChart;
use App\Charts\ActivitiesOverlayChart;
use App\Charts\LogementChart;
use App\Place;

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
        $place = (new Place())->getOne($slug);
        if ($place === false) {
            abort(404);
        }
        $place->slug = $slug;


        //Sort insee object data on each zone map
        $insee = $place->data->insee;
        foreach ($insee as $zone => $datas) {
          foreach ($datas as $key => $data) {
            $place->data->insee->{$zone}->{$key} = $this->sortDataInsee($data);
          }
        }

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
        /* $plots[] = (new ActivitiesOverlayChart('chart-overlay', 'bar'))->build( */
        /*    (array) [$place->data->population, $place->data->population] */
        /* ); */
        return view('place.show', compact('place', 'plots'));
    }

    protected function sortDataInsee($inseeData){
      $inseeDataArray = (array) $inseeData;
      $keys = array_keys($inseeDataArray);
      usort($inseeDataArray, function($a, $b)
      {
        return strcasecmp($a->title, $b->title);
      });
      return (object)$inseeDataArray;
    }

    protected function sortComposition($composition){
      $compositionArray = (array) $composition;
      $keys = array_keys($compositionArray);
      usort($compositionArray, function($a, $b)
      {
        if ($a->nombre == $b->nombre) {
            return 0;
        }
        return ($a->nombre > $b->nombre) ? -1 : 1;


      });
      return (object)$compositionArray;
    }
}
