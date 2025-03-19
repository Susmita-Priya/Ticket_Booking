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
                <div class="d-flex justify-content-end">
                    @can('expense-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add
                            New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Department</th>
                            <th>Type</th>
                            {{-- @if ($expense->employee_name)
                                <th>Employee Name</th>
                            @endif
                            @if ($expense->counter)
                                <th>Counter</th>
                            @endif
                            @if ($expense->vehicle)
                                <th>Vehicle</th>
                            @endif
                            @if ($expense->route)
                                <th>Route</th>
                            @endif --}}
                            <th>Name</th>
                            {{-- <th>Counter</th>
                            <th>Vehicle</th>
                            <th>Route</th> --}}
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
                                    @elseif($expense->department == 'Counter')
                                        <span class="badge bg-light">Counter</span>
                                    @elseif($expense->department == 'Vehicle')
                                        <span class="badge bg-primary">Vehicle</span>
                                    @elseif($expense->department == 'Route')
                                        <span class="badge bg-secondary">Route</span>
                                    @else
                                        <span class="badge bg-dark">{{ $expense->department }}</span>
                                    @endif
                                </td>
                                <td>{{ $expense->type }}</td>
                                <td>{{ $expense->employee->name ?? ($expense->counter->name ?? ($expense->vehicle->name ?? ($expense->route->name ?? 'N/A'))) }}
                                </td>
                                {{-- <td>{{ $expense->employee_name ?? 'N/A' }}</td>
                                <td>{{ $expense->counter ?? 'N/A' }}</td>
                                <td>{{ $expense->vehicle ?? 'N/A' }}</td>
                                <td>{{ $expense->route ?? 'N/A' }}</td> --}}
                                <td>{{ $expense->amount }}TK</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td>{{ $expense->status == 1 ? 'Active' : 'Inactive' }}</td>
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
                                                            <select name="department" class="form-select">
                                                                <option value="Checker"
                                                                    {{ $expense->department == 'Checker' ? 'selected' : '' }}>
                                                                    Checker</option>
                                                                <option value="Driver"
                                                                    {{ $expense->department == 'Driver' ? 'selected' : '' }}>
                                                                    Driver</option>
                                                                <option value="Helper"
                                                                    {{ $expense->department == 'Helper' ? 'selected' : '' }}>
                                                                    Helper</option>
                                                                <option value="Supervisor"
                                                                    {{ $expense->department == 'Supervisor' ? 'selected' : '' }}>
                                                                    Supervisor</option>
                                                                <option value="Route Manager"
                                                                    {{ $expense->department == 'Route Manager' ? 'selected' : '' }}>
                                                                    Route Manager</option>
                                                                <option value="Owner"
                                                                    {{ $expense->department == 'Owner' ? 'selected' : '' }}>
                                                                    Owner</option>
                                                                <option value="Counter"
                                                                    {{ $expense->department == 'Counter' ? 'selected' : '' }}>
                                                                    Counter</option>
                                                                <option value="Vehicle"
                                                                    {{ $expense->department == 'Vehicle' ? 'selected' : '' }}>
                                                                    Vehicle</option>
                                                                <option value="Route"
                                                                    {{ $expense->department == 'Route' ? 'selected' : '' }}>
                                                                    Route</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="type" class="form-label">Type</label>
                                                            <input type="text" id="type" name="type"
                                                                class="form-control" value="{{ $expense->type }}" required>
                                                        </div>
                                                    </div>
                                                    @if ($expense->employee_name)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="employee_name" class="form-label">Employee
                                                                    Name</label>
                                                                <input type="text" id="employee_name"
                                                                    name="employee_name" class="form-control"
                                                                    value="{{ $expense->employee_name }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($expense->counter)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="counter" class="form-label">Counter</label>
                                                                <input type="text" id="counter" name="counter"
                                                                    class="form-control" value="{{ $expense->counter }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($expense->vehicle)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="vehicle" class="form-label">Vehicle</label>
                                                                <input type="text" id="vehicle" name="vehicle"
                                                                    class="form-control" value="{{ $expense->vehicle }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($expense->route)
                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="route" class="form-label">Route</label>
                                                                <input type="text" id="route" name="route"
                                                                    class="form-control" value="{{ $expense->route }}">
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

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" id="department" class="form-select">
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="Checker">Checker</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Helper">Helper</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Route Manager">Route Manager</option>
                                    <option value="Owner">Owner</option>
                                    <option value="Counter">Counter</option>
                                    <option value="Vehicle">Vehicle</option>
                                    <option value="Route">Route</option>
                                </select>
                            </div>
                        </div>

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

                        <div class="row" id="employee_field">
                            <div class="col-12 mb-3">
                                <label for="employee" class="form-label">Employee Name</label>
                                <select name="employee_id" id="employee" class="form-select">
                                    <option value="" disabled selected>Select Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            data-department="{{ $employee->department }}">
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="counter_field" style="display: none;">
                            <div class="col-12 mb-3">
                                <label for="counter" class="form-label">Counter</label>
                                <select name="counter_id" id="counter" class="form-select">
                                    <option value="" disabled selected>Select Counter</option>
                                    @foreach ($counters as $counter)
                                        <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="vehicle_field" style="display: none;">
                            <div class="col-12 mb-3">
                                <label for="vehicle" class="form-label">Vehicle</label>
                                <select name="vehicle_id" id="vehicle" class="form-select">
                                    <option value="" disabled selected>Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }} (
                                            Coach-{{ $vehicle->vehicle_no }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row" id="route_field" style="display: none;">
                            <div class="col-12 mb-3">
                                <label for="route" class="form-label">Route</label>
                                <select name="route_id" id="route" class="form-select">
                                    <option value="" disabled selected>Select Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}">{{ $route->fromLocation->name }} to
                                            {{ $route->toLocation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const addNewModal = document.getElementById('addNewModalId');

                                addNewModal.addEventListener('show.bs.modal', function() {
                                    const departmentSelect = document.getElementById('department');
                                    const typeSelect = document.getElementById('type');
                                    const employeeField = document.getElementById('employee_field');
                                    const employeeSelect = document.getElementById('employee');
                                    const counterField = document.getElementById('counter_field');
                                    const vehicleField = document.getElementById('vehicle_field');
                                    const routeField = document.getElementById('route_field');

                                    // Store all employee options
                                    let allEmployeeOptions = Array.from(employeeSelect.options).slice(1);

                                    // Expense type options categorized by department
                                    const expenseOptions = {
                                        "Checker": ["Salary"],
                                        "Driver": ["Salary"],
                                        "Helper": ["Salary"],
                                        "Supervisor": ["Salary"],
                                        "Route Manager": ["Salary"],
                                        "Counter": ["Counter Rent", "Maintenance", "Utilities"],
                                        "Vehicle": ["Fuel", "Maintenance"],
                                        "Route": ["Route Cost"],
                                        "Owner": ["Vehicle Expense"]
                                    };

                                    // Function to reset form fields properly
                                    function resetFields() {
                                        employeeField.style.display = 'none';
                                        counterField.style.display = 'none';
                                        vehicleField.style.display = 'none';
                                        routeField.style.display = 'none';
                                        typeSelect.innerHTML =
                                        `<option value="" disabled selected>Select Expense Type</option>`;
                                    }

                                    // Function to update expense types based on department
                                    function updateExpenseTypeOptions(department) {
                                        typeSelect.innerHTML =
                                        `<option value="" disabled selected>Select Expense Type</option>`;

                                        if (expenseOptions[department]) {
                                            expenseOptions[department].forEach(type => {
                                                const option = document.createElement("option");
                                                option.value = type;
                                                option.textContent = type;
                                                typeSelect.appendChild(option);
                                            });
                                        }
                                    }

                                    // Function to filter employees by department
                                    function filterEmployees(department) {
                                        employeeSelect.innerHTML =
                                        `<option value="" disabled selected>Select Employee</option>`;

                                        allEmployeeOptions.forEach(option => {
                                            if (option.dataset.department === department) {
                                                employeeSelect.appendChild(option.cloneNode(true));
                                            }
                                        });

                                        if (employeeSelect.options.length === 1) {
                                            employeeSelect.innerHTML =
                                                `<option value="" disabled>No employees available</option>`;
                                        }
                                    }

                                    // Department change event listener
                                    departmentSelect.addEventListener('change', function() {
                                        const selectedDepartment = this.value;
                                        resetFields();

                                        if (["Counter", "Vehicle", "Route"].includes(selectedDepartment)) {
                                            document.getElementById(`${selectedDepartment.toLowerCase()}_field`).style
                                                .display =
                                                'block';
                                        } else if (["Checker", "Driver", "Helper", "Supervisor", "Route Manager",
                                                "Owner"
                                            ].includes(
                                                selectedDepartment)) {
                                            employeeField.style.display = 'block';
                                            filterEmployees(selectedDepartment);

                                        }

                                        updateExpenseTypeOptions(selectedDepartment);
                                    });

                                    // Trigger change event initially
                                    departmentSelect.dispatchEvent(new Event('change'));
                                });
                            });
                        </script>


                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" id="amount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
