@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Employees!</li>
                    </ol>
                </div>
                <h4 class="page-title">Employees!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('employee-create')
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
                            <th>Department Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Nid</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $key => $employee)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $employee->company->name }}</td>
                                <td>
                                    @if($employee->department == 'Checker')
                                        <span class="badge bg-primary">Checker</span>
                                    @elseif($employee->department == 'Driver')
                                        <span class="badge bg-secondary">Driver</span>
                                    @elseif($employee->department == 'Helper')
                                        <span class="badge bg-success">Helper</span>
                                    @elseif($employee->department == 'Supervisor')
                                        <span class="badge bg-danger">Supervisor</span>
                                    @elseif($employee->department == 'Route Manager')
                                        <span class="badge bg-warning">Route Manager</span>
                                    @elseif($employee->department == 'Owner')
                                        <span class="badge bg-info">Owner</span>
                                    @else
                                        <span class="badge bg-dark">{{ $employee->department }}</span>
                                    @endif
                                </td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>{{ $employee->nid }}</td>
                                <td>
                                    @if($employee->document)
                                    <a href="{{ asset($employee->document) }}" target="_blank" class="btn btn-primary btn-sm">View Document</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>{{ $employee->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('employee-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $employee->id }}">Edit</button>
                                        @endcan
                                        @can('employee-delete')
                                            <a href="{{ route('employee.destroy', $employee->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $employee->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $employee->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $employee->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $employee->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('employee.update', $employee->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="department" class="form-label">Department</label>
                                                            <select name="department" class="form-select">
                                                                <option value="Checker" {{ $employee->department == 'Checker' ? 'selected' : '' }}>Checker</option>
                                                                <option value="Driver" {{ $employee->department == 'Driver' ? 'selected' : '' }}>Driver</option>
                                                                <option value="Helper" {{ $employee->department == 'Helper' ? 'selected' : '' }}>Helper</option>
                                                                <option value="Supervisor" {{ $employee->department == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                                                                <option value="Route Manager" {{ $employee->department == 'Route Manager' ? 'selected' : '' }}>Route Manager</option>
                                                                <option value="Owner" {{ $employee->department == 'Owner' ? 'selected' : '' }}>Owner</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $employee->name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" id="email" name="email"
                                                                value="{{ $employee->email }}" class="form-control"
                                                                placeholder="Enter Email" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="phone" class="form-label">Phone</label>
                                                            <input type="text" id="phone" name="phone"
                                                                value="{{ $employee->phone }}" class="form-control"
                                                                placeholder="Enter Phone" required maxlength="15" pattern="\d{11,15}" title="Phone number must be between 11 to 15 digits">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" id="address" name="address"
                                                                value="{{ $employee->address }}" class="form-control"
                                                                placeholder="Enter Address" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="nid" class="form-label">Nid</label>
                                                            <input type="text" id="nid" name="nid"
                                                                value="{{ $employee->nid }}" class="form-control"
                                                                placeholder="Enter Nid" required maxlength="10">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="document" class="form-label">Document</label>
                                                            <input type="file" id="document" name="document" class="form-control">
                                                            @if($employee->document)
                                                                <a href="{{ asset($employee->document) }}" target="_blank" class="btn btn-primary btn-sm mt-2">View Document</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $employee->status == 1 ? 'selected' : '' }}>
                                                                    Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $employee->status == 0 ? 'selected' : '' }}>
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
                                <div id="danger-header-modal{{ $employee->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $employee->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $employee->id }}">
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
                                                <a href="{{ route('employee.destroy', $employee->id) }}"
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
                    <form method="post" action="{{ route('employee.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" class="form-select">
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="Checker">Checker</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Helper">Helper</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Route Manager">Route Manager</option>
                                    <option value="Owner">Owner</option>
                                </select>                         
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Enter Phone" required maxlength="15" pattern="\d{11,15}" title="Phone number must be between 11 to 15 digits">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Enter Address" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="nid" class="form-label">Nid</label>
                                <input type="text" id="nid" name="nid" class="form-control"
                                    placeholder="Enter Nid" required maxlength="10">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="document" class="form-label">Document</label>
                                <input type="file" id="document" name="document" class="form-control" >
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
