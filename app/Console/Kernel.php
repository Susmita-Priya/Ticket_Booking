<?php

namespace App\Console;

use App\Models\Vehicle;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            try {
                // Update vehicle statuses for ongoing trips
                Vehicle::whereHas('trips', function ($query) {
                    $query->whereNotNull('end_date')
                        ->whereNotNull('end_time')
                        ->whereRaw('CONCAT(end_date, " ", end_time) > NOW()');
                })->update(['is_booked' => 1]); // Vehicle is booked

                Vehicle::whereHas('trips', function ($query) {
                    $query->whereNotNull('end_date')
                          ->whereNotNull('end_time')
                          ->whereRaw('CONCAT(end_date, " ", end_time) <= NOW()');
                })->chunkById(100, function ($vehicles) {
                    foreach ($vehicles as $vehicle) {
                        // Mark vehicle as available
                        $vehicle->update(['is_booked' => 0]);
                
                        // Mark all seats of this vehicle as available
                        $vehicle->seats()->update([
                            'is_booked' => 0,
                            'is_reserved_by' => null
                        ]);
                
                        // Update only the completed trips to `trip_status = 2`
                        $vehicle->trips()->whereNotNull('end_date')
                                         ->whereNotNull('end_time')
                                         ->whereRaw('CONCAT(end_date, " ", end_time) <= NOW()')
                                         ->update(['trip_status' => 2]);
                    }
                });
            } catch (\Exception $e) {
                Log::error('Failed to update vehicle statuses: ' . $e->getMessage());
            }
        })->everyMinute(); // Adjust the frequency as needed
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load all the commands
        $this->load(__DIR__ . '/Commands');

        // Optionally, you can include commands from routes/console.php
        require base_path('routes/console.php');
    }
}
