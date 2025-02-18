<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class CounterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('counter-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $locations = Place::latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $counters = Counter::latest()->get();
        } else {
            $counters = Counter::where('company_id', auth()->user()->id)->latest()->get();
        }
        // $counters = Counter::where('company_id',auth()->user()->id)->latest()->get();
        return view('admin.pages.counters.index',compact('counters','locations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'location_id' => 'required',
            ]);

            $counter = new Counter();
            $counter->company_id = auth()->user()->id;
            $counter->name = $request->name;
            $counter->counter_no = $request->counter_no;
            $counter->location_id = $request->location_id;
            $counter->save();
            
            Toastr::success('Counter Added Successfully', 'Success');
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
                'location_id' => 'required',
            ]);
            
            $counter = Counter::find($id);
            $counter->name = $request->name;
            $counter->counter_no = $request->counter_no;
            $counter->location_id = $request->location_id;
            $counter->status = $request->status;
            $counter->save();
            Toastr::success('Counter Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $counter = Counter::find($id);
            $counter->delete();
            Toastr::success('Counter Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
