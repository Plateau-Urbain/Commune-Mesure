<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Place;

class SetValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:set-value {place} {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour une valeur dans les données';

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
        $slug = $this->argument('place');

        $place = Place::find($slug);

        if ($place === false) {
            throw new \Exception('Place does not exists : ' . $slug);
        }

        $value = $this->argument('value');
        if (is_file($value)) {
            $value = json_decode(file_get_contents($value));
        }

        //$old = Place::getHeadObjectChemin($place, $this->argument('key'));
        $old = null;

        if (is_array($old)) {
            throw new \Exception("Non implémentée");
        } else {
            $place->set($this->argument('key'), $value);
        }

        $place->save();
    }
}
