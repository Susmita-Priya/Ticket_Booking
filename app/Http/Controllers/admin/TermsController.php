<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class TermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('terms-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $terms = TermsAndCondition::latest()->get();
        return view('admin.pages.terms.index', compact('terms'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
            ]);
            $terms = new TermsAndCondition();
            $terms->title = $request->title;
            $terms->details = $request->details;
            $terms->save();
            Toastr::success('Terms And Condition Added Successfully', 'Success');
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
            $terms = TermsAndCondition::find($id);
            $terms->title = $request->title;
            $terms->details = $request->details;
            $terms->status = $request->status;
            $terms->save();
            Toastr::success('Terms And Condition Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $terms = TermsAndCondition::find($id);
            $terms->delete();
            Toastr::success('Terms And Condition Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
