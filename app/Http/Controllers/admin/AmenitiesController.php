<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class AmenitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('amenities-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        // $amenities = Amenities::where('company_id',auth()->user()->id)->latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $amenities = Amenities::latest()->get();
        } else {
            $amenities = Amenities::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.amenities.index', compact('amenities'));
    }

    public function store(Request $request)
    {
        try {
            $amenities = new Amenities();
            $amenities->name = $request->name;
            $amenities->short_details = $request->short_details;
            $amenities->company_id = auth()->user()->id;
            $amenities->save();
            Toastr::success('Amenities Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $amenities = Amenities::find($id);
            $amenities->name = $request->name;
            $amenities->short_details = $request->short_details;
            $amenities->status = $request->status;
            $amenities->save();
            Toastr::success('Amenities Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $amenities = Amenities::find($id);
            $amenities->delete();
            Toastr::success('Amenities Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
