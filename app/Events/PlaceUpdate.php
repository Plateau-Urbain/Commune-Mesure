<?php

namespace App\Events;

use App\Models\Place;

class PlaceUpdate extends Event
{
    /**
     * the place
     *
     * @var place $place
     */
    public $place;

    /**
     * the value
     *
     * @var string $value
     */
    public $value;

    /**
     * the old value
     *
     * @var mixed $old
     */
    public $old;

    /**
     * the new value
     *
     * @var mixed $newValue
     */
    public $new;

    /**
     * Create a new event instance.
     *
     * @param Place $place
     * @return void
     */
    public function __construct(Place $place, string $value, $old, $new)
    {
        $this->place = $place;
        $this->value = $value;
        $this->old = print_r($old, true);
        $this->new = print_r($new, true);
    }
}
