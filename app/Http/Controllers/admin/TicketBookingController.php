<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Seat;
use App\Models\TicketBooking;
use App\Models\Trip;
use App\Models\Vehicle;
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

    public function showDetails(Request $request)
{
    // Extract data from the request
    $trip = Trip::find($request->get('trip_id'));
    $vehicle = Vehicle::find($request->get('vehicle_id'));
    $route = Route::find($trip->route_id);
    $bookingDate = $request->get('booking_date');
    $seatsData = json_decode($request->get('seats_data'), true);

    // Return view using compact
    return view('admin.pages.ticketBooking.passengerDetails', compact('trip', 'vehicle', 'route','bookingDate', 'seatsData'));
}

public function store(Request $request)
{
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

        // Fetch trip, vehicle, and route details for the confirmation page
        $trip = Trip::find($request->trip_id);
        $vehicle = Vehicle::find($request->vehicle_id);
        $route = Route::find($trip->route_id);

        // Store data in the session (persist until explicitly removed)
        session([
            'passenger_name' => $request->passenger_name ?? null,
            'passenger_phone' => $request->passenger_phone,
            'trip' => $trip,
            'vehicle' => $vehicle,
            'route' => $route,
            'bookingDate' => $request->booking_date,
            'seatsData' => $selectedSeats,
        ]);

        // Redirect to the confirmation page
        return redirect()->route('booking.confirmation');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

public function showConfirmation(Request $request)
{
    // Check if session data exists
    if ( !session()->has('passenger_phone') || !session()->has('trip') || !session()->has('vehicle') || !session()->has('route') || !session()->has('bookingDate') || !session()->has('seatsData')) {
        return redirect()->route('ticket_booking.section')->with('error', 'No booking data found. Please book a ticket first.');
    }

    // Get data from the session
    $passenger_name = session('passenger_name');
    $passenger_phone = session('passenger_phone');
    $trip = session('trip');
    $vehicle = session('vehicle');
    $route = session('route');
    $bookingDate = session('bookingDate');
    $seatsData = session('seatsData');

    // Pass data to the view
    return view('admin.pages.ticketBooking.ticket', compact(
        'passenger_name',
        'passenger_phone',
        'trip',
        'vehicle',
        'route',
        'bookingDate',
        'seatsData'
    ));
}
public function reserveSeats(Request $request)
{
    $request->validate([
        'seats' => 'required|array',
        'seats.*.seatId' => 'required|exists:seats,id',
    ]);

    $selectedSeats = $request->input('seats');

    try {
        foreach ($selectedSeats as $seat) {
            $seatModel = Seat::find($seat['seatId']);
            if ($seatModel->is_booked == 0) {
                $seatModel->is_booked = 3; // Mark seat as reserved
                $seatModel->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Some seats are already reserved or booked.']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Seats reserved successfully!']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
}
