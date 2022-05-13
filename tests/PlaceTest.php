<?php

use App\Console\Commands\ImportTypeForm;
use App\Events\PlaceUpdate;
use App\Models\Place;
use Database\Seeders\PlaceSeeder;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class PlaceTest extends TestCase
{
    use DatabaseMigrations;

    public function testPlaceExists()
    {
        $place = Place::factory()->hasName('place-1')->create();
        $this->seeInDatabase('places', ['place' => 'place-1']);
    }

    public function testUniquePlace()
    {
        $this->expectException(PDOException::class);
        Place::factory()->hasName('place-1')->count(2)->create();
    }

    public function testIsModel()
    {
        Place::factory()->hasName('place-1')->create();
        $place = Place::find("place-1");

        $this->assertTrue($place instanceof Place);
    }

    public function testUpdatePlace()
    {
        Place::factory()->hasName('place-1')->create();
        $place = Place::find("place-1");

        $this->assertEquals("La Plateforme des XXXXXXXX", $place->get('name'));

        $place->set('name', "La Plateforme des tests");
        $place->save();

        $this->assertEquals("La Plateforme des tests", $place->get('name'));
    }

    public function testEventDispatched()
    {
        $this->expectsEvents(PlaceUpdate::class);

        Place::factory()->hasName('place-1')->create();
        $place = Place::find("place-1");
        $place->set('name', "La Plateforme des tests");
        $place->save();
    }
}
