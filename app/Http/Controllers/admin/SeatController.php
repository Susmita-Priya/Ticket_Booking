<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
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
    
        $vehicles = Vehicle::where('company_id', auth()->user()->id)->where('status',1)->get();
        $seats = Seat::where('company_id', auth()->user()->id)
                     ->where('vehicle_id', $vehicle_id)
                     ->latest()
                     ->get();
    
        $vehicle = Vehicle::firstWhere('id', $vehicle_id);
        $trip = Trip::where('company_id',auth()->user()->id)->where('vehicle_id', $request->vehicle_id)->first();
    
        return view('admin.pages.seat.index', compact('vehicles', 'vehicle', 'seats', 'trip', 'flag'));
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
            $seats = Seat::where('company_id',auth()->user()->id)->where('vehicle_id', $id)->get();
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
