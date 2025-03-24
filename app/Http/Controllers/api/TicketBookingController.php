<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\TicketBooking;
use App\Models\Trip;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TicketBookingController extends Controller
{
    public function storeBooking(Request $request)
    {
        {
            $this->validate($request, [
               'user_id' => 'required',
               'trip_id' => 'required',
               'seat_data' => 'required|array',
               'seat_data.*.id' => 'required',
               'passenger_phone' => 'required',
               'travel_date' => 'required',
            ]);
    
            $trip = Trip::find($request->trip_id)->first();
            $company_id = $trip->company_id;
            $vehicle_id = $trip->vehicle_id;
            $selectedSeats = $request->seat_data;
    
            // Retrieve seat data from Seat model
            $seatData = [];
            foreach ($selectedSeats as $seat) {
                $seatModel = Seat::find($seat['id']);
                if ($seatModel) {
                    $seatData[] = [
                        'seatId' => $seatModel->id,
                        'seatNo' => $seatModel->seat_no,
                        'seatPrice' => $trip->ticket_price,
                    ];
                } else {
                    return response()->json([
                        'message' => 'Seat not found for ID: ' . $seat['id']
                    ], 404);
                }
            }
    
            // Check if the booking already exists
            $existingBooking = TicketBooking::where('trip_id', $request->trip_id)
                ->where('seat_data', json_encode($seatData))
                ->where('travel_date', $request->travel_date)
                ->first();
    
            if ($existingBooking) {
                return response()->json([
                    'message' => "Can't book this ticket, it already exists"
                ], 409);
            }
    
            try {
                $booking = new TicketBooking();
                $user_id = $request->user_id;
                $booking->company_id = $company_id;
                $booking->trip_id = $request->trip_id;
                $booking->vehicle_id = $vehicle_id;
                $booking->seat_data = json_encode($seatData);
                $booking->passenger_name = $request->passenger_name;
                $booking->passenger_phone = $request->passenger_phone;
                $booking->travel_date = $request->travel_date;
                $booking->type = 'App';
                $booking->user_id = $user_id;
                $booking->save();
    
                foreach ($selectedSeats as $seat) {
                    $seatModel = Seat::find($seat['id']);
                    if ($seatModel) {
                        $seatModel->is_booked = 2;
                        $seatModel->save();
                    }
                }
    
                return response()->json([
                    'message' => 'Ticket Booking created successfully',
                ], 201);
            } catch (QueryException $e) {
                return response()->json([
                    'message' => 'Failed to create booking',
                    'error' => $e->errorInfo
                ], 409);
            }
        }
    }


    public function booking()
    {
        $user_id = auth()->user()->id;
        $bookings = TicketBooking::where('user_id', $user_id)->get();

        foreach ($bookings as $booking) {
            $booking->seat_data = json_decode($booking->seat_data);
            $booking->company;
            $booking->trip->route;
            $booking->trip->route->fromLocation;
            $booking->trip->route->toLocation;
            $booking->vehicle;
        }

        return response()->json([
            'message' => 'Bookings fetched successfully',
            'data' => $bookings
        ], 200);
    }
}
