<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Place
{
    protected $storage;
    protected $coordinates = [];
    protected $cities = [];
    protected $places = [];
    protected $withPopup = false;
    protected $meters = [];
    protected $etp = [];
    protected $evenements = [];
    protected $visiteurs = [];
    protected $popup = [];

    public function __construct()
    {
        $this->storage = getenv('STORAGE_PATH').'places/';
    }

    public function all()
    {
        $this->build();
        $totalmeters = array_sum($this->meters);
        $total_etp = array_sum($this->etp);
        $total_evenements = array_sum($this->evenements);
        $total_visiteurs= array_sum($this->visiteurs);
        return [$this->coordinates, $this->cities, $this->places,$totalmeters,$total_etp,$total_evenements,$total_visiteurs];
    }

    public function getAll()
    {
        $json = $this->getList();

        $json->transform(function ($item, $key) {
            $item->tags = json_decode($item->tags);
            $item->photos = json_decode($item->photos);
            return $item;
        });

        return $json;
    }

    public function getOne($slug)
    {
        $place = DB::table('places')
                    ->select('data')
                    ->where('deleted_at', null)
                    ->where('place', $slug)
                    ->value('data');

        if ($place === null) {
            return false;
        }

        return json_decode($place);
    }

    public function getList()
    {
        $places = DB::table('places')
            ->select('place as url', 'data->name as name', 'data->tags as tags',
                'data->geo->lat as lat', 'data->geo->lon as lon',
                'data->description as description', 'data->photos as photos',
                'data->address->city as city', 'data->address->postalcode as postalcode')
            ->where('deleted_at', null)
            ->get();

        return $places;
    }

    public function getCoordinates($place)
    {
        return [$place->url => ['geo' => ['lat' => $place->lat, 'lon' => $place->lon]]];
    }

    public function getStats()
    {
        $s = [];
        $s['cities'] = $this->getCities();
        $s['surface'] = $this->getMeters();
        $s['etp'] = $this->getETP();
        $s['evenements'] = $this->getEvents();
        $s['visiteurs'] = $this->getVisiteurs();

        return $s;
    }

    public function getPopup()
    {
        return $this->popup;
    }

    public function getCities()
    {
        return $this->cities;
    }

    public function getPlaces()
    {
        return $this->places;
    }

    public function getMeters()
    {
        return $this->meters;
    }
    public function getETP()
    {
        return $this->etp;
    }
    public function getEvents()
    {
        return $this->evenements;
    }
    public function getVisiteurs()
    {
        return $this->visiteurs;
    }

    public function getCompares(){
      $compare_data = [];
      $compare_place_name = [];
      $compare_title = [
        "moyens"=>[],
        'realisations'=>[]
      ];
      foreach ($this->places[0]->data->compare as $key => $value) {
        foreach ($value as $k => $v) {
          $compare_title[$key][$k] = $v->title;
        }
      }
      foreach ($this->places as $place) {

        $compare_data[$place->name] = $place->data->compare;
        $compare_place_name[$place->name] = $place->title;

      }
      $compares= [
        "data" => $compare_data,
        "titles" => $compare_title,
        "names" => $compare_place_name

    ];
      return $compares;
    }

    public function withPopup()
    {
        $this->withPopup = true;
        return $this;
    }

    public function build()
    {
        $places = $this->getAll();

        foreach ($places as $place) {
            if ($this->withPopup) {
                $popup = str_replace(["\r\n", "\n", '  '], '',
                    view('components/popup', ['name' => $place->url, 'title' => $place->name, 'description' => $place->description, 'departement' => $place->postalcode, 'city' => $place->city, 'images' => $place->photos])->render()
                );

                $this->popup[$place->url] = $popup;
            }

            $this->cities[$place->city][]= [
              "title" => $place->url,
            ];

            /* if (property_exists($json->data, 'compare')) { */
            /*     array_push($this->etp, $json->data->compare->moyens->etp->nombre); */
            /* } */

            /* if (property_exists($json, 'surface')) { */
            /*     array_push($this->meters, $json->surface); */
            /* } */

            /* $total = $json->evenements->publics->nombre + $json->evenements->prives->nombre; */
            /* if (property_exists($json, 'evenements')) { */
            /*     array_push($this->evenements, $total); */
            /* } */

            /* $total = $json->evenements->publics->nombre_visiteurs + $json->evenements->prives->nombre_visiteurs; */
            /* if (property_exists($json, 'evenements')) { */
            /*     array_push($this->visiteurs, $total); */
            /* } */

        }
        return $places;
    }

    public function sortCities()
    {
        ksort($this->cities);
        return $this;
    }

    public function sortPlacesBy(string $what = 'name')
    {
        usort($this->places, function($a, $b) use ($what) {
            if (strcasecmp($a->$what, $b->$what) === 0) {
                return 0;
            }
            return (strcasecmp($a->$what, $b->$what) < 0) ? -1 : 1;
        });
    }

    public function sortNumericPlacesBy(string $what = 'moyens-etp')
    {

        usort($this->places, function($a, $b) use ($what) {
          $q = explode("-", $what);

            if ($a->data->compare->{$q[0]}->{$q[1]}->nombre === $b->data->compare->{$q[0]}->{$q[1]}->nombre) {
                return 0;
            }
            return ($a->data->compare->{$q[0]}->{$q[1]}->nombre < $b->data->compare->{$q[0]}->{$q[1]}->nombre) ? -1 : 1;
        });
    }

    protected function getJson($place)
    {
        $json = json_decode(file_get_contents($place));

        if ($json === null) {
            throw new \LogicException("Invalid json : $place", 1);
        }

        if (property_exists($json->address, 'city') === false){
            throw new \LogicException("'La ville n'existe pas' in $place", 1);
        }

        if(property_exists($json, 'data') === false){
            throw new \LogicException("'Les données sont inexistantes.' in $place", 1);
        }

        return $json;
    }
}
