<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checker;
use App\Models\Counter;
use App\Models\Driver;
use App\Models\Employee;
use App\Models\LoginLog;
use App\Models\News;
use App\Models\Offer;
use App\Models\Owner;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\Route;
use App\Models\RouteManager;
use App\Models\Showcase;
use App\Models\Team;
use App\Models\Training;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Venue;
use Illuminate\Http\Request;
use MongoDB\Driver\Server;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->status != 1) {
            return redirect()->back()->with('error', 'Your account is inactive.');
        }
        if ($user->hasRole('Super Admin')) {
            $counters = Counter::latest()->get();
            $routes = Route::latest()->get();
            $routeManagers = Employee::where('department', "Route Manager")->latest()->get();
            $checkers = Employee::where('department', "Checker")->latest()->get();
            $owners = Employee::where('department', "Owner")->latest()->get();
            $drivers = Employee::where('department', "Driver")->latest()->get();
            $vehicles = Vehicle::latest()->get();
            $trips = Trip::latest()->get();
        } elseif ($user->hasRole('Company')) {
            $counters = Counter::where('company_id', $user->id)->latest()->get();
            $routes = Route::where('company_id', $user->id)->latest()->get();
            $routeManagers = Employee::where('department', "Route Manager")->where('company_id', $user->id)->latest()->get();
            $checkers = Employee::where('department', "Checker")->where('company_id', $user->id)->latest()->get();
            $owners = Employee::where('department', "Owner")->where('company_id', $user->id)->latest()->get();
            $drivers = Employee::where('department', "Driver")->where('company_id', $user->id)->latest()->get();
            $vehicles = Vehicle::where('company_id', $user->id)->latest()->get();
            $trips = Trip::where('company_id', $user->id)->latest()->get();
        } else {
            $counters = Counter::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->latest()->get();
            $routes = Route::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->latest()->get();
            $routeManagers = Employee::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->where('department', "Route Manager")->latest()->get();
            $checkers = Employee::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->where('department', "Checker")->latest()->get();
            $owners = Employee::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->where('department', "Owner")->latest()->get();
            $drivers = Employee::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->where('department', "Driver")->latest()->get();
            $vehicles = Vehicle::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->latest()->get();
            $trips = Trip::where('company_id', $user->id)
                ->orWhere('company_id', $user->is_registration_by)->latest()->get();
        }

        $loginLog = LoginLog::orderBy('last_login', 'desc')->get();
        $totalOffer = Offer::count();
        return view('admin.dashboard', compact('loginLog', 'totalOffer', 'counters', 'routes', 'routeManagers', 'checkers', 'owners', 'drivers', 'vehicles', 'trips'));
    }

    public function unauthorized()
    {
        return view('admin.unauthorized');
    }
}
