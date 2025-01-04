<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VehiclePublished;
use Illuminate\Http\Request;

class PublishedVehicleController extends Controller
{
    public function index()
    {
        $vehiclePublished  = VehiclePublished::latest()->get();
        $company = User::latest()->get();

        return view('admin.pages.vehicle.vehiclePublished', compact('vehiclePublished', 'company'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        return view('admin.pages.vehicle.vehiclePublishedList');
    }
}
