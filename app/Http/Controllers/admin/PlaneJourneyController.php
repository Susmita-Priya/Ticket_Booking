<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Country;
use App\Models\Journey_type;
use App\Models\Location;
use App\Models\Plane;
use App\Models\PlaneJourney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class PlaneJourneyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('plane-journey-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $plane_journey = PlaneJourney::where('company_id',auth()->user()->id)->latest()->get();
        $planes = Plane::where('company_id',auth()->user()->id)->latest()->get();
        $journey_types = Journey_type::all();
        $countries = Country::where('status', 1)->latest()->get();
        $locations = Location::all();

        return view('admin.pages.planejourney.index', compact('plane_journey', 'planes', 'journey_types', 'countries', 'locations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([

                'plane_id' => 'required',
                'journey_types_id' => 'required',
                'from_country_id' => 'required',
                'start_location_id' => 'required',
                'to_country_id' => 'required',
                'end_location_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'total_seats' => 'required',
            ]);
            $plane_journey = new PlaneJourney();
            $plane_journey->company_id = auth()->user()->id;
            $plane_journey->plane_id = $request->plane_id;
            $plane_journey->journey_types_id = json_encode($request->journey_types_id);
            $plane_journey->from_country_id = $request->from_country_id;
            $plane_journey->start_location_id = $request->start_location_id;
            $plane_journey->to_country_id = $request->to_country_id;
            $plane_journey->end_location_id = $request->end_location_id;
            $plane_journey->start_date = $request->start_date;
            $plane_journey->end_date = $request->end_date;
            $plane_journey->total_seats = $request->total_seats;
            $plane_journey->available_seats = $request->available_seats;
            $plane_journey->save();
            Toastr::success('Plane Journey Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getlocation($id)
    {
         $locations = Location::where('country_id', $id)->get();
         return response()->json($locations);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'plane_id' => 'required',
                'journey_types_id' => 'required',
                'from_country_id' => 'required',
                'start_location_id' => 'required',
                'to_country_id' => 'required',
                'end_location_id' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'total_seats' => 'required',
            ]);
            $plane_journey = PlaneJourney::find($id);
            $plane_journey->plane_id = $request->plane_id;
            $plane_journey->journey_types_id = json_encode($request->journey_types_id);
            $plane_journey->from_country_id = $request->from_country_id;
            $plane_journey->start_location_id = $request->start_location_id;
            $plane_journey->to_country_id = $request->to_country_id;
            $plane_journey->end_location_id = $request->end_location_id;
            $plane_journey->start_date = $request->start_date;
            $plane_journey->end_date = $request->end_date;
            $plane_journey->total_seats = $request->total_seats;
            $plane_journey->available_seats = $request->available_seats;
            $plane_journey->published_status = $request->published_status;
            $plane_journey->save();
            Toastr::success('Plane Journey Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $plane_journey = PlaneJourney::find($id);
            $plane_journey->delete();
            Toastr::success('Plane Journey Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
