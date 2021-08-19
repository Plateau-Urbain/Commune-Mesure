<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadIrisGeoJson extends Command
{
  protected $signature = 'iris:load {adresse}';
  protected $description = "Load iris";
  public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $data = [];
        $adresse = $this->argument('adresse');
        $iris_json = json_decode(file_get_contents("https://pyris.datajazz.io/api/search/?geojson=true&q=".urlencode($adresse)));
        $data['geo'] = [];
        $data['geo']['lat'] = $iris_json->lat;
        $data['geo']['lon'] = $iris_json->lon;
        $data['geo']['geo_json'] = [];
        $data['geo']['geo_json']['iris'] = ['type' => "Feature"];
        $data['geo']['geo_json']['iris']['geometry'] = $iris_json->geometry;
        $data['geo']['geo_json']['iris']['properties'] = $iris_json->properties;

        $commune_json = json_decode(file_get_contents("https://geo.api.gouv.fr/communes/".$iris_json->properties->citycode."?fields=nom,codesPostaux,codeDepartement,departement,codeRegion,region,population&format=geojson&geometry=contour"));
        $data['geo']['geo_json']['commune'] = $commune_json;

        $departements = json_decode(file_get_contents("https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/departements.geojson"));
        foreach($departements->features as $f) {
            if ($f->properties->code == $commune_json->properties->codeDepartement) {
                $data['geo']['geo_json']['departement'] = $f;
                break;
            }
        }
        $regions = json_decode(file_get_contents("https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/regions.geojson"));
        foreach($regions->features as $f) {
            if ($f->properties->code == $commune_json->properties->codeRegion) {
                $data['geo']['geo_json']['region'] = $f;
                break;
            }
        }

        print_r(json_encode($data));
    }
}
