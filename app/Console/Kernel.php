<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{

        /**

     * The Artisan commands provided by your application.

     *

     * @var array

     */

    protected $commands = [

        'App\Console\Commands\DatabaseBackUp'

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    // protected function schedule(Schedule $schedule)
    // {
    //     // $schedule->command('inspire')->hourly();
    // }


    protected function schedule(Schedule $schedule)

    {
        //* * * * * cd /var/www/html/mop-yvms/ && php artisan schedule:run >> /dev/null 2>&1
        // $schedule->command('database:backup')->daily();
        $schedule->command('backup:clean')->weekly()->at('01:00');
        $schedule->command('backup:run')->daily()->at('01:30');
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
