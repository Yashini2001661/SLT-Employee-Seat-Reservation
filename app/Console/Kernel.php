<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected $commands = [
        \App\Console\Commands\RotateDateSeats::class,
    ];
    

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        DB::table('date_seats')->where('date', '<', now()->format('Y-m-d'))->delete();
    })->dailyAt('00:00'); // This will run at midnight daily
}




}


