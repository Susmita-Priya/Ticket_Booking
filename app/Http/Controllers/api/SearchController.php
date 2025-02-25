<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JourneyType;
use App\Models\PlaneJourney;
use App\Models\Route;
use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchPlane(Request $request)
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
                'message' => 'No available planes.',
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


    public function searchBus(Request $request)
    {
        // Validate input
        $this->validate($request, [
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'date' => 'required|date',
        ]);

        // Query the database for matching bus routes
        $routes = Route::where('from_location_id', $request->from_location_id)
            ->where('to_location_id', $request->to_location_id)
            ->get();

        // Check if any routes were found
        if ($routes->isEmpty()) {
            return response()->json([
                'message' => 'No available routes.',
            ], 400);
        }

        $trips = Trip::whereIn('route_id', $routes->pluck('id'))
            ->where('start_date', $request->date)
            ->get();

        // Check if any trips were found
        if ($trips->isEmpty()) {
            return response()->json([
                'message' => 'No available trips.',
            ], 400);
        }

        // Ensure checkers_id is an array for each trip route
        foreach ($trips as $trip) {
            $trip->route->checkers_id = is_string($trip->route->checkers_id)
            ? json_decode($trip->route->checkers_id, true)
            : [];
        }

        // Ensure amenities_id is an array for each vehicle
        foreach ($trips as $trip) {
            $trip->vehicle->amenities_id = is_string($trip->vehicle->amenities_id)
                ? json_decode($trip->vehicle->amenities_id, true)
                : [];
        }

    
        // Load related details for each trip
        foreach ($trips as $trip) {
            $trip->company;
            $trip->route;
            $trip->route->fromLocation;
            $trip->route->fromLocation->district;
            $trip->route->fromLocation->district->division;
            $trip->route->toLocation;
            $trip->route->toLocation->district;
            $trip->route->toLocation->district->division;
            $trip->route->startCounter;
            $trip->route->endCounter;
            $trip->route->routeManager;
            $trip->vehicle;
            $trip->vehicle->owner;
            $trip->vehicle->type;
            $trip->driver;
            $trip->supervisor;
        }



        // Return the results with related details
        return response()->json([
            'message' => 'Available trips',
            'trips' => $trips,
        ], 200);
    }
}