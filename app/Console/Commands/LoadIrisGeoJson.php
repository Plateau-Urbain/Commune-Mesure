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

    public function handle_geo_adresse() {
        $data = [];
        $adresse = $this->argument('adresse');
        $this->iris_json = json_decode(file_get_contents("https://pyris.datajazz.io/api/search/?geojson=true&q=".urlencode($adresse)));
        $this->data['geo'] = [];
        $this->data['geo']['lat'] = $this->iris_json->lat;
        $this->data['geo']['lon'] = $this->iris_json->lon;
        $this->data['geo']['geo_json'] = [];
        $this->data['geo']['geo_json']['iris'] = ['type' => "Feature"];
        $this->data['geo']['geo_json']['iris']['geometry'] = $this->iris_json->geometry;
        $this->data['geo']['geo_json']['iris']['properties'] = $this->iris_json->properties;

        $this->iris_code = $this->iris_json->properties->complete_code;
        $this->city_code = $this->iris_json->properties->citycode;
        $this->departement_code = substr($this->iris_json->properties->citycode, 0, 2);
    }

    public function handle_geo_json() {
        $commune_json = json_decode(file_get_contents("https://geo.api.gouv.fr/communes/".$this->city_code."?fields=nom,codesPostaux,codeDepartement,departement,codeRegion,region,population&format=geojson&geometry=contour"));
        $this->data['geo']['geo_json']['commune'] = $commune_json;
        $this->region_code = $commune_json->properties->codeRegion;
        $this->departement_code = $commune_json->properties->codeDepartement;

        $departements = json_decode(file_get_contents("https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/departements.geojson"));
        foreach($departements->features as $f) {
            if ($f->properties->code == $this->departement_code) {
                $this->data['geo']['geo_json']['departement'] = $f;
                break;
            }
        }
        $regions = json_decode(file_get_contents("https://raw.githubusercontent.com/gregoiredavid/france-geojson/master/regions.geojson"));
        foreach($regions->features as $f) {
            if ($f->properties->code == $this->region_code) {
                $this->data['geo']['geo_json']['region'] = $f;
                break;
            }
        }
    }

    public function handle_iris_data() {
        $poplineid = 0;
        $popcsv = [];
        if ($file = fopen("storage/framework/cache/data/base-ic-evol-struct-pop-2016.csv", "r")) {
            //Output lines until EOF is reached
            while(! feof($file)) {
                $line = fgets($file);
                if ($poplineid++ == 4) {
                    $popcsv[] = str_getcsv($line, ';');
                }
                if (strpos($line, $this->iris_code) === 0) {
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
                $this->data['insee']['iris']['csp']['agriculteur'] = array('nb' => $popcsv[1][53], 'title' => 'Agriculteurs exploitants');
                $this->data['insee']['iris']['csp']['artisant'] = array('nb' => $popcsv[1][54], 'title' => 'Artisans, Comm., Chefs entr.');
                $this->data['insee']['iris']['csp']['cadre'] = array('nb' => $popcsv[1][55], 'title' => 'Cadres, Prof. intel. sup.');
                $this->data['insee']['iris']['csp']['prof_int'] = array('nb' => $popcsv[1][56], 'title' => 'Prof. intermédiaires');
                $this->data['insee']['iris']['csp']['employe'] = array('nb' => $popcsv[1][57], 'title' => 'Employés');
                $this->data['insee']['iris']['csp']['ouvrier'] = array('nb' => $popcsv[1][58], 'title' => 'Ouvriers');
                $this->data['insee']['iris']['csp']['retraite'] = array('nb' => $popcsv[1][59], 'title' => 'Retraités');
                $this->data['insee']['iris']['csp']['autre'] = array('nb' => $popcsv[1][60], 'title' => 'Autres');
            }
        }

        $logements = json_decode(file_get_contents("https://pyris.datajazz.io/api/insee/logement/".$this->iris_code));
        $this->data['insee']['iris']['logement']['house'] = array('title' => 'Maison', 'nb' => $logements->house);
        $this->data['insee']['iris']['logement']['appartment'] = array('title' => 'Appartement', 'nb' => $logements->appartment);
        $this->data['insee']['iris']['logement']['unoccupied'] = array("title" => "Appart/Maison inoccupé", "nb" => $logements->unoccupied);

        $activites = json_decode(file_get_contents("https://pyris.datajazz.io/api/insee/activite/".$this->iris_code));
        $this->data['insee']['iris']['activites']['chomeur'] = array('title' => 'Chômeur (Actif inoccupé)', 'nb' => $activites->chomeur);
        $this->data['insee']['iris']['activites']['actif'] = array('title' => 'Actif occupé', 'nb' => $activites->actif);
        $this->data['insee']['iris']['activites']['etudiant'] = array("title" => "Élèves, étudiants et stagiaires non rémunérés", "nb" => $activites->etudiant);
        $this->data['insee']['iris']['activites']['retraite'] = array("title" => "Retraités ou préretraités", "nb" => $activites->retraite);
        $this->data['insee']['iris']['activites']['autre'] = array("title" => "Autre inactif", "nb" => $activites->autre_inactif);
    }

    public function handle()
    {
        $this->handle_geo_adresse();
        $this->handle_geo_json();
        $this->handle_iris_data();

        print_r(json_encode($this->data));
    }
}
