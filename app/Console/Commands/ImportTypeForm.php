<?php

namespace App\Console\Commands;

use \stdClass;
use Illuminate\Console\Command;

class ImportTypeForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform {file : json contenant les réponses d\'un répondant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform";

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema.json';

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
        if (file_exists(storage_path().$this->schema) === false) {
            throw new \Exception("Schema file does not exists : ".storage_path().$this->schema);
        }

        $f = $this->argument('file');

        if (file_exists(realpath($f)) === false) {
            throw new \Exception("File does not exists : ".realpath($f));
        }

        $schema = json_decode(file_get_contents(storage_path().$this->schema));
        $import_file = json_decode(file_get_contents($f));

        $new_place = new stdClass;
        $new_place->name = $this->extract_val($schema->name, $import_file->answers);
        $new_place->status = $this->extract_val($schema->status, $import_file->answers);
        $new_place->address = new stdClass;
        $new_place->address->address = $this->extract_val($schema->address->address, $import_file->answers);
        $new_place->address->postalcode = $this->extract_val($schema->address->postalcode, $import_file->answers);

        //presentation
        $new_place->blocs = new stdClass;
        $new_place->blocs->presentation = new stdClass;
        $new_place->blocs->presentation->visible = 1;
        $new_place->blocs->presentation->donnees = new stdClass;
        $new_place->blocs->presentation->donnees->idee_fondatrice = $this->extract_val($schema->blocs->presentation->donnees->idee_fondatrice, $import_file->answers);
        $new_place->blocs->presentation->donnees->nombre_occupants = $this->extract_val($schema->blocs->presentation->donnees->nombre_occupants, $import_file->answers);
        $new_place->blocs->presentation->donnees->noms_occupants = $this->extract_val($schema->blocs->presentation->donnees->noms_occupants, $import_file->answers);
        $new_place->blocs->presentation->donnees->nb_manager = $this->extract_val($schema->blocs->presentation->donnees->nb_manager, $import_file->answers);
        $new_place->blocs->presentation->donnees->date_ouverture = $this->extract_val($schema->blocs->presentation->donnees->date_ouverture, $import_file->answers);
        $new_place->blocs->presentation->donnees->date_creation = $this->extract_val($schema->blocs->presentation->donnees->date_creation, $import_file->answers);
        $new_place->blocs->presentation->donnees->surface = $this->extract_val($schema->blocs->presentation->donnees->surface, $import_file->answers);
        $new_place->blocs->presentation->donnees->acteurs_publics = $this->extract_val($schema->blocs->presentation->donnees->acteurs_publics, $import_file->answers);
        $new_place->blocs->presentation->donnees->acteurs_prives = $this->extract_val($schema->blocs->presentation->donnees->acteurs_prives, $import_file->answers);

        $new_place->blocs->presentation->donnees->natures_partenariats = new stdClass;
        $new_place->blocs->presentation->donnees->natures_partenariats->public = $this->extract_val($schema->blocs->presentation->donnees->natures_partenariats->public, $import_file->answers);
        $new_place->blocs->presentation->donnees->natures_partenariats->prive = $this->extract_val($schema->blocs->presentation->donnees->natures_partenariats->prive, $import_file->answers);

        $ouvertures_choices = [];
        $ouvertures_choices = $this->extract_val($schema->blocs->presentation->donnees->ouverture->{"En permanence"}, $import_file->answers);

        $new_place->blocs->presentation->donnees->ouverture = new stdClass;
        $new_place->blocs->presentation->donnees->ouverture = $schema->blocs->presentation->donnees->ouverture;
        $new_place->blocs->presentation->donnees->ouverture->{"En permanence"} = 0;

        foreach ($ouvertures_choices as $oc) {
            $new_place->blocs->presentation->donnees->ouverture->$oc = 1;
        }

        // Accessibilite
        $public_choices = [];
        $public_choices = $this->extract_val($schema->blocs->accessibilite->donnees->publics->{"Chercheurs d'emplois"}, $import_file->answers);

        $new_place->blocs->accessibilite = new stdClass;
        $new_place->blocs->accessibilite->visible = 1;
        $new_place->blocs->accessibilite->donnees = new stdClass;
        $new_place->blocs->accessibilite->donnees->publics = $schema->blocs->accessibilite->donnees->publics;

        foreach ($public_choices as $pc) {
            $new_place->blocs->accessibilite->donnees->publics->$pc = 1;
        }

        $new_place->blocs->accessibilite->donnees->accessibilite = new stdClass;
        $new_place->blocs->accessibilite->donnees->accessibilite = $schema->blocs->accessibilite->donnees->accessibilite;
        $new_place->blocs->accessibilite->donnees->accessibilite->{"Handicapés"} = ($this->extract_val($schema->blocs->accessibilite->donnees->accessibilite->{"Handicapés"}, $import_file->answers) === "Yes")
            ? 1
            : 0;

        $new_place->blocs->accessibilite->donnees->transports = new stdClass;
        $new_place->blocs->accessibilite->donnees->transports = $schema->blocs->accessibilite->donnees->transports;

        // valeurs
        $new_place->blocs->valeurs = new stdClass;
        $new_place->blocs->valeurs->visible = 1;
        $new_place->blocs->valeurs->donnees = new stdClass;
        $new_place->blocs->valeurs->donnees = $schema->blocs->valeurs->donnees;

