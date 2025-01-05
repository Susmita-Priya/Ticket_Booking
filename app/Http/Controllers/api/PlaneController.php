<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Plane;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    public function plane()
    {
        $planes = Plane::with('planejourneys', 'company')->get();

        // Process amenities_id and journey_types_id to ensure they're arrays
        foreach ($planes as $plane) {
            // Decode amenities_id as array
            $plane->amenities_id = json_decode($plane->amenities_id);

            // Decode journey_types_id for each plane journey as an array
            foreach ($plane->planejourneys as $planeJourney) {
                $planeJourney->journey_types_id = json_decode($planeJourney->journey_types_id, true) ;
            }
        }

        if ($planes->isEmpty()) {
            return response()->json([
                'message' => 'No planes found.',
            ], 400);
        }else{
            return response()->json([
                'message' => 'Check out Planes',
                'planes' => $planes, // Optionally return data
            ], 200);
        }
    }
}
