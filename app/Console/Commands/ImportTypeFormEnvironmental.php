<?php

namespace App\Console\Commands;
use \stdClass;
use App\Mail\ImportEnvironmentSuccess;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;


class ImportTypeFormEnvironmental extends Command
{

    use ExtractTypeformValue;

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
        $this->logger = Log::channel('import_environmental');

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
        $this->logger->info("");
        $this->logger->info("---------------------------------------------------------------------------");
        $this->logger->info("------------------------------ Nouvel import ------------------------------");
        $this->logger->info("---------------------------------------------------------------------------");
        $this->logger->info("");

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

        $place_name = $this->extract_val($schema->nom, $this->answers, $this->logger);
        if ($exist->count() && $this->option('force') === false){
            $this->logger->notice($place_name." already imported. Use --force to overwrite.");
            die($place_name." already imported. Use --force to overwrite\n");
        }

        $slug = Str::of($place_name)->slug('-');
        $zipcode = $this->extract_val($schema->blocs->presentation->donnees->code_postal, $this->answers, $this->logger, $this->answers, $this->logger);

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
        $new_place->name = $this->extract_val($schema->nom, $this->answers, $this->logger);
        $new_place->share_data = $this->extract_val($schema->share_data, $this->answers, $this->logger);
        $new_place->share_email = $this->extract_val($schema->share_email, $this->answers, $this->logger);

        $new_place->blocs = new stdClass;
        $new_place->blocs->presentation = new stdClass;
        $new_place->blocs->presentation->donnees = new stdClass;
        $new_place->blocs->presentation->donnees->ville = $this->extract_val($schema->blocs->presentation->donnees->ville, $this->answers, $this->logger);
        $new_place->blocs->presentation->donnees->code_postal = $this->extract_val($schema->blocs->presentation->donnees->code_postal, $this->answers, $this->logger);
        $new_place->blocs->presentation->donnees->raison_etre = $this->extract_val($schema->blocs->presentation->donnees->raison_etre, $this->answers, $this->logger);
        $new_place->blocs->presentation->donnees->avancement_projet = $this->extract_val($schema->blocs->presentation->donnees->avancement_projet, $this->answers, $this->logger);

