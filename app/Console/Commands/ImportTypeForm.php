<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use \DOMDocument;
use \DOMXPath;

class ImportTypeForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Import:typeform';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_raw_path = glob(__DIR__."/aquarium*")[0];
        $file_example_path = __DIR__."/out/example.json";

        $example_json = json_decode(file_get_contents($file_example_path));
        $results_raw = json_decode(file_get_contents($file_raw_path));

        $place_to_fill = $example_json;





        $results_raw_t = transform_id_to_key($results_raw);

        $place_to_fill->name = fill_vall("name", $example_json, $results_raw_t);
        $place_to_fill->status = fill_vall("status", $example_json, $results_raw_t);
        $place_to_fill->address->address = fill_vall("address|address", $example_json, $results_raw_t);
        $place_to_fill->address->postalcode = fill_vall("address|postalcode", $example_json, $results_raw_t);

        //presentation
        $res_opening = fill_vall("blocs|presentation|donnees|ouverture|En permanence", $example_json, $results_raw_t);
        if(count($res_opening)){
          foreach ($res_opening as $key => $value) {
            $place_to_fillblocs->presentation->donnees->ouverture->$value = 1;
          }
        }else {
          $place_to_fill->blocs->presentation->donnees->ouverture->{"En permanence"} = 0;
        }

        $place_to_fill->blocs->presentation->donnees->idee_fondatrice = fill_vall("blocs|presentation|donnees|idee_fondatrice", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->nombre_occupants = fill_vall("blocs|presentation|donnees|nombre_occupants", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->noms_occupants = fill_vall("blocs|presentation|donnees|noms_occupants", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->nb_manager = fill_vall("blocs|presentation|donnees|nb_manager", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->date_ouverture = fill_vall("blocs|presentation|donnees|date_ouverture", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->date_creation = fill_vall("blocs|presentation|donnees|date_creation", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->surface = fill_vall("blocs|presentation|donnees|surface", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->acteurs_publics = fill_vall("blocs|presentation|donnees|acteurs_publics", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->acteurs_prives = fill_vall("blocs|presentation|donnees|acteurs_prives", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->natures_partenariats->public = fill_vall("blocs|presentation|donnees|natures_partenariats|public", $example_json, $results_raw_t);
        $place_to_fill->blocs->presentation->donnees->natures_partenariats->prive = fill_vall("blocs|presentation|donnees|natures_partenariats|prive", $example_json, $results_raw_t);

        //accessibilite
        $res_public_access = fill_vall("blocs|accessibilite|donnees|publics|Chercheurs d'emplois", $example_json, $results_raw_t);
        $place_to_fill->blocs->accessibilite->donnees->publics->{"Chercheurs d'emplois"} = 0;
        foreach ($res_public_access as $key => $value) {
          $place_to_fill->blocs->accessibilite->donnees->publics->$value = 1;
        }

        $res_handicap = fill_vall("blocs|accessibilite|donnees|accessibilite|Handicapés", $example_json, $results_raw_t);
        if($res_handicap === "Yes"){
          $place_to_fill->blocs->accessibilite->donnees->accessibilite->{"Handicapés"} = 1;
        }

        //moyens

        $place_to_fill->blocs->moyens->donnees->investissement->{"Fonds publics"} = fill_vall("blocs|moyens|donnees|investissement|Fonds publics", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->investissement->{"Fonds privés"} = fill_vall("blocs|moyens|donnees|investissement|Fonds privés", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->fonctionnement->Subventions = fill_vall("blocs|moyens|donnees|fonctionnement|Subventions", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->fonctionnement->{"Aides privées"} = fill_vall("blocs|moyens|donnees|fonctionnement|Aides privées", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->fonctionnement->Recettes = fill_vall("blocs|moyens|donnees|fonctionnement|Recettes", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->benevoles = fill_vall("blocs|moyens|donnees|benevoles", $example_json, $results_raw_t);
        $place_to_fill->blocs->moyens->donnees->partenaires = fill_vall("blocs|moyens|donnees|partenaires", $example_json, $results_raw_t);

        //composition
        $place_to_fill->blocs->composition->donnees->type->Entreprises = fill_vall("blocs|composition|donnees|type|Entreprises", $example_json, $results_raw_t);
        $place_to_fill->blocs->composition->donnees->type->Associations = fill_vall("blocs|composition|donnees|type|Associations", $example_json, $results_raw_t);
        $place_to_fill->blocs->composition->donnees->type->Artistes = fill_vall("blocs|composition|donnees|type|Artistes", $example_json, $results_raw_t);
        $place_to_fill->blocs->composition->donnees->type->{"Autres structures"} = fill_vall("blocs|composition|donnees|type|Autres structures", $example_json, $results_raw_t);
        $place_to_fill->blocs->composition->donnees->structures_crees = fill_vall("blocs|composition|donnees|structures_crees", $example_json, $results_raw_t);

        //impact_social
        $place_to_fill->blocs->impact_social->donnees->insertion_professionnelle = fill_vall("blocs|impact_social|donnees|insertion_professionnelle", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->appartenance_exclusion = fill_vall("blocs|impact_social|donnees|appartenance_exclusion", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->reseaux = fill_vall("blocs|impact_social|donnees|reseaux", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->capacite_agir = fill_vall("blocs|impact_social|donnees|capacite_agir", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->sante_bien_être = fill_vall("blocs|impact_social|donnees|sante_bien_être", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->lien_social = fill_vall("blocs|impact_social|donnees|lien_social", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->solidarite = fill_vall("blocs|impact_social|donnees|solidarite", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->egalite_homme_femme = fill_vall("blocs|impact_social|donnees|egalite_homme_femme", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->cadre_de_vie = fill_vall("blocs|impact_social|donnees|cadre_de_vie", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->entretien_des_espaces = fill_vall("blocs|impact_social|donnees|entretien_des_espaces", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->services_publics = fill_vall("blocs|impact_social|donnees|services_publics", $example_json, $results_raw_t);
        $place_to_fill->blocs->impact_social->donnees->innovation_publique = fill_vall("blocs|impact_social|donnees|innovation_publique", $example_json, $results_raw_t);

        //reseaux_sociaux
        foreach ($place_to_fill->reseaux_sociaux->donnees as $key => $value) {
          $place_to_fill->reseaux_sociaux->donnees[$key]->link = fill_vall("reseaux_sociaux|donnees|$key|link", $example_json, $results_raw_t);
        }

        //evenements
        $place_to_fill->evenements->publics->nombre = fill_vall("evenements|publics|nombre", $example_json, $results_raw_t);
        $place_to_fill->evenements->publics->{"personnes accueillies"} = fill_vall("evenements|publics|personnes accueillies", $example_json, $results_raw_t);
        $place_to_fill->evenements->prives->nombre = fill_vall("evenements|prives|nombre", $example_json, $results_raw_t);
        $place_to_fill->evenements->prives->{"personnes accueillies"} = fill_vall("evenements|prives|personnes accueillies", $example_json, $results_raw_t);

        $place_file = str_replace(" ", "_", $place_to_fill->name);
        file_put_contents("$place_file.json", json_encode($place_to_fill));

    }

    function transform_id_to_key($responses_raw){
      $out = [];

      foreach ($responses_raw->answers as $answers) {
        foreach ($answers->group->answers as $answer) {
          $out[$answers->id][$answer->id] = $answer;
        }
      }
      return $out;
    }

    function fill_vall($name_attr, $example_json, $results_raw_t){
      $name_path = $example_json;
      $out = null;
      foreach (explode("|", $name_attr) as $key => $value) {

        if(is_numeric($value)){
          $name_path = $name_path[$value];
        }else{
          $name_path = $name_path->$value;
        }

      }

      [$group_id, $response_id, $type_response, $res_val] = explode("|", $name_path);
      $res = explode("+", $response_id);

      if(count($res) > 1){
        foreach ($res as $key => $value) {
          $val = $results_raw_t[$group_id][$value]->$type_response->$res_val;
          if(is_numeric($val)){
            $out = $out + $val;
          }else{
            $out .= " ".$out;
          }

        }
      }else{
        $out = $results_raw_t[$group_id][$response_id]->$type_response->$res_val;
      }
      return $out;
    }

}
