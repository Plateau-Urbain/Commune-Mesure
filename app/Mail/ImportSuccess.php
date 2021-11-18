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
        $this->subject("Votre datapanorama est prêt à être édité et publié sur Commune Mesure !");
        $this->to($this->place->get('creator->email'), $this->place->get('creator->name'));
        $this->cc(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));

        return $this->text('emails.import.success');
    }
}
