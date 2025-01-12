<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\Owner;
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
        $vehicles = Vehicle::with('owner','type')->where('company_id',auth()->user()->id)->latest()->get();
        $owners =Owner::where('company_id',auth()->user()->id)->latest()->get();
        $types = Type::where('company_id',auth()->user()->id)->latest()->get();
        $amenities = Amenities::where('company_id',auth()->user()->id)->latest()->get();

        return view('admin.pages.vehicle.index', compact('vehicles', 'owners', 'types', 'amenities'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'vehicle_no' => 'required',
                'engin_no' => 'required',
                'chest_no' => 'required',
                'total_seat' => 'required',
                'per_seat_price' => 'required',
            ]);

            $vehicle = new Vehicle();
            $vehicle->company_id = auth()->user()->id;
            $vehicle->owner_id = $request->owner_id;
            $vehicle->type_id = $request->type_id;
            $vehicle->name = $request->name;
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->engin_no = $request->engin_no;
            $vehicle->chest_no = $request->chest_no;
            $vehicle->total_seat = $request->total_seat;
            $vehicle->amenities_id = json_encode($request->amenities_id);
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/vehiclesPdf';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
                $vehicle->document = $fullpath;
            }
            $vehicle->per_seat_price = $request->per_seat_price;
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
                'vehicle_no' => 'required',
                'engin_no' => 'required',
                'chest_no' => 'required',
                'total_seat' => 'required',
                'per_seat_price' => 'required',
            ]);
            $vehicle = Vehicle::find($id);
            if (!$vehicle) {
                return redirect()->back()->with('error', 'Vehicle not found');
            }
            $vehicle->owner_id = $request->owner_id;
            $vehicle->type_id = $request->type_id;
            $vehicle->name = $request->name;
            $vehicle->vehicle_no = $request->vehicle_no;
            $vehicle->engin_no = $request->engin_no;
            $vehicle->chest_no = $request->chest_no;
            $vehicle->total_seat = $request->total_seat;
            $vehicle->amenities_id = json_encode($request->amenities_id);
            if ($request->hasFile('document')) {
                $file = $request->file('document');

                if ($vehicle->document && file_exists(public_path($vehicle->document))) {
                    unlink(public_path($vehicle->document));
                }
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/vehiclesPdf';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
                $vehicle->document = $fullpath;
            }else{
                $vehicle->document = $vehicle->document;
            }
            $vehicle->per_seat_price = $request->per_seat_price;
            $vehicle->is_booked = $request->is_booked;
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
            
            if($vehicle->is_booked == 1){
                Toastr::error('Vehicle is already booked, Check Trip', 'Error');
                return redirect()->back();
            }
            if ($vehicle->document && file_exists(public_path($vehicle->document))) {
                unlink(public_path($vehicle->document));
            }
            $seats = $vehicle->seats;
            foreach ($seats as $seat) {
                $seat->delete();
            }
            
            $vehicle->delete();
            Toastr::success('Vehicle Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
