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
use PDF;

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
        $query = Expense::query();
        $user = auth()->user();

        if (auth()->user()->hasRole('Super Admin')) {
            $query->latest();
        } else {
            $query->where('company_id', $user->id)->orWhereHas('company', function ($query) use ($user) {
                $query->where('is_registration_by', $user->id);
                })->latest();
        }

        if ($department = request('department')) {
            $query->where('department', $department);
        }

        if ($type = request('type')) {
            $query->where('type', $type);
        }

        if ($fromDate = request('from_date')) {
            $query->whereDate('date', '>=', $fromDate);
        }

        if ($toDate = request('to_date')) {
            $query->whereDate('date', '<=', $toDate);
        }
        if (auth()->user()->hasRole('Super Admin')) {
            $expenses = $query->latest()->get();
            $employees = Employee::latest()->get();
            $counters = Counter::latest()->get();
            $vehicles = Vehicle::latest()->get();
            $routes = Route::latest()->get();
        } else {
            $expenses = $query->latest()->get();
            $employees = Employee::where('company_id', auth()->user()->id)->latest()->get();
            $counters = Counter::where('company_id', auth()->user()->id)->latest()->get();
            $vehicles = Vehicle::where('company_id', auth()->user()->id)->latest()->get();
            $routes = Route::where('company_id', auth()->user()->id)->latest()->get();
        }

        return view('admin.pages.expense.index', compact('expenses', 'employees', 'counters', 'vehicles', 'routes'));
    }

    public function getTypeEmployee(Request $request)
    {
        $department = $request->department;
        $employees = [];

        if ($department) {
            $employees = Employee::where('department', $department)->get(['id', 'name']); 
        }
        return response()->json([
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

    public function downloadPDF(Request $request)
    {
        // Fetch filtered expenses based on request parameters
        $expenses = Expense::when($request->department, function ($query, $department) {
                return $query->where('department', $department);
            })
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->from_date, function ($query, $from_date) {
                return $query->whereDate('date', '>=', $from_date);
            })
            ->when($request->to_date, function ($query, $to_date) {
                return $query->whereDate('date', '<=', $to_date);
            })
            ->get();

        // Load the PDF view and pass the expenses data
        $pdf = PDF::loadView('admin.pages.expense.pdf', compact('expenses'));

        // Download PDF
        return $pdf->download('expense_report.pdf');
    }

    public function deletedExpense()
    {
        $deletedExpenses = Expense::onlyTrashed()->get();

        return view('admin.pages.expense.deleted', compact('deletedExpenses'));
    }

    public function restore($id)
    {
        try {
            $expense = Expense::withTrashed()->find($id);
            $expense->restore();

            Toastr::success('Expense Restored Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $expense = Expense::withTrashed()->find($id);
            $expense->forceDelete();

            Toastr::success('Expense Deleted Permanently', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception here
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
