<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\DatabaseBackUp',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cron:queue')->everyMinute()->withoutOverlapping();
        $schedule->command('cron:deleteuserpermanently')->everyFiveMinutes();
        $schedule->command('cron:deleteuserregister')->everyFiveMinutes();
        $schedule->command('cron:deletekodeaktivasi')->twiceDaily(1, 13);
        $schedule->command('cron:deletefileqr')->dailyAt('02:00');
        $schedule->command('cron:logindata')->dailyAt('05:00');
        $schedule->command('cron:backup')->dailyAt('03:00');
        $schedule->command('cron:visitorcommand')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
