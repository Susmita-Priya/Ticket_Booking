<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Helper;
use App\Models\Place;
use App\Models\Route;
use App\Models\Supervisor;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('trip-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $locations = Place::latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $trips = Trip::with('route', 'vehicle', 'driver', 'supervisor')->where('trip_status',1)->latest()->get();
            $routes = Route::all();
            // $vehicles = Vehicle::where('status', 1)->where('current_location_id', $routes->first()->fromLocation)->get();
            $drivers = Driver::all();
            $helpers = Helper::all();
            $supervisors = Supervisor::all();

        } else {
            $trips = Trip::with('route', 'vehicle', 'driver', 'supervisor')->where('company_id', auth()->user()->id)->where('trip_status',1)->latest()->get();
            $routes = Route::where('company_id', auth()->user()->id)->get();
            // $vehicles = Vehicle::where('company_id', auth()->user()->id)->where('status', 1)->get();
            $drivers = Driver::where('company_id', auth()->user()->id)->get();
            $helpers = Helper::where('company_id', auth()->user()->id)->get();
            $supervisors = Supervisor::where('company_id', auth()->user()->id)->get();
        }
        
        return view('admin.pages.trip.index', compact('trips', 'routes', 'drivers', 'supervisors', 'locations', 'helpers'));
    }

// In your TripController or any other relevant controller
public function fetchVehicles(Request $request)
{
    $fromLocationId = $request->query('fromLocationId');

    $vehicles = Vehicle::where('status', 1)->where('is_booked',0)
        ->where(function($query) use ($fromLocationId) {
            $query->where('current_location_id', $fromLocationId)
                  ->orWhereNull('current_location_id');
        })
        ->get();

    return response()->json(['vehicles' => $vehicles]);
}

    public function store(Request $request)
    {
        try {
            $request->validate([
                'route_id' => 'required|integer',
                'vehicle_id' => 'required|integer',
                'driver_id' => 'required|integer',
                'helper_id' => 'required|integer',
                'supervisor_id' => 'required|integer',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'reporting_time' => 'required',
                'ticket_price' => 'required|numeric',
                'total_route_cost' => 'required|numeric',
            ]);

            $trip = new Trip();
            $trip->company_id = auth()->user()->id;
            $trip->route_id = $request->route_id;
            $trip->vehicle_id = $request->vehicle_id;
            $trip->driver_id = $request->driver_id;
            $trip->helper_id = $request->helper_id;
            $trip->supervisor_id = $request->supervisor_id;
            $trip->start_date = $request->start_date;
            $trip->end_date = $request->end_date;
            $trip->start_time = $request->start_time;
            $trip->end_time = $request->end_time;
            $trip->reporting_time = $request->reporting_time;
            $trip->ticket_price = $request->ticket_price;
            $trip->total_route_cost = $request->total_route_cost;
            $trip->trip_status = 1;
            $trip->save();


            $route = Route::find($request->route_id);
            $vehicle = Vehicle::find($request->vehicle_id);
            $vehicle->is_booked = 1;
            $vehicle->current_location_id = $route->to_location_id;
            $vehicle->save();
           
            Toastr::success('Trip Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'route_id' => 'required|integer',
                'vehicle_id' => 'required|integer',
                'driver_id' => 'required|integer',
                'helper_id' => 'required|integer',
                'supervisor_id' => 'required|integer',
                'start_date' => 'required',
                'end_date' => 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'reporting_time' => 'required',
                'ticket_price' => 'required|numeric',
                'total_route_cost' => 'required|numeric',
            ]);
            $trip = Trip::find($id);
            if (!$trip) {
                return redirect()->back()->with('error', 'Trip not found');
            }
            $trip->route_id = $request->route_id;
            $trip->vehicle_id = $request->vehicle_id;
            $trip->driver_id = $request->driver_id;
            $trip->helper_id = $request->helper_id;
            $trip->supervisor_id = $request->supervisor_id;
            $trip->start_date = $request->start_date;
            $trip->end_date = $request->end_date;
            $trip->start_time = $request->start_time;
            $trip->end_time = $request->end_time;
            $trip->reporting_time = $request->reporting_time;
            $trip->ticket_price = $request->ticket_price;
            $trip->total_route_cost = $request->total_route_cost;
            $trip->trip_status = $request->trip_status;
            $trip->status = $request->status;
            $trip->save();
            Toastr::success('Trip Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $trip = Trip::find($id);

            $vehicle = Vehicle::find($trip->vehicle_id);
            $vehicle->is_booked = 0;
            $vehicle->current_location_id = null;
            $vehicle->save();
            $trip->delete();
            
            Toastr::success('Trip Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
