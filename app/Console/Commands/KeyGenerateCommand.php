<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class KeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Set the application key";

    /**
     * id field to query
     * One of the following:
     *  * id
     *  * place
     *
     * @var string
     */
    protected $field = 'id';

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
            throw new \LogicException('Already set APP_KEY value in your .env');
        }

        $key = Str::random(32);
        $this->line($key);
    }
}
