<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('district-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $division = Division::latest()->get();
        $district = District::with('division')->latest()->get();
        return view('admin.pages.district.index', compact('division', 'district'));
    }

    public function store(Request $request)
    {
        try {
            $district = new District();
            $district->name = $request->name;
            $district->division_id = $request->division_id;
            $district->save();
            Toastr::success('District Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $district = District::find($id);
            $district->name = $request->name;
            $district->division_id = $request->division_id;
            $district->status = $request->status;
            $district->save();
            Toastr::success('District Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $district = District::find($id);
            $district->delete();
            Toastr::success('District Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


}
