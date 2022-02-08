<?php

namespace App\Console\Commands;

use App\Mail\ImportSuccess;
use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailSendImportSuccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-import-success {place}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi le mail d\'import réussi au créateur du lieu';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! config('mail.from.name') || ! config('mail.from.address')) {
            throw new \LogicException('Missing MAIL_* value in your .env');
        }

        $slug = $this->argument('place');
        $place = Place::find($slug);

        if ($place === false) {
            $this->error('Place not found');
            exit;
        }

        if ($this->confirm('This will send an email at '.$place->get('creator->email').'. Continue ?') === false) {
            $this->info('Mail NOT sent');
            exit;
        }

        Mail::send(new ImportSuccess($place));
    }
}
