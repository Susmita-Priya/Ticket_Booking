<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use App\Models\User;
use App\Models\VehiclePublished;
use Illuminate\Http\Request;

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
        return view('admin.pages.vehicle.vehiclePublished', compact('vehiclePublished', 'division'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        return view('admin.pages.vehicle.vehiclePublishedList');
    }
}
