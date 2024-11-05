<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('vehicle-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $vehicles = Vehicle::where('company_id',auth()->user()->id)->latest()->get();
        $categories = Category::all(); 
        $types = Type::all();
        $amenities = Amenities::where('company_id',auth()->user()->id)->latest()->get();

        return view('admin.pages.vehicle.index', compact('vehicles', 'categories', 'types', 'amenities'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'engin_no' => 'required',
                'total_seat' => 'required',
            ]);
            $vehicle = new Vehicle();
            $vehicle->company_id = auth()->user()->id;
            $vehicle->category_id = $request->category_id;
            $vehicle->type_id = $request->type_id;
            $vehicle->amenities_ids = json_encode($request->amenities_ids);
            $vehicle->name = $request->name;
            $vehicle->engin_no = $request->engin_no;
            $vehicle->total_seat = $request->total_seat;
            $vehicle->save();
            Toastr::success('Vehicle Added Successfully', 'Success');
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
                'name' => 'required',
                'engin_no' => 'required',
                'total_seat' => 'required',
            ]);
            $vehicle = Vehicle::find($id);
            if (!$vehicle) {
                return redirect()->back()->with('error', 'Vehicle not found');
            }
            $vehicle->category_id = $request->category_id;
            $vehicle->type_id = $request->type_id;
            $vehicle->amenities_ids = json_encode($request->amenities_ids);
            $vehicle->name = $request->name;
            $vehicle->engin_no = $request->engin_no;
            $vehicle->total_seat = $request->total_seat;
            $vehicle->status = $request->status;
            $vehicle->save();
            Toastr::success('Vehicle Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
            Toastr::success('Vehicle Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
