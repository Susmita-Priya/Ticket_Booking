<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Country;
use App\Models\Journey_type;
use App\Models\Location;
use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class PlaneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('plane-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $plane = Plane::where('company_id',auth()->user()->id)->latest()->get();
        $journey_types = Journey_type::all();
        $amenities = Amenities::where('company_id',auth()->user()->id)->latest()->get();
        $countries = Country::all();
        $locations = Location::all();
        return view('admin.pages.plane.index', compact('plane', 'journey_types', 'amenities', 'countries', 'locations'));
    }

    public function getlocation($id)
    {
         $locations = Location::where('country_id', $id)->get();
         return response()->json($locations);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $plane = new Plane();
            $plane->company_id = auth()->user()->id;
            $plane->journey_type_id = $request->journey_type_id;
            $plane->amenities_ids = json_encode($request->amenities_ids);
            $plane->country_id = $request->country_id;
            $plane->location_id = $request->location_id;
            $plane->name = $request->name;
            $plane->save();
            Toastr::success('Plane Added Successfully', 'Success');
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
            ]);
            $plane = Plane::find($id);
            $plane->journey_type_id = $request->journey_type_id;
            $plane->amenities_ids = json_encode($request->amenities_ids);
            $plane->country_id = $request->country_id;
            $plane->location_id = $request->location_id;
            $plane->name = $request->name;
            $plane->save();
            Toastr::success('Plane Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $plane = Plane::find($id);
            $plane->delete();
            Toastr::success('Plane Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
