<?php

namespace App\Console\Commands;

use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportOneValueTypeForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:one-value-typeform
                                {file : json contenant les réponses d\'un répondant}
                                {key : clé de la nouvelle valeur dans le json}
                                {place : le slug du lieu}
                                {--multiple : L\'entrée est un array}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe une valeur du json type form dans un lieu existant';

    /**
     * Json Schema file
     *
     * @var string
     */
    protected $schema = '/app/places/schema.json';

    /**
     * Logger
     *
     * @var Log
     */
    protected $logger;

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
        $this->logger = Log::channel('import');
        $this->answers = '';
        parent::__construct();
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->logger->info("Nouvel import");

        if (file_exists(storage_path().$this->schema) === false) {
            $this->logger->alert("Schema file does not exists", ['schema' => storage_path().$this->schema]);
            throw new \Exception("Schema file does not exists : ".storage_path().$this->schema);
        }

        $f = $this->argument('file');
        $this->logger->info("Chargement du fichier ".realpath($f));

        if (file_exists(realpath($f)) === false) {
            $this->logger->alert("File does not exists", ['file' => realpath($f)]);
            throw new \Exception("File does not exists : ".realpath($f));
        }

        $schema = json_decode(file_get_contents(storage_path().$this->schema));
        $import_file = json_decode(file_get_contents($f));
        $this->answers = $import_file->answers;

        $place = Place::find($this->argument('place'));

        if ($place === false) {
            $this->logger->alert("Place does not exists", ['place' => $this->argument('place')]);
            throw new \Exception("File does not exists : ".$this->argument('place'));
        }

        $path = explode('->', $this->argument('key'));
        $result = $schema;
        foreach ($path as $noeud) {
            $result = $result->{$noeud};
        }

        if ($this->option('multiple') === true) {
            $values = [];

            foreach ($result as $k => $val) {
                $new_value = $this->extract_val($val);
                if ($new_value === 'Yes') {
                    $values[] = $k;
                }
            }

            $place->set($this->argument('key'), $values);
        } else {
            $new_value = $this->extract_val($result);
            $place->set($this->argument('key'), $new_value);
        }

        $place->save();
    }
}
