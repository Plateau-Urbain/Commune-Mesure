<?php

namespace App\Console\Commands;
use \stdClass;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;
use App\Mail\ImportSocialImpactSuccess;
use Illuminate\Support\Facades\Mail;

class ImportTypeFormSocialImpact extends Command
{
    use ExtractTypeformValue;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform_socialimpact
                                {file : json contenant les réponses d\'un répondant}
                                {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform Questionnaire Effets sociaux";

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema_social_impact.json';

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
        $this->logger = Log::channel('import_social_impact');

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

        $exist = DB::table('places')->where('id',$import_file->token)->get();

        $place_name = $this->extract_val($schema->name, $this->answers, $this->logger, $this->answers, $this->logger);
        if ($exist->count() && $this->option('force') === false){
            $this->logger->notice($place_name." already imported. Use --force to overwrite.");
            die($place_name." already imported. Use --force to overwrite\n");
        }

        $slug = Str::of($place_name)->slug('-');
        $zipcode = $this->extract_val($schema->postalcode, $this->answers, $this->logger);

        $place = Place::searchBySlugAndZipcode($slug, $zipcode);

        try {
            $this->logger->info("Search for " . $slug);
            $place = Place::searchBySlugAndZipcode($slug, $zipcode);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            exit;
        }

        $this->logger->info(['place' => $place_name]);

        if ($this->option('force') === true) {
            $this->logger->info('Force option used');
        }

        $place_data = $place->getData();

        // impact social
        $place_data->blocs->impact_social = new stdClass;
        $place_data->blocs->impact_social->visible = 1;
        $place_data->blocs->impact_social->donnees = new stdClass;
        $place_data->blocs->impact_social->donnees->insertion_professionnelle = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->insertion_professionnelle_nb_personnes = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle_nb_personnes, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->insertion_professionnelle_effets = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle_effets, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion_public = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion_public, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion_type = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->reseaux = $this->extract_val($schema->blocs->impact_social->donnees->reseaux, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->reseaux_type = $this->extract_val($schema->blocs->impact_social->donnees->reseaux_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->reseaux_public = $this->extract_val($schema->blocs->impact_social->donnees->reseaux_public, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->capacite_agir = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->capacite_agir_nombre = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir_nombre, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->capacite_agir_porte = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir_porte, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->sante_bien_être = $this->extract_val($schema->blocs->impact_social->donnees->sante_bien_être, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->sante_effet = $this->extract_val($schema->blocs->impact_social->donnees->sante_effet, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->lien_social = $this->extract_val($schema->blocs->impact_social->donnees->lien_social, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->solidarite = $this->extract_val($schema->blocs->impact_social->donnees->solidarite, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->solidarite_type = $this->extract_val($schema->blocs->impact_social->donnees->solidarite_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->solidarite_public = $this->extract_val($schema->blocs->impact_social->donnees->solidarite_public, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_public = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_public, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_dirigeants = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_dirigeants, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_occupants = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_occupants, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_gestion = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_gestion, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->cadre_de_vie = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->cadre_de_vie_type = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->cadre_de_vie_image = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie_image, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->services_publics = $this->extract_val($schema->blocs->impact_social->donnees->services_publics, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->services_publics_gestion = $this->extract_val($schema->blocs->impact_social->donnees->services_publics_gestion, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->services_publics_besoin_urgent = $this->extract_val($schema->blocs->impact_social->donnees->services_publics_besoin_urgent, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->innovation_publique = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->innovation_publique_effet = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique_effet, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->innovation_publique_type = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique_type, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->intensite_effets_individuels = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_individuels, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->intensite_effets_collectifs = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_collectifs, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->intensite_effets_territoriaux = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_territoriaux, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->mots_cles_effets_individuels = $this->extract_val($schema->blocs->impact_social->donnees->mots_cles_effets_individuels, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->mots_cles_effets_collectifs = $this->extract_val($schema->blocs->impact_social->donnees->mots_cles_effets_collectifs, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->impact_social_public = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_public, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->impact_social_occasion = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_occasion, $this->answers, $this->logger);
        $place_data->blocs->impact_social->donnees->impact_social_frequence = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_frequence, $this->answers, $this->logger);

        $this->logger->info("Saving model");
        $place->data = $place_data;
        $place->save();

        try {
            $creatorEmail = $place->get('creator->email');
            if ($creatorEmail !== null) {
                $this->logger->info('Sending mail to '.$creatorEmail);
                Mail::send(new ImportSocialImpactSuccess($place));
                $this->logger->info('Sent');
            } else {
                $this->logger->info('No email address associated to '. $place->name);
            }

        } catch (\Exception $e) {
            $this->logger->emergency('Failed to send mail : '.$e->getMessage());
            die("Can't send email to : ".$place->name.". Check file ".realpath($f)." for email address");
        }

        $this->logger->info($place_data->name . ' updated');
    }
}
