<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class PlaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('place-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $district = District::latest()->get();
        $place = Place::with('district')->latest()->get();
        return view('admin.pages.place.index', compact('district', 'place'));
    }

    public function store(Request $request)
    {
        try {
            $place = new Place();
            $place->name = $request->name;
            $place->district_id = $request->district_id;
            $place->save();
            Toastr::success('Place Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $place = Place::find($id);
            $place->name = $request->name;
            $place->district_id = $request->district_id;
            $place->status = $request->status;
            $place->save();
            Toastr::success('Place Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $place = Place::find($id);
            $place->delete();
            Toastr::success('Place Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
