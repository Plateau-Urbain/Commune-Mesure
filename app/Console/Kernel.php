<?php

namespace App\Console;

use App\Console\Commands\LoadIrisGeoJson;
use App\Console\Commands\GenerateHashAdmin;
use App\Console\Commands\KeyGenerateCommand;
use App\Console\Commands\ImportTypeForm;
use App\Console\Commands\ImportOneValueTypeForm;
use App\Console\Commands\ImportForAll;
use App\Console\Commands\SetValue;
use App\Console\Commands\SetValueForAll;
use App\Console\Commands\MailSendImportSuccess;
use App\Console\Commands\Export\OriginalToCsv;
use App\Console\Commands\Export\PlaceToCsv;
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
        ImportForAll::class,

        SetValue::class,
        SetValueForAll::class,

        MailSendImportSuccess::class,

        OriginalToCsv::class,
        PlaceToCsv::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // header et footer du wordpress
        $schedule->exec('bash bin/scrape.sh > /dev/null')->everyThirtyMinutes()
                                                         ->emailOutputOnFailure(env('CRON_MAIL'));

        // import des lieux depuis Typeform
        $schedule->exec('bash bin/import.sh > /dev/null')->hourly()
                                                         ->withoutOverlapping()
                                                         ->runInBackground()
                                                         ->emailOutputOnFailure(env('CRON_MAIL'));

    }
}
