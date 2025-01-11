@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Trips!</li>
                    </ol>
                </div>
                <h4 class="page-title">Trips!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('trip-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add
                            New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Supervisor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Total Route Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $key => $trip)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $trip->route->name }}</td>
                                <td>{{ $trip->vehicle->name }} <br>
                                    ({{ $trip->vehicle->vehicle_no }} )</td>
                                <td>{{ $trip->driver->name }}</td>
                                <td>{{ $trip->supervisor->name }}</td>
                                <td>{{ $trip->Date }}</td>
                                <td>{{ $trip->Time }}</td>
                                <td>{{ $trip->total_route_cost }} TK</td>
                                <td>
                                    @if ($trip->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @elseif ($trip->status == 0)
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('trip-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $trip->id }}">Edit</button>
                                        @endcan
                                        @can('trip-delete')
                                            <a href="{{ route('trip.destroy', $trip->id) }}"
                                                class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $trip->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $trip->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $trip->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $trip->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"  
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('trip.update', $trip->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="route_id" class="form-label">Route</label>
                                                            <select name="route_id" class="form-select">
                                                                @foreach ($routes as $route)
                                                                    <option value="{{ $route->id }}"
                                                                        {{ $trip->route_id == $route->id ? 'selected' : '' }}>
                                                                        {{ $route->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="vehicle_id" class="form-label">Vehicle</label>
                                                            <select name="vehicle_id" class="form-select">
                                                                @foreach ($vehicles as $vehicle)
                                                                    <option value="{{ $vehicle->id }}"
                                                                        {{ $trip->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                                        {{ $vehicle->name }} ({{ $vehicle->vehicle_no }})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="driver_id" class="form-label">Driver</label>
                                                            <select name="driver_id" class="form-select">
                                                                @foreach ($drivers as $driver)
                                                                    <option value="{{ $driver->id }}"
                                                                        {{ $trip->driver_id == $driver->id ? 'selected' : '' }}>
                                                                        {{ $driver->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="supervisor_id" class="form-label">Supervisor</label>
                                                            <select name="supervisor_id" class="form-select">
                                                                @foreach ($supervisors as $supervisor)
                                                                    <option value="{{ $supervisor->id }}"
                                                                        {{ $trip->supervisor_id == $supervisor->id ? 'selected' : '' }}>
                                                                        {{ $supervisor->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="date" class="form-label">Date</label>
                                                            <input type="date" id="date" name="Date"
                                                                value="{{ $trip->date }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="time" class="form-label">Time</label>
                                                            <input type="time" id="time" name="Time"
                                                                value="{{ $trip->time }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="total_route_cost" class="form-label">Total Route Cost</label>
                                                            <input type="number" id="total_route_cost" name="total_route_cost"
                                                                value="{{ $trip->total_route_cost }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $trip->status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $trip->status == 0 ? 'selected' : '' }}>Inactive
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
                                <div id="danger-header-modal{{ $trip->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $trip->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $trip->id }}">
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
                                                <a href="{{ route('trip.destroy', $trip->id) }}"
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
                    <form method="post" action="{{ route('trip.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="route_id" class="form-label">Route</label>
                                <select name="route_id" class="form-select">
                                    <option selected value="">Select Route</option>
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->id }}">{{ $route->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="vehicle_id" class="form-label">Vehicle</label>
                                <select name="vehicle_id" class="form-select">
                                    <option selected value="">Select Vehicle</option>
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->vehicle_no }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="driver_id" class="form-label">Driver</label>
                                <select name="driver_id" class="form-select">
                                    <option selected value="">Select Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="supervisor_id" class="form-label">Supervisor</label>
                                <select name="supervisor_id" class="form-select">
                                    <option selected value="">Select Supervisor</option>
                                    @foreach ($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="Date" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" id="time" name="Time" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="total_route_cost" class="form-label">Total Route Cost</label>
                                <input type="number" id="total_route_cost" name="total_route_cost" class="form-control"
                                    required>
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
