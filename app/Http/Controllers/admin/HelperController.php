<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class HelperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('helper-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        // $helpers = Helper::where('company_id',auth()->user()->id)->latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $helpers = Helper::latest()->get();
        } else {
            $helpers = Helper::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.helper.index',compact('helpers'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'nid' => 'required',
            ]);

            $helper = new Helper();
            $helper->company_id = auth()->user()->id;
            $helper->name = $request->name;
            $helper->email = $request->email;
            $helper->phone = $request->phone;
            $helper->address = $request->address;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/helperdocument';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
                $helper->document = $fullpath;
            }
            $helper->nid = $request->nid;
            $helper->save();
            
            Toastr::success('Helper Added Successfully', 'Success');
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
                'phone' => 'required',
                'address' => 'required',
                'nid' => 'required',
            ]);
            
            $helper = Helper::find($id);
            $helper->name = $request->name;
            $helper->email = $request->email;
            $helper->phone = $request->phone;
            $helper->address = $request->address;
            $helper->nid = $request->nid;
            if ($request->hasFile('document')) {
                $file = $request->file('document');

                if ($helper->document && file_exists(public_path($helper->document))) {
                    unlink(public_path($helper->document));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/helperdocument';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
            }
            else{
                $fullpath = $helper->document;
            }
            $helper->document = $fullpath;
            $helper->status = $request->status;
            $helper->save();
            Toastr::success('Helper Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $helper = Helper::find($id);
            if ($helper->document && file_exists(public_path($helper->document))) {
                unlink(public_path($helper->document));
            }
            $helper->delete();
            Toastr::success('Helper Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
