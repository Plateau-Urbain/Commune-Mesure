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

    public static function retrivePlaces(){
      $places = DB::table('places')
          ->select('place as slug')
          ->where('deleted_at', null)
          ->get();

      $array_place = [];
      foreach($places as $place){
          $p = self::find($place->slug);
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
        return [$place->getSlug() => ['geo' => ['lat' => $place->get('blocs->data_territoire->donnees->geo->lat'), 'lon' => $place->get('blocs->data_territoire->donnees->geo->lon')]]];
    }

    public function getStats(){

      $places = $this->retrivePlaces();

      foreach($places as $place){
        $this->cities[$place->get('address->city')][]= [ "title" => $place->getSlug(),];
        $this->stats[self::STAT_SURFACE] += $place->get('blocs->presentation->donnees->surface');
        $this->stats[self::STAT_EVENTS] +=  ($place->get('evenements->prives->nombre') + $place->get('evenements->publics->nombre'));
        $this->stats[self::STAT_ETP] += ($place->get('blocs->presentation->donnees->etp')) ? $place->get('blocs->presentation->donnees->etp') : 0 ;
        $this->stats[self::STAT_VISITORS] += ($place->get('evenements->prives->nombre_visiteurs') + $place->get('evenements->publics->nombre_visiteurs'));
        $this->stats[self::STAT_CITIES] = count($this->cities);
      }
      return $this->stats;
    }

    public function withPopup()
    {
        $this->withPopup = true;
        return $this;
    }

    public function getInfoPopup($place)
    {
      if ($place->withPopup()) {
          $popup["name"] = $place->getSlug();
          $popup["title"] = $place ->get("name");
          $popup['description'] = json_encode($place->get('blocs->presentation->donnees->idee_fondatrice'));
          $popup['departement'] = $place->get('address->postalcode');
          $popup['city'] = $place->get('address->city');
          if(count($place->getPhotos()) > 0){
            $popup['images'] = $place->getPhotos()[0];
          }
          else{
            $popup['images'] = "";
          }
          $this->popup[$place->getSlug()] = $popup;
      }
      return $this->popup;

    }

    public function getPhotos(){
      if($this->getData()->blocs->galerie->donnees){
        return $this->getData()->blocs->galerie->donnees;
      }
      return array();
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
        return $result;
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


  public function setOnArray($chemin,$index,$newValue){
    return (self::getHeadObjectChemin($this->getData(),$chemin)->{self::getLastChemin($chemin)}[$index]= $newValue);
  }

  public function set($chemin,$newValue){
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
    $sections = $this->getVisibility();
    $visibility = $sections[$section];
    return !$visibility;

  }

  public function getVisibility(){
    $tabSections = ["presentation","accessibilite","valeurs","moyens","composition","impact_social","data_territoire","galerie"];
    $tabVisibility=array();
    foreach($tabSections as $s){
      $tabVisibility[$s]= $this->get('blocs->'.$s.'->visible');
    }
    return $tabVisibility;
  }


  public function save(array $options = Array()){
    $result = DB::table('places')
        ->where('place', $this->getSlug())
        ->update(array('data'=>json_encode($this->getData())));
    return $result;
  }

  public function addPhoto($newPhoto){
    $photos=$this->getPhotos();
    array_push($photos,$newPhoto);
    $this->set('blocs->galerie->donnees',$photos);
    var_dump($this->getPhotos());
  }

  public function deletePhoto($indexOfPhoto){
    $photos = $this->getPhotos();
    unset($photos[$indexOfPhoto]);
    $photos = array_values($photos);
    $this->set('blocs->galerie->donnees',$photos);
    var_dump($this->getPhotos());
  }


  public function getCompares($places){
    $array_compares = json_decode(json_encode($places->first()->get('blocs->data_territoire->donnees->compare')),true);
    $compare_data = [];
    $compare_place_name = [];
    $compare_title = [
      "moyens"=>[],
      'realisations'=>[]
    ];
    foreach ($array_compares as $key => $value) {
      foreach ($value as $k => $v) {
        $compare_title[$key][$k] = $v['title'];
      }
    }

   foreach ($places as $place) {
      $data = '{"moyens":{"etp":{"nombre":'.
              $place->get('blocs->presentation->donnees->etp').
              ',"title":"Nombre d\'ETP"},"benevole":{"nombre":'.
              $place->get('blocs->moyens->donnees->benevoles').
              ',"title":"Nombre de bénévoles"},"partenaire":{"nombre":'
              . $place->get('blocs->moyens->donnees->partenaires').
              ',"title":"Nombre de partenaires publics / privés"},"superficie":{"nombre":'
              . $place->get('blocs->presentation->donnees->surface').
              ',"title":"Superficie du lieu (m2)"}},"realisations":{"ouverture":{"nombre":'
              .$place->get('blocs->data_territoire->donnees->compare->realisations->ouverture->nombre').
              ',"title":"Nombre d\'heures d\'ouverture"},"event":{"nombre":'.
              $place->get('blocs->data_territoire->donnees->compare->realisations->event->nombre').
              ',"title":"Nombre d\'événements publics / privés"},"struct_hebergee":{"nombre":'.
              $place->get('blocs->data_territoire->donnees->compare->realisations->struct_hebergee->nombre').
              ',"title":"Nombre de structures hébergées"},"visiteur":{"nombre":'.
              $place->get('blocs->data_territoire->donnees->compare->realisations->visiteur->nombre').
              ',"title":"Nombre de visiteurs par an"}}}';

      $compare_data[$place->get('name')] = json_decode($data,true);
      $compare_place_name[$place->get('name')] = $place->get('name');
    }

    $compares= [
      "data" => $compare_data,
      "titles" => $compare_title,
      "names" => $compare_place_name
    ];
    return json_encode($compares, JSON_HEX_APOS);
  }


  public function getPublics(){
    return json_decode(json_encode($this->get('blocs->accessibilite->donnees->publics')),true);
  }

  public function getAccessibilite(){
    return json_decode(json_encode($this->get('blocs->accessibilite->donnees->accessibilite')),true);
  }
  public function getTransports(){
    return json_decode(json_encode($this->get('blocs->accessibilite->donnees->transports')),true);
  }


}
