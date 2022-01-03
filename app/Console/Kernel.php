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
        $schedule->command('queue:run')->everyMinute()->withoutOverlapping();
        $schedule->command('payment:restore')->everyFiveMinutes();
        $schedule->command('visitor:run')->daily();
        $schedule->command('period:new')->daily();
        $schedule->command('period:dayoff')->dailyAt('00:15');
        $schedule->command('activationcode:delete')->twiceDaily(1, 13);
        $schedule->command('fileqr:delete')->dailyAt('02:00');
        $schedule->command('database:backup')->dailyAt('03:00');
        $schedule->command('user:delete')->dailyAt('04:00');
        $schedule->command('datalogin:delete')->dailyAt('05:00');
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
