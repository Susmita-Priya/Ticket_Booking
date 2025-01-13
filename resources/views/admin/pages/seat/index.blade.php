@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Seat!</li>
                    </ol>
                </div>
                <h4 class="page-title">Seat!</h4>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        @can('vehicle-select')
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
            Filter by Vehicle
        </button>
        @endcan
        
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="filterModalLabel">Filter by Vehicle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('seats.section') }}">
                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <select name="vehicle_id" id="vehicle_id" class="form-select">
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicles as $vehi)
                                    <option value="{{ $vehi->id }}" {{ isset($vehicle) && $vehi->id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehi->name }} ({{ $vehi->vehicle_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end gap-1">
                    @if ($flag == 1)
                    @can('reset-seat-list')
                        <!-- Reset Button -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#resetSeatModal">Reset</button>
                    @endcan 
                    @can('booking-list')
                        <a href="{{ route('seat_booking.section', $vehicle->id) }}" class="btn btn-success">Booking List</a>
                    @endcan
                    @can('seats-create')
                        {{-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button> --}}
                        @if ($vehicle->total_seat > $seats->count())
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#addNewModalId">Add New</button>
                        @endif
                    @endcan 
                    @endif
                
                </div>
            </div>
            <div class="card-body">
                    <div class="text-center mb-3">
                        {{-- <h1>Trip Details</h1> --}}
                        @if ($trip)
                        <h3><strong>Route:</strong> {{ $trip->route->name }}</h3>
                        <h5>{{ $vehicle->name }}</h5>
                        <p><strong></strong> {{ \Carbon\Carbon::parse($trip->Date)->format('d M Y') }} ,
                            {{ \Carbon\Carbon::parse($trip->Time)->format('h:i A') }}</p>
                        <p><strong>Driver:</strong> {{ $trip->driver->name }} <strong>, Supervisor:</strong>
                            {{ $trip->supervisor->name }}</p>
                        <p></p>
                        @endif

                    </div>

                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Vehicle</th>
                            <th>Seat No</th>
                            <th>Is Booked?</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if ($flag == 1)
                        @foreach ($seats as $key => $seatData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @php
                                        $vehicle = $vehicle->firstWhere('id', $seatData->vehicle_id);
                                    @endphp
                                    {{ $vehicle ? $vehicle->name : 'N/A' }} ({{ $vehicle ? $vehicle->engin_no : 'N/A' }})
                                </td>
                                <td>{{ $seatData->seat_no }}</td>
                                <td>
                                    @if ($seatData->is_booked == 1)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($seatData->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('seat-booking-create')
                                            @if ($seatData->is_booked == 0 && $vehicle->is_booked == 1)
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#bookSeatModal{{ $seatData->id }}">Book</button>
                                            @endif
                                        @endcan
                                        @can('seats-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $seatData->id }}">Edit</button>
                                        @endcan
                                        @can('seats-delete')
                                            <a href="{{ route('seats.destroy', $seatData->id) }}"class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $seatData->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Reset Confirmation Modal -->
                                <div class="modal fade" id="resetSeatModal" data-bs-backdrop="static" tabindex="-1"
                                    role="dialog" aria-labelledby="resetSeatModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="resetSeatModalLabel">Reset Seats</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to reset the seats?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('reset.seat', $vehicle->id) }}"
                                                    class="btn btn-warning">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Book Seat Modal -->
                                <div class="modal fade" id="bookSeatModal{{ $seatData->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="bookSeatModalLabel{{ $seatData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="bookSeatModalLabel{{ $seatData->id }}">Book
                                                    Seat</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                    action="{{ route('seat_booking.store', $seatData->id) }}">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="passenger_name" class="form-label">Passenger
                                                                    Name</label>
                                                                <input type="text" id="passenger_name"
                                                                    name="passenger_name" class="form-control"
                                                                    placeholder="Enter Passenger Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="passenger_phone" class="form-label">Passenger
                                                                    Phone</label>
                                                                <input type="text" id="passenger_phone"
                                                                    name="passenger_phone" class="form-control"
                                                                    placeholder="Enter Phone Number" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="vehicle_name"
                                                                    class="form-label">Vehicle</label>
                                                                <input type="text" id="vehicle_name"
                                                                    name="vehicle_name"
                                                                    value="{{ $vehicle->name }} ({{ $vehicle->vehicle_no }})"
                                                                    class="form-control" readonly>
                                                                <input type="hidden" name="vehicle_id"
                                                                    value="{{ $vehicle->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="seat_no_display" class="form-label">Seat
                                                                    No</label>
                                                                <input type="text" id="seat_no_display"
                                                                    name="seat_no_display"
                                                                    value="{{ $seatData->seat_no }}" class="form-control"
                                                                    readonly>
                                                                <input type="hidden" name="seat_no"
                                                                    value="{{ $seatData->seat_no }}">
                                                                <input type="hidden" name="seat_id"
                                                                    value="{{ $seatData->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="payment_amount" class="form-label">Payment
                                                                    Amount</label>
                                                                <input type="text" id="payment_amount"
                                                                    name="payment_amount"
                                                                    value="{{ $vehicle->per_seat_price }}"
                                                                    class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="booking_date" class="form-label">Date</label>
                                                                <input type="date" id="booking_date"
                                                                    name="booking_date"
                                                                    value="{{ \Carbon\Carbon::today()->toDateString() }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary" type="submit">Book</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $seatData->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $seatData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $seatData->id }}">Edit
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('seats.update', $seatData->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    {{-- <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label for="vehicle_id" class="form-label">Vehicle</label>
                                                        <select name="vehicle_id" class="form-select">
                                                            
                                                                <option value="{{ $vehicle->id }}"
                                                                    {{ $seatData->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                                    {{ $vehicle->name }}</option>
                                                           
                                                        </select>
                                                    </div>
                                                </div> --}}
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="seat_no" class="form-label">Seat No</label>
                                                                <input type="text" id="seat_no" name="seat_no"
                                                                    value="{{ $seatData->seat_no }}" class="form-control"
                                                                    placeholder="Enter Seat No" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="example-select" class="form-label">Is
                                                                    Booked</label>
                                                                <select name="is_booked" class="form-select">
                                                                    <option value="1"
                                                                        {{ $seatData->is_booked === 1 ? 'selected' : '' }}>
                                                                        Yes</option>
                                                                    <option value="0"
                                                                        {{ $seatData->is_booked === 0 ? 'selected' : '' }}>
                                                                        No</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="example-select"
                                                                    class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1"
                                                                        {{ $seatData->status === 1 ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="0"
                                                                        {{ $seatData->status === 0 ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
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
                                <div id="danger-header-modal{{ $seatData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $seatData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabe{{ $seatData->id }}l">
                                                    Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('seats.destroy', $seatData->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">No Data Found , Please Select Vehicle</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($flag == 1)
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('seats.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="seat_no" class="form-label">Seat No</label>
                                    <input type="text" id="seat_no" name="seat_no" class="form-control"
                                        placeholder="Enter Seat No" required>
                                </div>
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
  @endif
@endsection
