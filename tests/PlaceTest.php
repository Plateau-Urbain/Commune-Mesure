<?php

use App\Console\Commands\ImportTypeForm;
use App\Models\Place;
use Database\Seeders\PlaceSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlaceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
    }

    public function testPlaceExists()
    {
        $this->seeInDatabase('places', ['place' => 'place-1']);
    }
}
