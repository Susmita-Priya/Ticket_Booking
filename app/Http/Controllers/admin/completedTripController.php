<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class completedTripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('completed-trip-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $trips = Trip::with('route', 'vehicle', 'driver', 'supervisor')->where('trip_status',2)->latest()->get();

        } else {
            $trips = Trip::with('route', 'vehicle', 'driver', 'supervisor')->where('company_id', auth()->user()->id)->where('trip_status',2)->latest()->get();
        }
        
        return view('admin.pages.completedTrip.index', compact('trips'));
    }
}
