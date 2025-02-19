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

        if ($user->hasRole('User')) {
            $routes = Route::where('company_id', $user->id)
            ->orWhere('company_id', $user->is_registration_by)
            ->get();
            $trips = Trip::where('company_id', $user->id)
            ->orWhere('company_id', $user->is_registration_by)
            ->where('start_date', '>=', now()->toDateString())
            ->latest()
            ->get();
        } elseif ($user->hasRole('Company')) {
            $routes = Route::where('company_id', $user->id)->get();
            $trips = Trip::where('company_id', $user->id) ->where('start_date', '>=', now()->toDateString())->latest()->get();
        } else {
            $routes = Route::latest()->get();
            $trips = Trip::latest() ->where('start_date', '>=', now()->toDateString())->get();
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
                ->latest()
                ->get();
            } elseif ($user->hasRole('Company')) {
                $trips = Trip::where('company_id', $user->id)
                ->where('route_id', $request->route_id)
                ->where('start_date', $filter_date)
                ->latest()
                ->get();
            } elseif ($user->hasRole('Super Admin')) {
                $trips = Trip::where('route_id', $request->route_id)
                ->where('start_date', $filter_date)
                ->latest()
                ->get();
            }

        return view('admin.pages.ticketBooking.index', compact('routes', 'route', 'trips', 'filter_date'));
        }
    }

//     public function showDetails(Request $request)
// {
//     // Extract data from the request
//     $trip = Trip::find($request->get('trip_id'));
//     $vehicle = Vehicle::find($request->get('vehicle_id'));
//     $route = Route::find($trip->route_id);
//     $bookingDate = $request->get('booking_date');
//     $seatsData = json_decode($request->get('seats_data'), true);

//     // Return view using compact
//     return view('admin.pages.ticketBooking.passengerDetails', compact('trip', 'vehicle', 'route','bookingDate', 'seatsData'));
// }

// public function store(Request $request)
// {
//     try {
//         $request->validate([
//             'trip_id' => 'required|exists:trips,id',
//             'vehicle_id' => 'required|exists:vehicles,id',
//             'booking_date' => 'required|date',
//             'passenger_phone' => 'required|string',
//         ]);

//         $selectedSeats = json_decode($request->seats_data, true);

//         if (is_array($selectedSeats)) {
//             foreach ($selectedSeats as $seat) {
//                 TicketBooking::create([
//                     'company_id' => auth()->user()->id,
//                     'trip_id' => $request->trip_id,
//                     'vehicle_id' => $request->vehicle_id,
//                     'seat_id' => $seat['seatId'],
//                     'seat_no' => $seat['seatNo'],
//                     'booking_date' => $request->booking_date,
//                     'payment_amount' => $seat['seatPrice'],
//                     'passenger_name' => $request->passenger_name,
//                     'passenger_phone' => $request->passenger_phone,
//                 ]);

//                 $seatModel = Seat::where('id', $seat['seatId'])->first();
//                 $seatModel->is_booked = 2;
//                 $seatModel->save();
//             }
//         } else {
//             return redirect()->back()->with('error', 'Invalid selected seats data.');
//         }

//         // Fetch trip, vehicle, and route details for the confirmation page
//         $trip = Trip::find($request->trip_id);
//         $vehicle = Vehicle::find($request->vehicle_id);
//         $route = Route::find($trip->route_id);

//         // Store data in the session (persist until explicitly removed)
//         session([
//             'passenger_name' => $request->passenger_name ?? null,
//             'passenger_phone' => $request->passenger_phone,
//             'trip' => $trip,
//             'vehicle' => $vehicle,
//             'route' => $route,
//             'bookingDate' => $request->booking_date,
//             'seatsData' => $selectedSeats,
//         ]);

//         // Return a success response with a flag to show the modal
//         return response()->json([
//             'success' => true,
//             'message' => 'Booking successful!',
//             'show_modal' => true, // Flag to indicate that the modal should be shown
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'An error occurred: ' . $e->getMessage(),
//         ], 500);
//     }
// }

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
                    // 'payment_method' => $request->payment_method, 
                    // 'total_payment' => $totalPayment,
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

// public function generatePdf(Request $request)
// {
//     $data = [
//         'vehicle' => Vehicle::find($request->vehicle_id),
//         'route' => Route::find($request->route_id),
//         'trip' => Trip::find($request->trip_id),
//         'seatsData' => json_decode($request->seats_data, true),
//         'passenger_name' => $request->passenger_name,
//         'passenger_phone' => $request->passenger_phone,
//     ];

//     $pdf = FacadePdf::loadView('admin.pages.ticketBooking.print', $data);
//     return $pdf->download('ticket.pdf');
// }

// public function showConfirmation(Request $request)
// {
//     // Check if session data exists
//     if ( !session()->has('passenger_phone') || !session()->has('trip') || !session()->has('vehicle') || !session()->has('route') || !session()->has('bookingDate') || !session()->has('seatsData')) {
//         return redirect()->route('ticket_booking.section')->with('error', 'No booking data found. Please book a ticket first.');
//     }

//     // Get data from the session
//     $passenger_name = session('passenger_name');
//     $passenger_phone = session('passenger_phone');
//     $trip = session('trip');
//     $vehicle = session('vehicle');
//     $route = session('route');
//     $bookingDate = session('bookingDate');
//     $seatsData = session('seatsData');

//     // Pass data to the view
//     return view('admin.pages.ticketBooking.ticket', compact(
//         'passenger_name',
//         'passenger_phone',
//         'trip',
//         'vehicle',
//         'route',
//         'bookingDate',
//         'seatsData'
//     ));
// }
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