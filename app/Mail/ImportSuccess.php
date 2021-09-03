<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Place;

class ImportSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Place */
    public $place;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Place $place)
    {
        $this->place = $place;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.import.success');
    }
}
