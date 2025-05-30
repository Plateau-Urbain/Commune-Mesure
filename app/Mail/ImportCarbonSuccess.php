<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Place;

class ImportCarbonSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $name, $filePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $name, string $filePath)
    {
        $this->email = $email;
        $this->name = $name;
        $this->filePath = $filePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject("Votre bilan carbone a été généré !");
        $this->to($this->email, $this->name);
        $this->cc(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $this->attach($this->filePath);

        return $this->text('emails.import.successcarbon');
    }
}
