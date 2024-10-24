<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
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

    public function index()
    {
        $seats = Seat::latest()->get();
        $vehicles = Vehicle::all();

        return view('admin.pages.seat.index', compact('vehicles', 'seats'));
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
            $seat->vehicle_id = $request->vehicle_id;
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


}
