@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Routes!</li>
                    </ol>
                </div>
                <h4 class="page-title">Routes!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('route-create')
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
                            <th>Route Name</th>
                            <th>Route no</th>
                            <th>Counters</th>
                            <th>Route Manager</th>
                            <th>Checkers</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($route as $key => $routedata)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $routedata->name }}</td>
                                <td>{{ $routedata->route_no }}</td>
                                <td>
                                    @php
                                        $routeCounters = json_decode($routedata->counters_id, true) ?? [];
                                    @endphp
                                    @foreach ($counters as $counter)
                                        @if (in_array($counter->id, $routeCounters))
                                            <span class="badge bg-primary">{{ $counter->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $routedata->routeManager->name?? "N/A" }}
                                </td>
                                <td>
                                    @php
                                        $routeCheckers = json_decode($routedata->checkers_id, true) ?? [];
                                    @endphp
                                    @foreach ($checkers as $checker)
                                        @if (in_array($checker->id, $routeCheckers))
                                            <span class="badge bg-primary">{{ $checker->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($routedata->document)
                                    <a href="{{ asset($routedata->document) }}" target="_blank" class="btn btn-primary btn-sm">Route Permit Doc</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>
                                    @if ($routedata->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif

                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('route-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $routedata->id }}">Edit</button>
                                        @endcan
                                        @can('route-delete')
                                            <a href="{{ route('route.destroy', $routedata->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $routedata->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $routedata->id }}"
                                    data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="editNewModalLabel{{ $routedata->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editNewModalLabel{{ $routedata->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('route.update', $routedata->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Route Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $routedata->name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="route_no" class="form-label">Route No</label>
                                                            <input type="text" id="route_no" name="route_no"
                                                                value="{{ $routedata->route_no }}" class="form-control"
                                                                placeholder="Enter Route No" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="counters_id" class="form-label">Counters</label>
                                                            <select name="counters_id[]" class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($counters as $counter)
                                                                    <option value="{{ $counter->id }}"
                                                                        {{ in_array($counter->id, json_decode($routedata->counters_id, true) ?? []) ? 'selected' : '' }}>
                                                                        {{ $counter->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="route_manager_id" class="form-label">Route Manager</label>
                                                            <select name="route_manager_id" class="form-select">
                                                                <option value="">Select Route Manager</option>
                                                                @foreach ($routeManagers as $routeManager)
                                                                    <option value="{{ $routeManager->id }}"
                                                                        {{ $routeManager->id == $routedata->route_manager_id ? 'selected' : '' }}>
                                                                        {{ $routeManager->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="checkers_id" class="form-label">Checkers</label>
                                                            <select name="checkers_id[]" class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($checkers as $checker)
                                                                    <option value="{{ $checker->id }}"
                                                                        {{ in_array($checker->id, json_decode($routedata->checkers_id, true) ?? []) ? 'selected' : '' }}>
                                                                        {{ $checker->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="document" class="form-label">Document</label>
                                                            <input type="file" id="document" name="document" class="form-control">
                                                            @if($routedata->document)
                                                                <a href="{{ asset($routedata->document) }}" target="_blank" class="btn btn-primary btn-sm mt-2">View Document</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $routedata->status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0" {{ $routedata->status == 0 ? 'selected' : '' }}>Inactive
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
                                <div id="danger-header-modal{{ $routedata->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $routedata->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $routedata->id }}">
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
                                                <a href="{{ route('route.destroy', $routedata->id) }}"
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
                    <form method="post" action="{{ route('route.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Route Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter Name (e.g, Dhaka to Rajshaji)" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="route_no" class="form-label">Route No</label>
                                <input type="text" id="route_no" name="route_no" class="form-control"
                                    placeholder="Enter Route No" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="counters_id" class="form-label">Counters</label>
                                <select name="counters_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($counters as $counter)
                                        <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="route_manager_id" class="form-label">Route Manager</label>
                                <select name="route_manager_id" class="form-select">
                                    <option value="">Select Route Manager</option>
                                    @foreach ($routeManagers as $routeManager)
                                        <option value="{{ $routeManager->id }}">{{ $routeManager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="checkers_id" class="form-label   ">Checkers</label>
                                <select name="checkers_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($checkers as $checker)
                                        <option value="{{ $checker->id }}">{{ $checker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="document" class="form-label">Document</label>
                                <input type="file" id="document" name="document" class="form-control">
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
