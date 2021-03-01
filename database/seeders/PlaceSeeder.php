<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storage = getenv('STORAGE_PATH').'places/';

        foreach (glob($storage.'*.json') as $lieu) {
            $name = basename($lieu, '.json');
            $json = file_get_contents($lieu);

            DB::table('places')->insert([
                'id' => Str::orderedUuid(),
                'place' => $name,
                'data' => $json
            ]);
        }
    }
}
