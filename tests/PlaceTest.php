<?php

use App\Console\Commands\ImportTypeForm;
use App\Events\PlaceUpdate;
use App\Models\Place;
use Database\Seeders\PlaceSeeder;
use Illuminate\Support\Facades\Event;
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

    public function testIsModel()
    {
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
        $place = Place::find("place-1");

        $this->assertTrue($place instanceof Place);
    }

    public function testUpdatePlace()
    {
        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
        $place = Place::find("place-1");

        $this->assertEquals("La Plateforme des XXXXXXXX", $place->get('name'));

        $place->set('name', "La Plateforme des tests");
        $place->save();

        $this->assertEquals("La Plateforme des tests", $place->get('name'));
    }

    public function testEventDispatched()
    {
        Event::fake();

        $this->artisan('db:seed', ['--class' => 'PlaceSeeder']);
        $place = Place::find("place-1");
        $place->set('name', "La Plateforme des tests");
        $place->save();

        Event::assertDispatched(PlaceUpdate::class);
    }
}
