<?php

namespace App\Console\Commands;
use \stdClass;
use App\Exports\BDDJsonExport;
use App\Exports\OriginalJsonExport;
use App\Models\Place;
use App\Mail\ImportGeneralInformationSuccess;
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

class ImportTypeFormGeneralInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform_generalinformation
                                {file : json contenant les réponses d\'un répondant}
                                {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importer les données reponses du typeform information générale";

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

        $this->logger->withContext(['place' => $place_name]);

        if ($this->option('force') === true) {
            $this->logger->info('Force option used');
        }

        $new_place = new stdClass;
        $new_place->name = $place_name;
        $new_place->status = $this->extract_val($schema->status);
        $new_place->publish = true;
        $new_place->tags = [];
        $new_place->address = new stdClass;
        $new_place->address->address = $this->extract_val($schema->address->address);
        $new_place->address->postalcode = $this->extract_val($schema->address->postalcode);

        // Createur
        $new_place->creator = new stdClass;
        $new_place->creator->name = $this->extract_val($schema->creator->name);
        $new_place->creator->email = $this->extract_val($schema->creator->email);

        //presentation
        $new_place->blocs = new stdClass;
        $new_place->blocs->presentation = new stdClass;
        $new_place->blocs->presentation->visible = 1;
        $new_place->blocs->presentation->donnees = new stdClass;
        $new_place->blocs->presentation->donnees->idee_fondatrice = $this->extract_val($schema->blocs->presentation->donnees->idee_fondatrice);
        $new_place->blocs->presentation->donnees->nombre_occupants = $this->extract_val($schema->blocs->presentation->donnees->nombre_occupants);
        $new_place->blocs->presentation->donnees->noms_occupants = $this->extract_val($schema->blocs->presentation->donnees->noms_occupants);
        $new_place->blocs->presentation->donnees->nb_manager = $this->extract_val($schema->blocs->presentation->donnees->nb_manager);

        $date_ouverture = $this->extract_val($schema->blocs->presentation->donnees->date_ouverture);
        $date_creation = $this->extract_val($schema->blocs->presentation->donnees->date_creation);
        if (empty($date_creation)) {
            $date_creation = $date_ouverture;
        }
        $new_place->blocs->presentation->donnees->date_ouverture = ($date_ouverture) ? Carbon::createFromIsoFormat('L', $date_ouverture, null, config('app.locale')) : '';
        $new_place->blocs->presentation->donnees->date_creation = ($date_creation) ? Carbon::createFromIsoFormat('L', $date_creation, null, config('app.locale')) : '';
        $new_place->blocs->presentation->donnees->date_fermeture = '';
        $new_place->blocs->presentation->donnees->surface = $this->extract_val($schema->blocs->presentation->donnees->surface);
        $new_place->blocs->presentation->donnees->{"emplois directs"} = 0;

        foreach ($schema->blocs->presentation->donnees->{"emplois directs"} as $answer) {
            $val = str_replace(',', '.', $this->extract_val($answer));
            if (is_numeric($val)) {
                $new_place->blocs->presentation->donnees->{"emplois directs"} += $val;
            }
        }

        $new_place->blocs->presentation->donnees->acteurs_publics = $this->extract_val($schema->blocs->presentation->donnees->acteurs_publics);
        $new_place->blocs->presentation->donnees->acteurs_prives = $this->extract_val($schema->blocs->presentation->donnees->acteurs_prives);

        $new_place->blocs->presentation->donnees->natures_partenariats = new stdClass;
        $new_place->blocs->presentation->donnees->natures_partenariats->public = $this->extract_val($schema->blocs->presentation->donnees->natures_partenariats->public);
        $new_place->blocs->presentation->donnees->natures_partenariats->prive = $this->extract_val($schema->blocs->presentation->donnees->natures_partenariats->prive);

        $ouvertures_choices = [];
        $ouvertures_choices = $this->extract_val($schema->blocs->presentation->donnees->ouverture->{"En permanence"});

        $new_place->blocs->presentation->donnees->ouverture = new stdClass;
        $new_place->blocs->presentation->donnees->ouverture = $schema->blocs->presentation->donnees->ouverture;
        $new_place->blocs->presentation->donnees->ouverture->{"En permanence"} = 0;

        foreach ($ouvertures_choices as $oc) {
            $new_place->blocs->presentation->donnees->ouverture->$oc = 1;
        }

        $new_place->blocs->presentation->donnees->surfaces = new stdClass;
        $new_place->blocs->presentation->donnees->surfaces->totale = $this->extract_val($schema->blocs->presentation->donnees->surfaces->totale);
        $new_place->blocs->presentation->donnees->surfaces->exterieur = $this->extract_val($schema->blocs->presentation->donnees->surfaces->exterieur);
        $new_place->blocs->presentation->donnees->surfaces->bureau = $this->extract_val($schema->blocs->presentation->donnees->surfaces->bureau);
        $new_place->blocs->presentation->donnees->surfaces->atelier = $this->extract_val($schema->blocs->presentation->donnees->surfaces->atelier);
        $new_place->blocs->presentation->donnees->surfaces->agriculture = $this->extract_val($schema->blocs->presentation->donnees->surfaces->agriculture);

        $new_place->blocs->presentation->donnees->thematiques = $this->extract_val($schema->blocs->presentation->donnees->thematiques);

        // Accessibilite
        $public_choices = [];
        $public_choices = $this->extract_val($schema->blocs->accessibilite->donnees->publics->{"Chercheurs d'emplois"});

        $new_place->blocs->accessibilite = new stdClass;
        $new_place->blocs->accessibilite->visible = 1;
        $new_place->blocs->accessibilite->donnees = new stdClass;
        $new_place->blocs->accessibilite->donnees->publics = $schema->blocs->accessibilite->donnees->publics;
        $new_place->blocs->accessibilite->donnees->publics->{"Chercheurs d'emplois"} = 0;

        foreach ($public_choices as $pc) {
            $new_place->blocs->accessibilite->donnees->publics->{$pc} = 1;
        }

        $new_place->blocs->accessibilite->donnees->accessibilite = new stdClass;
        $new_place->blocs->accessibilite->donnees->accessibilite = $schema->blocs->accessibilite->donnees->accessibilite;
        $new_place->blocs->accessibilite->donnees->accessibilite->{"Handicapés"} = ($this->extract_val($schema->blocs->accessibilite->donnees->accessibilite->{"Handicapés"}) === "Yes")
            ? 1
            : 0;


        $transport_choices = [];
        $transport_choices = $this->extract_val($schema->blocs->accessibilite->donnees->transports->Bus);

        $new_place->blocs->accessibilite->donnees->transports = new stdClass;
        $new_place->blocs->accessibilite->donnees->transports = $schema->blocs->accessibilite->donnees->transports;

        $new_place->blocs->accessibilite->donnees->transports = $schema->blocs->accessibilite->donnees->transports;
        $new_place->blocs->accessibilite->donnees->transports->Bus = 0;

        foreach ($transport_choices as $tc) {
            $new_place->blocs->accessibilite->donnees->transports->{$tc} = 1;
        }


        // valeurs
        $valeurs_choices = [];
        $valeurs_choices = $this->extract_val($schema->blocs->valeurs->donnees->Accueil);

        $new_place->blocs->valeurs = new stdClass;
        $new_place->blocs->valeurs->visible = 1;
        $new_place->blocs->valeurs->donnees = new stdClass;
        $new_place->blocs->valeurs->donnees = $schema->blocs->valeurs->donnees;
        $new_place->blocs->valeurs->donnees->Accueil = 0;

        $count = 0;
        foreach ($valeurs_choices as $vc) {
          if($count > 3){
            continue;
          }
          if(array_key_exists($vc,json_decode(json_encode($new_place->blocs->valeurs->donnees), true))){
            $new_place->blocs->valeurs->donnees->{$vc} = 1;
            $count++;
          }
        }

        // texte des valeurs
        $new_place->blocs->valeurs->texte = new stdClass;

        // moyens
        $new_place->blocs->moyens = new stdClass;
        $new_place->blocs->moyens->visible = 1;
        $new_place->blocs->moyens->donnees = new stdClass;
        $new_place->blocs->moyens->donnees->investissement = new stdClass;
        $new_place->blocs->moyens->donnees->investissement->{"Fonds publics"} = $this->extract_val($schema->blocs->moyens->donnees->investissement->{"Fonds publics"});
        $new_place->blocs->moyens->donnees->investissement->{"Fonds privés"} = $this->extract_val($schema->blocs->moyens->donnees->investissement->{"Fonds privés"});
        $new_place->blocs->moyens->donnees->investissement->{"Fonds apportés"} = 0;
        $new_place->blocs->moyens->donnees->fonctionnement = new stdClass;
        $new_place->blocs->moyens->donnees->fonctionnement->{"Autres Subventions"} = $this->extract_val($schema->blocs->moyens->donnees->fonctionnement->{"Autres Subventions"});
        $new_place->blocs->moyens->donnees->fonctionnement->{"Aides privées"} = $this->extract_val($schema->blocs->moyens->donnees->fonctionnement->{"Aides privées"});
        $new_place->blocs->moyens->donnees->fonctionnement->{"Aides publiques"} = $this->extract_val($schema->blocs->moyens->donnees->fonctionnement->{"Aides publiques"});
        $new_place->blocs->moyens->donnees->fonctionnement->{"Recettes"} = $this->extract_val($schema->blocs->moyens->donnees->fonctionnement->{"Recettes"});
        $new_place->blocs->moyens->donnees->benevoles = $this->extract_val($schema->blocs->moyens->donnees->benevoles);

        $partenaires = 0;
        $pubpriv = $schema->blocs->moyens->donnees->partenaires;
        if ($this->extract_val("fzsbr9WEujZQ|96UejUyeCROl|yes_no|value") === "Yes") {
            $pub = $this->extract_val($pubpriv[0]); // public

            if (strlen($pub) == 0) {
                $partenaires += 0;
            } elseif (strpos($pub, "\n")) {
                $partenaires += count(explode("\n", $pub));
            } elseif (strpos($pub, ", ")) {
                $partenaires += count(explode(", ", $pub));
            } elseif (strpos($pub, " - ")) {
                $partenaires += count(explode(' - ', $pub));
            } else {
                $partenaires++;
            }
        }

        if ($this->extract_val("fzsbr9WEujZQ|KY0NcflXUycv|yes_no|value") === "Yes") {
            $priv = $this->extract_val($pubpriv[1]); // prive

            if (strlen($priv) == 0) {
                $partenaires += 0;
            } elseif (strpos($priv, "\n")) {
                $partenaires += count(explode("\n", $priv));
            } elseif (strpos($priv, ", ")) {
                $partenaires += count(explode(", ", $priv));
            } elseif (strpos($priv, " - ")) {
                $partenaires += count(explode(' - ', $priv));
            } else {
                $partenaires++;
            }
        }

        $new_place->blocs->moyens->donnees->partenaires = $partenaires;

        // composition
        $new_place->blocs->composition = new stdClass;
        $new_place->blocs->composition->visible = 1;
        $new_place->blocs->composition->donnees = new stdClass;
        $new_place->blocs->composition->donnees->type = new stdClass;
        $new_place->blocs->composition->donnees->type->Entreprises = $this->extract_val($schema->blocs->composition->donnees->type->Entreprises);
        $new_place->blocs->composition->donnees->type->Associations = $this->extract_val($schema->blocs->composition->donnees->type->Associations);
        $new_place->blocs->composition->donnees->type->Artistes = $this->extract_val($schema->blocs->composition->donnees->type->Artistes);
        $new_place->blocs->composition->donnees->type->{"Autres structures"} = $this->extract_val($schema->blocs->composition->donnees->type->{"Autres structures"});
        $new_place->blocs->composition->donnees->structures_crees = $this->extract_val($schema->blocs->composition->donnees->structures_crees);

        // galerie
        $new_place->blocs->galerie = new stdClass;
        $new_place->blocs->galerie->visible = 1;
        $new_place->blocs->galerie->donnees = [];

        // reseaux sociaux
        $new_place->reseaux_sociaux = new stdClass;
        $new_place->reseaux_sociaux->visible = 1;
        $new_place->reseaux_sociaux->donnees = new stdClass;

        foreach ($schema->reseaux_sociaux->donnees as $k => $reseau) {
            $new_place->reseaux_sociaux->donnees->$k = $this->extract_val($schema->reseaux_sociaux->donnees->$k);
        }

        // evenements
        $new_place->evenements = new stdClass;
        $new_place->evenements->publics = new stdClass;
        $new_place->evenements->publics->nombre = $this->extract_val($schema->evenements->publics->nombre);
        $new_place->evenements->publics->{"personnes accueillies"} = $this->extract_val($schema->evenements->publics->{"personnes accueillies"});
        $new_place->evenements->prives = new stdClass;
        $new_place->evenements->prives->nombre = $this->extract_val($schema->evenements->prives->nombre);
        $new_place->evenements->prives->{"personnes accueillies"} = $this->extract_val($schema->evenements->prives->{"personnes accueillies"});

        // activites
        $new_place->activites = [];

        foreach ($schema->activites as $activite => $val) {
            $present = $this->extract_val($val);

            if ($present === 'Yes') {
                $new_place->activites[] = $activite;
            }
        }

        // geojson
        $new_place->blocs->data_territoire = new stdClass;
        $new_place->blocs->data_territoire->visible = 1;
        $new_place->blocs->data_territoire->donnees = new stdClass;

        // images
        $new_place->blocs->galerie->donnees = [];
        $info_photo = $this->extract_val($schema->blocs->galerie->donnees);

        $this->logger->info("Does it have a photo ?");

        if ($info_photo->file_url && substr($info_photo->file_name, -4) !== '.pdf') {
            $this->logger->info("Found !", ['filename' => $info_photo->file_name]);

            $pathinfo = pathinfo($info_photo->file_name);
            $filename = Str::of($new_place->name.'-'.$pathinfo['filename'])->slug('-').'.'.($pathinfo['extension'] ?? str_replace('image/', '', mime_content_type($info_photo->filename)));
            $dest_dir = base_path()."/public/images/lieux/";

            $file_path = implode(DIRECTORY_SEPARATOR, [
                storage_path('import'),
                Str::of($new_place->name)->slug('-'),
                $filename
            ]);

            $this->logger->info("File will be saved to : ".$file_path);

            if (! is_dir(dirname($file_path))) {
                mkdir(dirname($file_path), 0755, true);
            }

            $this->logger->info("Downloading file... ".$info_photo->file_url);
            $photo = fopen($file_path, "w");
            $this->curl($info_photo->file_url, $photo);
            fclose($photo);
            $this->logger->info("Done!");

            if (filesize($file_path) > 11 && exif_imagetype($file_path) !== false) {
                $new_place->blocs->galerie->donnees[] = $filename;
                $this->logger->info("Saving it into the json");

                if (! is_dir($dest_dir)) {
                    mkdir($dest_dir, 0755, true);
                }

                $this->logger->info("Moving it to : ".$dest_dir.$filename);
                rename($file_path, $dest_dir.$filename);

                $this->logger->info("Resizing it...");
                $process = new Process(['bash', base_path().'/bin/resize_one_place_img.sh', $filename]);
                $process->run();

                // executes after the command finishes
                if (! $process->isSuccessful()) {
                    $this->logger->alert("Error while resizing !!!", ['output' => sprintf('Command: "%s" failed. Exit code: %s(%s)', $process->getCommandLine(), $process->getExitCode() ?? 999, $process->getExitCodeText() ?? 'Unknown exit code')]);
                    $this->logger->emergency("Import aborted");
                    throw new ProcessFailedException($process);
                }
                $this->logger->info("Done resizing it.");

            } else { $this->logger->notice('Wrong file format !'); }
        } else { $this->logger->info('No'); }

        // insee
        $this->logger->info('Downloading insee information...', ['adresse' => $new_place->address->address.", ".$new_place->address->postalcode]);
        $output = new BufferedOutput();
        try {
            Artisan::call('iris:load', [
                'adresse' => $new_place->address->address.", ".$new_place->address->postalcode
            ], $output);
            //FacadesStorage::put('file.json', $output->fetch());
            $new_place->blocs->data_territoire->donnees = json_decode($output->fetch());
           // dd($new_place->blocs->data_territoire->donnees);

            // on récupere l'info de la ville dans les données geojson de l'insee
            $new_place->address->city = $new_place->blocs->data_territoire->donnees->geo->geo_json->commune->properties->nom;
        } catch (\Exception $e) {
            $this->logger->alert('Insee information failed : '.$e->getMessage());
            $this->logger->emergency("Import aborted");
            $stderr = (new ConsoleOutput())->getErrorOutput();
            $stderr->writeln("Downloading insee information failed for : ".$new_place->name);

            $adresse = ['adresse' => $new_place->address->address.", ".$new_place->address->postalcode];
            $this->logger->info('Fallback...', $adresse);
            $geogouv = json_decode(file_get_contents("https://api-adresse.data.gouv.fr/search/?q=".urlencode(implode($adresse))));
            $new_place->blocs->data_territoire->donnees->geo = [
                'lat' => $geogouv->features[0]->geometry->coordinates[1],
                'lon' => $geogouv->features[0]->geometry->coordinates[0]
            ];
            $new_place->address->city = $geogouv->features[0]->properties->city;
        }

        if ($exist->count() && $this->option('force') === true) {
            $this->logger->info("Updating in database...");
            DB::table('places')->where('id', $import_file->token)
                               ->where('type_donnees', 'datapanorama')
                               ->update([
                                   'place' => Str::of($new_place->name)->slug('-'),
                                   'data' => json_encode($new_place),
                                   'updated_at' => \Carbon\Carbon::now()
                               ]);

            $this->logger->info($new_place->name . ' updated');
        } else {
            $this->logger->info('Creating place '.$new_place->name);
            DB::table('places')->insert([
                'id' => $import_file->token,
                'place' => Str::of($new_place->name)->slug('-'),
                'data' => json_encode($new_place),
                'type_donnees' => 'datapanorama',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
            $this->logger->info('Created');

            $this->logger->info('Generating a new hash');
            $this->call('admin:generate-hash', [
                'place' => Str::of($new_place->name)->slug('-')
            ]);

            $place = Place::find(Str::of($new_place->name)->slug('-'));

            try {
                $this->logger->info('Sending mail to '.$new_place->creator->name);
                Mail::send(new ImportGeneralInformationSuccess($place));
                $this->logger->info('Sent');

                $exportOriginal = new OriginalJsonExport($f);
                $exportOriginal->setExportDir(storage_path('exports'));
                $exportOriginal->save();

                $exportBDD = new BDDJsonExport($place->getSlug());
                $exportBDD->setExportDir(storage_path('exports'));
                $exportBDD->save();

                $this->logger->info('Place exported to '.storage_path('exports'));
            } catch (\InvalidArgumentException $e) {
                $this->logger->emergency('Failed to export : '.$e->getMessage());
            } catch (\ErrorException $e) {
                $this->logger->emergency('Failed to send mail : '.$e->getMessage());
                die("Can't send email to : ".$new_place->name.". Check file ".realpath($f)." for email address");
            }
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
