<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checker;
use App\Models\Counter;
use App\Models\Place;
use App\Models\Route;
use App\Models\RouteManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('route-list')) {
                return redirect()->route('unauthorized.action');
            }

            return $next($request);
        })->only('index');
    }
    
    public function index()
    {
        // $route = Route::with( 'routeManager')->where('company_id',auth()->user()->id)->latest()->get();
        // $counters = Counter::where('company_id',auth()->user()->id)->latest()->get();
        // $routeManagers = RouteManager::where('company_id',auth()->user()->id)->latest()->get();
        // $checkers = Checker::where('company_id',auth()->user()->id)->latest()->get();
        $locations = Place::latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $routes = Route::with('routeManager')->latest()->get();
            $counters = Counter::with('location')->latest()->get(); 
            $routeManagers = RouteManager::latest()->get();
            $checkers = Checker::latest()->get();
        } else {
            $routes = Route::with('routeManager')->where('company_id', auth()->user()->id)->latest()->get();
            $counters = Counter::with('location')->where('company_id', auth()->user()->id)->latest()->get();
            $routeManagers = RouteManager::where('company_id', auth()->user()->id)->latest()->get();
            $checkers = Checker::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.route.index', compact('routes', 'counters', 'routeManagers', 'checkers', 'locations'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
            'from_location_id' => 'required',
            'to_location_id' => 'required',
            'start_counter_id' => 'required',
            'end_counter_id' => 'required',
            'route_manager_id' => 'required',
            'checkers_id' => 'required',
            ]);

            $route = new Route();
            $route->company_id = auth()->user()->id;
            $route->from_location_id = $request->from_location_id ;
            $route->to_location_id = $request->to_location_id;
            $route->start_counter_id = $request->start_counter_id;
            $route->end_counter_id = $request->end_counter_id;
            $route->via_counters_id = json_encode(array_values($request->via_counters_id));
            $route->route_manager_id = $request->route_manager_id;
            $route->checkers_id = json_encode($request->checkers_id);
            if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/pdfs';
            $file->move(public_path($path), $filename);
            $fullpath = $path . '/' . $filename;
            $route->document = $fullpath;
            }
            $route->save();
            Toastr::success('Route Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
               'from_location_id' => 'required',
                'to_location_id' => 'required',
                'start_counter_id' => 'required',
                'end_counter_id' => 'required',
                'route_manager_id' => 'required',
                'checkers_id' => 'required',
            ]);

            $route = Route::find($id);
            // $route->name = $request->from_location_id . ' to_location_id ' . $request->to_location_id;
            $route->from_location_id = $request->from_location_id ;
            $route->to_location_id = $request->to_location_id;
            $route->start_counter_id = $request->start_counter_id;
            $route->end_counter_id = $request->end_counter_id;
            $route->via_counters_id = json_encode($request->via_counters_id);
            $route->route_manager_id = $request->route_manager_id;
            $route->checkers_id = json_encode($request->checkers_id);
            $fullpath = $route->document;
            if ($request->hasFile('document')) {
                $file = $request->file('document');

                if ($route->document && file_exists(public_path($route->document))) {
                    unlink(public_path($route->document));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/pdfs';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;

            }
            else{
                $fullpath = $route->document;
            }
            $route->document = $fullpath;
            $route->status = $request->status;
            $route->save();
            
            Toastr::success('Route Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $route = Route::find($id);
            // if ($route->document && file_exists(public_path($route->document))) {
            //     unlink(public_path($route->document));
            // }
            $route->delete();
            Toastr::success('Route Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
