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

        $poplineid = 0;
        $popcsv = [];
        if ($file = fopen("storage/framework/cache/data/base-ic-evol-struct-pop-2016.csv", "r")) {
            //Output lines until EOF is reached
            while(! feof($file)) {
                $line = fgets($file);
                if ($poplineid++ == 4) {
                    $popcsv[] = str_getcsv($line, ';');
                }
                if (strpos($line, $iris_json->properties->complete_code) === 0) {
                    $popcsv[] = str_getcsv($line, ';');
                    break;
                }
            }
        }else{
            echo "WARNING: storage/framework/cache/data/base-ic-evol-struct-pop-2016.csv missing\n";
            echo "\tcsv converted from the official xls downloaded from https://www.insee.fr/fr/statistiques/fichier/4228434/base-ic-evol-struct-pop-2016.zip\n";
            echo "\tle code iris complet DDCCCIIIII (D = département, C = commune insee, I = Iris) attendu en première colonne\n";
            echo "\tseparateur ;\n";
        }
        if ($popcsv) {
            if ($popcsv[0][53] == 'Pop 15 ans ou plus Agriculteurs exploitants en 2016 (compl)' && $popcsv[0][59] == 'Pop 15 ans ou plus Retraités en 2016 (compl)') {
                $data['insee']['iris']['csp']['agriculteur'] = array('nb' => $popcsv[1][53], 'title' => 'Agriculteurs exploitants');
                $data['insee']['iris']['csp']['artisant'] = array('nb' => $popcsv[1][54], 'title' => 'Artisans, Comm., Chefs entr.');
                $data['insee']['iris']['csp']['cadre'] = array('nb' => $popcsv[1][55], 'title' => 'Cadres, Prof. intel. sup.');
                $data['insee']['iris']['csp']['prof_int'] = array('nb' => $popcsv[1][56], 'title' => 'Prof. intermédiaires');
                $data['insee']['iris']['csp']['employe'] = array('nb' => $popcsv[1][57], 'title' => 'Employés');
                $data['insee']['iris']['csp']['ouvrier'] = array('nb' => $popcsv[1][58], 'title' => 'Ouvriers');
                $data['insee']['iris']['csp']['retraite'] = array('nb' => $popcsv[1][59], 'title' => 'Retraités');
                $data['insee']['iris']['csp']['autre'] = array('nb' => $popcsv[1][60], 'title' => 'Autres');
            }

        }
        print_r(json_encode($data));
    }
}
