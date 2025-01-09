<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
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
        $trips = Trip::with('route','vehicle','driver','supervisor')->where('company_id',auth()->user()->id)->latest()->get();
        $routes = Route::where('company_id',auth()->user()->id)->get();
        $vehicles = Vehicle::where('company_id',auth()->user()->id)->get();
        $drivers = Driver::where('company_id',auth()->user()->id)->get();
        $supervisors = Supervisor::where('company_id',auth()->user()->id)->get();

        return view('admin.pages.trip.index', compact('trips', 'routes', 'vehicles', 'drivers', 'supervisors'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'route_id' => 'required|integer',
                'vehicle_id' => 'required|integer',
                'driver_id' => 'required|integer',
                'supervisor_id' => 'required|integer',
                'Date' => 'required|date',
                'Time' => 'required|date_format:H:i',
                'total_route_cost' => 'required|numeric',
            ]);

            $trip = new Trip();
            $trip->company_id = auth()->user()->id;
            $trip->route_id = $request->route_id;
            $trip->vehicle_id = $request->vehicle_id;
            $trip->driver_id = $request->driver_id;
            $trip->supervisor_id = $request->supervisor_id;
            $trip->Date = $request->Date;
            $trip->Time = $request->Time;
            $trip->total_route_cost = $request->total_route_cost;
            $trip->save();
           
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
                'supervisor_id' => 'required|integer',
                'Date' => 'required|date',
                'Time' => 'required|date_format:H:i',
                'total_route_cost' => 'required|numeric',
            ]);
            $trip = Trip::find($id);
            if (!$trip) {
                return redirect()->back()->with('error', 'Trip not found');
            }
            $trip->route_id = $request->route_id;
            $trip->vehicle_id = $request->vehicle_id;
            $trip->driver_id = $request->driver_id;
            $trip->supervisor_id = $request->supervisor_id;
            $trip->Date = $request->Date;
            $trip->Time = $request->Time;
            $trip->total_route_cost = $request->total_route_cost;
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
            $trip->delete();
            Toastr::success('Trip Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
