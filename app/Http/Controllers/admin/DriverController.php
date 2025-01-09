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
        $drivers = Driver::where('company_id',auth()->user()->id)->latest()->get();
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
                'nid' => 'required',
            ]);

            $driver = new Driver();
            $driver->company_id = auth()->user()->id;
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->phone = $request->phone;
            $driver->address = $request->address;
            if ($request->hasFile('license')) {
                $file = $request->file('license');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/driverLicense';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
                $driver->license = $fullpath;
            }
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
                'nid' => 'required',
            ]);
            
            $driver = Driver::find($id);
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->phone = $request->phone;
            $driver->address = $request->address;
            $driver->nid = $request->nid;
            if ($request->hasFile('license')) {
                $file = $request->file('license');

                if ($driver->license && file_exists(public_path($driver->license))) {
                    unlink(public_path($driver->license));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/driverLicense';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
            }
            else{
                $fullpath = $driver->license;
            }
            $driver->license = $fullpath;
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

            if ($driver->license && file_exists(public_path($driver->license))) {
                unlink(public_path($driver->license));
            }
            $driver->delete();
            Toastr::success('Driver Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

