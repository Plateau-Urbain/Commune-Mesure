<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    const JSON_EXAMPLE = __DIR__.'/../../docs/exemple_lieu.json';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $json = file_get_contents(self::JSON_EXAMPLE);

        DB::table('places')->insert([
            'id' => $faker->md5(),
            'hash_admin' => $faker->sha256(),
            'place' => 'place-1',
            'data' => $json,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
