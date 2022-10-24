<?php

namespace App\Console\Commands;

use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetValueForAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:set-value-for-all
                                {key : La clé à modifier}
                                {value : La nouvelle valeur}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Édite un champs pour tous les lieux';

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
        $places = Place::retrievePlaces();

        foreach ($places as $place) {
            Artisan::call('admin:set-value', [
                'place' => $place->getSlug(),
                'key' => $this->argument('key'),
                'value' => $this->argument('value')
            ]);
        }
    }
}