        $new_place->blocs->circularite_sobriete = new stdClass;
        $new_place->blocs->circularite_sobriete->donnees = new stdClass;
        $new_place->blocs->circularite_sobriete->donnees->reutilisation_objet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->reutilisation_objet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->equipement_partage = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_partage, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->reparation_objet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->reparation_objet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->limitation_achat = $this->extract_val($schema->blocs->circularite_sobriete->donnees->limitation_achat, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->limitation_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->limitation_dechet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->equipement_reutilisable = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_reutilisable, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->equipement_reconditionne = $this->extract_val($schema->blocs->circularite_sobriete->donnees->equipement_reconditionne, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->distributeur_local = $this->extract_val($schema->blocs->circularite_sobriete->donnees->distributeur_local, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->charte_selection_fournisseur = $this->extract_val($schema->blocs->circularite_sobriete->donnees->charte_selection_fournisseur, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->optimisation_achat = $this->extract_val($schema->blocs->circularite_sobriete->donnees->optimisation_achat, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->alimentation_locale = $this->extract_val($schema->blocs->circularite_sobriete->donnees->alimentation_locale, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->demarche_zero_dechets = $this->extract_val($schema->blocs->circularite_sobriete->donnees->demarche_zero_dechets, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->low_tech = $this->extract_val($schema->blocs->circularite_sobriete->donnees->low_tech, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->eco_conception = $this->extract_val($schema->blocs->circularite_sobriete->donnees->eco_conception, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->fontaine_eau = $this->extract_val($schema->blocs->circularite_sobriete->donnees->fontaine_eau, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->bio_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->bio_dechet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->recycle_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->recycle_dechet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->dechet_atelier_revalorise = $this->extract_val($schema->blocs->circularite_sobriete->donnees->dechet_atelier_revalorise, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->point_collecte_dechet = $this->extract_val($schema->blocs->circularite_sobriete->donnees->point_collecte_dechet, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->circularite_sobriete_action = $this->extract_val($schema->blocs->circularite_sobriete->donnees->circularite_sobriete_action, $this->answers, $this->logger);
        $new_place->blocs->circularite_sobriete->donnees->circularite_sobriete_chiffre = $this->extract_val($schema->blocs->circularite_sobriete->donnees->circularite_sobriete_chiffre, $this->answers, $this->logger);

        $new_place->blocs->emission_gaz_effet_serre = new stdClass;
        $new_place->blocs->emission_gaz_effet_serre->donnees = new stdClass;
        $new_place->blocs->emission_gaz_effet_serre->donnees->ges_identifie = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->ges_identifie, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->bilan_carbon_calcule = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->bilan_carbon_calcule, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->strategie_enjeu_climatique = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->strategie_enjeu_climatique, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->covoiturage = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->covoiturage, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->accueil_velo = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->accueil_velo, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->forfait_mobilite_durable = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->forfait_mobilite_durable, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_usager_occasionnel = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_usager_occasionnel, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_fournisseur = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->mobilite_douce_fournisseur, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->restauration = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->restauration, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->type_alimentation = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->type_alimentation, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->soutien_vegetarien = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->soutien_vegetarien, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->alimentation_saison = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->alimentation_saison, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->approvisionnement_local = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->approvisionnement_local, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->batiment_energie_positive = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->batiment_energie_positive, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->batiment_isolation_chaleur = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->batiment_isolation_chaleur, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->dpe = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->dpe, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->eco_energie_tertiaire = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->eco_energie_tertiaire, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->temperature_raisonnable = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->temperature_raisonnable, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->fournisseur_energie_verte = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->fournisseur_energie_verte, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->energie_produite_site = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->energie_produite_site, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->sobriete_numerique = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->sobriete_numerique, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->appareil_econome = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->appareil_econome, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_action, $this->answers, $this->logger);
        $new_place->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_chiffre = $this->extract_val($schema->blocs->emission_gaz_effet_serre->donnees->emission_gaz_effet_serre_chiffre, $this->answers, $this->logger);

        $new_place->blocs->biodiversite = new stdClass;
        $new_place->blocs->biodiversite->donnees = new stdClass;
        $new_place->blocs->biodiversite->donnees->espace_exterieur = $this->extract_val($schema->blocs->biodiversite->donnees->espace_exterieur, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->suivi_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->suivi_biodiversite, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->pratique_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->pratique_biodiversite, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->colonisation_faune = $this->extract_val($schema->blocs->biodiversite->donnees->colonisation_faune, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->corridor_ecologique = $this->extract_val($schema->blocs->biodiversite->donnees->corridor_ecologique, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->arbre_pleine_terre = $this->extract_val($schema->blocs->biodiversite->donnees->arbre_pleine_terre, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->reduction_pollution_lumineuse = $this->extract_val($schema->blocs->biodiversite->donnees->reduction_pollution_lumineuse, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->reduction_pollution_sonore = $this->extract_val($schema->blocs->biodiversite->donnees->reduction_pollution_sonore, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->habitat_biodiversite = $this->extract_val($schema->blocs->biodiversite->donnees->habitat_biodiversite, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->encourage_diversite = $this->extract_val($schema->blocs->biodiversite->donnees->encourage_diversite, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->espace_vegetalise = $this->extract_val($schema->blocs->biodiversite->donnees->espace_vegetalise, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->biodiversite_action = $this->extract_val($schema->blocs->biodiversite->donnees->biodiversite_action, $this->answers, $this->logger);
        $new_place->blocs->biodiversite->donnees->biodiversite_chiffre = $this->extract_val($schema->blocs->biodiversite->donnees->biodiversite_chiffre, $this->answers, $this->logger);

        $new_place->blocs->environnement_physique = new stdClass;
        $new_place->blocs->environnement_physique->donnees = new stdClass;
        $new_place->blocs->environnement_physique->donnees->risque_rarefaction_ressource = $this->extract_val($schema->blocs->environnement_physique->donnees->risque_rarefaction_ressource, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->risques = $this->extract_val($schema->blocs->environnement_physique->donnees->risques, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->risque_concerne = $this->extract_val($schema->blocs->environnement_physique->donnees->risque_concerne, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->activite_depend = $this->extract_val($schema->blocs->environnement_physique->donnees->activite_depend, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->activite_agricole = $this->extract_val($schema->blocs->environnement_physique->donnees->activite_agricole, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->fertilisation_chimique_bannie = $this->extract_val($schema->blocs->environnement_physique->donnees->fertilisation_chimique_bannie, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->pesticide_chimique_banni = $this->extract_val($schema->blocs->environnement_physique->donnees->pesticide_chimique_banni, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->culture_respectueuse = $this->extract_val($schema->blocs->environnement_physique->donnees->culture_respectueuse, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->agriculture_durable = $this->extract_val($schema->blocs->environnement_physique->donnees->agriculture_durable, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->regeneration_sol = $this->extract_val($schema->blocs->environnement_physique->donnees->regeneration_sol, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->ancienne_friche = $this->extract_val($schema->blocs->environnement_physique->donnees->ancienne_friche, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->refertilisation = $this->extract_val($schema->blocs->environnement_physique->donnees->refertilisation, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->artificialisation_sol = $this->extract_val($schema->blocs->environnement_physique->donnees->artificialisation_sol, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->utilisation_projet_complementaire = $this->extract_val($schema->blocs->environnement_physique->donnees->utilisation_projet_complementaire, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->espace_modulable = $this->extract_val($schema->blocs->environnement_physique->donnees->espace_modulable, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->restriction_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->restriction_eau, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->reduction_consommation_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->reduction_consommation_eau, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->toilette_seche = $this->extract_val($schema->blocs->environnement_physique->donnees->toilette_seche, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->captation_eau_pluie = $this->extract_val($schema->blocs->environnement_physique->donnees->captation_eau_pluie, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->eau_economisee = $this->extract_val($schema->blocs->environnement_physique->donnees->eau_economisee, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->irrigation_limitee = $this->extract_val($schema->blocs->environnement_physique->donnees->irrigation_limitee, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->pollution_ressource_eau = $this->extract_val($schema->blocs->environnement_physique->donnees->pollution_ressource_eau, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->choix_peinture = $this->extract_val($schema->blocs->environnement_physique->donnees->choix_peinture, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->produit_entretien = $this->extract_val($schema->blocs->environnement_physique->donnees->produit_entretien, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->environnement_physique_action = $this->extract_val($schema->blocs->environnement_physique->donnees->environnement_physique_action, $this->answers, $this->logger);
        $new_place->blocs->environnement_physique->donnees->environnement_physique_chiffre = $this->extract_val($schema->blocs->environnement_physique->donnees->environnement_physique_chiffre, $this->answers, $this->logger);

        $new_place->blocs->sensibilisation_engagement = new stdClass;
        $new_place->blocs->sensibilisation_engagement->donnees = new stdClass;
        $new_place->blocs->sensibilisation_engagement->donnees->znieff = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->znieff, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->activite_biodiversite = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->activite_biodiversite, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->preservation_environnement = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->preservation_environnement, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->strategie_environnementale = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->strategie_environnementale, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->label = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->label, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->salarie_formes_enjeu_environnemental = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->salarie_formes_enjeu_environnemental, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->formation_solution = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->formation_solution, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->mesure_quantitative = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->mesure_quantitative, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->intervention_sensibilisation = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->intervention_sensibilisation, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->contenu_sensibilisation = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->contenu_sensibilisation, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->communication_action = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->communication_action, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->association_tribune = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->association_tribune, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->essaime_bonne_pratique = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->essaime_bonne_pratique, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->connait_acteur_territoire = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->connait_acteur_territoire, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->partenariat_acteur_transition = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->partenariat_acteur_transition, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->aligne_engagement_territoire = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->aligne_engagement_territoire, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_action, $this->answers, $this->logger);
        $new_place->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_chiffre = $this->extract_val($schema->blocs->sensibilisation_engagement->donnees->sensibilisation_engagement_chiffre, $this->answers, $this->logger);

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

            try {
                $creatorEmail = $place->get('creator->email');
                if ($creatorEmail !== null) {
                    $this->logger->info('Sending mail to '.$creatorEmail);
                    Mail::send(new ImportEnvironmentSuccess($place));
                    $this->logger->info('Sent');
                } else {
                    $this->logger->info('No email address associated to '. $new_place->name);
                }

            } catch (\Exception $e) {
                $this->logger->emergency('Failed to send mail : '.$e->getMessage());
                die("Can't send email to : ".$new_place->name.". Check file ".realpath($f)." for email address");
            }
        }
    }
}
