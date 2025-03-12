<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yoeunes\Toastr\Facades\Toastr;

class employeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('employee-list')) {
                return redirect()->route('unauthorized.action');
            }
            return $next($request);
        })->only('index');
    }

    public function index()
    {
        // $employees = Employee::where('company_id',auth()->user()->id)->latest()->get();
        if (auth()->user()->hasRole('Super Admin')) {
            $employees = Employee::latest()->get();
        } else {
            $employees = Employee::where('company_id', auth()->user()->id)->latest()->get();
        }
        return view('admin.pages.employee.index',compact('employees'));
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

            $employee = new Employee();
            $employee->company_id = auth()->user()->id;
            $employee->department = $request->department;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employeeDocument';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
                $employee->document = $fullpath;
            }
            $employee->nid = $request->nid;
            $employee->save();
            
            Toastr::success('Employee Added Successfully', 'Success');
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
            
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->nid = $request->nid;
            if ($request->hasFile('document')) {
                $file = $request->file('document');

                if ($employee->document && file_exists(public_path($employee->document))) {
                    unlink(public_path($employee->document));
                }

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = 'uploads/employeeDocument';
                $file->move(public_path($path), $filename);
                $fullpath = $path . '/' . $filename;
            }
            else{
                $fullpath = $employee->document;
            }
            $employee->document = $fullpath;
            $employee->status = $request->status;
            $employee->save();
            Toastr::success('Employee Updated Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::find($id);

            if ($employee->document && file_exists(public_path($employee->document))) {
                unlink(public_path($employee->document));
            }
            $employee->delete();
            Toastr::success('Employee Deleted Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
