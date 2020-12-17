<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Place
{
    const STAT_CITIES = "cities";
    const STAT_SURFACE = "surface";
    const STAT_EVENTS = "evenements";
    const STAT_ETP = "etp";
    const STAT_VISITORS = "visiteurs";

    protected $stats = [
        self::STAT_SURFACE => 0,
        self::STAT_EVENTS => 0,
        self::STAT_ETP => 0,
        self::STAT_VISITORS => 0
    ];
    protected $cities = [];
    protected $places = [];
    protected $withPopup = false;
    protected $popup = [];

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
                'data->data->compare as compare', 'data->surface as surface', 'data->evenements as evenements',
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
        $this->stats[self::STAT_CITIES] = count($this->cities);
        return $this->stats;
    }

    public function getPopup()
    {
        return $this->popup;
    }

    public function getCompares($places){
      $compare_data = [];
      $compare_place_name = [];
      $compare_title = [
        "moyens"=>[],
        'realisations'=>[]
      ];

      foreach ($places->first()->compare as $key => $value) {
        foreach ($value as $k => $v) {
          $compare_title[$key][$k] = $v->title;
        }
      }

      foreach ($places as $place) {
        $compare_data[$place->name] = $place->compare;
        $compare_place_name[$place->name] = $place->name;
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
        $places = $this->getList();

        $places->transform(function ($item, $key) {
            $item->tags = json_decode($item->tags);
            $item->photos = json_decode($item->photos);
            $item->evenements = json_decode($item->evenements);
            $item->compare = json_decode($item->compare);
            return $item;
        });


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

            $this->stats[self::STAT_SURFACE] += $place->surface;
            $this->stats[self::STAT_EVENTS] += ($place->evenements->prives->nombre + $place->evenements->publics->nombre);
            $this->stats[self::STAT_ETP] += ($place->compare) ? $place->compare->moyens->etp->nombre : 0;
            $this->stats[self::STAT_VISITORS] += ($place->evenements->prives->nombre_visiteurs + $place->evenements->publics->nombre_visiteurs);
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
}
