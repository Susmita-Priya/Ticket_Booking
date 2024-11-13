<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PlaneJourney;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // $plane_journeys = Plane_journey::all();

    //    Validate input
       $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'date' => 'required|date',
            'person_no' => 'required',
    ]);
// dd($request->all());

        $plane_journeys = PlaneJourney::where('start_location_id', $request->from)
            ->where('end_location_id', $request->to)
            ->where('start_date', $request->date)
            ->where('available_seats', '>=', $request->person_no)
            ->get();


            if (count($plane_journeys) > 0) {
                return response()->json([
                    'message' => 'Available Planes',
                    'planes' => $plane_journeys, // Optionally return data
                ], 200);
            } else {
                // Return error response for invalid verification code
                return response()->json([
                    'error' => 'No available Plane.',
                ], 400);
            }
    }

}
