<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class PlaceFactory extends Factory
{
    const JSON_EXAMPLE = __DIR__.'/../../docs/exemple_lieu.json';

    protected $model = Place::class;

    public function definition(): array
    {
        $json = file_get_contents(self::JSON_EXAMPLE);

        return [
            'id' => $this->faker->md5(),
            'hash_admin' => $this->faker->sha256(),
            'place' => $this->faker->lexify('place-??????'),
            'data' => $json,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Place $place) {
            $attrs = $place->getAttributes();

            $place->setSlug($attrs['place']);
            $place->setData($attrs['data']);
        })->afterCreating(function (Place $place) {
            $attrs = $place->getAttributes();

            $place->setSlug($attrs['place']);
            $place->setData($attrs['data']);

            $place->parentSave();
        });
    }

    public function hasName(string $name)
    {
        return $this->state([
            'place' => $name
        ]);
    }
}
