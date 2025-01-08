<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('supervisor-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $supervisors = Supervisor::latest()->get();
        return view('admin.pages.supervisor.index',compact('supervisors'));
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

            $supervisor = new Supervisor();
            $supervisor->name = $request->name;
            $supervisor->email = $request->email;
            $supervisor->phone = $request->phone;
            $supervisor->address = $request->address;
            $supervisor->nid = $request->nid;
            $supervisor->save();
            
            Toastr::success('Supervisor Added Successfully', 'Success');
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
            
            $supervisor = Supervisor::find($id);
            $supervisor->name = $request->name;
            $supervisor->email = $request->email;
            $supervisor->phone = $request->phone;
            $supervisor->address = $request->address;
            $supervisor->nid = $request->nid;
            $supervisor->status = $request->status;
            $supervisor->save();
            Toastr::success('Supervisor Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $supervisor = Supervisor::find($id);
            $supervisor->delete();
            Toastr::success('Supervisor Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
