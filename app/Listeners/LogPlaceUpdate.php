<?php

namespace App\Listeners;

use App\Events\PlaceUpdate;
use Illuminate\Support\Facades\Log;

class LogPlaceUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PlaceUpdate  $event
     * @return void
     */
    public function handle(PlaceUpdate $event)
    {
        $place = $event->place;
        $log = Log::channel('update');
        $message = "Updating %s | value: %s, old: %s, new: %s";

        $log->info(sprintf($message,
            $place->getSlug(),
            $event->value,
            $event->old,
            $event->new
        ));
    }
}
