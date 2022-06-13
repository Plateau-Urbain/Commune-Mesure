<?php

use App\Console\Commands\ImportTypeForm;
use App\Events\PlaceUpdate;
use App\Models\Place;
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

    public function testSaveMultiple()
    {
        $places = Place::factory()->count(3)->create();
        $this->assertCount(3, $places);
    }

    public function testIsModel()
    {
        Place::factory()->hasName('place-1')->create();
        $place = Place::find("place-1");

        $this->assertTrue($place instanceof Place);
    }

    public function testHasGeoJson()
    {
        Place::factory()->hasName('place-1')->create();
        $place = Place::find('place-1');
        $this->assertNull($place->get('blocs->data_territoire->donnees->geo->geo_json'));

        $place = Place::find('place-1', false);
        $this->assertIsObject($place->get('blocs->data_territoire->donnees->geo->geo_json'));
    }

    public function testUpdatePlace()
    {
        $place = Place::factory()->hasName('place-1')->make();
        $this->assertEquals("La Plateforme des XXXXXXXX", $place->get('name'));
        $place->set('name', "La Plateforme des tests");

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
