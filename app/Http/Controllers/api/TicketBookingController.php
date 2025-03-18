<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\TicketBooking;
use App\Models\Trip;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TicketBookingController extends Controller
{
    public function storeBooking(Request $request)
    {
        $this->validate($request, [
           'user_id' => 'required',
           'trip_id' => 'required',
           'seat_data' => 'required',
           'passenger_phone' => 'required',
           'travel_date' => 'required',
        ]);

        // $user_id = auth()->user()->id;
        $trip = Trip::find($request->trip_id)->first();
        $company_id = $trip->company_id;
        $vehicle_id = $trip->vehicle_id;

        // Check if the booking already exists
        $existingBooking = TicketBooking::where('trip_id', $request->trip_id)
            ->where('seat_data', json_encode($request->seat_data))
            ->where('travel_date', $request->travel_date)
            ->first();

        if ($existingBooking) {
            return response()->json([
                'message' => "Can't book this ticket, it already exists"
            ], 409);
        }

        try {
            $booking = new TicketBooking();
            $user_id = $request->id;
            $booking->company_id = $company_id;
            $booking->trip_id = $request->trip_id;
            $booking->vehicle_id = $vehicle_id;
            $booking->seat_data = json_encode($request->seat_data);
            $booking->passenger_name = $request->passenger_name;
            $booking->passenger_phone = $request->passenger_phone;
            $booking->travel_date = $request->travel_date;
            $booking->type = 'App';
            $booking->user_id = $user_id;
            $booking->save();

            return response()->json([
                'message' => 'Ticket Booking created successfully',
                // 'data' => $booking
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed to create booking',
                'error' => $e->errorInfo
            ], 409);
        }
    }


    public function booking()
    {
        $user_id = auth()->user()->id;
        $bookings = TicketBooking::where('user_id', $user_id)->get();

        foreach ($bookings as $booking) {
            $booking->seat_data = json_decode($booking->seat_data);
        }

        return response()->json([
            'message' => 'Bookings fetched successfully',
            'data' => $bookings
        ], 200);
    }
}
