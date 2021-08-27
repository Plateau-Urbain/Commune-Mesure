<?php

namespace App\Console;

use App\Console\Commands\LoadIrisGeoJson;
use App\Console\Commands\GenerateHashAdmin;
use App\Console\Commands\KeyGenerateCommand;
use App\Console\Commands\ImportTypeForm;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        LoadIrisGeoJson::class,
        GenerateHashAdmin::class,
        KeyGenerateCommand::class,
        ImportTypeForm::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
