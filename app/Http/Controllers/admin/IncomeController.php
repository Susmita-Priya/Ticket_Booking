<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Route;
use App\Models\TicketBooking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;
class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('income-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        $query = TicketBooking::with(['trip.route.fromLocation', 'trip.route.toLocation', 'vehicle'])->where('type', 'Counter');
        $user = auth()->user();
        
        if (auth()->user()->hasRole('Super Admin')) {
            $query->latest();
        } else {
            $query->where('company_id', $user->id)->orWhereHas('company', function ($query) use ($user) {
                $query->where('is_registration_by', $user->id);
                })->latest();
        }

        if ($routeId = request('route_id')) {
            $query->whereHas('trip.route', function ($q) use ($routeId) {
            $q->where('id', $routeId);
            });
        }

        if ($vehicleId = request('vehicle_id')) {
            $query->where('vehicle_id', $vehicleId);
        }

        if ($fromDate = request('from_date')) {
            $query->whereDate('travel_date', '>=', $fromDate);
        }

        if ($toDate = request('to_date')) {
            $query->whereDate('travel_date', '<=', $toDate);
        }

        $incomes = $query->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $vehicles = Vehicle::latest()->get();
            $routes = Route::latest()->get();
            $owners = Employee::where('department', 'Owner')->latest()->get();
        } else {
            $vehicles = Vehicle::where('company_id', auth()->user()->id)->latest()->get();
            $routes = Route::where('company_id', auth()->user()->id)->latest()->get();
            $owners = Employee::where('department', 'Owner')->where('company_id', auth()->user()->id)->latest()->get();
        }

        return view('admin.pages.income.index', compact('incomes', 'vehicles', 'routes', 'owners'));
    }

    public function getVehicles(Request $request)
    {
        $routeId = $request->query('route_id');
        $ownerId = $request->query('owner_id');

        $vehicles = Vehicle::query();

        if ($routeId) {
            $vehicles->whereHas('trips', function ($query) use ($routeId) {
                $query->where('route_id', $routeId);
            });
        }

        if ($ownerId) {
            $vehicles->whereHas('owner', function ($query) use ($ownerId) {
                $query->where('id', $ownerId)->where('department', 'Owner');
            });
        }

        $vehicles = $vehicles->get(['id', 'name', 'vehicle_no']);

        return response()->json(['vehicles' => $vehicles]);
    }

    public function downloadPDF(Request $request)
    {
        $query = TicketBooking::with(['trip.route.fromLocation', 'trip.route.toLocation', 'vehicle'])->where('type', 'Counter');

        if (auth()->user()->hasRole('Super Admin')) {
            $query->latest();
        } else {
            $query->where('company_id', auth()->user()->id)->latest();
        }

        if ($routeId = $request->route_id) {
            $query->whereHas('trip.route', function ($q) use ($routeId) {
                $q->where('id', $routeId);
            });
        }

        if ($vehicleId = $request->vehicle_id) {
            $query->where('vehicle_id', $vehicleId);
        }

        if ($fromDate = $request->from_date) {
            $query->whereDate('travel_date', '>=', $fromDate);
        }

        if ($toDate = $request->to_date) {
            $query->whereDate('travel_date', '<=', $toDate);
        }

        $incomes = $query->get();

        $pdf = PDF::loadView('admin.pages.income.pdf', compact('incomes'));
        return $pdf->download('income.pdf');
    }


}
