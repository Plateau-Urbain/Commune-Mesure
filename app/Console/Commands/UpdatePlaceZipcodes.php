<?php

namespace App\Console\Commands;

ini_set('memory_limit', '-1');

use Illuminate\Console\Command;
use App\Models\Place;
use Illuminate\Support\Facades\DB;

class UpdatePlaceZipcodes extends Command
{
      /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'places:update-zipcodes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loop through all places and fill the zipcode field from the address postalcode';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $places = Place::all();

        foreach ($places as $place) {
            $placeData = json_decode($place->data, true);

            if (isset($placeData['address']) && isset($placeData['address']['postalcode'])) {
                $place->zipcode = $placeData['address']['postalcode'];

                DB::table('places')->where('id', $place->id)->update([
                    'zipcode' => $placeData['address']['postalcode']
                ]);

                $this->info('Updated place ID: ' .  $placeData['name'] . ' with zipcode: ' . $placeData['address']['postalcode']);
            } else {
                $this->warn('Skipped place ID: ' . $placeData['name'] . ' - No postalcode found in address');
            }
        }

        $this->info('Zipcodes update complete.');

        return 0;
    }
}
