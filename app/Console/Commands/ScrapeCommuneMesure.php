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
    protected $signature = 'scrape:header-footer';

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
        $response = Http::get('https://communemesure.fr/blog/export');
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);

        $dom->loadHtml($response->body());
        $xpath = new DOMXPath($dom);
        $this->scrapeFooter($xpath);
        $header = $this->scrapeFooter($xpath);

        $queryHeader = '//header';
        $header = $xpath->query($queryHeader);

        $queryHeadLink = "//head/link[@rel='stylesheet']";
        $queryHeadStyle = "//head/style";

        $headLink = $xpath->query($queryHeadLink)->item(0);
        $headStyle = $xpath->query($queryHeadStyle)->item(0);

        $queryFooterScript = "//body/script";
        $queryFooterStyle = "//body/style";

        $footerScript = $xpath->query($queryFooterScript)->item(0);
        $footerScript = $xpath->query($queryFooterStyle)->item(0);
    }


    private function scrapeFooter($xpath)
    {
        $query = '//footer';

        return $xpath->query($query)->item(0);
    }
}
