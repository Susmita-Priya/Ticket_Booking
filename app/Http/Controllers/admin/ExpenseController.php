<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('expense-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        if (auth()->user()->hasRole('Super Admin')) {
            $expenses = Expense::latest()->get();
            $employees = Employee::latest()->get();
            $counters = Counter::latest()->get();
            $vehicles = Vehicle::latest()->get();
            $routes = Route::latest()->get();
        } else {
            $expenses = Expense::where('company_id', auth()->user()->id)->latest()->get();
            $employees = Employee::where('company_id', auth()->user()->id)->latest()->get();
            $counters = Counter::where('company_id', auth()->user()->id)->latest()->get();
            $vehicles = Vehicle::where('company_id', auth()->user()->id)->latest()->get();
            $routes = Route::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.expense.index', compact('expenses', 'employees', 'counters', 'vehicles', 'routes'));
    }

    public function getTypeEmployee(Request $request)
    {
        // dd($request->all());
        $department = $request->department;
        // $types = [];
        $employees = [];

        // if ($department === 'Counter') {
        //     $types = ["Counter Rent", "Maintenance", "Utilities"];
        // } elseif ($department === 'Vehicle') {
        //     $types = ["Fuel", "Maintenance"];
        // } elseif ($department === 'Route') {
        //     $types = ["Route Cost"];
        // } elseif ($department === 'Owner') {
        //     $types = ["Vehicle Expense"];
        // } elseif (in_array($department, ['Checker', 'Driver', 'Helper', 'Supervisor'])) {
        //     $types = ["Salary"];
        //     // dd($types);
        // } else {
        //     $types = [];
        // }

        if ($department) {
            $employees = Employee::where('department', $department)->get(['id', 'name']); 
        }
        //return redirect()->back()->withInput();
        return response()->json([
            // 'types' => $types,
            'employees' => $employees,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'department' => 'required',
                'type' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ]);

            $expense = new Expense();
            $expense->company_id = auth()->user()->id;
            $expense->department = $request->department;
            $expense->type = $request->type;
            $expense->employee_id = $request->employee_id;
            $expense->counter_id = $request->counter_id;
            $expense->vehicle_id = $request->vehicle_id;
            $expense->route_id = $request->route_id;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->save();

            Toastr::success('Expense Added Successfully', 'Success');
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
                'department' => 'required',
                'type' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ]);

            $expense = Expense::find($id);
            $expense->department = $request->department;
            $expense->type = $request->type;
            $expense->employee_id = $request->employee_id;
            $expense->counter_id = $request->counter_id;
            $expense->vehicle_id = $request->vehicle_id;
            $expense->route_id = $request->route_id;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->save();

            Toastr::success('Expense Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $expense = Expense::find($id);
            $expense->delete();

            Toastr::success('Expense Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
