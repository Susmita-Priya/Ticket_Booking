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

    .seat-reserved{
        background: #28a745;
        color: #fff;
        border-color: #28a745;
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

    .reserved-example {
        background: #28a745;
        border: 1px solid #28a745;
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
                        <li class="breadcrumb-item active">Ticket!</li>
                    </ol>
                </div>
                <h4 class="page-title">Ticket!</h4>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 60px;">
        <div class="d-flex justify-content-between g-3 align-items-end">
            @can('vehicle-select')
                <form method="GET" action="{{ route('ticket_booking.section') }}" class="d-flex w-100">
                    <div class="col-md-1">
                        <label for="vehicle_id" class="form-label"></label>
                    </div>
                    <div class="col-md-4 me-3">
                        <label for="route_id" class="form-label">Route</label>
                        <select name="route_id" id="route_id" class="form-select">
                            <option value="">Select Route</option>
                            @foreach ($routes as $rte)
                                <option value="{{ $rte->id }}"
                                    {{ isset($route) && $route->id == $rte->id ? 'selected' : '' }}>
                                    {{ $rte->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 me-3">
                        <label for="filter_date" class="form-label">date</label>
                        <input type="date" id="filter_date" name="filter_date" class="form-control"
                            value="{{ request('filter_date') ?: date('Y-m-d') }}">
                    </div>

                    <div class="col-md-2 me-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-50">Filter</button>
                    </div>
                </form>
            @endcan
        </div>
    </div>



    @if (empty($trips))
        <h4 class="text-muted text-center">No trips found</h4>
    @else
        <h4 class="text-muted text-center">Choose Departing Ticket</h4>
        <h5 class="text-muted text-center">Route: {{ $route->name }}</h5>
        <div class="card-body">
            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Vehicle</th>
                        <th>Category</th>
                        <th>Start Counter</th>
                        <th>End Counter</th>
                        <th>date</th>
                        <th>time</th>
                        <th>Ticket Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trips as $trip)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trip->vehicle->name ?? 'N/A' }} <br>
                                ({{ $trip->vehicle->vehicle_no ?? 'N/A' }})
                            </td>
                            <td>
                                @if ($trip->vehicle->category == '0')
                                    <span class="badge bg-info">Economy Class</span>
                                @elseif ($trip->vehicle->category == '1')
                                    <span class="badge bg-info">Business Class</span>
                                @elseif ($trip->vehicle->category == '2')
                                    <span class="badge bg-info">Sleeping Coach</span>
                                @endif
                            </td>
                            <td>{{ $trip->route->startCounter->name }}</td>
                            <td>{{ $trip->route->endCounter->name }}</td>
                            <td>{{ $trip->date }}</td>
                            <td>{{ $trip->time }}</td>
                            <td>{{ $trip->ticket_price }} TK</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    @can('ticket-booking')
                                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight{{ $trip->id }}"
                                            aria-controls="offcanvasRight{{ $trip->id }}">
                                            Book Ticket
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>

                        <!-- Offcanvas Structure -->
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight{{ $trip->id }}"
                            aria-labelledby="offcanvasRightLabel{{ $trip->id }}">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasRightLabel{{ $trip->id }}">Book Tickets</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            <div class="offcanvas-body">
                                <!-- Seat Box -->
                                <div class="seat-box p-4 bg-white">
                                    <div class="seat-wrapper">
                                        <div class="text-center mb-3">
                                            <h3>{{ $trip->vehicle->name }}</h3>
                                            <h5> {{ $trip->route->name }}</h5>

                                            <p><strong></strong> {{ \Carbon\Carbon::parse($trip->date)->format('d M Y') }},
                                                {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</p>
                                            <p><strong>Driver:</strong> {{ $trip->driver->name }} <strong>,
                                                    Supervisor:</strong>
                                                {{ $trip->supervisor->name }}</p>
                                            <br>
                                        </div>
                                        <!-- Seat Legend -->
                                        <div class="d-flex justify-content-around mb-0">
                                            <ul class="d-flex list-unstyled align-items-center">
                                                <li class="seat-means available-example"></li>
                                                <li class="legend-label">Available</li>
                                            </ul>
                                            <ul class="d-flex list-unstyled align-items-center">
                                                <li class="seat-means selected-example"></li>
                                                <li class="legend-label">Selected</li>
                                            </ul>
                                        </div>
                                        <div class="d-flex justify-content-around mb-4">
                                            <ul class="d-flex list-unstyled align-items-center">
                                                <li class="seat-means sold-example"></li>
                                                <li class="legend-label">Sold</li>
                                            </ul>
                                            <ul class="d-flex list-unstyled align-items-center">
                                                <li class="seat-means reserved-example"></li>
                                                <li class="legend-label">Reserved</li>
                                            </ul>
                                        </div>

                                        @php
                                            $vehicle_category = $trip->vehicle->category;
                                            $seats = $trip->vehicle->seats->sortBy('seat_no');
                                        @endphp

                                        @if ($vehicle_category == 0)
                                            <!-- Seat Layout -->
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
                                                            @elseif ($seatData->is_booked == 2) seat-booked 
                                                            @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                        data-seat-id="{{ $seatData->id }}"
                                                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                        data-seat-no="{{ $seatData->seat_no }}">
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
                                                            @elseif ($seatData->is_booked == 2) seat-booked 
                                                            @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                        data-seat-id="{{ $seatData->id }}"
                                                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                        data-seat-no="{{ $seatData->seat_no }}">
                                                                        {{ $seatData->seat_no }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($vehicle_category == 1)
                                            <!-- Seat Layout -->
                                            <div class="row g-5">
                                                <div class="col-3">
                                                    <div class="row g-3">
                                                        @foreach ($seats as $seatData)
                                                            @if (in_array(substr($seatData->seat_no, -1), ['1']))
                                                                <div class="col-6">
                                                                    <button
                                                                        class="seat 
                                                            @if ($seatData->is_booked == 0) seat-available 
                                                            @elseif ($seatData->is_booked == 1) seat-selected 
                                                            @elseif ($seatData->is_booked == 2) seat-booked 
                                                            @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                        data-seat-id="{{ $seatData->id }}"
                                                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                        data-seat-no="{{ $seatData->seat_no }}">
                                                                        {{ $seatData->seat_no }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                </div>
                                                <div class="col-6">
                                                    <div class="row g-3">
                                                        @foreach ($seats as $seatData)
                                                            @if (in_array(substr($seatData->seat_no, -1), ['2', '3']))
                                                                <div class="col-6">
                                                                    <button
                                                                        class="seat 
                                                            @if ($seatData->is_booked == 0) seat-available 
                                                            @elseif ($seatData->is_booked == 1) seat-selected 
                                                            @elseif ($seatData->is_booked == 2) seat-booked 
                                                            @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                        data-seat-id="{{ $seatData->id }}"
                                                                        data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                        data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                        data-seat-no="{{ $seatData->seat_no }}">
                                                                        {{ $seatData->seat_no }}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($vehicle_category == 2)
                                            <!--   tab section     -->
                                            <ul class="nav nav-pills border nav-justified mb-4" id="pills-tab"
                                                role="tablist">
                                                <!--single tab  -->
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="pills-lower-tab"
                                                        data-toggle="pill" data-target="#pills-lower" type="button"
                                                        role="tab" aria-controls="pills-lower"
                                                        aria-selected="true">Lower</button>
                                                </li>
                                                <!--   single tab     -->
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pills-upper-tab" data-toggle="pill"
                                                        data-target="#pills-upper" type="button" role="tab"
                                                        aria-controls="pills-upper" aria-selected="false">Upper</button>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="pills-tabContent">
                                                <!--    lower content      -->
                                                <div class="tab-pane fade show active" id="pills-lower" role="tabpanel"
                                                    aria-labelledby="pills-lower-tab">
                                                    <div class="seat-wrapper">
                                                        <div class="row g-5">
                                                            <div class="col-3">
                                                                <div class="row g-3">
                                                                    @foreach ($seats as $seatData)
                                                                        @if (in_array(substr($seatData->seat_no, -1), ['1']))
                                                                            <div class="col-6">
                                                                                <button
                                                                                    class="seat 
                                                                    @if ($seatData->is_booked == 0) seat-available 
                                                                    @elseif ($seatData->is_booked == 1) seat-selected 
                                                                    @elseif ($seatData->is_booked == 2) seat-booked
                                                                    @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                                    data-seat-id="{{ $seatData->id }}"
                                                                                    data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                                    data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                                    data-seat-no="{{ $seatData->seat_no }}">
                                                                                    {{ $seatData->seat_no }}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="row g-3">
                                                                    @foreach ($seats as $seatData)
                                                                        @if (in_array(substr($seatData->seat_no, -1), ['2', '3']))
                                                                            <div class="col-6">
                                                                                <button
                                                                                    class="seat 
                                                                    @if ($seatData->is_booked == 0) seat-available 
                                                                    @elseif ($seatData->is_booked == 1) seat-selected 
                                                                    @elseif ($seatData->is_booked == 2) seat-booked
                                                                    @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                                    data-seat-id="{{ $seatData->id }}"
                                                                                    data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                                    data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                                    data-seat-no="{{ $seatData->seat_no }}">
                                                                                    {{ $seatData->seat_no }}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--     upper content     -->
                                                <div class="tab-pane fade" id="pills-upper" role="tabpanel"
                                                    aria-labelledby="pills-upper-tab">
                                                    <div class="seat-wrapper">
                                                        <div class="row g-5">
                                                            <div class="col-3">
                                                                <div class="row g-3">
                                                                    @foreach ($seats as $seatData)
                                                                        @if (in_array(substr($seatData->seat_no, -1), ['4']))
                                                                            <div class="col-6">
                                                                                <button
                                                                                    class="seat 
                                                                    @if ($seatData->is_booked == 0) seat-available 
                                                                    @elseif ($seatData->is_booked == 1) seat-selected 
                                                                    @elseif ($seatData->is_booked == 2) seat-booked
                                                                    @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                                    data-seat-id="{{ $seatData->id }}"
                                                                                    data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                                    data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                                    data-seat-no="{{ $seatData->seat_no }}">
                                                                                    {{ $seatData->seat_no }}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="row g-3">
                                                                    @foreach ($seats as $seatData)
                                                                        @if (in_array(substr($seatData->seat_no, -1), ['5', '6']))
                                                                            <div class="col-6">
                                                                                <button
                                                                                    class="seat 
                                                                    @if ($seatData->is_booked == 0) seat-available 
                                                                    @elseif ($seatData->is_booked == 1) seat-selected 
                                                                    @elseif ($seatData->is_booked == 2) seat-booked
                                                                    @elseif ($seatData->is_booked == 3) seat-reserved @endif"
                                                                                    data-seat-id="{{ $seatData->id }}"
                                                                                    data-seat-price="{{ $trip->ticket_price ?? 0 }}"
                                                                                    data-vehicle-id="{{ $trip->vehicle_id ?? 'N/A' }}"
                                                                                    data-seat-no="{{ $seatData->seat_no }}">
                                                                                    {{ $seatData->seat_no }}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Selected Seats and Total Price -->
                                        <div class="mt-4">
                                            <div class="d-flex justify-content-between">
                                                <p class="h5" id="selected-seats-count-{{ $trip->id }}">0
                                                    ticket(s)
                                                    selected</p>
                                                <p class="h5" id="total-price-{{ $trip->id }}">৳ 0</p>
                                            </div>
                                            
                                        <div class="d-flex justify-content-between mt-2">
                                            <button class="btn btn-primary w-50 me-2"
                                                id="continue-button-{{ $trip->id }}"
                                                style="background-color: #E0115F; border-color: #E0115F">
                                                Sell
                                            </button>
                                            {{-- <button class="btn btn-success w-50 me-2" id="sell-button-{{ $trip->id }}" style="background-color: #28a745; border-color: #28a745">
                                                Sell
                                            </button> --}}
                                            <button class="btn btn-primary w-50" id="reserve-button-{{ $trip->id }}" style="background-color: #28a745; border-color: #28a745">
                                                Reserve
                                            </button>
                                        </div>
                                        </div>

                                        @can('reset-seat-list')
                                            <!-- Reset Button -->
                                            <div class="d-flex justify-content-center mt-3 gap-2">
                                                <h5 class="align-self-center mb-0">Reset Seats?</h5>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#resetSeatModal{{ $trip->vehicle->id }}"
                                                    data-vehicle-id="{{ $trip->vehicle->id }}">Reset</button>
                                            </div>
                                        @endcan
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Reset Confirmation Modal -->
                        <div class="modal fade" id="resetSeatModal{{ $trip->vehicle->id }}" data-bs-backdrop="static"
                            tabindex="-1" role="dialog" aria-labelledby="resetSeatModalLabel{{ $trip->vehicle->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="resetSeatModalLabel{{ $trip->vehicle->id }}">Reset
                                            Seats</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to reset the seats?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <a href="{{ route('reset.seat', $trip->vehicle->id) }}"
                                            class="btn btn-warning">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Iterate through each trip
                document.querySelectorAll('.offcanvas').forEach(offcanvas => {
                const tripKey = offcanvas.id.replace('offcanvasRight', ''); // Extract trip key from ID
                const seatButtons = offcanvas.querySelectorAll('.seat');
                const selectedSeatsCount = offcanvas.querySelector(`#selected-seats-count-${tripKey}`);
                const totalPriceDisplay = offcanvas.querySelector(`#total-price-${tripKey}`);
                const continueButton = offcanvas.querySelector(`#continue-button-${tripKey}`);

                let selectedSeats = [];
                let totalPrice = 0;

                // Add click event listeners to seat buttons
                seatButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        if (this.classList.contains('seat-booked')) return;

                        const seatId = this.dataset.seatId;
                        const seatPrice = parseFloat(this.dataset.seatPrice);
                        const seatNo = this.dataset.seatNo;

                        if (this.classList.contains('seat-selected')) {
                            this.classList.remove('seat-selected');
                            this.classList.add('seat-available');
                            selectedSeats = selectedSeats.filter(seat => seat.seatId !== seatId);
                            totalPrice -= seatPrice;
                        } else if (this.classList.contains('seat-available')) {
                            this.classList.add('seat-selected');
                            this.classList.remove('seat-available');
                            selectedSeats.push({
                                seatId,
                                seatNo,
                                seatPrice
                            });
                            totalPrice += seatPrice;
                        }else if (this.classList.contains('seat-reserved')) {
                            this.classList.add('seat-selected');
                            this.classList.remove('seat-reserved');
                            selectedSeats.push({
                                seatId,
                                seatNo,
                                seatPrice
                            });
                            totalPrice += seatPrice;
                        } 


                        selectedSeatsCount.innerText =
                            `${selectedSeats.length} ticket(s) selected`;
                        totalPriceDisplay.innerText = `৳ ${totalPrice.toFixed(2)}`;
                    });
                });

                // Handle reserve button click
                const reserveButton = offcanvas.querySelector(`#reserve-button-${tripKey}`);
                reserveButton.addEventListener('click', function() {
                    if (selectedSeats.length === 0) {
                        alert('No seats selected!');
                        return;
                    }

                    fetch('{{ route('reserve.seats') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            seats: selectedSeats,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selectedSeats.forEach(seat => {
                                const seatButton = offcanvas.querySelector(`[data-seat-id="${seat.seatId}"]`);
                                seatButton.classList.remove('seat-selected');
                                seatButton.classList.add('seat-reserved');
                            });
                            alert('Seats reserved successfully!');
                            selectedSeats = [];
                            totalPrice = 0;
                            selectedSeatsCount.innerText = '0 ticket(s) selected';
                            totalPriceDisplay.innerText = '৳ 0.00';
                        } else {
                            alert('Failed to reserve seats!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while reserving seats!');
                    });
                });

            // Handle continue button click
            continueButton.addEventListener('click', function() {
                if (selectedSeats.length === 0) {
                    alert('No seats selected!');
                    return;
                }

                // Extract trip data
                const tripId = tripKey;
                const vehicleId = offcanvas.querySelector('.seat').dataset.vehicleId || 'N/A';
                const bookingDate = "{{ request('filter_date') }}";

                // Redirect to passenger detail route with necessary data
                const seatsData = encodeURIComponent(JSON.stringify(selectedSeats));
                const url = `{{ route('passenger.detail') }}?trip_id=${tripId}&seats_data=${seatsData}`;
                window.location.href = url;
            });
            });
            
            $(".nav-link").on("click", function(e) {
                e.preventDefault();

                // Remove active class from all tab buttons and contents
                $(".nav-link").removeClass("active");
                $(".tab-pane").removeClass("show active");

                // Add active class to the clicked tab and its corresponding content
                $(this).addClass("active");
                $($(this).data("target")).addClass("show active");
            });
        });
    </script>
@endsection
