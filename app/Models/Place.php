<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class Place extends Model
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
    public $incrementing = false;

    protected $keyType = 'string';
    protected $popup = [];
    protected $cities = [];
    protected $places = [];
    protected $withPopup = false;

    private $data;
    private $slug;

    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps()->withPivot('visible');
    }

    public static function find($slug)
    {
        $db = DB::table('places')
                    ->select('place as slug', 'data')
                    ->where('deleted_at', null)
                    ->where('place', $slug)
                    ->first();

        if ($db === null) {
            return false;
        }

        $place = new Place();
        $place->setSlug($db->slug);
        $place->setData(json_decode($db->data));

        return $place;
    }

    public function list(){
      $places = DB::table('places')
          ->select('place as url', 'data->name as name', 'data->tags as tags',
              'data->geo->lat as lat', 'data->geo->lon as lon',
              'data->data->compare as compare', 'data->surface as surface', 'data->evenements as evenements',
              'data->description as description', 'data->photos as photos',
              'data->address->city as city', 'data->address->postalcode as postalcode','data->publish as publish')
          ->where('deleted_at', null)
          ->get();


      $array_place = [];
      foreach($places as $place){
          $p = new Place();
          $p->setData($place);
          $array_place[] =$p;
      }

      $return = collect($array_place);
      return $return;
    }

    public function setData($data){
      $this->data = $data;
    }

    public function getData(){
      return $this->data;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug(){
      return $this->slug;
    }

    public function getCoordinates($place)
    {
        return [$place->url => ['geo' => ['lat' => $place->lat, 'lon' => $place->lon]]];
    }


    public function getAuth($place = null)
    {
        $query = DB::table('places');

        if ($place) {
            $query->where('place', $place);
        }

        return $query->pluck('hash_admin', 'place');
    }

    public function getSections()
    {
        return self::where('place', $this->slug)->with('sections')->firstOrFail()->sections()->pluck('visible', 'section');
    }

    public function get($chemin)
    {
        return self::getValueByChemin($this->getData(), $chemin);
    }

    public function isPublish()
    {
        return $this->data->publish;
    }


    public static function getValueByChemin($place,$chemin){
      $array=explode("->", $chemin);
      $result=$place;
      foreach ($array as $champ){
        $hash = preg_replace("/\[[0-9]+\]$/", "", $champ);
        if(!isset($result->$hash)){
          return;
        }
        $result=$result->$hash;
        if(preg_match("/\[([0-9]+)\]$/", $champ, $matches)) {
           $result=$result[$matches[1]];
        }
      }
      if(is_array($result)) {
        foreach ($result as $key => $value) {
          if(is_object($value)){
            return $result;
          }
        }
        return implode("\n", $result);
      }
      return $result;
  }

  public static function getHeadObjectChemin($place,$chemin){
    $array=explode('->',$chemin);
    $result=$place;
    for($i=0 ; $i < count($array)-1; $i++){
      $result=$result->{$array[$i]};
    }
    return $result;
  }

  public static function getLastChemin($chemin){
    $array=explode('->',$chemin);
    return ($array[count($array)-1]);
  }

  public function set($chemin,$newValue){
    if(is_array($this->get($chemin))){
       throw new Exception('Not Implemented');
    }
    return (self::getHeadObjectChemin($this->getData(),$chemin)->{self::getLastChemin($chemin)}= $newValue);
  }

  public function check($auth)
  {
      $place = DB::table('places')->select('hash_admin')
                                  ->where('place', $this->getSlug())
                                  ->first();

      return $place->hash_admin === $auth;
  }

  public function getId(){
    return Place::where('place', $this->getSlug())->value('id');
  }

  public function toggleVisibility($section){
    $place_id = $this->getId();
    $s = Section::where('section', $section)->firstOrFail();
    $visibility = $s->places()->where('place_id', $place_id)->value('visible');
    $s->places()->updateExistingPivot($place_id, [
        'visible' => ! $visibility
    ]);
    return $s;
  }

  public function save(array $options = Array()){
    $result = DB::table('places')
        ->where('place', $this->getSlug())
        ->update(array('data'=>json_encode($this->getData())));
    return $result;
  }

  public function getPopup()
  {
      return $this->popup;
  }

  public function withPopup()
  {
      $this->withPopup = true;
      return $this;
  }

  public function build()
  {
      $places = $this->list();
      // var_dump($places);
      // exit;
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

  public function getStats()
  {
      $this->stats[self::STAT_CITIES] = count($this->cities);
      return $this->stats;
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

}
