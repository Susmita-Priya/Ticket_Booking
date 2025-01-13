@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Seat Booking</li>
                    </ol>
                </div>
                <h4 class="page-title">Seat Booking</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    <form method="GET" action="{{ route('seat_booking.section', ['vehicle_id' => $vehicle->id]) }}">
                        <div class="d-flex align-items-center">
                            <label for="filter_date" class="me-4">Select Date:</label>
                            <input type="date" id="filter_date" name="filter_date" class="form-control me-2"
                                value="{{ request('filter_date') }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <h3 class="text-center"> {{ $vehicle->name }}</h3>
                <p class="text-center">Total Payment : <span style="color: green;"><strong>{{ $total_payment }} TK</strong></span></p>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Vehicle</th>
                            <th>Seat No</th>
                            <th>Booking Date</th>
                            <th>Payment Amount</th>
                            <th>Passenger Name</th>
                            <th>Passenger Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $vehicle->name }} <br>
                                    Vehicle No : {{ $vehicle->vehicle_no }}</td>
                                <td>{{ $booking->seat_no }}</td>
                                <td>{{ $booking->booking_date }}</td>
                                <td>{{ $booking->payment_amount }}</td>
                                <td>{{ $booking->passenger_name ?? 'N/A' }}</td>
                                <td>{{ $booking->passenger_phone }}</td>
                                <td>
                                    <div class="d-flex ">
                                        {{-- @can('seats-edit')
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$booking->id}}">Edit</button>
                                @endcan --}}
                                        @can('seats-delete')
                                            <a href="{{ route('seat_booking.destroy', $booking->id) }}"
                                                class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $booking->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Booking Modal -->
                            {{-- <div class="modal fade" id="editModal{{$booking->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$booking->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="editModalLabel{{$booking->id}}">Edit Booking</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="{{ route('seat_booking.update', $booking->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="vehicle_id{{$booking->id}}" class="form-label">Vehicle</label>
                                            <select id="vehicle_id{{$booking->id}}" name="vehicle_id" class="form-select" required>
                                                @foreach ($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id }}" {{ $vehicle->id == $booking->vehicle_id ? 'selected' : '' }}>{{ $vehicle->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="seat_no{{$booking->id}}" class="form-label">Seat No</label>
                                            <input type="text" id="seat_no{{$booking->id}}" name="seat_no" value="{{ $booking->seat_no }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="booking_date{{$booking->id}}" class="form-label">Booking Date</label>
                                            <input type="date" id="booking_date{{$booking->id}}" name="booking_date" value="{{ $booking->booking_date }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="payment_amount{{$booking->id}}" class="form-label">Payment Amount</label>
                                            <input type="number" id="payment_amount{{$booking->id}}" name="payment_amount" value="{{ $booking->payment_amount }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="passenger_name{{$booking->id}}" class="form-label">Passenger Name</label>
                                            <input type="text" id="passenger_name{{$booking->id}}" name="passenger_name" value="{{ $booking->passenger_name }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="passenger_phone{{$booking->id}}" class="form-label">Passenger Phone</label>
                                            <input type="text" id="passenger_phone{{$booking->id}}" name="passenger_phone" value="{{ $booking->passenger_phone }}" class="form-control" required>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                            <!-- Delete Modal -->
                            <div id="deleteModal{{ $booking->id }}" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel{{ $booking->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="deleteModalLabel{{ $booking->id }}">Delete Booking
                                            </h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are you sure you want to delete this booking?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('seat_booking.destroy', $booking->id) }}"
                                                class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
