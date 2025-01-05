<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function location()
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

}
