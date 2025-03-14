@extends('admin.app')
<style>
    .seat-section {
        padding: 130px 0;
    }

    .seat-box {
        max-width: 320px;
        /* height: 100vh; */
        margin: auto;
        border-radius: 15px;
    }

    .seat {
        display: grid;
        place-content: center;
        width: 47px;
        height: 47px;
        border: 1px solid #dee0f0;
        border-radius: 16px;
        font-style: normal;
        font-weight: 700;
        font-size: 11px;
        line-height: 11px;
        text-align: center;
        text-transform: uppercase;
    }

    .seat-selected {
        background: #e0115f;
        border-color: #e0115f;
        color: #fff;
    }

    .seat-available {
        background: #fff;
        color: #000;
        border-color: #c8c8c8;
    }

    .seat-booked {
        background: #d7d7d7 !important;
        color: #9b9b9b !important;
        cursor: not-allowed !important;
        border: 1px solid #d7d7d7 !important;
    }

    .seat-means {
        width: 15px;
        height: 15px;
        margin-right: 5px;
        border-radius: 4px;
    }

    .legend-label {
        font-size: 12px;
        font-weight: 400;
        line-height: 15px;
        color: #202020;
    }

    .available-example {
        background: white;
        border: 1px solid #000000;
    }

    .sold-example {
        background: #d7d7d7;
        border: 1px solid #d7d7d7;
    }

    .selected-example {
        background: #e0115f;
        border: 1px solid #e0115f;
    }
