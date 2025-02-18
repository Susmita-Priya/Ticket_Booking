<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class CheckerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('checker-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $checkers = Checker::latest()->get();
        } else {
            $checkers = Checker::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.checker.index',compact('checkers'));
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

            $checker = new Checker();
            $checker->company_id = auth()->user()->id;
            $checker->name = $request->name;
            $checker->email = $request->email;
            $checker->phone = $request->phone;
            $checker->address = $request->address;
            $checker->nid = $request->nid;
            $checker->save();
            
            Toastr::success('Checker Added Successfully', 'Success');
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
            
            $checker = Checker::find($id);
            $checker->name = $request->name;
            $checker->email = $request->email;
            $checker->phone = $request->phone;
            $checker->address = $request->address;
            $checker->nid = $request->nid;
            $checker->status = $request->status;
            $checker->save();
            Toastr::success('Checker Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $checker = Checker::find($id);
            $checker->delete();
            Toastr::success('Checker Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
