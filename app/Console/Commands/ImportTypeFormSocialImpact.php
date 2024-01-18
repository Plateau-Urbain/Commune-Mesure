<?php

namespace App\Console\Commands;
use \stdClass;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class ImportTypeFormSocialImpact extends Command
{
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

        $exist = DB::table('places')->where('id',$import_file->token)->get();

        $place_name = $this->extract_val($schema->name);
        if ($exist->count() && $this->option('force') === false){
            $this->logger->notice($place_name." already imported. Use --force to overwrite.");
            die($place_name." already imported. Use --force to overwrite\n");
        }

        $slug = Str::of($place_name)->slug('-');
        $zipcode = $this->extract_val($schema->postalcode);

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
        $place_data->blocs->impact_social->donnees->insertion_professionnelle = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle);
        $place_data->blocs->impact_social->donnees->insertion_professionnelle_nb_personnes = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle_nb_personnes);
        $place_data->blocs->impact_social->donnees->insertion_professionnelle_effets = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle_effets);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion_public = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion_public);
        $place_data->blocs->impact_social->donnees->appartenance_exclusion_type = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion_type);
        $place_data->blocs->impact_social->donnees->reseaux = $this->extract_val($schema->blocs->impact_social->donnees->reseaux);
        $place_data->blocs->impact_social->donnees->reseaux_type = $this->extract_val($schema->blocs->impact_social->donnees->reseaux_type);
        $place_data->blocs->impact_social->donnees->reseaux_public = $this->extract_val($schema->blocs->impact_social->donnees->reseaux_public);
        $place_data->blocs->impact_social->donnees->capacite_agir = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir);
        $place_data->blocs->impact_social->donnees->capacite_agir_nombre = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir_nombre);
        $place_data->blocs->impact_social->donnees->capacite_agir_porte = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir_porte);
        $place_data->blocs->impact_social->donnees->sante_bien_être = $this->extract_val($schema->blocs->impact_social->donnees->sante_bien_être);
        $place_data->blocs->impact_social->donnees->sante_effet = $this->extract_val($schema->blocs->impact_social->donnees->sante_effet);
        $place_data->blocs->impact_social->donnees->lien_social = $this->extract_val($schema->blocs->impact_social->donnees->lien_social);
        $place_data->blocs->impact_social->donnees->solidarite = $this->extract_val($schema->blocs->impact_social->donnees->solidarite);
        $place_data->blocs->impact_social->donnees->solidarite_type = $this->extract_val($schema->blocs->impact_social->donnees->solidarite_type);
        $place_data->blocs->impact_social->donnees->solidarite_public = $this->extract_val($schema->blocs->impact_social->donnees->solidarite_public);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_public = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_public);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_dirigeants = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_dirigeants);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_occupants = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_occupants);
        $place_data->blocs->impact_social->donnees->egalite_homme_femme_gestion = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme_gestion);
        $place_data->blocs->impact_social->donnees->cadre_de_vie = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie);
        $place_data->blocs->impact_social->donnees->cadre_de_vie_type = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie_type);
        $place_data->blocs->impact_social->donnees->cadre_de_vie_image = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie_image);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_type);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_positif_example);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_type);
        $place_data->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces_effets_negatif_example);
        $place_data->blocs->impact_social->donnees->services_publics = $this->extract_val($schema->blocs->impact_social->donnees->services_publics);
        $place_data->blocs->impact_social->donnees->services_publics_gestion = $this->extract_val($schema->blocs->impact_social->donnees->services_publics_gestion);
        $place_data->blocs->impact_social->donnees->services_publics_besoin_urgent = $this->extract_val($schema->blocs->impact_social->donnees->services_publics_besoin_urgent);
        $place_data->blocs->impact_social->donnees->innovation_publique = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique);
        $place_data->blocs->impact_social->donnees->innovation_publique_effet = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique_effet);
        $place_data->blocs->impact_social->donnees->innovation_publique_type = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique_type);
        $place_data->blocs->impact_social->donnees->intensite_effets_individuels = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_individuels);
        $place_data->blocs->impact_social->donnees->intensite_effets_collectifs = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_collectifs);
        $place_data->blocs->impact_social->donnees->intensite_effets_territoriaux = $this->extract_val($schema->blocs->impact_social->donnees->intensite_effets_territoriaux);
        $place_data->blocs->impact_social->donnees->mots_cles_effets_individuels = $this->extract_val($schema->blocs->impact_social->donnees->mots_cles_effets_individuels);
        $place_data->blocs->impact_social->donnees->mots_cles_effets_collectifs = $this->extract_val($schema->blocs->impact_social->donnees->mots_cles_effets_collectifs);
        $place_data->blocs->impact_social->donnees->impact_social_public = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_public);
        $place_data->blocs->impact_social->donnees->impact_social_occasion = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_occasion);
        $place_data->blocs->impact_social->donnees->impact_social_frequence = $this->extract_val($schema->blocs->impact_social->donnees->impact_social_frequence);

        $this->logger->info("Saving model");
        $place->data = $place_data;
        $place->save();

        $this->logger->info($place_data->name . ' updated');

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