</style>
@section('admin_content')
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
            <form method="GET" action="{{ route('seats.section') }}" class="d-flex gap-2">
                <div>
                    <label for="route_id" class="form-label">Route</label>
                    <select name="route_id" id="route_id" class="form-select">
                        <option value="">Select Route</option>
                        {{-- @foreach ($routes as $route)
                            <option value="{{ $route->id }}"
                                {{ isset($trip) && $route->id == $trip->route_id ? 'selected' : '' }}>
                                {{ $route->name }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>
                <div>
                    <label for="trip_date" class="form-label">Date</label>
                    <input type="date" id="trip_date" name="trip_date" class="form-control" value="{{ request('trip_date') }}">
                </div>
                <div class="align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        @endcan
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

                    {{-- @if ($flag == 1)
                    <div class="container">
                        <div class="seat-box p-4 bg-white">
                            <div class="seat-wrapper">
                                <div class="d-flex justify-content-around mb-4">
                                    <ul class="d-flex list-unstyled align-items-center">
                                        <li class="seat-means available-example"></li>
                                        <li class="legend-label">Available</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled align-items-center">
                                        <li class="seat-means sold-example"></li>
                                        <li class="legend-label">Sold</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled align-items-center">
                                        <li class="seat-means selected-example"></li>
                                        <li class="legend-label">Selected</li>
                                    </ul>
                                </div>
                                <div class="row g-5">
                                    <div class="col-6">
                                        <div class="row g-3">
                                            @foreach ($seats as $seatData)
                                                @if (in_array(substr($seatData->seat_no, -1), ['1', '2']))
                                                    <div class="col-6">
                                                        <button 
                                                            class="seat 
                                                                @if ($seatData->is_booked == 0) seat-available 
                                                                @elseif ($seatData->is_booked == 1) seat-selected 
                                                                @elseif ($seatData->is_booked == 2) seat-booked @endif"
                                                            data-seat-id="{{ $seatData->id }}"
                                                            data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                            data-booked="{{ $seatData->is_booked }}"
                                                        >
                                                            {{ $seatData->seat_no }}
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row g-3">
                                            @foreach ($seats as $seatData)
                                                @if (in_array(substr($seatData->seat_no, -1), ['3', '4']))
                                                    <div class="col-6">
                                                        <button 
                                                            class="seat 
                                                                @if ($seatData->is_booked == 0) seat-available 
                                                                @elseif ($seatData->is_booked == 1) seat-selected 
                                                                @elseif ($seatData->is_booked == 2) seat-booked @endif"
                                                            data-seat-id="{{ $seatData->id }}"
                                                            data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                            data-booked="{{ $seatData->is_booked }}"
                                                        >
                                                            {{ $seatData->seat_no }}
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="d-flex justify-content-between">
                                        <p class="h5" id="selected-seats-count">0 ticket(s) selected</p>
                                        <p class="h5" id="total-price">৳ 0</p>
                                    </div>
                                    <button class="btn btn-primary w-100 mt-2"
                                        style="background-color: #E0115F; border-color: #E0115F">
                                        Continue
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif --}}

                    @if ($flag == 1)
<div class="container">
    <div class="seat-box p-4 bg-white">
        <div class="seat-wrapper">
            <div class="d-flex justify-content-around mb-4">
                <ul class="d-flex list-unstyled align-items-center">
                    <li class="seat-means available-example"></li>
                    <li class="legend-label">Available</li>
                </ul>
                <ul class="d-flex list-unstyled align-items-center">
                    <li class="seat-means sold-example"></li>
                    <li class="legend-label">Sold</li>
                </ul>
                <ul class="d-flex list-unstyled align-items-center">
                    <li class="seat-means selected-example"></li>
                    <li class="legend-label">Selected</li>
                </ul>
            </div>
            <div class="row g-5">
                <div class="col-6">
                    <div class="row g-3">
                        @foreach ($seats as $seatData)
                            @if (in_array(substr($seatData->seat_no, -1), ['1', '2']))
                                <div class="col-6">
                                    <button 
                                        class="seat 
                                            @if ($seatData->is_booked == 0) seat-available 
                                            @elseif ($seatData->is_booked == 1) seat-selected 
                                            @elseif ($seatData->is_booked == 2) seat-booked @endif"
                                        data-seat-id="{{ $seatData->id }}"
                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                        data-seat-no="{{ $seatData->seat_no }}"
                                    >
                                        {{ $seatData->seat_no }}
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-6">
                    <div class="row g-3">
                        @foreach ($seats as $seatData)
                            @if (in_array(substr($seatData->seat_no, -1), ['3', '4']))
                                <div class="col-6">
                                    <button 
                                        class="seat 
                                            @if ($seatData->is_booked == 0) seat-available 
                                            @elseif ($seatData->is_booked == 1) seat-selected 
                                            @elseif ($seatData->is_booked == 2) seat-booked @endif"
                                        data-seat-id="{{ $seatData->id }}"
                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                        data-seat-no="{{ $seatData->seat_no }}"
                                    >
                                        {{ $seatData->seat_no }}
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <p class="h5" id="selected-seats-count">0 ticket(s) selected</p>
                    <p class="h5" id="total-price">৳ 0</p>
                </div>
                <button class="btn btn-primary w-100 mt-2"
                    id="continue-button"
                    style="background-color: #E0115F; border-color: #E0115F">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="passengerModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="passengerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="passenger-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="passengerModalLabel">Passenger Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="passenger-name" class="form-label">Passenger Name</label>
                        <input type="text" class="form-control" id="passenger-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="passenger-phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="passenger-phone" name="phone" required>
                    </div>
                    <input type="hidden" id="total-amount" name="total_amount">
                    <div class="mb-3">
                        <p>Total Payable: <span id="modal-total-price">৳ 0</span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="continue-button">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let selectedSeats = [];
        let totalPrice = 0;
    
        document.querySelectorAll('.seat').forEach(button => {
            button.addEventListener('click', function () {
                if (this.classList.contains('seat-booked')) return;
    
                const seatId = this.dataset.seatId;
                const seatPrice = parseFloat(this.dataset.seatPrice);
                const seatNo = this.dataset.seatNo;
                const vehicleName = this.dataset.vehicleName;
    
                if (this.classList.contains('seat-selected')) {
                    this.classList.remove('seat-selected');
                    this.classList.add('seat-available');
    
                    selectedSeats = selectedSeats.filter(seat => seat.seatId !== seatId);
                    totalPrice -= seatPrice;
                } else {
                    this.classList.add('seat-selected');
                    this.classList.remove('seat-available');
    
                    selectedSeats.push({ seatId, seatNo, seatPrice, vehicleName });
                    totalPrice += seatPrice;
                }
    
                document.getElementById('selected-seats-count').innerText = `${selectedSeats.length} ticket(s) selected`;
                document.getElementById('total-price').innerText = `৳ ${totalPrice.toFixed(2)}`;
            });
        });
    
        document.getElementById('continue-button').addEventListener('click', function () {
            if (selectedSeats.length === 0) {
                alert('No seats selected!');
                return;
            }
    
            document.getElementById('modal-total-price').innerText = `৳ ${totalPrice.toFixed(2)}`;
            document.getElementById('total-amount').value = totalPrice.toFixed(2);
            const modal = new bootstrap.Modal(document.getElementById('passengerModal'));
            modal.show();
        });
    
        document.getElementById('passenger-form').addEventListener('submit', function (e) {
            e.preventDefault();
    
            const name = document.getElementById('passenger-name').value;
            const phone = document.getElementById('passenger-phone').value;
    
            fetch('{{ route("seat_booking.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, phone, seats: selectedSeats })
            })
            .then(response => response.json())
            .then(data => {
                alert('Booking successful!');
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
    @endif


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
                                        {{ $vehicle ? $vehicle->name : 'N/A' }}
                                        ({{ $vehicle ? $vehicle->engin_no : 'N/A' }})
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
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
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
                                    <div class="modal fade" id="bookSeatModal{{ $seatData->id }}"
                                        data-bs-backdrop="static" tabindex="-1" role="dialog"
                                        aria-labelledby="bookSeatModalLabel{{ $seatData->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="bookSeatModalLabel{{ $seatData->id }}">
                                                        Book
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
                                                                    <label for="passenger_name"
                                                                        class="form-label">Passenger
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
                                                                    <label for="passenger_phone"
                                                                        class="form-label">Passenger
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
                                                                        value="{{ $seatData->seat_no }}"
                                                                        class="form-control" readonly>
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
                                                                    <label for="booking_date"
                                                                        class="form-label">Date</label>
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
                                    <div class="modal fade" id="editNewModalId{{ $seatData->id }}"
                                        data-bs-backdrop="static" tabindex="-1" role="dialog"
                                        aria-labelledby="editNewModalLabel{{ $seatData->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="addNewModalLabel{{ $seatData->id }}">Edit
                                                    </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('seats.update', $seatData->id) }}"
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
                                                                    <label for="seat_no" class="form-label">Seat
                                                                        No</label>
                                                                    <input type="text" id="seat_no" name="seat_no"
                                                                        value="{{ $seatData->seat_no }}"
                                                                        class="form-control" placeholder="Enter Seat No"
                                                                        required>
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
                                                    <h4 class="modal-title"
                                                        id="danger-header-modalLabe{{ $seatData->id }}l">
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

    
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const seats = document.querySelectorAll(".seat");
            const selectedSeatsElement = document.querySelector(".selected-seats");
            const totalPriceElement = document.querySelector(".total-price");
            const ticketPrice = {{ $trip->ticket_price ?? 0 }}; // Pass ticket price from the server.
    
            let selectedSeatsCount = {{ session('selected_seats', 0) }};
            let totalPrice = {{ session('total_price', 0) }};
    
            seats.forEach((seat) => {
                seat.addEventListener("click", function (e) {
                    e.preventDefault();
    
                    const seatId = this.dataset.seatId;
                    const isBooked = this.classList.contains("seat-selected");
    
                    // Toggle seat status
                    if (isBooked) {
                        this.classList.remove("seat-selected");
                        this.classList.add("seat-available");
                        selectedSeatsCount--;
                    } else {
                        this.classList.add("seat-selected");
                        this.classList.remove("seat-available");
                        selectedSeatsCount++;
                    }
    
                    // Update total price
                    totalPrice = ticketPrice * selectedSeatsCount;
    
                    // Update UI
                    selectedSeatsElement.textContent = `${selectedSeatsCount} ticket(s) selected`;
                    totalPriceElement.textContent = `৳ ${totalPrice}`;
    
                    // Send AJAX request to update the server
                    fetch("{{ route('seats.select') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({
                            seat_id: seatId,
                            is_booked: isBooked ? 0 : 1, // Toggle booking status
                        }),
                    }).catch((error) => console.error("Error:", error));
                });
            });
        });
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedSeatsCount = 0;
            let totalPrice = 0;
        
            document.querySelectorAll('.seat').forEach(button => {
                button.addEventListener('click', function () {
                    // Prevent action if the seat is already sold
                    if (this.classList.contains('seat-booked')) {
                        return;
                    }
        
                    const seatPrice = parseFloat(this.dataset.seatPrice);
        
                    // Toggle seat selection
                    if (this.classList.contains('seat-selected')) {
                        this.classList.remove('seat-selected');
                        this.classList.add('seat-available');
                        selectedSeatsCount--;
                        totalPrice -= seatPrice;
                    } else {
                        this.classList.add('seat-selected');
                        this.classList.remove('seat-available');
                        selectedSeatsCount++;
                        totalPrice += seatPrice;
                    }
        
                    // Update UI
                    document.getElementById('selected-seats-count').innerText = `${selectedSeatsCount} ticket(s) selected`;
                    document.getElementById('total-price').innerText = `৳ ${totalPrice.toFixed(2)}`;
                });
            });
        });
</script> --}}
@endsection
