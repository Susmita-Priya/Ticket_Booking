<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('owner-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $owners = Owner::latest()->get();
        return view('admin.pages.owner.index',compact('owners'));
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

            $owner = new Owner();
            $owner->name = $request->name;
            $owner->email = $request->email;
            $owner->phone = $request->phone;
            $owner->address = $request->address;
            $owner->nid = $request->nid;
            $owner->save();
            
            Toastr::success('Owner Added Successfully', 'Success');
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
            
            $owner = Owner::find($id);
            $owner->name = $request->name;
            $owner->email = $request->email;
            $owner->phone = $request->phone;
            $owner->address = $request->address;
            $owner->nid = $request->nid;
            $owner->status = $request->status;
            $owner->save();
            Toastr::success('Owner Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $owner = Owner::find($id);
            $owner->delete();
            Toastr::success('Owner Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
