<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\SeatBooking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class SeatBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('seat-booking-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $vehicle = Vehicle::where('company_id', auth()->user()->id)->where('id', $request->vehicle_id)->firstOrFail();
        $vehicle_id = $request->vehicle_id;

        $filter_date = $request->filter_date;
        $bookings = SeatBooking::where('company_id', auth()->user()->id)->where('vehicle_id', $vehicle_id)->where('booking_date', $filter_date)->latest()->get();
        $total_payment = $bookings->sum('payment_amount');

        return view('admin.pages.seatBooking.index', compact('vehicle', 'bookings', 'total_payment'));
    }


    public function store(Request $request)
    {
        dd($request->all());
        try {
            $request->validate([
                'vehicle_id' => 'required|integer',
                'seat_id' => 'required|integer',
                'seat_no' => 'required|string|max:255',
                'booking_date' => 'required|date',
                'payment_amount' => 'required|numeric',
                'passenger_phone' => 'required|string|max:15',
            ]);

            $seat_booking = new SeatBooking();
            $seat_booking->company_id = auth()->user()->id;
            $seat_booking->vehicle_id = $request->vehicle_id;
            $seat_booking->seat_id = $request->seat_id;
            $seat_booking->seat_no = $request->seat_no;
            $seat_booking->booking_date = $request->booking_date;
            $seat_booking->payment_amount = $request->payment_amount;
            $seat_booking->passenger_name = $request->passenger_name;
            $seat_booking->passenger_phone = $request->passenger_phone;
            $seat_booking->save();

            $seat = Seat::where('id', $request->seat_id)->first();
            $seat->is_booked = 1;
            $seat->save();

            Toastr::success('Seat Booking Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }




    // public function update(Request $request, $id)
    // {
    //     try {
    //         $request->validate([
    //             'seat_no' => 'required',
    //         ]);
    //         $seat = Seat::find($id);
    //         if (!$seat) {
    //             return redirect()->back()->with('error', 'Seat not found');
    //         }
    //         // $seat->vehicle_id = $request->vehicle_id;
    //         $seat->seat_no = $request->seat_no;
    //         $seat->is_booked = $request->is_booked;
    //         $seat->status = $request->status;
    //         $seat->save();
    //         Toastr::success('Seat Updated Successfully', 'Success');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    //     }
    // }

    public function destroy($id)
    {
        try {
            $seat_booking = SeatBooking::find($id);
            $seat = Seat::where('id', $seat_booking->seat_id)->first();
            $seat->is_booked = 0;
            $seat->save();
            $seat_booking->delete();
            Toastr::success('Seat Booking Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
