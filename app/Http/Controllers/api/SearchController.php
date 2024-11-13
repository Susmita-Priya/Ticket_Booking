<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JourneyType;
use App\Models\PlaneJourney;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // $plane_journeys = Plane_journey::all();

        // Validate input
        $this->validate($request, [
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'date' => 'required|date',
            'person_no' => 'required|integer|min:1',
        ]);

        // Query the database for matching plane journeys
        $plane_journeys = PlaneJourney::where('start_location_id', $request->from_location_id)
            ->where('end_location_id', $request->to_location_id)
            ->where('start_date', $request->date)
            ->where('available_seats', '>=', $request->person_no)
            ->get();

        // Check if any planes were found
        if ($plane_journeys->isEmpty()) {
            return response()->json([
                'error' => 'No available planes.',
            ], 400);
        }

        // Ensure journey_types_id is an array for each plane journey
        foreach ($plane_journeys as $planeJourney) {
            $planeJourney->journey_types_id = is_string($planeJourney->journey_types_id)
                ? json_decode($planeJourney->journey_types_id, true)
                : [];
        }

        // Return the results with journey_types_id as an array
        return response()->json([
            'message' => 'Available planes',
            'planes' => $plane_journeys,
        ], 200);
    }
}