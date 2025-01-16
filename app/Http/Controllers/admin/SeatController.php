<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\SeatBooking;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class SeatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('seats-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $vehicle_id = $request->vehicle_id;
        $flag = $vehicle_id ? 1 : 0;
        $seat_count = 0;

        $vehicles = Vehicle::where('company_id', auth()->user()->id)->where('status', 1)->get();
        $seats = Seat::where('company_id', auth()->user()->id)
            ->where('vehicle_id', $vehicle_id)
            ->orderBy('seat_no', 'asc')
            ->get();

        $vehicle = Vehicle::firstWhere('id', $vehicle_id);
        $trip = Trip::where('company_id', auth()->user()->id)->where('vehicle_id', $request->vehicle_id)->first();

        return view('admin.pages.seat.index', compact('vehicles', 'vehicle', 'seats', 'trip', 'flag', 'seat_count'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'seat_no' => 'required',
            ]);
            $seat = new Seat();
            $seat->company_id = auth()->user()->id;
            $seat->vehicle_id = $request->vehicle_id;
            $seat->seat_no = $request->seat_no;
            $seat->save();
            Toastr::success('Seat Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    // seat select
    public function selectSeat(Request $request)
    {
        try {
            // Retrieve the current seat count from the session or default to 0
            $seat_count = session('selected_seats', 0);

            $seat = Seat::find($request->id);

            if ($seat->is_booked == 1) {
                $seat->is_booked = 0;
                $seat_count--;
            } elseif ($seat->is_booked == 0) {
                $seat->is_booked = 1;
                $seat_count++;
            }

            
            $trip = Trip::where('vehicle_id', $seat->vehicle_id)->first();
            $total_price = $trip ? (int)$trip->ticket_price * $seat_count : 0;

            // Update the session with the new values
            $request->session()->put('selected_seats', $seat_count);
            $request->session()->put('total_price', $total_price);

            $seat->save();

            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

//     public function selectSeat(Request $request)
// {
//     try {
//         $seat = Seat::find($request->seat_id);

//         if (!$seat) {
//             return response()->json(['error' => 'Seat not found'], 404);
//         }

//         // Toggle the seat booking status
//         $seat->is_booked = $request->is_booked;
//         $seat->save();

//         // Update session values
//         $seat_count = session('selected_seats', 0);
//         $seat_count += $request->is_booked ? 1 : -1;

//         $trip = Trip::where('vehicle_id', $seat->vehicle_id)->first();
//         $total_price = $trip ? (int)$trip->ticket_price * $seat_count : 0;

//         session(['selected_seats' => $seat_count, 'total_price' => $total_price]);

//         return response()->json(['seat_count' => $seat_count, 'total_price' => $total_price]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'An error occurred: ' . $e->getMessage()]);
//     }
// }



    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'seat_no' => 'required',
            ]);
            $seat = Seat::find($id);
            if (!$seat) {
                return redirect()->back()->with('error', 'Seat not found');
            }
            // $seat->vehicle_id = $request->vehicle_id;
            $seat->seat_no = $request->seat_no;
            $seat->is_booked = $request->is_booked;
            $seat->status = $request->status;
            $seat->save();
            Toastr::success('Seat Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $seat = Seat::find($id);
            $seat->delete();
            Toastr::success('Seat Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function resetSeat($id)
    {
        try {
            $seats = Seat::where('company_id', auth()->user()->id)->where('vehicle_id', $id)->get();
            foreach ($seats as $seat) {
                $seat->is_booked = 0;
                $seat->save();
            }
            
            session()->forget('selected_seats');
            session()->forget('total_price');
            
            Toastr::success('Seat Reset Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