        // moyens
        $new_place->blocs->moyens = new stdClass;
        $new_place->blocs->moyens->visible = 1;
        $new_place->blocs->moyens->donnees = new stdClass;
        $new_place->blocs->moyens->donnees->investissement = new stdClass;
        //$new_place->blocs->moyens->donnees->investissement->
        $new_place->blocs->moyens->donnees->fonctionnement = new stdClass;

        echo PHP_EOL;
        echo json_encode($new_place);
        echo PHP_EOL;
        exit;


        //moyens

        $new_place->blocs->moyens->donnees->investissement->{"Fonds publics"} = fill_val("blocs|moyens|donnees|investissement|Fonds publics", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->investissement->{"Fonds privés"} = fill_val("blocs|moyens|donnees|investissement|Fonds privés", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->fonctionnement->Subventions = fill_val("blocs|moyens|donnees|fonctionnement|Subventions", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->fonctionnement->{"Aides privées"} = fill_val("blocs|moyens|donnees|fonctionnement|Aides privées", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->fonctionnement->Recettes = fill_val("blocs|moyens|donnees|fonctionnement|Recettes", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->benevoles = fill_val("blocs|moyens|donnees|benevoles", $example_json, $results_raw_t);
        $new_place->blocs->moyens->donnees->partenaires = fill_val("blocs|moyens|donnees|partenaires", $example_json, $results_raw_t);

        //composition
        $new_place->blocs->composition->donnees->type->Entreprises = fill_val("blocs|composition|donnees|type|Entreprises", $example_json, $results_raw_t);
        $new_place->blocs->composition->donnees->type->Associations = fill_val("blocs|composition|donnees|type|Associations", $example_json, $results_raw_t);
        $new_place->blocs->composition->donnees->type->Artistes = fill_val("blocs|composition|donnees|type|Artistes", $example_json, $results_raw_t);
        $new_place->blocs->composition->donnees->type->{"Autres structures"} = fill_val("blocs|composition|donnees|type|Autres structures", $example_json, $results_raw_t);
        $new_place->blocs->composition->donnees->structures_crees = fill_val("blocs|composition|donnees|structures_crees", $example_json, $results_raw_t);

        //impact_social
        $new_place->blocs->impact_social->donnees->insertion_professionnelle = fill_val("blocs|impact_social|donnees|insertion_professionnelle", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->appartenance_exclusion = fill_val("blocs|impact_social|donnees|appartenance_exclusion", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->reseaux = fill_val("blocs|impact_social|donnees|reseaux", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->capacite_agir = fill_val("blocs|impact_social|donnees|capacite_agir", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->sante_bien_être = fill_val("blocs|impact_social|donnees|sante_bien_être", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->lien_social = fill_val("blocs|impact_social|donnees|lien_social", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->solidarite = fill_val("blocs|impact_social|donnees|solidarite", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->egalite_homme_femme = fill_val("blocs|impact_social|donnees|egalite_homme_femme", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->cadre_de_vie = fill_val("blocs|impact_social|donnees|cadre_de_vie", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->entretien_des_espaces = fill_val("blocs|impact_social|donnees|entretien_des_espaces", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->services_publics = fill_val("blocs|impact_social|donnees|services_publics", $example_json, $results_raw_t);
        $new_place->blocs->impact_social->donnees->innovation_publique = fill_val("blocs|impact_social|donnees|innovation_publique", $example_json, $results_raw_t);

        //reseaux_sociaux
        foreach ($new_place->reseaux_sociaux->donnees as $key => $value) {
            $new_place->reseaux_sociaux->donnees[$key]->link = fill_val("reseaux_sociaux|donnees|$key|link", $example_json, $results_raw_t);
        }

        //evenements
        $new_place->evenements->publics->nombre = fill_val("evenements|publics|nombre", $example_json, $results_raw_t);
        $new_place->evenements->publics->{"personnes accueillies"} = fill_val("evenements|publics|personnes accueillies", $example_json, $results_raw_t);
        $new_place->evenements->prives->nombre = fill_val("evenements|prives|nombre", $example_json, $results_raw_t);
        $new_place->evenements->prives->{"personnes accueillies"} = fill_val("evenements|prives|personnes accueillies", $example_json, $results_raw_t);

        $place_file = str_replace(" ", "_", $new_place->name);
        file_put_contents("$place_file.json", json_encode($new_place));

    }

    public function extract_val($keys, $file)
    {
        echo $keys.PHP_EOL;

        $key = explode('|', $keys);
        foreach ($file as $group_of_answers) {
            if ($group_of_answers->id !== $key[0]) {
                continue;
            }

            echo $group_of_answers->title."\t";

            foreach ($group_of_answers->group->answers as $question) {
                if ($question->id !== $key[1]) {
                    continue;
                }

                echo $question->title."\t";

                // DEBUG
                if ($key[3] === "choices") {
                    foreach ($question->{$key[2]}->{$key[3]} as $c) {
                        echo $c." ";
                    }
                } else {
                    echo "\t".$question->{$key[2]}->{$key[3]};
                }
                echo PHP_EOL;
                echo PHP_EOL;

                return $question->{$key[2]}->{$key[3]};
            }
        }
    }
}
