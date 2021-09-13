<?php

namespace App\Console\Commands;

use \stdClass;
use App\Models\Place;
use App\Mail\ImportSuccess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use \Carbon\Carbon;

class ImportTypeForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:typeform
                                {file : json contenant les réponses d\'un répondant}
                                {--force}';

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
     * answers file
     *
     * @var string
     */
    protected $answers;

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
        $this->answers = $import_file->answers;

        $exist = DB::table('places')->where('id',$import_file->token)->get();

        if ($exist->count() && $this->option('force') === false){
            die($this->extract_val($schema->name)." already imported. Use --force to overwrite\n");
        }

        $new_place = new stdClass;
        $new_place->name = $this->extract_val($schema->name);
        $new_place->status = $this->extract_val($schema->status);
        $new_place->publish = false;
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
        $new_place->blocs->presentation->donnees->date_ouverture = Carbon::createFromIsoFormat('L', $this->extract_val($schema->blocs->presentation->donnees->date_ouverture), null, config('app.locale'));
        $new_place->blocs->presentation->donnees->date_creation = Carbon::createFromIsoFormat('L', $this->extract_val($schema->blocs->presentation->donnees->date_creation), null, config('app.locale'));
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
        $new_place->blocs->moyens->donnees->partenaires = $this->extract_val($schema->blocs->moyens->donnees->partenaires);

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

        // impact social
        $new_place->blocs->impact_social = new stdClass;
        $new_place->blocs->impact_social->visible = 1;
        $new_place->blocs->impact_social->donnees = new stdClass;
        $new_place->blocs->impact_social->donnees->insertion_professionnelle = $this->extract_val($schema->blocs->impact_social->donnees->insertion_professionnelle);
        $new_place->blocs->impact_social->donnees->appartenance_exclusion = $this->extract_val($schema->blocs->impact_social->donnees->appartenance_exclusion);
        $new_place->blocs->impact_social->donnees->reseaux = $this->extract_val($schema->blocs->impact_social->donnees->reseaux);
        $new_place->blocs->impact_social->donnees->capacite_agir = $this->extract_val($schema->blocs->impact_social->donnees->capacite_agir);
        $new_place->blocs->impact_social->donnees->sante_bien_être = $this->extract_val($schema->blocs->impact_social->donnees->sante_bien_être);
        $new_place->blocs->impact_social->donnees->lien_social = $this->extract_val($schema->blocs->impact_social->donnees->lien_social);
        $new_place->blocs->impact_social->donnees->solidarite = $this->extract_val($schema->blocs->impact_social->donnees->solidarite);
        $new_place->blocs->impact_social->donnees->egalite_homme_femme = $this->extract_val($schema->blocs->impact_social->donnees->egalite_homme_femme);
        $new_place->blocs->impact_social->donnees->cadre_de_vie = $this->extract_val($schema->blocs->impact_social->donnees->cadre_de_vie);
        $new_place->blocs->impact_social->donnees->entretien_des_espaces = $this->extract_val($schema->blocs->impact_social->donnees->entretien_des_espaces);
        $new_place->blocs->impact_social->donnees->services_publics = $this->extract_val($schema->blocs->impact_social->donnees->services_publics);
        $new_place->blocs->impact_social->donnees->innovation_publique = $this->extract_val($schema->blocs->impact_social->donnees->innovation_publique);

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

        // geojson
        $new_place->blocs->data_territoire = new stdClass;
        $new_place->blocs->data_territoire->visible = 1;
        $new_place->blocs->data_territoire->donnees = '';

        // images
        $new_place->blocs->galerie->donnees = [];
        $info_photo = $this->extract_val($schema->blocs->galerie->donnees);

        if ($info_photo->file_url && substr($info_photo->file_url, -4) !== '.pdf') {
            $filename = Str::of($new_place->name.'-'.pathinfo($info_photo->file_name)['filename'])->slug('-').'.'.pathinfo($info_photo->file_name)['extension'];
            $dest_dir = base_path()."/public/images/lieux/originals/";

            $file_path = implode(DIRECTORY_SEPARATOR, [
                storage_path('import'),
                Str::of($new_place->name)->slug('-'),
                $filename
            ]);

            if (! is_dir(dirname($file_path))) {
                mkdir(dirname($file_path), 0755, true);
            }

            $photo = fopen($file_path, "w");
            $this->curl($info_photo->file_url, $photo);
            fclose($photo);

            if (filesize($file_path) > 11 && exif_imagetype($file_path) !== false) {
                $new_place->blocs->galerie->donnees[] = $filename;

                if (! is_dir($dest_dir)) {
                    mkdir($dest_dir, 0755, true);
                }

                rename($file_path, $dest_dir.$filename);

                $process = new Process(['bash', base_path().'/bin/resize_place_img.sh', $filename]);
                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
            }
        }

        // insee
        $output = new BufferedOutput();
        Artisan::call('iris:load', [
            'adresse' => $new_place->address->address.", ".$new_place->address->postalcode
        ], $output);

        $new_place->blocs->data_territoire->donnees = json_decode($output->fetch());

        // on récupere l'info de la ville dans les données geojson de l'insee
        $new_place->address->city = $new_place->blocs->data_territoire->donnees->geo->geo_json->commune->properties->nom;

        echo PHP_EOL;
        echo json_encode($new_place);
        echo PHP_EOL;

        if ($exist->count() && $this->option('force') === true) {
            DB::table('places')->where('id', $import_file->token)
                               ->update([
                                   'place' => Str::of($new_place->name)->slug('-'),
                                   'data' => json_encode($new_place),
                                   'updated_at' => \Carbon\Carbon::now()
                               ]);
        } else {
            DB::table('places')->insert([
                'id' => $import_file->token,
                'place' => Str::of($new_place->name)->slug('-'),
                'data' => json_encode($new_place),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);

            $this->call('admin:generate-hash', [
                'place' => Str::of($new_place->name)->slug('-')
            ]);

            $place = Place::find(Str::of($new_place->name)->slug('-'));

            try {
                Mail::send(new ImportSuccess($place));
            } catch (ErrorException $e) {
                die("Can't send email to : ".$new_place->name.". Check file ".realpath($f)." for email address");
            }
        }
    }

    public function extract_val($keys)
    {
        echo $keys.PHP_EOL;

        $key = explode('|', $keys);
        $file = $this->answers;
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
        curl_setopt($c, CURLOPT_HTTPHEADER, ['Authorization: Bearer '.getenv('TYPEFORM_TOKEN')]);

        if ($path) {
            curl_setopt($c, CURLOPT_FILE, $path);
        }

        curl_exec($c);
        curl_close($c);
    }
}
