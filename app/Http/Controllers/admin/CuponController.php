<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class CuponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('cupon-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $cupon = Cupon::where('company_id',auth()->user()->id)->latest()->get();
        //  dd($cupon->toArray());
        return view('admin.pages.cupon.index', compact('cupon'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cupon_code' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            $cupon = new Cupon();
            $cupon->company_id = auth()->user()->id;
            $cupon->cupon_code = $request->cupon_code;
            $cupon->start_date = $request->start_date;
            $cupon->end_date = $request->end_date;
            $cupon->minimum_expend = $request->minimum_expend;
            $cupon->discount_amount = $request->discount_amount;
            $cupon->save();
            Toastr::success('Cupon Added Successfully', 'Success');
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
                'cupon_code' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);
            $cupon = Cupon::find($id);
            $cupon->cupon_code = $request->cupon_code;
            $cupon->start_date = $request->start_date;
            $cupon->end_date = $request->end_date;
            $cupon->minimum_expend = $request->minimum_expend;
            $cupon->discount_amount = $request->discount_amount;
            $cupon->save();
            Toastr::success('Cupon Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $cupon = Cupon::find($id);
            $cupon->delete();
            Toastr::success('Cupon Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}

