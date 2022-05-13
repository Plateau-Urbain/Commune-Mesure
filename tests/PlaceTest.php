<?php

use App\Console\Commands\ImportTypeForm;
use App\Models\Place;
use Database\Seeders\PlaceSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlaceTest extends TestCase
{
    use DatabaseMigrations;

    public function testPlaceExists()
    {
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
        $this->seeInDatabase('places', ['place' => 'place-1']);
    }

    public function testUniquePlace()
    {
        $this->expectException(PDOException::class);
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
    }
}
