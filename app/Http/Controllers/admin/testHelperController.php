<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class testHelperController extends Controller
{
    public function index()
    {
        // Update vehicle statuses for ongoing trips
        $ongoingTrips = Vehicle::whereHas('trips', function ($query) {
            $query->whereNotNull('end_date')
                  ->whereNotNull('end_time')
                  ->whereRaw('CONCAT(end_date, " ", end_time) > NOW()');
        })->update(['is_booked' => 1]); // Vehicle is booked

        // Update vehicle statuses for completed trips
        $completedTrips = Vehicle::whereHas('trips', function ($query) {
            $query->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhereNull('end_time')
                  ->orWhereRaw('CONCAT(end_date, " ", end_time) <= NOW()');
            });
        })->update(['is_booked' => 0]); // Vehicle is available

        dd(['ongoingTrips' => $ongoingTrips, 'completedTrips' => $completedTrips]);
        
    }
}
