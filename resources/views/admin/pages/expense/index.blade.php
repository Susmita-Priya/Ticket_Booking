@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Expenses!</li>
                    </ol>
                </div>
                <h4 class="page-title">Expenses!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('expense.section') }}" class="d-flex gap-2">
                        <select name="department" class="form-select" style="width: 200px;">
                            <option value="" selected>All Departments</option>
                            @foreach (['Checker', 'Driver', 'Helper', 'Supervisor', 'Route Manager', 'Owner', 'Counter', 'Vehicle', 'Route'] as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                        <select name="type" class="form-select" style="width: 200px;">
                            <option value="" selected>All Expense Types</option>
                            <option value="Salary" {{ request('type') == 'Salary' ? 'selected' : '' }}>Salary</option>
                            <option value="Counter Rent" {{ request('type') == 'Counter Rent' ? 'selected' : '' }}>Counter Rent</option>
                            <option value="Maintenance" {{ request('type') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Utilities" {{ request('type') == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                            <option value="Fuel" {{ request('type') == 'Fuel' ? 'selected' : '' }}>Fuel</option>
                            <option value="Route Cost" {{ request('type') == 'Route Cost' ? 'selected' : '' }}>Route Cost</option>
                            <option value="Vehicle Expense" {{ request('type') == 'Vehicle Expense' ? 'selected' : '' }}>Vehicle Expense</option>
                        </select>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('expense.section') }}" class="btn btn-secondary">Reset</a>
                        
                    </form>
                    <div class="d-flex justify-content-between align-items-center ms-2 w-100">
                        <a href="{{ route('expenses.pdf', request()->all()) }}" class="btn btn-success">Download PDF</a>
                        @can('expense-create')
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                <h3 class="text-center">List of all expenses</h3>
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $key => $expense)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $expense->company->name }}</td>
                                <td>
                                    @if ($expense->department == 'Checker')
                                        <span class="badge bg-primary">Checker</span>
                                    @elseif($expense->department == 'Driver')
                                        <span class="badge bg-secondary">Driver</span>
                                    @elseif($expense->department == 'Helper')
                                        <span class="badge bg-success">Helper</span>
                                    @elseif($expense->department == 'Supervisor')
                                        <span class="badge bg-danger">Supervisor</span>
                                    @elseif($expense->department == 'Route Manager')
                                        <span class="badge bg-warning">Route Manager</span>
                                    @elseif($expense->department == 'Owner')
                                        <span class="badge bg-info">Owner</span>
                                    @else
                                        <span class="badge bg-dark">{{ $expense->department }}</span>
                                    @endif
                                </td>
                                <td>{{ $expense->type }}</td>
                                <td>{{ $expense->employee->name ?? ($expense->counter->name ?? ($expense->vehicle->name ?? ($expense->route->fromLocation->name . ' to ' . $expense->route->toLocation->name ?? 'N/A'))) }}
                                </td>
                                <td>{{ number_format($expense->amount, 2) }}TK</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge {{ $expense->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $expense->status == 1 ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('expense-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $expense->id }}">Edit</button>
                                        @endcan
                                        @can('expense-delete')
                                            <a href="{{ route('expense.destroy', $expense->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $expense->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $expense->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $expense->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $expense->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('expense.update', $expense->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="department" class="form-label">Department</label>
                                                            <input type="text" class="form-control" value="{{ $expense->department }}" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="type" class="form-label">Expense Type</label>
                                                            <select name="type" id="type" class="form-select" required>
                                                                <option value="" disabled>Select Expense Type</option>
                                                                <option value="Salary" {{ $expense->type == 'Salary' ? 'selected' : '' }}>Salary</option>
                                                                <option value="Counter Rent" {{ $expense->type == 'Counter Rent' ? 'selected' : '' }}>Counter Rent</option>
                                                                <option value="Maintenance" {{ $expense->type == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                <option value="Utilities" {{ $expense->type == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                                                <option value="Fuel" {{ $expense->type == 'Fuel' ? 'selected' : '' }}>Fuel</option>
                                                                <option value="Route Cost" {{ $expense->type == 'Route Cost' ? 'selected' : '' }}>Route Cost</option>
                                                                <option value="Vehicle Expense" {{ $expense->type == 'Vehicle Expense' ? 'selected' : '' }}>Vehicle Expense</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @if ($expense->employee)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="employee_name" class="form-label">Employee
                                                                    Name</label>
                                                                <select id="employee_name" name="employee_id" class="form-select">
                                                                    <option value="" disabled>Select Employee</option>
                                                                    @foreach ($employees as $employee)
                                                                        <option value="{{ $employee->id }}" {{ $expense->employee->id == $employee->id ? 'selected' : '' }}>
                                                                            {{ $employee->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    
                                                    @if ($expense->counter)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="counter" class="form-label">Counter</label>
                                                                <select name="counter_id" id="counter" class="form-select">
                                                                    <option value="" disabled>Select Counter</option>
                                                                    @foreach ($counters as $counter)
                                                                        <option value="{{ $counter->id }}" {{ $expense->counter->id == $counter->id ? 'selected' : '' }}>
                                                                            {{ $counter->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($expense->vehicle)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="vehicle" class="form-label">Vehicle</label>
                                                                <select name="vehicle_id" id="vehicle" class="form-select">
                                                                    <option value="" disabled>Select Vehicle</option>
                                                                    @foreach ($vehicles as $vehicle)
                                                                        <option value="{{ $vehicle->id }}" {{ $expense->vehicle->id == $vehicle->id ? 'selected' : '' }}>
                                                                            {{ $vehicle->name }} (Coach-{{ $vehicle->vehicle_no }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($expense->route)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="route" class="form-label">Route</label>
                                                                <select name="route_id" id="route" class="form-select">
                                                                    <option value="" disabled>Select Route</option>
                                                                    @foreach ($routes as $route)
                                                                        <option value="{{ $route->id }}" {{ $expense->route->id == $route->id ? 'selected' : '' }}>
                                                                            {{ $route->fromLocation->name }} to {{ $route->toLocation->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="amount" class="form-label">Amount</label>
                                                            <input type="text" id="amount" name="amount"
                                                                class="form-control" value="{{ $expense->amount }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="date" class="form-label">Date</label>
                                                            <input type="date" id="date" name="date"
                                                                class="form-control" value="{{ $expense->date }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $expense->status == 1 ? 'selected' : '' }}>
                                                                    Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $expense->status == 0 ? 'selected' : '' }}>
                                                                    Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div id="danger-header-modal{{ $expense->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $expense->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $expense->id }}">
                                                    Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are You Sure You Want to Delete this?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('expense.destroy', $expense->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total Expense:</strong></td>
                            <td><strong><span class="text-danger">{{ number_format($expenses->sum('amount'), 2) }}TK</span></strong></td>
                            <td colspan="3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
<div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="addNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('expense.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Department Selection -->
                    <div class="col-12 mb-3">
                        <label for="department" class="form-label">Department</label>
                        <select name="department" id="department" class="form-select" required>
                            <option value="" disabled selected>Select Department</option>
                            @foreach (['Checker', 'Driver', 'Helper', 'Supervisor', 'Route Manager', 'Owner', 'Counter', 'Vehicle', 'Route'] as $dept)
                                <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>

                     <!-- Employee Selection -->
                     <div class="col-12 mb-3" id="employee_field" style="display: none;">
                        <label for="employee" class="form-label">Employee Name</label>
                        <select name="employee_id" id="employee" class="form-select">
                            <option value="" disabled selected>Select Employee</option>
                        </select>
                    </div>

                    <!-- Expense Type -->
                    {{-- <div class="col-12 mb-3">
                        <label for="type" class="form-label">Expense Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="" disabled selected>Select Expense Type</option>
                        </select>
                    </div> --}}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="type" class="form-label">Expense Type</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="" disabled selected>Select Expense Type</option>
                                <option value="Salary">Salary</option>
                                <option value="Counter Rent">Counter Rent</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Utilities">Utilities</option>
                                <option value="Fuel">Fuel</option>
                                <option value="Route Cost">Route Cost</option>
                                <option value="Vehicle Expense">Vehicle Expense</option>
                            </select>
                        </div>
                    </div>

                    <!-- Counter Field -->
                    <div class="col-12 mb-3" id="counter_field" style="display: none;">
                        <label for="counter" class="form-label">Counter</label>
                        <select name="counter_id" id="counter" class="form-select">
                            <option value="" disabled selected>Select Counter</option>
                            @foreach ($counters as $counter)
                                <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vehicle Field -->
                    <div class="col-12 mb-3" id="vehicle_field" style="display: none;">
                        <label for="vehicle" class="form-label">Vehicle</label>
                        <select name="vehicle_id" id="vehicle" class="form-select">
                            <option value="" disabled selected>Select Vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }} (Coach-{{ $vehicle->vehicle_no }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Route Field -->
                    <div class="col-12 mb-3" id="route_field" style="display: none;">
                        <label for="route" class="form-label">Route</label>
                        <select name="route_id" id="route" class="form-select">
                            <option value="" disabled selected>Select Route</option>
                            @foreach ($routes as $route)
                                <option value="{{ $route->id }}">{{ $route->fromLocation->name }} to {{ $route->toLocation->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="col-12 mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control" required>
                    </div>

                    <!-- Date -->
                    <div class="col-12 mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Expense Type & Employee Fetching Script -->
<script>
    $(document).ready(function () {
        // When modal opens, fetch data if a department is already selected
        $('#addNewModalId').on('shown.bs.modal', function () {
            if ($('#department').val()) {
                fetchTypeAndEmployee();
            }
        });

        // Listen for department changes
        $('#department').on('change', fetchTypeAndEmployee);
    });

    function fetchTypeAndEmployee() {
        const department = $('#department').val();
        const employeeField = $('#employee_field');
        const employeeSelect = $('#employee');

        employeeSelect.html('<option value="" disabled selected>Select Employee</option>');
        resetFields();

        if (!department) return;

        $.ajax({
            url: `/get-employee?department=${department}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.employees && data.employees.length > 0) {
                    employeeField.show();
                    data.employees.forEach(employee => {
                        employeeSelect.append(new Option(employee.name, employee.id));
                    });
                }

                // Show additional fields based on department
                if (["Counter", "Vehicle", "Route"].includes(department)) {
                    $(`#${department.toLowerCase()}_field`).show();
                } else if (["Checker", "Driver", "Helper", "Supervisor", "Route Manager", "Owner"].includes(department)) {
                    employeeField.show();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function resetFields() {
        $('#counter_field, #vehicle_field, #route_field, #employee_field').hide();
    }
</script>

<script>
    $(document).ready(function () {
        // When edit modal opens, fetch data if a department is already selected
        $('[id^=editNewModalId]').on('shown.bs.modal', function () {
            const modalId = $(this).attr('id');
            const department = $(`#${modalId} select[name="department"]`).val();
            if (department) {
                fetchEditEmployee(modalId, department);
            }
        });

        // Listen for department changes in edit modals
        $('[id^=editNewModalId] select[name="department"]').on('change', function () {
            const modalId = $(this).closest('.modal').attr('id');
            const department = $(this).val();
            fetchEditEmployee(modalId, department);
        });
    });

    function fetchEditEmployee(modalId, department) {
        const employeeField = $(`#${modalId} #employee_field`);
        const employeeSelect = $(`#${modalId} #employee_name`);

        employeeSelect.html('<option value="" disabled>Select Employee</option>');
        resetEditFields(modalId);

        if (!department) return;

        $.ajax({
            url: `/get-employee?department=${department}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.employees && data.employees.length > 0) {
                    employeeField.show();
                    data.employees.forEach(employee => {
                        employeeSelect.append(new Option(employee.name, employee.id));
                    });
                }

                // Show additional fields based on department
                if (["Counter", "Vehicle", "Route"].includes(department)) {
                    $(`#${modalId} #${department.toLowerCase()}_field`).show();
                } else if (["Checker", "Driver", "Helper", "Supervisor", "Route Manager", "Owner"].includes(department)) {
                    employeeField.show();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    }

    function resetEditFields(modalId) {
        $(`#${modalId} #counter_field, #${modalId} #vehicle_field, #${modalId} #route_field, #${modalId} #employee_field`).hide();
    }
</script>


    @endsection
