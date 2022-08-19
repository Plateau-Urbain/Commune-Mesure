<?php

use App\Console\Commands\SetValue;
use App\Models\Place;
use Illuminate\Support\Facades\Artisan;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UpdatePlaceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * On set un array à l'utilisation de la commande admin:set-value.
     *
     * @return void
     */
    public function testSetArray()
    {
        Place::factory()->hasName('place-1')->create();

        $place = Place::find('place-1');
        $this->assertEquals("[]", $place->get('activites'));

        Artisan::call('admin:set-value place-1 "activites" []');
        $place = Place::find('place-1');
        $this->assertEquals([], $place->get('activites'));

        Artisan::call('admin:set-value', ['place' => 'place-1', 'key' => "activites", 'value' => ["test"]]);
        $place = Place::find('place-1');
        $this->assertEquals(['test'], $place->get('activites'));
    }
}
