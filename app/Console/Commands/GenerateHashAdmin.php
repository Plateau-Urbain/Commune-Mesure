<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateHashAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:generate-hash {place?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Génère un nouveau secret pour éditer un espace de lieu";

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
        if (config('app.key') === NULL) {
            throw new \LogicException('Missing APP_KEY value in your .env');
        }
    }
}
