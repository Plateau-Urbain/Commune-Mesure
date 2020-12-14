<?php

use Illuminate\Database\Seeder;
use Database\Seeders\PlaceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PlaceSeeder::class);
    }
}
