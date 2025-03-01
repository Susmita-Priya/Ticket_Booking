<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Checker;
use App\Models\Counter;
use App\Models\Driver;
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
        if (auth()->user()->hasRole('Super Admin')) {
            $counters = Counter::latest()->get();
            $routes = Route::latest()->get();
            $routeManagers = RouteManager::latest()->get();
            $checkers = Checker::latest()->get();
            $owners = Owner::latest()->get();
            $drivers = Driver::latest()->get();
            $vehicles = Vehicle::latest()->get();
            $trips = Trip::latest()->get();
        } else {
            $counters = Counter::where('company_id', auth()->user()->id)->latest()->get();
            $routes = Route::where('company_id', auth()->user()->id)->latest()->get();
            $routeManagers = RouteManager::where('company_id', auth()->user()->id)->latest()->get();
            $checkers = Checker::where('company_id', auth()->user()->id)->latest()->get();
            $owners = Owner::where('company_id', auth()->user()->id)->latest()->get();
            $drivers = Driver::where('company_id', auth()->user()->id)->latest()->get();
            $vehicles = Vehicle::where('company_id', auth()->user()->id)->latest()->get();
            $trips = Trip::where('company_id', auth()->user()->id)->latest()->get();
        }

        $loginLog = LoginLog::orderBy('last_login','desc')->get();
        $totalOffer = Offer::count();
       return view('admin.dashboard', compact('loginLog','totalOffer','counters', 'routes', 'routeManagers', 'checkers', 'owners', 'drivers', 'vehicles', 'trips'));
    }

    public function unauthorized()
    {
        return view('admin.unauthorized');
    }





}
