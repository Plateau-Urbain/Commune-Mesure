<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
     * id field to query
     * One of the following:
     *  * id
     *  * place
     *
     * @var string
     */
    protected $field = 'place';

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

        $slug = $this->argument('place');

        if ($this->confirm('This will erase existing hash. Continue ?')) {
            $total = 0;

            if ($slug === null) {
                $places = DB::table('places')->select($this->field)->pluck($this->field);

                foreach ($places as $place) {
                    $this->updateHash($place);
                    $total++;
                }
            } else {
                if (DB::table('places')->select($this->field)->where($this->field, $slug)->doesntExist()) {
                    $this->error('Place doesn\'t exists');
                    exit;
                }

                $this->updateHash($slug);
                $total++;
            }

            $this->info($total.' hash updated');
        }
    }

    protected function updateHash($id)
    {
        DB::table('places')->where($this->field, $id)->update([
            'hash_admin' => hash('sha256', $id.Str::random(32).config('app.key'))
        ]);
    }
}
