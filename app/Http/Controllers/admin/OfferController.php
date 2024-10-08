<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('offer-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $offer = Offer::latest()->get();
        return view('admin.pages.offer.index', compact('offer'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/offer'), $imageName);
            $offer = new Offer();
            $offer->title = $request->title;
            $offer->details = $request->details;
            $offer->amount = $request->amount;
            $offer->discount_amount = $request->discount_amount;
            $offer->image = $imageName;
            $offer->save();
            Toastr::success('Offer Added Successfully', 'Success');
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
                'title' => 'required',
            ]);
            $offer = Offer::find($id);
            $offer->title = $request->title;
            $offer->details = $request->details;
            $offer->amount = $request->amount;
            $offer->discount_amount = $request->discount_amount;
            $offer->status = $request->status;

            if($request->image){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/offer'), $imageName);
                $offer->image = $imageName;
            }
            $offer->save();
            Toastr::success('Offer Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $offer = Offer::find($id);
            $imagePath = public_path('images/offer/' . $offer->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the Team member
            $offer->delete();
            Toastr::success('Offer Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
