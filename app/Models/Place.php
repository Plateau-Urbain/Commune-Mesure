<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class Place extends Model
{
    public $incrementing = false;
    private $place;
    protected $keyType = 'string';

    public function sections()
    {
        return $this->belongsToMany(Section::class)->withTimestamps()->withPivot('visible');
    }

    public function find($slug)
    {
        $place = DB::table('places')
                    ->select('data')
                    ->where('deleted_at', null)
                    ->where('place', $slug)
                    ->value('data');
        if ($place === null) {
            return false;
        }
        $this->place=json_decode($place);
        return $this->place;
    }
    public function setPlace($place){
      $this->place = $place;
    }

    public function getPlace(){
      return $this->place;
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
          $p->setPlace($place);
          $array_place[] = $p;
      }

      return $places;
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

  public static function setValueByChemin($place,$chemin,$newValue){
    if(is_array(self::getValueByChemin($place,$chemin))){
       throw new Exception('Not Implemented');
    }
    return (self::getHeadObjectChemin($place,$chemin)->{self::getLastChemin($chemin)}= $newValue);
  }
}
