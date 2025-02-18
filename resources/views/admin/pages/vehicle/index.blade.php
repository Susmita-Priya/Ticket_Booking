@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Vehicles!</li>
                    </ol>
                </div>
                <h4 class="page-title">Vehicles!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('vehicle-create')
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
                            <th>Vehicle</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Owner</th>
                            <th>Total Seat</th>
                            <th>Amenities</th>
                            <th>Document</th>
                            <th>Seat</th>
                            <th>Assign trip?</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $key => $vehicle)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-wrap">
                                    {{ $vehicle->company->name }}
                                </td>
                                <td>Name : {{ $vehicle->name }} <br>
                                Vehicle No : {{ $vehicle->vehicle_no }} <br>
                                Engine No : {{ $vehicle->engin_no }} <br>
                                Chassis No : {{ $vehicle->chest_no }}</td>
                                <td>{{ $vehicle->type->name }}</td>
                                <td>
                                    @if ($vehicle->category == '0')
                                        Economy Class
                                    @elseif ($vehicle->category == '1')
                                        Business Class
                                    @elseif ($vehicle->category == '2')
                                        Sleeping Coach
                                    @endif
                                </td>
                                <td>{{ $vehicle->owner->name }}</td>  
                                <td>{{ $vehicle->total_seat }}</td>
                                <td>
                                    @php
                                        $vehicleAmenities = json_decode($vehicle->amenities_id, true) ?? [];
                                    @endphp
                                    @foreach ($amenities as $amenity)
                                        @if (in_array($amenity->id, $vehicleAmenities))
                                            <span class="badge bg-primary">{{ $amenity->name }}</span> <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($vehicle->document)
                                        <a href="{{ asset($vehicle->document) }}" target="_blank" class="btn btn-primary btn-sm">View</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>
                                    @can('seats-list')
                                        <a href="{{ route('seats.section', $vehicle->id) }}" class="btn btn-info btn-sm">
                                            <i class="ri-arrow-right-line"></i>
                                            <span> Seats </span>
                                        </a>
                                    @endcan
                                </td>
                                <td>
                                    @if ($vehicle->is_booked == 1)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($vehicle->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @elseif ($vehicle->status == 0)
                                    <span class="badge bg-danger">Inactive</span>
                                    @else
                                    <span class="badge bg-warning">Maintenance</span>
                                    @endif
                                </td>
                                <td style="width: 100px;">
                                    <div class="d-flex flex-column gap-2">
                                        @can('vehicle-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $vehicle->id }}">Edit</button>
                                        @endcan
                                        @can('vehicle-delete')
                                            <a href="{{ route('vehicle.destroy', $vehicle->id) }}"
                                                class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $vehicle->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $vehicle->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $vehicle->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $vehicle->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('vehicle.update', $vehicle->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="owner_id" class="form-label">Owner</label>
                                                            <select name="owner_id" class="form-select">
                                                                @foreach ($owners as $owner)
                                                                    <option value="{{ $owner->id }}"
                                                                        {{ $vehicle->owner_id == $owner->id ? 'selected' : '' }}>
                                                                        {{ $owner->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="type_id" class="form-label">Type</label>
                                                            <select name="type_id" class="form-select">
                                                                @foreach ($types as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ $vehicle->type_id == $type->id ? 'selected' : '' }}>
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="category" class="form-label">Category</label>
                                                            <select name="category" class="form-select">
                                                                <option >Select Category</option>
                                                                <option value='0'
                                                                    {{ $vehicle->category == '0' ? 'selected' : '' }}>
                                                                    Economy Class</option>
                                                                <option value='1'
                                                                    {{ $vehicle->category == '1' ? 'selected' : '' }}>
                                                                    Business Class</option>
                                                                <option value='2'
                                                                    {{ $vehicle->category == '2' ? 'selected' : '' }}>
                                                                    Sleeping Coach</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $vehicle->name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="vehicle_no" class="form-label">Vehicle No</label>
                                                            <input type="text" id="vehicle_no" name="vehicle_no"
                                                                value="{{ $vehicle->vehicle_no }}" class="form-control"
                                                                placeholder="Enter vehicle number" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="engin_no" class="form-label">Engine No</label>
                                                            <input type="text" id="engin_no" name="engin_no"
                                                                value="{{ $vehicle->engin_no }}" class="form-control"
                                                                placeholder="Enter engine number" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="chest_no" class="form-label">Chassis No</label>
                                                            <input type="text" id="chest_no" name="chest_no"
                                                                value="{{ $vehicle->chest_no }}" class="form-control"
                                                                placeholder="Enter chest number" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="total_seat" class="form-label">Total Seat</label>
                                                            <input type="number" id="total_seat" name="total_seat"
                                                                value="{{ $vehicle->total_seat }}" class="form-control"
                                                                placeholder="Enter total seat" required max="100">
                                                        </div>
                                                    </div>

                                                    {{--  Amenities --}}
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="amenities_id" class="form-label">Amenities</label>
                                                            <select name="amenities_id[]"
                                                                class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($amenities as $amenity)
                                                                    @php
                                                                        $selectedAmenities =
                                                                            json_decode($vehicle->amenities_id, true) ??
                                                                            [];
                                                                    @endphp
                                                                    <option value="{{ $amenity->id }}"
                                                                        {{ in_array($amenity->id, $selectedAmenities) ? 'selected' : '' }}>
                                                                        {{ $amenity->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="document" class="form-label">Document</label>
                                                            <input type="file" id="document" name="document"
                                                                class="form-control">
                                                            @if ($vehicle->document)
                                                                <a href="{{ asset($vehicle->document) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm mt-2">View Document</a>
                                                            @else
                                                                No Document
                                                            @endif
                                                        </div>
                                                    </div>
                                                   
                                                    <div class = "row">
                                                        <div class="col-12 mb-3">
                                                            <label for="is_booked" class="form-label">Is Booked</label>
                                                            <select name="is_booked" class="form-select">
                                                                <option value="1"
                                                                    {{ $vehicle->is_booked == 1 ? 'selected' : '' }}>Yes
                                                                </option>
                                                                <option value="0"
                                                                    {{ $vehicle->is_booked == 0 ? 'selected' : '' }}>No
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $vehicle->status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $vehicle->status == 0 ? 'selected' : '' }}>Inactive
                                                                </option>
                                                                <option value="2"
                                                                    {{ $vehicle->status == 2 ? 'selected' : '' }}>Maintenance
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
                                <div id="danger-header-modal{{ $vehicle->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $vehicle->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $vehicle->id }}">
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
                                                <a href="{{ route('vehicle.destroy', $vehicle->id) }}"
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
                    <form method="post" action="{{ route('vehicle.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="owner_id" class="form-label">Owner</label>
                                <select name="owner_id" class="form-select">
                                    <option selected value="">Select Owner</option>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="type_id" class="form-label">Type</label>
                                <select name="type_id" class="form-select">
                                    <option selected value="">Select Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" class="form-select">
                                    <option >Select Category</option>
                                    <option value='0'>Economy Class</option>
                                    <option value='1'>Business Class</option>
                                    <option value='2'>Sleeping Coach</option>
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
                                <label for="vehicle_no" class="form-label">Vehicle No</label>
                                <input type="text" id="vehicle_no" name="vehicle_no" class="form-control"
                                    placeholder="Enter vehicle number" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="engin_no" class="form-label">Engine No</label>
                                <input type="text" id="engin_no" name="engin_no" class="form-control"
                                    placeholder="Enter engine number" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="chest_no" class="form-label">Chassis No</label>
                                <input type="text" id="chest_no" name="chest_no" class="form-control"
                                    placeholder="Enter chest number" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="total_seat" class="form-label">Total Seat</label>
                                <input type="number" id="total_seat" name="total_seat" class="form-control"
                                    placeholder="Enter total seat" required max="100">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="amenities_id" class="form-label">Amenities</label>
                                <select name="amenities_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
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
