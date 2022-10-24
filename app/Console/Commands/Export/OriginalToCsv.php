<?php

namespace App\Console\Commands\Export;

use App\Exports\OriginalJsonExport;
use Illuminate\Console\Command;

class OriginalToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:original-to-csv {json} {exportDir?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporte le fichier json original au format csv';

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

        $export = new OriginalJsonExport($this->argument('json'));
        $export->setExportDir($this->exportDir);

        $file = $export->save();
        $this->line("File stored at: ".$file->getPathname());
    }
}
