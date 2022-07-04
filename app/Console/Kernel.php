<?php

namespace App\Console;

use App\Console\Commands\LoadIrisGeoJson;
use App\Console\Commands\GenerateHashAdmin;
use App\Console\Commands\KeyGenerateCommand;
use App\Console\Commands\ImportTypeForm;
use App\Console\Commands\ImportOneValueTypeForm;
use App\Console\Commands\SetValue;
use App\Console\Commands\MailSendImportSuccess;
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
        ImportTypeForm::class,
        ImportOneValueTypeForm::class,
        SetValue::class,
        MailSendImportSuccess::class
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
