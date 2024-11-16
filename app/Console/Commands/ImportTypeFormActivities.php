<?php

namespace App\Console\Commands;

ini_set('memory_limit', '256M');

use App\Models\Place;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class ImportTypeFormActivities extends Command
{

    use ExtractTypeformValue;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform_activities
                                {file : json contenant les réponses d\'un répondant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer la partie programmation du typeform information générale (rattrapage)";

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema_general_information.json';

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
        $this->logger = Log::channel('import_general_information');

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
        $this->logger->info("----------------------- Nouvel import programmation -----------------------");
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

        $place_name = $this->extract_val($schema->name, $this->answers, $this->logger);

        $slug = Str::of($place_name)->slug('-');
        $zipcode = $this->extract_val($schema->address->postalcode, $this->answers, $this->logger);

        $place = null;
        try {
            $place = Place::searchBySlugAndZipcode($slug, $zipcode);
            if ($place == null) {
                $this->logger->alert("Place null");
                return;
            }
        } catch (\Exception $e) {
            $this->logger->alert("Place not found");
            return;
        }

        $this->logger->withContext(['place' => $place_name]);

        $activites = [];

        foreach ($schema->activites as $activite => $val) {
            $present = $this->extract_val($val, $this->answers, $this->logger);

            if ($present === true) {
                $activites[] = $activite;
            }
        }

        $data = $place->getData();
        $data->activites = $activites;

        $this->logger->info("Updating in database...");
        DB::table('places')->where('id', $import_file->token)
                            ->where('zipcode', $data->address->postalcode)
                            ->where('type_donnees', 'datapanorama')
                            ->update([
                                'place' => $place->getSlug(),
                                'data' => json_encode($data),
                                'updated_at' => \Carbon\Carbon::now()
                            ]);

        $this->logger->info($place->name . ' activities updated');
    }
}
