<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RouteManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class RouteManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('route-manager-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $routeManagers = RouteManager::latest()->get();
        return view('admin.pages.routeManager.index',compact('routeManagers'));
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

            $routeManager = new RouteManager();
            $routeManager->name = $request->name;
            $routeManager->email = $request->email;
            $routeManager->phone = $request->phone;
            $routeManager->address = $request->address;
            $routeManager->nid = $request->nid;
            $routeManager->save();
            
            Toastr::success('RouteManager Added Successfully', 'Success');
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
            
            $routeManager = RouteManager::find($id);
            $routeManager->name = $request->name;
            $routeManager->email = $request->email;
            $routeManager->phone = $request->phone;
            $routeManager->address = $request->address;
            $routeManager->nid = $request->nid;
            $routeManager->status = $request->status;
            $routeManager->save();
            Toastr::success('RouteManager Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $routeManager = RouteManager::find($id);
            $routeManager->delete();
            Toastr::success('RouteManager Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
