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

    .seat-reserved {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
    }

    .seat-reserved-disable {
        background: #28a745;
        color: #fff;
        border-color: #28a745;
        cursor: not-allowed;
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
                        <li class="breadcrumb-item active">Ticket Booking!</li>
                    </ol>
                </div>
                <h4 class="page-title">Ticket Booking!</h4>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 60px;">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between g-3 align-items-end">
                    <form method="GET" action="{{ route('ticket_booking.section') }}" class="d-flex w-100">
                        <div class="col-md-1">
                            <label for="vehicle_id" class="form-label"></label>
                        </div>
                        <div class="col-md-4 me-3">
                            <label for="route_id" class="form-label">Route</label>
                            <div class="dropdown">
                                <button
                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                    type="button" id="routeDropdownButton" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="text-align: left; padding-left: 10px; background-color: white;">
                                    @if ($route)
                                        <span id="selected-route">{{ $route->fromLocation->name }} to
                                            {{ $route->toLocation->name }}</span>
                                    @else
                                        <span id="selected-route">Select Route</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu pt-0" aria-labelledby="routeDropdownButton" style="width: 100%;">
                                    <input type="text" class=" from-select form-control mb-2" placeholder="Search..."
                                        id="route-search" oninput="handleRouteSearch()"
                                        style="width: 100%; padding-left: 10px;">
                                    @foreach ($routes as $rte)
                                        <li><a class="dropdown-item route-dropdown-item" href="#"
                                                data-id="{{ $rte->id }}"
                                                data-name="{{ $rte->fromLocation->name }} to {{ $rte->toLocation->name }}">
                                                {{ $rte->fromLocation->name }} to {{ $rte->toLocation->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" id="route" name="route_id" value="{{ request('route_id') }}">
                        </div>
                        <script>
                            function handleRouteSearch() {
                                const searchInput = document.getElementById('route-search');
                                const filter = searchInput.value.toLowerCase();
                                const items = document.querySelectorAll('.route-dropdown-item');
                                items.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(filter) ? "block" : "none";
                                });
                            }
                            document.querySelectorAll('.route-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedRoute = event.target;
                                    const routeName = selectedRoute.getAttribute('data-name');
                                    const routeId = selectedRoute.getAttribute('data-id');
                                    document.getElementById('selected-route').textContent = routeName;
                                    document.getElementById('route').value = routeId;
                                    document.getElementById('routeDropdownButton').click();
                                });
                            });
                        </script>

                        <div class="col-md-4 me-3">
                            <label for="filter_date" class="form-label">date</label>
                            <input type="date" id="filter_date" name="filter_date" class="form-control"
                                value="{{ request('filter_date') ?: date('Y-m-d') }}">
                        </div>

                        <div class="col-md-2 me-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-50">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <h3 class="text-center"> Vehicle List</h3>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Vehicle</th>
                            <th>Category</th>
                            <th>Start Counter</th>
                            <th>End Counter</th>
                            <th>Start Date & Time</th>
                            <th>End Date & Time</th>
                            <th>Ticket Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $trip)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-wrap">{{ $trip->company->name ?? 'N/A' }}</td>
                                <td>{{ $trip->vehicle->name ?? 'N/A' }} <br>
                                    (Coach : {{ $trip->vehicle->vehicle_no ?? 'N/A' }})
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

                                @if ($trip->route)
                                    <td>{{ $trip->route->startCounter->name }}{{ $trip->route->startCounter->counter_no ? ' (' . $trip->route->startCounter->counter_no . ' no)' : '' }}
                                    </td>
                                    <td>{{ $trip->route->endCounter->name }}{{ $trip->route->endCounter->counter_no ? ' (' . $trip->route->endCounter->counter_no . ' no)' : '' }}
                                    </td>
                                @else
                                    <td>N/A</td>
                                    <td>N/A</td>
                                @endif

                                {{-- <td>{{ $trip->start_date }}</td>
                        <td>{{ $trip->end_date }}</td>
                        <td>{{ $trip->start_time }}</td>
                        <td>{{ $trip->end_time }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($trip->start_date . ' ' . $trip->start_time)->format('d-m-Y h:i A') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($trip->end_date . ' ' . $trip->end_time)->format('d-m-Y h:i A') }}
                                </td>
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
                                    <h5 class="offcanvas-title" id="offcanvasRightLabel{{ $trip->id }}">Book
                                        Tickets</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <!-- Seat Box -->
                                    <div class="seat-box p-4 bg-white">
                                        <div class="seat-wrapper">
                                            <div class="text-center mb-3">
                                                <h3>{{ $trip->vehicle->name }}</h3>
                                                <h5>(Coach : {{ $trip->vehicle->vehicle_no ?? 'N/A' }})
                                                </h5>
                                                <h5>
                                                    @if ($trip->route)
                                                        <h5>{{ $trip->route->name }}</h5>
                                                    @else
                                                        <h5>No route available</h5>
                                                    @endif
                                                </h5>
                                                <p><strong></strong>
                                                    {{ \Carbon\Carbon::parse($trip->start_date . ' ' . $trip->start_time)->format('d M Y h:i A') }}
                                                </p>
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
                                                                            data-seat-no="{{ $seatData->seat_no }}"
                                                                            data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                            data-seat-no="{{ $seatData->seat_no }}"
                                                                            data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                            data-seat-no="{{ $seatData->seat_no }}"
                                                                            data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                            data-seat-no="{{ $seatData->seat_no }}"
                                                                            data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                            aria-controls="pills-upper"
                                                            aria-selected="false">Upper</button>
                                                    </li>
                                                </ul>

                                                <div class="tab-content" id="pills-tabContent">
                                                    <!--    lower content      -->
                                                    <div class="tab-pane fade show active" id="pills-lower"
                                                        role="tabpanel" aria-labelledby="pills-lower-tab">
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
                                                                                        data-seat-no="{{ $seatData->seat_no }}"
                                                                                        data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                                        data-seat-no="{{ $seatData->seat_no }}"
                                                                                        data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                                        data-seat-no="{{ $seatData->seat_no }}"
                                                                                        data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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
                                                                                        data-seat-no="{{ $seatData->seat_no }}"
                                                                                        data-is_reserved_by="{{ $seatData->is_reserved_by }}">
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

                                                    <button class="btn btn-primary w-50"
                                                        id="reserve-button-{{ $trip->id }}"
                                                        style="background-color: #28a745; border-color: #28a745">
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
                            <div class="modal fade" id="resetSeatModal{{ $trip->vehicle->id }}"
                                data-bs-backdrop="static" tabindex="-1" role="dialog"
                                aria-labelledby="resetSeatModalLabel{{ $trip->vehicle->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="resetSeatModalLabel{{ $trip->vehicle->id }}">
                                                Reset
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
        </div>
    </div>
            @if ($trips->isEmpty())
                <div class="text-center">
                    {{-- <h4>No data found</h4> --}}
                </div>
            @else
                <!-- Passenger Modal -->
                <div class="modal fade" id="passengerModal" tabindex="-1" aria-labelledby="passengerModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <h3 class="text-center mt-1">{{ $trip->vehicle->name }} </h3>
                            <h4 class="text-center">
                                @if ($trip->vehicle->category == '0')
                                    Economy Class
                                @elseif ($trip->vehicle->category == '1')
                                    Business Class
                                @elseif ($trip->vehicle->category == '2')
                                    Sleeping Coach
                                @endif
                            </h4>
                            <div class="modal-header">

                                <h5 class="modal-title" id="passengerModalLabel">Enter Passenger Details</h5>

                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form id="passenger-form" method="POST"
                                            action="{{ route('ticket_booking.store') }}">
                                            @csrf
                                            <input type="hidden" id="trip-id" name="trip_id">
                                            <input type="hidden" id="seats-data" name="seats_data">
                                            <input type="hidden" id="vehicle-id" name="vehicle_id">
                                            <input type="hidden" id="travel-date" name="travel_date">

                                            <div class="mb-3">
                                                <label for="passenger-name" class="form-label">Passenger Name</label>
                                                <input type="text" id="passenger-name" name="passenger_name"
                                                    class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label for="passenger-phone" class="form-label">Passenger Phone<span
                                                        style="color: red;">*</span></label>
                                                <input type="text" id="passenger-phone" name="passenger_phone"
                                                    class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="payment-method" class="form-label">Payment Method<span
                                                        style="color: red;">*</span></label>
                                                <select id="payment-method" name="payment_method" class="form-select"
                                                    required>
                                                    <option value="cash">Cash</option>
                                                    <option value="card">Card</option>
                                                    <option value="mobile_banking">Mobile Banking</option>
                                                </select>
                                            </div>

                                            <div class="mb-3" id="transaction-id-field" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="banking_type" class="form-label">Banking Type<span
                                                            style="color: red;">*</span></label>
                                                    <select id="banking_type" name="banking_type" class="form-select">
                                                        <option value="bKash">bKash</option>
                                                        <option value="Nagad">Nagad</option>
                                                        <option value="Rocket">Rocket (Dutch-Bangla Bank)</option>
                                                        <option value="Upay">Upay</option>
                                                        <option value="others">Others</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="transaction_id" class="form-label">Transaction ID<span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" id="transaction_id" name="transaction_id"
                                                        class="form-control" placeholder="XXXXXXXXXX">
                                                </div>
                                            </div>

                                            <div class="mb-3" id="card-id-field" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="card-id" class="form-label">Card Number<span
                                                            style="color: red;">*</span></label>
                                                    <input type="text" id="card-id" name="card_number"
                                                        class="form-control" placeholder="XXXX XXXX XXXX XXXX">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="expirationdate" class="form-label">Expiration
                                                        (mm/yy)<span style="color: red;">*</span></label>
                                                    <input id="expirationdate" type="text" pattern="\d{2}/\d{4}"
                                                        name="card_expiry" inputmode="numeric" class="form-control"
                                                        placeholder="MM/YYYY">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="securitycode" class="form-label">Security Code<span
                                                            style="color: red;">*</span></label>
                                                    <input id="securitycode" type="text" pattern="[0-9]*"
                                                        name=security_code inputmode="numeric" class="form-control"
                                                        placeholder="XXX">
                                                </div>
                                            </div>

                                            <script>
                                                document.getElementById('payment-method').addEventListener('change', function() {
                                                    const transactionIdField = document.getElementById('transaction-id-field');
                                                    const cardIdField = document.getElementById('card-id-field');
                                                    const cardIdInput = document.getElementById('card-id');
                                                    const expirationDateInput = document.getElementById('expirationdate');
                                                    const securityCodeInput = document.getElementById('securitycode');
                                                    const transactionIdInput = document.getElementById('transaction_id');
                                                    const bankingTypeInput = document.getElementById('banking_type');

                                                    // Reset all required attributes
                                                    cardIdInput.required = false;
                                                    expirationDateInput.required = false;
                                                    securityCodeInput.required = false;
                                                    transactionIdInput.required = false;
                                                    bankingTypeInput.required = false;

                                                    if (this.value === 'cash') {
                                                        transactionIdField.style.display = 'none';
                                                        cardIdField.style.display = 'none';
                                                    } else if (this.value === 'card') {
                                                        cardIdField.style.display = 'block';
                                                        cardIdInput.required = true;
                                                        cardIdInput.minLength = 16;
                                                        expirationDateInput.required = true;
                                                        securityCodeInput.required = true;
                                                        transactionIdField.style.display = 'none';
                                                    } else {
                                                        transactionIdField.style.display = 'block';
                                                        transactionIdInput.required = true;
                                                        transactionIdInput.minLength = 10;
                                                        bankingTypeInput.required = true;
                                                        cardIdField.style.display = 'none';
                                                    }
                                                });
                                            </script>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary"
                                                    id="book-button-{{ $trip->id }}">Book Tickets</button>
                                            </div>
                                            {{-- <script>
                                        document.getElementById('book-button-{{ $trip->id }}').addEventListener('click', function() {
                                            const modal = document.getElementById('passengerModal');
                                            const bootstrapModal = bootstrap.Modal.getInstance(modal);
                                            bootstrapModal.hide();
                                        });
                                    </script> --}}
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="header-title">Booking Details</h4>
                                                <ul type="none">
                                                    <li><strong>Coach : </strong> {{ $trip->vehicle->vehicle_no }}</li>
                                                    <li><strong>Travel Date : </strong>
                                                        {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }}
                                                    </li>
                                                    <li><strong>Start Time : </strong>
                                                        {{ \Carbon\Carbon::parse($trip->start_time)->format('h:i A') }}
                                                    </li>
                                                    <li><strong>From : </strong>
                                                        {{ $trip->route->startCounter->name }}{{ $trip->route->startCounter->counter_no ? ' (' . $trip->route->startCounter->counter_no . ' no)' : '' }}
                                                    </li>
                                                    <li><strong>To : </strong>
                                                        {{ $trip->route->endCounter->name }}{{ $trip->route->endCounter->counter_no ? ' (' . $trip->route->endCounter->counter_no . ' no)' : '' }}
                                                    </li>
                                                </ul>

                                                <h4 class="header-title">Selected Seats</h4>
                                                <ul id="selected-seats-list">
                                                    <!-- Seats will be populated by JavaScript -->
                                                </ul>
                                                <h4 class="header-title">Total Price : ৳ <span
                                                        id="total-price-modal">0.00</span>
                                                </h4>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- ticket modal -->
                {{-- <div class="modal fade" id="downloadTicketModal" tabindex="-1" role="dialog"
            aria-labelledby="downloadTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="downloadTicketModalLabel">Download Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to download the ticket?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <a href={{ route('generate.pdf') }} id="download-link" class="btn btn-primary">Yes, Download</a>
                    </div>
                </div>
            </div>
        </div> --}}
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
                        // const bookButton = document.getElementById(`book-button-${tripKey}`);
                        const authUserId = "{{ auth()->user()->id }}";
                        const dateField = document.getElementById('filter_date');
                        dateField.value = '{{ $trip->start_date ?? '' }}';

                        let selectedSeats = [];
                        let totalPrice = 0;

                        // Add click event listeners to seat buttons
                        seatButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                if (this.classList.contains('seat-booked')) return;

                                const seatId = this.dataset.seatId;
                                const seatPrice = parseFloat(this.dataset.seatPrice);
                                const seatNo = this.dataset.seatNo;
                                const isReservedBy = this.dataset.is_reserved_by;

                                if (this.classList.contains('seat-selected')) {
                                    this.classList.remove('seat-selected');
                                    this.classList.add('seat-available');
                                    selectedSeats = selectedSeats.filter(seat => seat.seatId !==
                                        seatId);
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
                                } else if (this.classList.contains('seat-reserved')) {
                                    if (isReservedBy == authUserId) {

                                        Swal.fire({
                                            title: 'This seat is reserved by you.',
                                            text: 'Are you sure you want to select this seat?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, select it!',
                                            cancelButtonText: 'Remove reservation'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                this.classList.add('seat-selected');
                                                this.classList.remove('seat-reserved');
                                                selectedSeats.push({
                                                    seatId,
                                                    seatNo,
                                                    seatPrice
                                                });
                                                totalPrice += seatPrice;
                                                selectedSeatsCount.innerText =
                                                    `${selectedSeats.length} ticket(s) selected`;
                                                totalPriceDisplay.innerText =
                                                    `৳ ${totalPrice.toFixed(2)}`;

                                            } else if (result.dismiss === Swal.DismissReason
                                                .cancel) {
                                                selectedSeats.push({
                                                    seatId,
                                                    seatNo,
                                                    seatPrice
                                                });
                                                fetch('{{ route('cancel.reservation') }}', {
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
                                                            const seatButton = offcanvas
                                                                .querySelector(
                                                                    `[data-seat-id="${seatId}"]`
                                                                );
                                                            seatButton.classList.remove(
                                                                'seat-reserved');
                                                            seatButton.classList.add(
                                                                'seat-available');
                                                            toastr.success(
                                                                'Reservation cancelled successfully!'
                                                            );
                                                            selectedSeats = [];
                                                            totalPrice = 0;
                                                            selectedSeatsCount
                                                                .innerText =
                                                                '0 ticket(s) selected';
                                                            totalPriceDisplay
                                                                .innerText = '৳ 0.00';
                                                            // window.location.reload();
                                                        } else {
                                                            toastr.error(
                                                                'Failed to cancel reservation!'
                                                            );
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error:', error);
                                                        toastr.error(
                                                            'An error occurred while cancelling reservation!'
                                                        );
                                                    });
                                            }
                                        });
                                    } else {
                                        // Seat is reserved by another user
                                        button.style.cursor = 'not-allowed';

                                        fetch(
                                                `/show/users/${isReservedBy}`)
                                            .then(response => {
                                                if (!response.ok) {
                                                    throw new Error(
                                                        'Failed to fetch user data');
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                button.setAttribute('title',
                                                    `Reserved by: ${data.username}`);
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Reserved Seat',
                                                    html: `This seat is reserved by user : <strong style="color: blue;">${data.username}</strong>`,
                                                });
                                            })
                                            .catch(error => {
                                                console.error('Error fetching user data:',
                                                    error);
                                                // Fallback tooltip if fetching fails
                                                button.setAttribute('title',
                                                    `Reserved by user: ${isReservedBy}`);
                                            });
                                    }
                                } else {
                                    return;
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
                                toastr.error('No seats selected!');
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
                                            const seatButton = offcanvas.querySelector(
                                                `[data-seat-id="${seat.seatId}"]`);
                                            seatButton.classList.remove('seat-selected');
                                            seatButton.classList.add('seat-reserved');
                                        });
                                        toastr.success('Seats reserved successfully!');
                                        selectedSeats = [];
                                        totalPrice = 0;
                                        selectedSeatsCount.innerText = '0 ticket(s) selected';
                                        totalPriceDisplay.innerText = '৳ 0.00';
                                        isReservedBy = authUserId;
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 100);
                                    } else {
                                        toastr.error('Failed to reserve seats!');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    toastr.error('An error occurred while reserving seats!');
                                });
                        });

                        // Handle continue button click
                        continueButton.addEventListener('click', function() {
                            if (selectedSeats.length === 0) {
                                toastr.error('No seats selected!');
                                return;
                            }

                            // Extract trip data
                            const tripId = tripKey;
                            const vehicleId = offcanvas.querySelector('.seat').dataset.vehicleId || 'N/A';

                            // Populate and show the modal
                            const modal = document.getElementById('passengerModal');
                            const seatsInput = modal.querySelector('#seats-data');
                            const tripIdInput = modal.querySelector('#trip-id');
                            const vehicleIdInput = modal.querySelector('#vehicle-id');
                            const travelDateInput = modal.querySelector('#travel-date');

                            seatsInput.value = JSON.stringify(selectedSeats);
                            tripIdInput.value = tripId;
                            vehicleIdInput.value = vehicleId;
                            travelDateInput.value = dateField.value;


                            // Populate selected total seats list and total price in the modal
                            const selectedSeatsList = modal.querySelector('#selected-seats-list');
                            const totalPriceModal = modal.querySelector('#total-price-modal');
                            selectedSeatsList.innerHTML = '';
                            selectedSeats.forEach(seat => {
                                const li = document.createElement('li');
                                li.textContent = `${seat.seatNo} - ৳${seat.seatPrice.toFixed(2)}`;
                                selectedSeatsList.appendChild(li);
                            });
                            totalPriceModal.textContent = totalPrice.toFixed(2);

                            // Show modal
                            const bootstrapModal = new bootstrap.Modal(modal);
                            bootstrapModal.show();

                            // Close offcanvas
                            const bootstrapOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
                            bootstrapOffcanvas.hide();
                        });

                        // Handle book button click

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
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll("form").forEach(form => {
                        form.addEventListener("submit", function() {
                            const modal = this.closest(".modal"); // Get the modal wrapping this form
                            const bootstrapModal = bootstrap.Modal.getInstance(modal);
                            if (bootstrapModal) {
                                bootstrapModal.hide(); // Close the modal
                            }
                            setTimeout(function() {
                                location.reload(); // Reload the page
                            }, 2000);
                        });
                    });
                });
            </script>
        @endsection
