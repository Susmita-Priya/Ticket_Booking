<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('driver-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('admin.pages.driver.index',compact('drivers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'license' => 'required',
                'nid' => 'required',
            ]);

            $driver = new Driver();
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->phone = $request->phone;
            $driver->address = $request->address;
            $driver->license = $request->license;
            $driver->nid = $request->nid;
            $driver->save();
            
            Toastr::success('Driver Added Successfully', 'Success');
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
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'license' => 'required',
                'nid' => 'required',
            ]);
            
            $driver = Driver::find($id);
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->phone = $request->phone;
            $driver->address = $request->address;
            $driver->nid = $request->nid;
            $driver->license = $request->license;
            $driver->status = $request->status;
            $driver->save();
            Toastr::success('Driver Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $driver = Driver::find($id);
            $driver->delete();
            Toastr::success('Driver Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

