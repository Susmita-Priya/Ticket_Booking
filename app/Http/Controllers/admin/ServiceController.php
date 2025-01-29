<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;
class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('service-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    public function index()
    {
        $service = Service::latest()->get();
        return view('admin.pages.service.index', compact('service'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/service'), $imageName);
            $service = new Service();
            $service->title = $request->title;
            $service->details = $request->details;
            $service->image = $imageName;
            $service->save();
            Toastr::success('Service Added Successfully', 'Success');
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
            $service = Service::find($id);
            $service->title = $request->title;
            $service->details = $request->details;
            $service->status = $request->status;
            if($request->image){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/service'), $imageName);
                $service->image = $imageName;
            }
            $service->save();
            Toastr::success('Service Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::find($id);
            $imagePath = public_path('images/service/' . $service->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            // Delete the Team member
            $service->delete();
            Toastr::success('Service Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
