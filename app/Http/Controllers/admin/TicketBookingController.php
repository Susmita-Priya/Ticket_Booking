<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Seat;
use App\Models\TicketBooking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class TicketBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('ticket-booking-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        $routes = Route::where('company_id', auth()->user()->id)->get();
        $route = $routes->where('id', $request->route_id)->first();
        $filter_date = $request->filter_date;

        if ($request->route_id == null || $request->filter_date == null) {
            return view('admin.pages.ticketBooking.index', compact('routes'));
        }
        $trips = Trip::where('company_id', auth()->user()->id)->where('route_id', $request->route_id)->where('Date', $filter_date)->latest()->get();

        return view('admin.pages.ticketBooking.index', compact('routes', 'route', 'trips', 'filter_date'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'trip_id' => 'required|exists:trips,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'booking_date' => 'required|date',
                'passenger_phone' => 'required|string',
            ]);

            $selectedSeats = json_decode($request->seats_data, true);

            if (is_array($selectedSeats)) {
                foreach ($selectedSeats as $seat) {
                    TicketBooking::create([
                        'company_id' => auth()->user()->id,
                        'trip_id' => $request->trip_id,
                        'vehicle_id' => $request->vehicle_id,
                        'seat_id' => $seat['seatId'],
                        'seat_no' => $seat['seatNo'],
                        'booking_date' => $request->booking_date,
                        'payment_amount' => $seat['seatPrice'],
                        'passenger_name' => $request->passenger_name,
                        'passenger_phone' => $request->passenger_phone,
                    ]);

                    $seatModel = Seat::where('id', $seat['seatId'])->first();
                    $seatModel->is_booked = 2;
                    $seatModel->save();
                }
            } else {
                return redirect()->back()->with('error', 'Invalid selected seats data.');
            }

            Toastr::success('Ticket Booking Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        Toastr::success('Ticket Booking Successfully', 'Success');
    }

    public function resetSeat($id)
    {
        try {
            $seats = Seat::where('company_id', auth()->user()->id)->where('vehicle_id', $id)->get();
            foreach ($seats as $seat) {
                $seat->is_booked = 0;
                $seat->save();
            }
            
            Toastr::success('Seat Reset Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
