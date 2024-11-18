<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Plane;
use App\Models\PlaneJourney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('booking-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $booking = Booking::latest()->get();
        $planes = Plane::all();
        $planeJourneys = PlaneJourney::all();
        $locations = Location::all();
        return view('admin.pages.booking.index', compact('booking', 'planes', 'locations','planeJourneys'));
    }

    public function destroy($id)
    {
        try {
           $booking = Booking::find($id);
            $booking->delete();
            Toastr::success('Booking Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
