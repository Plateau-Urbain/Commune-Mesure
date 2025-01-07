<?php

namespace App\Console\Commands;

ini_set('memory_limit', '256M');

use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SetPublicsProperty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'places:setpublics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set publics blocs since FTL import did not handle those';

    protected $schema = '/app/places/schema_general_information.json';

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

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
     * @return void
     */
    public function handle()
    {
        $this->logger = Log::channel('import_general_information');

        $schema = json_decode(file_get_contents(storage_path().$this->schema));

        $all = Place::retrievePlaces();

        foreach ($all as $place) {
            $data = $place->getData();
            if(!isset($data->blocs->accessibilite->donnees->publics)) {
                $data->blocs->accessibilite->donnees->publics = $schema->blocs->accessibilite->donnees->publics;
                $data->blocs->accessibilite->donnees->publics->{"Chercheurs d'emplois"} = 0;
                $this->logger->info("Updating in database...");
                DB::table('places')->where('place', $place->getSlug())
                                    ->where('type_donnees', 'datapanorama')
                                    ->update([
                                        'place' => $place->getSlug(),
                                        'data' => json_encode($data),
                                        'updated_at' => \Carbon\Carbon::now()
                                    ]);
                $this->logger->info($place->name . ' publics updated');
            }
        }
    }
}
