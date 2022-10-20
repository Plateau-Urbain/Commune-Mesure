<?php

namespace App\Console\Commands;

use App\Models\Place;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PlacesList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'places:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return void
     */
    public function handle()
    {
        $all = DB::table('places')
            ->select(['place', 'data->name as name', 'deleted_at'])
            ->where('type_donnees', Place::TYPE_DONNEES_DATAPANORAMA)
            ->get();

        foreach ($all->toArray() as $place) {
            $line = [$place->place, $place->name, ($place->deleted_at) ? 'deleted' : 'active'];
            $this->line(
                implode(';', $line)
            );
        }
    }
}
