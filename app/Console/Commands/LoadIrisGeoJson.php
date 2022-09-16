<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadIrisGeoJson extends Command
{
    protected $signature = 'iris:load {adresse}';
    protected $description = "Load iris";

    protected $data = [];
    protected $iris_json = '';
    protected $iris_code = '';
    protected $city_code = '';
    protected $departement_code = '';
    protected $region_code = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle_geo_adresse()
    {
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
        $file = null;
        try {
            $file = fopen("storage/framework/cache/data/base-ic-evol-struct-pop-2016.csv", "r");
        } catch (\Exception $e) {
            $this->warn("WARNING: storage/framework/cache/data/base-ic-evol-struct-pop-2016.csv missing");
            $this->warn("\tcsv converted from the official xls downloaded from https://www.insee.fr/fr/statistiques/fichier/4228434/base-ic-evol-struct-pop-2016.zip");
            $this->warn("\tlibreoffice --headless --convert-to csv:\"Text - txt - csv (StarCalc)\":59,34,0,1,1 /tmp/base-ic-evol-struct-pop-2016.xls --outdir storage/framework/cache/data/");
            $this->warn("\tle code iris complet DDCCCIIIII (D = département, C = commune insee, I = Iris) attendu en première colonne");
            $this->warn("\tseparateur ;");
            $this->newLine();
            $this->warn("Skipping population...");
        }
        if ($file) {
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

        try {
            $activites = json_decode(file_get_contents("https://pyris.datajazz.io/api/insee/activite/".$this->iris_code));
        } catch (\ErrorException $e) {
            $activites = new \stdClass;
            $activites->chomeur = 0;
            $activites->actif = 0;
            $activites->etudiant = 0;
            $activites->retraite = 0;
            $activites->autre_inactif = 0;
        }

        $this->data['insee']['iris']['activites']['chomeur'] = array('title' => 'Chômeur (Actif inoccupé)', 'nb' => $activites->chomeur);
        $this->data['insee']['iris']['activites']['actif'] = array('title' => 'Actif occupé', 'nb' => $activites->actif);
        $this->data['insee']['iris']['activites']['etudiant'] = array("title" => "Élèves, étudiants et stagiaires non rémunérés", "nb" => $activites->etudiant);
        $this->data['insee']['iris']['activites']['retraite'] = array("title" => "Retraités ou préretraités", "nb" => $activites->retraite);
        $this->data['insee']['iris']['activites']['autre'] = array("title" => "Autre inactif", "nb" => $activites->autre_inactif);
    }

    public function parse_insee($url) {
        if ($file = fopen($url, "r")) {
            //Output lines until EOF is reached
            $table_name = '';
            $line_name = '';
            $tdid = '';
            $htmldata = array();
            while(! feof($file)) {
                $line = fgets($file);
                if (strpos($line, 'POP T5 - Population de 15 ans') !== false) {
                    $table_name = 'population';
                }
                if (strpos($line, 'EMP T1 - Population de 15') !== false) {
                    $table_name = 'activites';
                }
                if (strpos($line, 'LOG T2 - Catégories et types de logements') !== false) {
                    $table_name = 'logements';
                }
                if ($table_name && strpos($line, '</tbody>') !== false) {
                    $table_name = '';
                }
                if ($table_name && strpos($line, '<th ') !== false) {
                    $line_name = self::strip_line($line);
                    $tdid = 0;
                }
                if ($line_name && strpos($line, '</tr>') !== false) {
                    $line_name = '';
                    $tdid = 0;
                }
                if ($line_name && strpos($line, '<td ') !== false) {
                    $htmldata[$table_name][$line_name][$tdid] = self::strip_line($line);
                    $tdid++;
                }
            }
            return $htmldata;
        }
    }

    public static function strip_line($s) {
        $s = strip_tags($s);
        $s = preg_replace('/^ */', '', $s);
        $s = str_replace('&nbsp;', '', $s);
        $s = preg_replace('/[\n ]*$/', '', $s);
        if (preg_match('/^[0-9]/', $s)) {
            $s = str_replace(',', '.', $s);
        }
        return $s;
    }

    public function handle_insee($geocode, $insee_geotype) {
        $data = $this->parse_insee("https://www.insee.fr/fr/statistiques/2011101?geo=".$geocode);
        $this->data['insee'][$insee_geotype]['csp']['agriculteur'] = array('title' => 'Agriculteurs exploitants', 'nb' => (isset($data['population']))? $data['population']['Agriculteurs exploitants'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['artisant'] = array('title' => 'Artisans, Comm., Chefs entr.', 'nb' => (isset($data['population']))? $data['population']["Artisans, commerçants, chefs d'entreprise"][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['cadre'] = array('title' => 'Cadres, Prof. intel. sup.', 'nb' => (isset($data['population']))? $data['population']['Cadres et professions intellectuelles supérieures'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['prof_int'] = array('title' => 'Prof. intermédiaires', 'nb' => (isset($data['population']))? $data['population']['Professions intermédiaires'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['employe'] = array('title' => 'Employés', 'nb' => (isset($data['population']))? $data['population']['Employés'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['ouvrier'] = array('title' => 'Ouvriers', 'nb' => (isset($data['population']))? $data['population']['Ouvriers'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['retraite'] = array('title' => 'Retraités', 'nb' => (isset($data['population']))? $data['population']['Retraités'][4] : 0);
        $this->data['insee'][$insee_geotype]['csp']['autre'] = array('title' => 'Autres', 'nb' => (isset($data['population']))? $data['population']['Autres personnes sans activité professionnelle'][4] : 0);
        $this->data['insee'][$insee_geotype]['logement']['house'] = array('title' => 'Maison', 'nb' => $data['logements']['Maisons'][4]);
        $this->data['insee'][$insee_geotype]['logement']['appartment'] = array('title' => 'Appartement', 'nb' => $data['logements']['Appartements'][4]);
        $this->data['insee'][$insee_geotype]['logement']['unoccupied'] = array("title" => "Appart/Maison inoccupé", "nb" => $data['logements']['Logements vacants'][4]);
        $this->data['insee'][$insee_geotype]['activites']['chomeur'] = array('title' => 'Chômeur (Actif inoccupé)', 'nb' => $data['activites']['Chômeurs en %'][2] / 100 * $data['activites']['Ensemble'][4]);
        $this->data['insee'][$insee_geotype]['activites']['actif'] = array('title' => 'Actif occupé', 'nb' => $data['activites']['Actifs en %'][2] / 100 * $data['activites']['Ensemble'][4]);
        $this->data['insee'][$insee_geotype]['activites']['etudiant'] = array("title" => "Élèves, étudiants et stagiaires non rémunérés", "nb" => $data['activites']['Élèves, étudiants et stagiaires non rémunérés en %'][2] / 100 * $data['activites']['Ensemble'][4]);
        $this->data['insee'][$insee_geotype]['activites']['retraite'] = array("title" => "Retraités ou préretraités", "nb" => $data['activites']['Retraités ou préretraités en %'][2] / 100 * $data['activites']['Ensemble'][4]);
        $this->data['insee'][$insee_geotype]['activites']['autre'] = array("title" => "Autre inactif", "nb" => $data['activites']['Autres inactifs en %'][2] / 100 * $data['activites']['Ensemble'][4]);
    }

    public function handle()
    {
        $this->handle_geo_adresse();
        $this->handle_geo_json();
        $this->handle_iris_data();
        $this->handle_insee('COM-'.$this->city_code, 'commune');
        $this->handle_insee('DEP-'.$this->departement_code, 'departement');
        $this->handle_insee('REG--'.$this->region_code, 'region');

        $json = json_encode($this->data);
        $this->line($json);
    }
}
