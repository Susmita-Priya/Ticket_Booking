<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('faq-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $faq = Faq::latest()->get();
        return view('admin.pages.faq.index', compact('faq'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
            ]);
            $faq = new Faq();
            $faq->title = $request->title;
            $faq->details = $request->details;
            $faq->save();
            Toastr::success('Faq Added Successfully', 'Success');
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
            $faq = Faq::find($id);
            $faq->title = $request->title;
            $faq->details = $request->details;
            $faq->status = $request->status;
            $faq->save();
            Toastr::success('Faq Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::find($id);
            $faq->delete();
            Toastr::success('Faq Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
