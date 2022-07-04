<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportForAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:value-for-all {key : la clé de la valeur à ajouter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importe une valeur pour tous les lieux';

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
        $files = glob('storage/import/*.json');

        foreach ($files as $file) {
            echo $file.' : ';
            $json = json_decode(file_get_contents($file));
            $name = Str::of($json->answers[1]->group->answers[0]->short_text->value)->slug('-');
            echo $name . PHP_EOL;

            echo "import:one-value-typeform $file ".$this->argument('key')." $name".PHP_EOL;
            Artisan::call('import:one-value-typeform', [
                'file' => $file,
                'key' => $this->argument('key'),
                'place' => $name
            ]);
        }
    }
}
