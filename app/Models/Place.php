<?php

namespace App\Models;

use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Place extends Model
{
  const STAT_CITIES = "cities";
  const STAT_SURFACE = "surface";
  const STAT_EVENTS = "evenements";
  const STAT_EMPLOIS_DIRECTS = "emplois directs";
  const STAT_PERSONNES_ACCUEILLIES = "personnes accueillies";

    const OUVERTURES = [
        'En permanence', 'Plusieurs jours par semaine', 'Une fois par semaine ou moins',
        "Lors d'évènements ponctuels seulement"
    ];

  protected $stats = [
      self::STAT_SURFACE => 0,
      self::STAT_EVENTS => 0,
      self::STAT_EMPLOIS_DIRECTS => 0,
      self::STAT_PERSONNES_ACCUEILLIES => 0,
      self::STAT_CITIES => 0
  ];
    public $incrementing = false;

    protected $keyType = 'string';
    protected $popup = [];
    protected $cities = [];
    protected static $places = [];
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
                    ->select(['place as slug', 'data'])
                    ->where('deleted_at', null)
                    ->where('place', $slug)
                    ->first();

        if ($db === null) {
            return false;
        }

        $place = new Place();
        $place->setSlug($db->slug);
        $place->setData(json_decode($db->data));

        //Cache::put('place.'.$slug, $place, 10);

        return $place;
    }

    public static function retrievePlaces($sort = null){
        if (! empty(self::$places)) {
            return self::$places;
        }

        $places = DB::table('places')
            ->select('place as slug')
            ->where('deleted_at', null);

        if (in_array($sort, ['latest', 'oldest'], true)) {
            $places->$sort();
        }

        $places = $places->get();

        self::$places = $places->map(function ($place, $key) {
            return self::find($place->slug);
        });

        return self::$places;
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

      $places = self::retrievePlaces();

      foreach($places as $place){
        $this->cities[$place->get('address->city')][]= [ "title" => $place->getSlug(),];
        $this->stats[self::STAT_SURFACE] += $place->get('blocs->presentation->donnees->surface');
        $this->stats[self::STAT_EVENTS] +=  ($place->get('evenements->prives->nombre') + $place->get('evenements->publics->nombre'));
        $this->stats[self::STAT_EMPLOIS_DIRECTS] += ($place->get('blocs->presentation->donnees->emplois directs')) ? $place->get('blocs->presentation->donnees->emplois directs') : 0 ;
        $this->stats[self::STAT_PERSONNES_ACCUEILLIES] += ($place->get('evenements->prives->personnes accueillies') + $place->get('evenements->publics->personnes accueillies'));
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
          $popup = [];
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
            $query->where('place', $place->getSlug());
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

  public static function getHeadObjectChemin($place, $chemin){
    $array = explode('->',$chemin);
    $result = $place;
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
    return (self::getHeadObjectChemin($this->getData(),$chemin)->{self::getLastChemin($chemin)}= $newValue);
  }

  public function check($auth)
  {
      $place = DB::table('places')->select('hash_admin')
                                  ->where('place', $this->getSlug())
                                  ->first();

      if ($place === null) return false;

      return $place->hash_admin === $auth;
  }

  public function getId(){
    return Place::where('place', $this->getSlug())->value('id');
  }

  public function toggleVisibility($section){
    $sections = $this->getVisibility();
    $visibility = $sections[$section];
    $this->set('blocs->'.$section.'->visible', !$visibility);
  }

  public function getVisibility(){
    $tabSections = ["presentation","accessibilite","valeurs","moyens","composition","impact_social","data_territoire","galerie"];
    $tabVisibility=array();
    foreach($tabSections as $s){
      $tabVisibility[$s]= $this->get('blocs->'.$s.'->visible');
      if($s !='presentation'){
        if($this->isEmpty($s)){
          $tabVisibility[$s]= !$this->isEmpty($s);
        }
      }
    }
    return $tabVisibility;
  }

  public function getVisibilitybySection($section){
    $tab = $this->getVisibility();
    return $tab[$section];
  }

  public function getIsEmpty(){
    $tabSections = ["accessibilite","valeurs","moyens","composition","impact_social","galerie"];
    $tabIsEmpty=array();
    foreach($tabSections as $s){
      $tabIsEmpty[$s]= $this->isEmpty($s);
    }
    return $tabIsEmpty;
  }

  public function isEmptyAccessibilityBySection($s){
    $tab = $this->get('blocs->accessibilite->donnees->'.$s);
    foreach($tab as $v){
      if($v != 0){
        return false;
      }
    }
    return true;
  }

  public function isEmptyAccessibility(){
    $tab = json_decode(json_encode($this->get('blocs->accessibilite->donnees')),true);
    foreach($tab as $k=>$v){
      if(!$this->isEmptyAccessibilityBySection($k)){
        return false;
      }
    }
    return true;
  }

  public function isEmptyInvestissement(){
    $tab = json_decode(json_encode($this->get('blocs->moyens->donnees->investissement')),true);
    foreach($tab as $k => $v){
      if(!empty($v)){
        return false;
      }
    }
    return true;
  }

  public function isEmptyFonctionnement(){
    $tab = json_decode(json_encode($this->get('blocs->moyens->donnees->fonctionnement')),true);
    foreach($tab as $k => $v){
      if(!empty($v)){
        return false;
      }
    }
    return true;
  }

  public function isEmpty($section){
    if($section == "moyens"){
      if($this->isEmptyFonctionnement() && $this->isEmptyInvestissement()){
        return true;
      }
      return false;
    }

    if($section == "accessibilite"){  //cas particulier 0/1
      return $this->isEmptyAccessibility();
    }

    $tab = $this->get('blocs->'.$section.'->donnees');
    if (! $tab) {return true;}

    foreach($tab as $v){
      if(is_object($v)){
        foreach($v as $k){
          if(!empty($k)){
            return false;
          }
        }
        return true;
      }
      if(!empty($v)){
        return false;
      }
    }
    return true;
  }

  public function save(array $options = Array()){
    $result = DB::table('places')
        ->where('place', $this->getSlug())
        ->update([
            'data' => json_encode($this->getData()),
            'updated_at' => Carbon::now()
        ]);
    return $result > 0;
  }

    public function addPhoto($newPhoto) {
      $photos = $this->getPhotos();
      array_push($photos, $newPhoto);
      $this->set('blocs->galerie->donnees', $photos);
    }

    public function deletePhoto($index) {
        $photos = $this->getPhotos();
        unset($photos[$index]);
        $photos = array_values($photos);
        $this->set('blocs->galerie->donnees', $photos);
    }


  public function getCompares($places){
    $compare_data = [];
    $compare_place_name = [];
    $compare_title = [
      "moyens"=>[
        "emplois directs" => "Nombre d'emplois directs",
        "benevole" => "Nombre de bénévoles",
        "partenaire" => "Nombre de partenaires publics / privés",
        "superficie" => "Superficie du lieu (m2)"
      ],
      'realisations'=>[
        //"ouverture" => "Nombre d'heures d'ouverture",
        //"event" => "Nombre d'événements publics / privés",
        //"struct_hebergee" => "Nombre de structures hébergées",
        "personnes accueillies" => "Nombre de personnes accueillies par an"]
      ];

    foreach ($places as $place) {
        $data = [
            // Le « + » est voulu : https://www.php.net/manual/en/language.operators.arithmetic.php
            // pour caster les strings en int ou float automagiquement
            'moyens' => [
                'emplois directs' => [
                    'nombre' => +($place->get('blocs->presentation->donnees->emplois directs')) ?: 0,
                    'title' => 'Nombre d\'emplois directs'
                ],
                'benevole' => [
                    'nombre' => +($place->get('blocs->moyens->donnees->benevoles')) ?: 0,
                    'title' => 'Nombre de bénévoles'
                ],
                'partenaire' => [
                    'nombre' => +($place->get('blocs->moyens->donnees->partenaires')) ?: 0,
                    'title' => 'Nombre de partenaires publics / privés'
                ],
                'superficie' => [
                    'nombre' => +($place->get('blocs->presentation->donnees->surface')) ?: 0,
                    'title' => 'Superficie du lieu (m²)'
                ]
            ],
            'realisations' => [
                //'ouverture' => [
                //    'nombre' => +($place->get('blocs->data_territoire->donnees->realisations->ouverture->nombre')) ?: 0,
                //    'title' => 'Nombre d\'heures d\'ouverture'
                //],
                //'event' => [
                //    'nombre' => +($place->get('blocs->data_territoire->donnees->realisations->event->nombre')) ?: 0,
                //    'title' => 'Nombre d\'événements publics / privés'
                //],
                //'struct_hebergee' => [
                //    'nombre' => +($place->get('blocs->data_territoire->donnees->realisations->struct_hebergee->nombre')) ?: 0,
                //    'title' => 'Nombre de structures hébergées'
                //],
                'personnes accueillies' => [
                    'nombre' => +(($place->get('evenements->publics->personnes accueillies')) ?: 0) + (($place->get('evenements->prives->personnes accueillies')) ?: 0),
                    'title' => 'Nombre de personnes accueillies par an'
                ],
            ]
        ];

        $compare_data[$place->get('name')] = $data;
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

  public function getOuverture(){
    $ouverture = json_decode(json_encode($this->get('blocs->presentation->donnees->ouverture')),true);
    foreach( $ouverture as $k => $v){
      if($v == 1){
        return $k;
      }
    }
    return "";
  }

    public function getQrCode(string $text)
    {
        return QrCode::size(150)
            ->margin(2)
            ->eyeColor(0, 232, 80, 72, 156, 0, 0)
            ->eyeColor(1, 232, 80, 72, 156, 0, 0)
            ->eyeColor(2, 232, 80, 72, 156, 0, 0)
            ->generate($text);
    }

    public function export($type, $croped = false)
    {
        $processArgs = ['bash', base_path().'/bin/export.sh', $this->getSlug()];
        if ($croped) {
            $processArgs[] = true;
        }

        $process = new Process($processArgs);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            abort(500, $process->getExitCode().": ".$process->getOutput());
        }

        $lastoutput = array_filter(explode("\n", $process->getOutput()));
        $lastoutput = end($lastoutput);

        $path = Storage::putFileAs(
            'screenshots',
            new File($lastoutput),
            pathinfo($lastoutput)['basename']
        );

        if ($path === false) {
            abort(500, 'Error writing jpg file on disk');
        }

        if ($type === 'image') {
            return $path;
        }

        $process = new Process(['bash', base_path().'/bin/export_pdf.sh', Storage::path($path)]);
        $process->run();

        if (! $process->isSuccessful()) {
            abort(500, $process->getExitCode().": ".$process->getOutput());
        }

        $lastoutput = array_filter(explode("\n", $process->getOutput()));
        $lastoutput = end($lastoutput);

        $path = Storage::putFile(
            'screenshots',
            new File($lastoutput)
        );

        if ($path === false) {
            abort(500, 'Error writing pdf file on disk');
        }

        return $path;
    }

  public function exportCsv(string $auth) : \Generator
  {
      $csv = [];
      $link = route('place.show',['slug' => $this->getSlug() ]);
      $name = $this->getSlug();

      $csv[] = [$link, $name, 'nom', $this->getSlug()];
      $csv[] = [$link, $name, 'cree le', $this->getCreatedAt()];
      $csv[] = [$link, $name, 'page admin', route('place.edit', ['slug' => $this->getSlug(), 'auth' => $auth])];
      $csv[] = [$link, $name, 'cle', $auth];

      $status = ($this->get('publish')) ? 'publié' : 'non publié';

      $csv[] = [$link, $name, 'status', $status];
      $csv[] = [$link, $name, 'email', $this->get('creator->email')];

      foreach ($csv as $line) {
        yield $line;
      }
  }

    public function getCreatedAt()
    {
        return DB::table('places')->where('place', $this->slug)->value('created_at');
    }

    public function updateData(string $hash, array $inputs = [])
    {
        $type = $inputs['type'] ?? null;
        $dirty = [];

        foreach ($inputs as $chemin => $value) {
            if ($chemin === 'type') {
                continue;
            }

            // Dans certaines versions, $request->all() (ou le parametre $inputs)
            // renvoie aussi l'url dans le tableau
            if (strpos($chemin, '/place/') !== false) {
                continue;
            }

            // TODO: ne plus utiliser $hash.
            // TODO: fix espaces dans $chemin
            //$to_edit = $place->get(str_replace('__', '->', $chemin));
            $to_edit = $this->get(urldecode($hash));

            if ($type === 'select') {
                $dirty = (array) $to_edit;
                array_walk($dirty, function (&$v) {
                    $v = 0;
                });

                $dirty[$value] = 1;
                $dirty = (object) $dirty;
            } elseif (is_array($to_edit)) {
                $dirty = array_values(array_filter(array_unique($value), 'strlen'));
            } elseif (is_object($to_edit)) {
                $dirty = array_merge((array) $to_edit, array_filter($value, 'strlen'));

                if ($type === 'checkbox') {
                    array_walk($dirty, function (&$v) {
                        $v = ($v === "on") ? 1 : 0;
                    });
                }

                $dirty = (object) $dirty;
            } else {
                $dirty = $value;
            }

            $this->set(urldecode($hash), $dirty);
        }

        // Cas où `type === checkbox` et zéro checkbox coché
        // ie. la boucle ne passe pas au dessus outre $chemin === type
        if ($type === 'checkbox' && empty($dirty)) {
            $to_edit = $this->get(urldecode($hash));
            $dirty = (array) $to_edit;

            array_walk($dirty, function (&$v) {
                $v = 0;
            });

            $dirty = (object) $dirty;
            $this->set(urldecode($hash), $dirty);
        }

        return $dirty;
    }

    // TODO: ne plus utiliser $hash.
    // TODO: fix espaces dans $chemin
    //$to_edit = $place->get(str_replace('__', '->', $chemin));
    public function getValidator(array $inputs, string $hash)
    {
        $validator = [];
        $type = $inputs['type'] ?? null;

        foreach ($inputs as $chemin => $value) {
            if ($chemin === 'type') {
                continue;
            }

            // Dans certaines versions, $request->all() (ou le parametre $inputs)
            // renvoie aussi l'url dans le tableau
            if (strpos($chemin, '/place/') !== false) {
                continue;
            }

            $rules = [];
            $to_edit = $this->get(urldecode($hash));

            if ($type === 'select') {
                $rules[] = Rule::in(self::OUVERTURES);
            } elseif (is_array($to_edit) || is_object($to_edit)) {
                $validator[$chemin] = 'array';
            }

            if ($type) {
                switch ($type) {
                    case 'checkbox':
                        $rules[] = 'accepted';
                        break;
                    case 'select':
                        $rules[] = Rule::in(self::OUVERTURES);
                        break;
                    case 'number':
                        $rules[] = 'numeric';
                        $rules[] = 'min:0';
                        break;
                    case 'date':
                        $rules[] = 'date';
                        break;
                    default:
                        $rules[] = 'min:1';
                        break;
                }
            } else {
                $rules[] = 'string';
            }

            if (is_array($to_edit) || is_object($to_edit)) {
                $validator[$chemin.'.*'] = implode('|', $rules);
            } else {
                $validator[$chemin] = implode('|', $rules);
            }
        }

        return $validator;
    }

    public function updateHash()
    {
        return DB::table('places')->where('place', $this->slug)->update([
            'hash_admin' => hash('sha256', $this->slug.Str::random(32).config('app.key')),
            'updated_at' => Carbon::now()
        ]);
    }

    public function delete()
    {
        return DB::table('places')->where('place', $this->slug)->update([
            'deleted_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]) > 0;
    }
}
