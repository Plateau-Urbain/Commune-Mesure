<?php

namespace App\Console\Commands\Export;

use InvalidArgumentException;
use SplFileInfo;
use SplFileObject;
use Illuminate\Console\Command;

class FusionOriginalEtBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:fusion {json} {bdd} {exportDir?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fusionne un CSV d\'export du json original et un csv de la base';

    /**
     * The export dir
     *
     * @var array|null|string
     */
    protected $exportDir;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->exportDir = storage_path('exports');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->argument('exportDir') !== null) {
            $this->exportDir = $this->argument('exportDir');
        }

        $json = new SplFileInfo($this->argument('json'));
        $bdd = new SplFileInfo($this->argument('bdd'));

        if ($json->isFile() === false || $bdd->isFile() === false) {
            throw new InvalidArgumentException(__CLASS__.' require a valid file, [json : '.$json->getPathname().'] [bdd : '.$bdd->getPathname().'] provided.');
        }

        $json = $json->openFile();
        $bdd = $bdd->openFile();
        $json->setCsvControl(';');
        $bdd->setCsvControl(';');

        $array_json = [];
        $array_bdd = [];

        while (! $json->eof()) {
            $array_json[] = $json->fgetcsv();
        }

        while (! $bdd->eof()) {
            $array_bdd[] = $bdd->fgetcsv();
        }

        // 2 : id, 4 : réponse
        $bdd_answer_indexed_by_id = array_column($array_bdd, 4, 2);

        $export = new SplFileObject(storage_path('exports').'/'.$json->getBasename('.typeform.' . $json->getExtension()).'.diff.csv', 'w');

        foreach ($array_json as $line) {
            if ($line[0] === null) continue;

            $id = $line[3];
            $newline = $line;

            if (array_key_exists($id, $bdd_answer_indexed_by_id)) {
                $newline[] = $bdd_answer_indexed_by_id[$id];
            } else {
                $newline[] = '';
            }

            $export->fputcsv($newline, ';');
        }
    }
}
