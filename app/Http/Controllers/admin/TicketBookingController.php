<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Route;
use App\Models\Seat;
use App\Models\TicketBooking;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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
        $user = auth()->user();
        $route = null;
        $trips = null;
        $routes = null;

        if ($user->hasRole('User')) {
            $routes = Route::where('company_id', $user->id)
            ->orWhere('company_id', $user->is_registration_by)
            ->get();
            $trips = Trip::where('company_id', $user->id)
            ->orWhere('company_id', $user->is_registration_by)
            ->where(function ($query) {
                $query->whereRaw("CONCAT(start_date, ' ', start_time) > ?", [now()->toDateTimeString()]);
            })
            ->where('trip_status', 1)
            ->latest()
            ->get();
        } elseif ($user->hasRole('Company')) {
            $routes = Route::where('company_id', $user->id)->get();
            $trips = Trip::where('company_id', $user->id)
            ->where(function ($query) {
                $query->whereRaw("CONCAT(start_date, ' ', start_time) > ?", [now()->toDateTimeString()]);
            })
            ->where('trip_status', 1)
            ->latest()
            ->get();
        } else {
            $routes = Route::latest()->get();
            $trips = Trip::latest()->where(function ($query) {
                $query->whereRaw("CONCAT(start_date, ' ', start_time) > ?", [now()->toDateTimeString()]);
            })
            ->where('trip_status', 1)->get();
        }
        
        if ($request->route_id == null || $request->filter_date == null) {
            return view('admin.pages.ticketBooking.index', compact('routes', 'trips', 'route'));
        }else{

            $route = $routes->where('id', $request->route_id)->first();
            $filter_date = $request->filter_date;

            if ($user->hasRole('User')) {
                $trips = Trip::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)
                ->where('route_id', $request->route_id)
                ->where('start_date', $filter_date)
                ->where('trip_status', 1)
                ->latest()
                ->get();
            } elseif ($user->hasRole('Company')) {
                $trips = Trip::where('company_id', $user->id)
                ->where('route_id', $request->route_id)
                ->where('start_date', $filter_date)
                ->where('trip_status', 1)
                ->latest()
                ->get();
            } elseif ($user->hasRole('Super Admin')) {
                $trips = Trip::where('route_id', $request->route_id)
                ->where('start_date', $filter_date)
                ->where('trip_status', 1)
                ->latest()
                ->get();
            }

        return view('admin.pages.ticketBooking.index', compact('routes', 'route', 'trips', 'filter_date'));
        }
    }



public function store(Request $request)
{
        // dd($request->all());
        try {
            $request->validate([
                'trip_id' => 'required|exists:trips,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'passenger_phone' => 'required|string',
            ]);
            $selectedSeats = json_decode($request->seats_data, true);
            $totalPayment = 0;
            foreach ($selectedSeats as $seat) {
                $totalPayment += $seat['seatPrice'];
            }

            if (is_array($selectedSeats)) {
                $ticket_booking = TicketBooking::create([
                    'company_id' => auth()->user()->id,
                    'trip_id' => $request->trip_id,
                    'vehicle_id' => $request->vehicle_id,
                    'seat_data' => json_encode($selectedSeats),
                    'passenger_name' => $request->passenger_name,
                    'passenger_phone' => $request->passenger_phone,
                    'travel_date' => $request->travel_date,
                    'type' => "Counter",
                ]);
                Payment::create([
                    'booking_id' => $ticket_booking->id,
                    'total_payment' => $totalPayment,
                    'payment_method' => $request->payment_method,
                    'card_number' => $request->card_number,
                    'card_expiry' => $request->card_expiry,
                    'security_code' => $request->security_code,
                    'banking_type' => $request->banking_type,
                    'transaction_id' => $request->transaction_id,
                ]);
                foreach ($selectedSeats as $seat) {
                    $seatModel = Seat::where('id', $seat['seatId'])->first();
                    $seatModel->is_booked = 2;
                    $seatModel->save();
                }
            } else {
                return redirect()->back()->with('error', 'Invalid selected seats data.');
            }

            $data = [
                'trip' => Trip::find($request->trip_id),
                'vehicle' => Vehicle::find($request->vehicle_id),
                'seatsData' => $selectedSeats,
                'passenger_name' => $request->passenger_name??null,
                'passenger_phone' => $request->passenger_phone,
            ];

            $pdf = FacadePdf::loadView('admin.pages.ticketBooking.print', $data);
            return $pdf->download('ticket.pdf');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
        Toastr::success('Ticket Booking Successfully', 'Success');
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
                $seatModel->is_reserved_by = auth()->user()->id;
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

public function cancelReservation(Request $request)
{
    $request->validate([
        'seats' => 'required|array',
        'seats.*.seatId' => 'required|exists:seats,id',
    ]);

    $selectedSeats = $request->input('seats');

    try {
        foreach ($selectedSeats as $seat) {
            $seatModel = Seat::find($seat['seatId']);
            if ($seatModel->is_booked == 3 && $seatModel->is_reserved_by == auth()->user()->id) {
                $seatModel->is_booked = 0;
                $seatModel->is_reserved_by = null;
                $seatModel->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Some seats are not reserved by you.']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Seats reservation canceled successfully!']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
}