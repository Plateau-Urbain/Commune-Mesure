<?php

namespace App\Console\Commands;
use Storage;
use \stdClass;
use App\Exports\BDDJsonExport;
use App\Exports\OriginalJsonExport;
use App\Models\Place;
use App\Models\ImpactSocial;
use App\Mail\ImportSuccess;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ImportTypeFormEnvironmental extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform_environmental
                                {file : json contenant les réponses d\'un répondant}
                                {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform environnemental";

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema_environmental.json';

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * answers file
     *
     * @var object
     */
    protected $answers;

    /**
     * token typeform
     *
     * @var string
     */
    protected $typeformToken;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logger = Log::channel('import');

        $token = getenv('TYPEFORM_TOKEN');
        if ($token === false) {
            throw new \LogicException('Token typeform non défini. Est-il renseigné dans le fichier .env ?');
        }

        $this->typeformToken = $token;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->logger->info("Nouvel import");

        if (file_exists(storage_path().$this->schema) === false) {
            $this->logger->alert("Schema file does not exists", ['schema' => storage_path().$this->schema]);
            throw new \Exception("Schema file does not exists : ".storage_path().$this->schema);
        }

        /** @var string $f */
        $f = $this->argument('file');
        $this->logger->info("Chargement du fichier ".realpath($f));

        if (file_exists(realpath($f)) === false) {
            $this->logger->alert("File does not exists", ['file' => realpath($f)]);
            throw new \Exception("File does not exists : ".realpath($f));
        }

        $schema = json_decode(file_get_contents(storage_path().$this->schema));
        $import_file = json_decode(file_get_contents($f));

        $this->answers = $import_file->answers;


        $exist = DB::table('place_environment')->where('id', $import_file->token)->get();

        $place_name = $this->extract_val($schema->nom);
       /* if ($exist->count() && $this->option('force') === false){
            $this->logger->notice($place_name." already imported. Use --force to overwrite.");
            die($place_name." already imported. Use --force to overwrite\n");
        }*/

        $slug = Str::of($place_name)->slug('-');
        $zipcode = $this->extract_val($schema->blocs->presentation->donnees->code_postal);

        try {
            $this->logger->info("Search for " . $slug);
            $place = Place::searchBySlugAndZipcode($slug, $zipcode);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit;
        }

        $this->logger->withContext(['place' => $place_name]);

        if ($this->option('force') === true) {
            $this->logger->info('Force option used');
        }

        $new_place = new stdClass;
        $new_place->name = $this->extract_val($schema->nom);
        $new_place->share_data = $this->extract_val($schema->share_data);
        $new_place->share_email = $this->extract_val($schema->share_email);

        $new_place->blocs = new stdClass;
        $new_place->blocs->presentation = new stdClass;
        $new_place->blocs->presentation->donnees = new stdClass;
        $new_place->blocs->presentation->donnees->ville = $this->extract_val($schema->blocs->presentation->donnees->ville);
        $new_place->blocs->presentation->donnees->code_postal = $this->extract_val($schema->blocs->presentation->donnees->code_postal);
        $new_place->blocs->presentation->donnees->raison_etre = $this->extract_val($schema->blocs->presentation->donnees->raison_etre);
        $new_place->blocs->presentation->donnees->avancement_projet = $this->extract_val($schema->blocs->presentation->donnees->avancement_projet);

        $new_place->blocs->circularite_sobriete = new stdClass;
        $new_place->blocs->circularite_sobriete->donnees = new stdClass;
        $new_place->blocs->circularite_sobriete->donnees->reutilisation_objet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->reutilisation_objet);
        $new_place->blocs->circularite_sobriete->donnees->equipement_partage = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_partage);
        $new_place->blocs->circularite_sobriete->donnees->reparation_objet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->reparation_objet);
        $new_place->blocs->circularite_sobriete->donnees->limitation_achat = $this->extract_val($schema->blocs->circularite_sobriete->donnees->limitation_achat);
        $new_place->blocs->circularite_sobriete->donnees->limitation_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->limitation_dechet);
        $new_place->blocs->circularite_sobriete->donnees->equipement_reutilisable = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_reutilisable);
        $new_place->blocs->circularite_sobriete->donnees->equipement_reconditionne = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_reconditionne);
        $new_place->blocs->circularite_sobriete->donnees->distributeur_local = $this->extract_val($schema->blocs->circularite_sobriete->donnees->distributeur_local);
        $new_place->blocs->circularite_sobriete->donnees->charte_selection_fournisseur = $this->extract_val($schema->blocs->circularite_sobriete->donnees->charte_selection_fournisseur);
        $new_place->blocs->circularite_sobriete->donnees->optimisation_achat = $this->extract_val($schema->blocs->circularite_sobriete->donnees->optimisation_achat);
        $new_place->blocs->circularite_sobriete->donnees->alimentation_locale = $this->extract_val($schema->blocs->circularite_sobriete->donnees->alimentation_locale);
        $new_place->blocs->circularite_sobriete->donnees->demarche_zero_dechets = $this->extract_val($schema->blocs->circularite_sobriete->donnees->demarche_zero_dechets);
        $new_place->blocs->circularite_sobriete->donnees->low_tech = $this->extract_val($schema->blocs->circularite_sobriete->donnees->low_tech);
        $new_place->blocs->circularite_sobriete->donnees->eco_conception = $this->extract_val($schema->blocs->circularite_sobriete->donnees->eco_conception);
        $new_place->blocs->circularite_sobriete->donnees->fontaine_eau = $this->extract_val($schema->blocs->circularite_sobriete->donnees->fontaine_eau);
        $new_place->blocs->circularite_sobriete->donnees->bio_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->bio_dechet);
        $new_place->blocs->circularite_sobriete->donnees->recycle_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->recycle_dechet);
        $new_place->blocs->circularite_sobriete->donnees->dechet_atelier_revalorise = $this->extract_val($schema->blocs->circularite_sobriete->donnees->dechet_atelier_revalorise);
        $new_place->blocs->circularite_sobriete->donnees->point_collecte_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->point_collecte_dechet);
        $new_place->blocs->circularite_sobriete->donnees->circularite_sobriete_action = $this->extract_val($schema->blocs->circularite_sobriete->donnees->circularite_sobriete_action);
        $new_place->blocs->circularite_sobriete->donnees->circularite_sobriete_chiffre = $this->extract_val($schema->blocs->circularite_sobriete->donnees->circularite_sobriete_chiffre);

        $new_place->blocs->emission_gaz_effet_serre = new stdClass;
        $new_place->blocs->emission_gaz_effet_serre->donnees = new stdClass;
        $new_place->blocs->emission_gaz_effet_serre->donnees->ges_identifie = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->ges_identifie);
        $new_place->blocs->emission_gaz_effet_serre->donnees->bilan_carbon_calcule = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->bilan_carbon_calcule);
        $new_place->blocs->emission_gaz_effet_serre->donnees->strategie_enjeu_climatique = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->strategie_enjeu_climatique);
        $new_place->blocs->emission_gaz_effet_serre->donnees->covoiturage = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->covoiturage);
        $new_place->blocs->emission_gaz_effet_serre->donnees->accueil_velo = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->accueil_velo);
        $new_place->blocs->emission_gaz_effet_serre->donnees->forfait_mobilite_durable = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->forfait_mobilite_durable);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_usager_occasionnel = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_usager_occasionnel);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_fournisseur = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_fournisseur);
        $new_place->blocs->emission_gaz_effet_serre->donnees->restauration = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->restauration);
        $new_place->blocs->emission_gaz_effet_serre->donnees->type_alimentation = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->type_alimentation);
        $new_place->blocs->emission_gaz_effet_serre->donnees->soutien_vegetarien = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->soutien_vegetarien);
        $new_place->blocs->emission_gaz_effet_serre->donnees->alimentation_saison = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->alimentation_saison);
        $new_place->blocs->emission_gaz_effet_serre->donnees->approvisionnement_local = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->approvisionnement_local);
        $new_place->blocs->emission_gaz_effet_serre->donnees->batiment_energie_positive = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->batiment_energie_positive);
        $new_place->blocs->emission_gaz_effet_serre->donnees->batiment_isolation_chaleur = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->batiment_isolation_chaleur);
        $new_place->blocs->emission_gaz_effet_serre->donnees->dpe = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->dpe);
        $new_place->blocs->emission_gaz_effet_serre->donnees->eco_energie_tertiaire = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->eco_energie_tertiaire);
        $new_place->blocs->emission_gaz_effet_serre->donnees->temperature_raisonnable = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->temperature_raisonnable);
        $new_place->blocs->emission_gaz_effet_serre->donnees->fournisseur_energie_verte = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->fournisseur_energie_verte);
        $new_place->blocs->emission_gaz_effet_serre->donnees->energie_produite_site = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->energie_produite_site);
        $new_place->blocs->emission_gaz_effet_serre->donnees->sobriete_numerique = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->sobriete_numerique);
        $new_place->blocs->emission_gaz_effet_serre->donnees->appareil_econome = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->appareil_econome);
        $new_place->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action);
        $new_place->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_chiffre = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_chiffre);

        $new_place->blocs->biodiversite = new stdClass;
        $new_place->blocs->biodiversite->donnees = new stdClass;
        $new_place->blocs->biodiversite->donnees->espace_exterieur = $this->extract_val($schema->blocs->biodiversite->donnees->espace_exterieur);
        $new_place->blocs->biodiversite->donnees->suivi_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->suivi_biodiversite);
        $new_place->blocs->biodiversite->donnees->pratique_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->pratique_biodiversite);
        $new_place->blocs->biodiversite->donnees->colonisation_faune = $this->extract_val($schema->blocs->biodiversite->donnees->colonisation_faune);
        $new_place->blocs->biodiversite->donnees->corridor_ecologique = $this->extract_val($schema->blocs->biodiversite->donnees->corridor_ecologique);
        $new_place->blocs->biodiversite->donnees->arbre_pleine_terre = $this->extract_val($schema->blocs->biodiversite->donnees->arbre_pleine_terre);
        $new_place->blocs->biodiversite->donnees->reduction_pollution_lumineuse = $this->extract_val($schema->blocs->biodiversite->donnees->reduction_pollution_lumineuse);
        $new_place->blocs->biodiversite->donnees->reduction_pollution_sonore = $this->extract_val($schema->blocs->biodiversite->donnees->reduction_pollution_sonore);
        $new_place->blocs->biodiversite->donnees->habitat_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->habitat_biodiversite);
        $new_place->blocs->biodiversite->donnees->encourage_diversite = $this->extract_val($schema->blocs->biodiversite->donnees->encourage_diversite);
        $new_place->blocs->biodiversite->donnees->espace_vegetalise = $this->extract_val($schema->blocs->biodiversite->donnees->espace_vegetalise);
        $new_place->blocs->biodiversite->donnees->biodiversite_action = $this->extract_val($schema->blocs->biodiversite->donnees->biodiversite_action);
        $new_place->blocs->biodiversite->donnees->biodiversite_chiffre = $this->extract_val($schema->blocs->biodiversite->donnees->biodiversite_chiffre);

        $new_place->blocs->environnement_physique = new stdClass;
        $new_place->blocs->environnement_physique->donnees = new stdClass;
        $new_place->blocs->environnement_physique->donnees->risque_rarefaction_ressource = $this->extract_val($schema->blocs->environnement_physique->donnees->risque_rarefaction_ressource);
        $new_place->blocs->environnement_physique->donnees->risques = $this->extract_val($schema->blocs->environnement_physique->donnees->risques);
        $new_place->blocs->environnement_physique->donnees->risque_concerne = $this->extract_val($schema->blocs->environnement_physique->donnees->risque_concerne);
        $new_place->blocs->environnement_physique->donnees->activite_depend = $this->extract_val($schema->blocs->environnement_physique->donnees->activite_depend);
        $new_place->blocs->environnement_physique->donnees->activite_agricole = $this->extract_val($schema->blocs->environnement_physique->donnees->activite_agricole);
        $new_place->blocs->environnement_physique->donnees->fertilisation_chimique_bannie = $this->extract_val($schema->blocs->environnement_physique->donnees->fertilisation_chimique_bannie);
        $new_place->blocs->environnement_physique->donnees->pesticide_chimique_banni = $this->extract_val($schema->blocs->environnement_physique->donnees->pesticide_chimique_banni);
        $new_place->blocs->environnement_physique->donnees->culture_respectueuse = $this->extract_val($schema->blocs->environnement_physique->donnees->culture_respectueuse);
        $new_place->blocs->environnement_physique->donnees->agriculture_durable = $this->extract_val($schema->blocs->environnement_physique->donnees->agriculture_durable);
        $new_place->blocs->environnement_physique->donnees->regeneration_sol = $this->extract_val($schema->blocs->environnement_physique->donnees->regeneration_sol);
        $new_place->blocs->environnement_physique->donnees->ancienne_friche = $this->extract_val($schema->blocs->environnement_physique->donnees->ancienne_friche);
        $new_place->blocs->environnement_physique->donnees->refertilisation = $this->extract_val($schema->blocs->environnement_physique->donnees->refertilisation);
        $new_place->blocs->environnement_physique->donnees->artificialisation_sol = $this->extract_val($schema->blocs->environnement_physique->donnees->artificialisation_sol);
        $new_place->blocs->environnement_physique->donnees->utilisation_projet_complementaire = $this->extract_val($schema->blocs->environnement_physique->donnees->utilisation_projet_complementaire);
        $new_place->blocs->environnement_physique->donnees->espace_modulable = $this->extract_val($schema->blocs->environnement_physique->donnees->espace_modulable);
        $new_place->blocs->environnement_physique->donnees->restriction_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->restriction_eau);
        $new_place->blocs->environnement_physique->donnees->reduction_consommation_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->reduction_consommation_eau);
        $new_place->blocs->environnement_physique->donnees->toilette_seche = $this->extract_val($schema->blocs->environnement_physique->donnees->toilette_seche);
        $new_place->blocs->environnement_physique->donnees->captation_eau_pluie = $this->extract_val($schema->blocs->environnement_physique->donnees->captation_eau_pluie);
        $new_place->blocs->environnement_physique->donnees->eau_economisee = $this->extract_val($schema->blocs->environnement_physique->donnees->eau_economisee);
        $new_place->blocs->environnement_physique->donnees->irrigation_limitee = $this->extract_val($schema->blocs->environnement_physique->donnees->irrigation_limitee);
        $new_place->blocs->environnement_physique->donnees->pollution_ressource_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->pollution_ressource_eau);
        $new_place->blocs->environnement_physique->donnees->choix_peinture = $this->extract_val($schema->blocs->environnement_physique->donnees->choix_peinture);
        $new_place->blocs->environnement_physique->donnees->produit_entretien = $this->extract_val($schema->blocs->environnement_physique->donnees->produit_entretien);
        $new_place->blocs->environnement_physique->donnees->environnement_physique_action = $this->extract_val($schema->blocs->environnement_physique->donnees->environnement_physique_action);
        $new_place->blocs->environnement_physique->donnees->environnement_physique_chiffre = $this->extract_val($schema->blocs->environnement_physique->donnees->environnement_physique_chiffre);

        $new_place->blocs->sensibilisation_engagement = new stdClass;
        $new_place->blocs->sensibilisation_engagement->donnees = new stdClass;
        $new_place->blocs->sensibilisation_engagement->donnees->znieff = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->znieff);
        $new_place->blocs->sensibilisation_engagement->donnees->activite_biodiversite = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->activite_biodiversite);
        $new_place->blocs->sensibilisation_engagement->donnees->preservation_environnement = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->preservation_environnement);
        $new_place->blocs->sensibilisation_engagement->donnees->strategie_environnementale = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->strategie_environnementale);
        $new_place->blocs->sensibilisation_engagement->donnees->label = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->label);
        $new_place->blocs->sensibilisation_engagement->donnees->salarie_formes_enjeu_environnemental = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->salarie_formes_enjeu_environnemental);
        $new_place->blocs->sensibilisation_engagement->donnees->formation_solution = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->formation_solution);
        $new_place->blocs->sensibilisation_engagement->donnees->mesure_quantitative = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->mesure_quantitative);
        $new_place->blocs->sensibilisation_engagement->donnees->intervention_sensibilisation = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->intervention_sensibilisation);
        $new_place->blocs->sensibilisation_engagement->donnees->contenu_sensibilisation = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->contenu_sensibilisation);
        $new_place->blocs->sensibilisation_engagement->donnees->communication_action = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->communication_action);
        $new_place->blocs->sensibilisation_engagement->donnees->association_tribune = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->association_tribune);
        $new_place->blocs->sensibilisation_engagement->donnees->essaime_bonne_pratique = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->essaime_bonne_pratique);
        $new_place->blocs->sensibilisation_engagement->donnees->connait_acteur_territoire = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->connait_acteur_territoire);
        $new_place->blocs->sensibilisation_engagement->donnees->partenariat_acteur_transition = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->partenariat_acteur_transition);
        $new_place->blocs->sensibilisation_engagement->donnees->aligne_engagement_territoire = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->aligne_engagement_territoire);
        $new_place->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action);
        $new_place->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_chiffre = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_chiffre);

        if ($exist->count() && $this->option('force') === true) {
            $this->logger->info("Updating in database...");
            DB::table('place_environment')->where('id', $import_file->token)
                ->update([
                    'place_id' => $place->getId(),
                    'data' => json_encode($new_place),
                    'updated_at' => \Carbon\Carbon::now()
                ]);

            $this->logger->info($new_place->name . ' updated');
        } else {
            $this->logger->info('Creating place '.$new_place->name);
            DB::table('place_environment')->insert([
                'id' => $import_file->token,
                'place_id' => $place->getId(),
                'data' => json_encode($new_place),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
            $this->logger->info('Created');
        }
    }

    public function extract_val($keys)
    {
        $this->logger->info('Extracting values', ['keys' => $keys]);

        $key = explode('|', $keys);
        $file = $this->answers;
        foreach ($file as $group_of_answers) {
            if ($group_of_answers->id !== $key[0]) {
                continue;
            }

            // Answer a root level (not in a group)
            if (count($key) === 3) {
                if ($key[1] === "number" and $group_of_answers->{$key[1]}->{$key[2]} === "") {
                    return 0;
                } else {
                    return $group_of_answers->{$key[1]}->{$key[2]};
                }
            }

            $this->logger->info('Group : '.$group_of_answers->title, ['key' => $key[0]]);

            foreach ($group_of_answers->group->answers as $question) {

                if ($question->id !== $key[1]) {
                    continue;
                }

                $this->logger->info('Question : '.$question->title, ['key' => $key[1]]);

                // DEBUG
                if ($key[3] === "choices") {
                    $this->logger->info('Answers type : choices', ['key' => $key[0].'|'.$key[1]]);
                    foreach ($question->{$key[2]}->{$key[3]} as $c) {
                        $this->logger->info('Answer: '.$c);
                    }
                } else {

                    $this->logger->info('Answers type : '.$key[2], ['key' => $key[0].'|'.$key[1]]);
                    $this->logger->info('Answer : '.$question->{$key[2]}->{$key[3]});
                }

                if ($key[2] === "number" and $question->{$key[2]}->{$key[3]} === "") {
                    return 0;
                }

                if ($key[2] === "file_upload") {
                    return $question->{$key[2]};
                }

                return $question->{$key[2]}->{$key[3]};
            }
        }
    }

    public function curl($url, $path = null)
    {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_HTTPHEADER, ['Authorization: Bearer '. $this->typeformToken]);

        if ($path) {
            curl_setopt($c, CURLOPT_FILE, $path);
        }

        curl_exec($c);
        curl_close($c);
    }
}
