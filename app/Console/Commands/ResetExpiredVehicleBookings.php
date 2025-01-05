<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Models\VehiclePublished;
use Carbon\Carbon;

class ResetExpiredVehicleBookings extends Command
{
    // The name and signature of the console command
    protected $signature = 'vehicles:reset-expired-bookings';

    // The console command description
    protected $description = 'Reset is_booked status for vehicles whose journey has ended';

    // Execute the console command
    public function handle()
    {
        // Get the current time
        $currentDateTime = Carbon::now();

        // Get all VehiclePublished records where end_time has passed
        $vehiclePublishedRecords = VehiclePublished::whereDate('journey_date', '<=', $currentDateTime->toDateString())
            ->whereTime('end_time', '<=', $currentDateTime->toTimeString())
            ->get();

        foreach ($vehiclePublishedRecords as $vehiclePublished) {
            // Find the associated vehicle
            $vehicle = Vehicle::find($vehiclePublished->vehicle_id);

            if ($vehicle) {
                // Reset the is_booked status to 0 (available for the next trip)
                $vehicle->is_booked = 0;
                $vehicle->save();
            }

            // Optionally, you can delete the VehiclePublished entry or mark it as completed
            // $vehiclePublished->delete();  // If you want to remove the record after the journey is completed
        }

        $this->info('Expired vehicle bookings have been reset.');
    }
}
