<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehiclePublished;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class PublishedVehicleController extends Controller
{

    public function getDistrictsByDivision($divisionId)
    {
        $districts = District::where('division_id', $divisionId)->get();
        return response()->json($districts);
    }

    public function index()
    {
        $vehiclePublished  = VehiclePublished::latest()->get();
        $division = Division::latest()->get();
        $vehicle = Vehicle::where('company_id', auth()->user()->id)->where('is_booked',0)->get();
        return view('admin.pages.vehicle.vehiclePublished', compact('vehiclePublished', 'division', 'vehicle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_division_id' => 'required',
            'start_district_id' => 'required',
            'end_division_id' => 'required',
            'end_district_id' => 'required',
            'journey_date' => 'required',
            'vehicle_id' => 'required',
        ]);

        $vehiclePublished = new VehiclePublished();
        $vehiclePublished->company_id = auth()->user()->id;
        $vehiclePublished->vehicle_id = $request->vehicle_id;
        $vehiclePublished->start_division_id = $request->start_division_id;
        $vehiclePublished->start_district_id = $request->start_district_id;
        $vehiclePublished->end_division_id = $request->end_division_id;
        $vehiclePublished->end_district_id = $request->end_district_id;
        $vehiclePublished->journey_date = $request->journey_date;
        $vehiclePublished->start_time = $request->start_time;
        $vehiclePublished->end_time = $request->end_time;
        $vehiclePublished->save();

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $vehicle->is_booked = 1;
        $vehicle->save();

        Toastr::success('Seat Added Successfully', 'Success');
        return redirect()->back();
    }
}
