<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PlaneJourney;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class BookingController extends Controller
{
    //

    public function storeBooking(Request $request)
    {
        $this->validate($request, [
            'plane_journey_id' => 'required',
            'passengers_name' => 'required',
            'passengers_phone' => 'required',
            'passengers_passport_no' => 'required',
            'passengers_age' => 'required',
        ]);
   

        // if (count($request->passengers_name) !== count($request->passengers_phone) ||
        // count($request->passengers_name) !== count($request->passengers_passport_no) ||
        // count($request->passengers_name) !== count($request->passengers_age)) {
        // return response()->json([
        //     'message' => 'Passenger information arrays must have the same length'
        // ], 422);
        // }

        $user = auth()->user()->id;
        $planeJourney = PlaneJourney::find($request->plane_journey_id)->first();
        $plane_id = $planeJourney->plane_id;
        $company_id = $planeJourney->company_id;

        // dd($plane_id, $company_id);

        try {
        $booking = new Booking();
        $booking->user_id = $user;
        $booking->plane_id = $plane_id;
        $booking->company_id = $company_id;
        $booking->plane_journey_id = $request->plane_journey_id; 
        $booking->passengers_name = json_encode($request->passengers_name);
        $booking->passengers_phone = json_encode($request->passengers_phone);
        $booking->passengers_passport_no = json_encode($request->passengers_passport_no);
        $booking->passengers_age = json_encode($request->passengers_age);
        $booking->save();
        

        return response()->json([
            'message' => 'Booking created successfully',
            // 'data' => $booking
        ],201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create booking',
                'error' => $e->errorInfo
            ],409);
        }
    }

    public function booking()
    {
        $user = auth()->user()->id;
        $bookings = Booking::where('user_id', $user)->get();

        foreach ($bookings as $booking) {
            $booking->passengers_name = json_decode($booking->passengers_name);
            $booking->passengers_phone = json_decode($booking->passengers_phone);
            $booking->passengers_passport_no = json_decode($booking->passengers_passport_no);
            $booking->passengers_age = json_decode($booking->passengers_age);
        }
        return response()->json([
            'message' => 'Bookings retrieved successfully',
            'data' => $bookings
        ], 200);
    }
    

    
}
