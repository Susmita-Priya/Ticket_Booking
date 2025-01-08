<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the reset-expired-bookings command to run hourly
        $schedule->command('vehicles:reset-expired-bookings')->hourly(); // Adjust to 'daily()' or 'everyFifteenMinutes()' if needed
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load all the commands
        $this->load(__DIR__.'/Commands');

        // Optionally, you can include commands from routes/console.php
        require base_path('routes/console.php');
    }
}
