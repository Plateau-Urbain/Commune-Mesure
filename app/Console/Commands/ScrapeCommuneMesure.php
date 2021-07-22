<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use \DOMDocument;
use \DOMXPath;

class ScrapeCommuneMesure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:communemesure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Télécharge le footer distant et remplace le footer";

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
        $this->scrapeFooter();
    }

    private function scrapeFooter()
    {
        $response = Http::get('https://communemesure.fr/blog/export');
        $this->dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHtml($response->body());
        $xpath = new DOMXPath($dom);

        $query = '//footer';

        $footer = $xpath->query($query)->item(0);
    }
}
