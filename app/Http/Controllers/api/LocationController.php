<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Place;

class LocationController extends Controller
{
    public function locationPlane()
    {
        $locations = Location::all();

        if ($locations->isEmpty()) {
            return response()->json([
                'message' => 'No locations found.',
            ], 400);
        }else{
            return response()->json([
                'message' => 'Check out locations',
                'locations' => $locations, // Optionally return data
            ], 200);
        }
    }

    public function locationBus()
    {
        $locations = Place::all();

        if ($locations->isEmpty()) {
            return response()->json([
                'message' => 'No locations found.',
            ], 400);
        }

        foreach ($locations as $location) {
            $location->district;
            $location->district->division;
        }
        
            return response()->json([
                'message' => 'Check out locations',
                'locations' => $locations, // Optionally return data
            ], 200);
    }

}
