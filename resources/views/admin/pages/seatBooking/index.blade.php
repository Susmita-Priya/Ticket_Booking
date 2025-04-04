@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Seat Booking List</li>
                    </ol>
                </div>
                <h4 class="page-title">Seat Booking List</h4>
            </div>
        </div>
    </div>

    <div class="row" style="margin-bottom: 60px;">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between g-3 align-items-end">
                    <form method="GET" action="{{ route('seat_booking.section') }}" class="d-flex w-100">
                        <div class="col-md-1">
                            <label class="form-label"></label>
                        </div>
                        <div class="col-md-4 me-3">
                            <label for="vehicle_id" class="form-label">Vehicle</label>
                            <div class="dropdown">
                                <button
                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                    type="button" id="vehicleDropdownButton" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="text-align: left; padding-left: 10px; background-color: white;">
                                    @if($vehicle)
                                        <span id="selected-vehicle">{{ $vehicle->name }} ( Coach - {{ $vehicle->vehicle_no }})</span>
                                    @else
                                        <span id="selected-vehicle">Select Vehicle</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu pt-0" aria-labelledby="vehicleDropdownButton" style="width: 100%;">
                                    <input type="text" class=" from-select form-control mb-2" placeholder="Search..."
                                        id="vehicle-search" oninput="handleVehicleSearch()"
                                        style="width: 100%; padding-left: 10px;">
                                    @foreach ($vehicles as $vcle)
                                        <li><a class="dropdown-item vehicle-dropdown-item" href="#"
                                                data-id="{{ $vcle->id }}"
                                                data-name="{{ $vcle->name }} ( Coach - {{ $vcle->vehicle_no }})">
                                                {{ $vcle->name }} ( Coach - {{ $vcle->vehicle_no }})</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" id="vehicle" name="vehicle_id" value="{{ request('vehicle_id') }}">
                        </div>
                        <script>
                            function handleVehicleSearch() {
                                const searchInput = document.getElementById('vehicle-search');
                                const filter = searchInput.value.toLowerCase();
                                const items = document.querySelectorAll('.vehicle-dropdown-item');
                                items.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(filter) ? "block" : "none";
                                });
                            }
                            document.querySelectorAll('.vehicle-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedVehicle = event.target;
                                    const vehicleName = selectedVehicle.getAttribute('data-name');
                                    const vehicleId = selectedVehicle.getAttribute('data-id');
                                    document.getElementById('selected-vehicle').textContent = vehicleName;
                                    document.getElementById('vehicle').value = vehicleId;
                                    document.getElementById('vehicleDropdownButton').click();
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
            <div class="card-body table-responsive">
                @if($vehicle)
                    <h3 class="text-center"> {{ $vehicle->name }} (Coach - {{ $vehicle->vehicle_no }})</h3>
                    <p class="text-center">Total Payment : <span style="color: green;"><strong>{{ $total_payment }} TK</strong></span></p>
                @endif
                
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Vehicle</th>
                            <th>Seat No</th>
                            <th>Booking Date</th>
                            <th>Payment Method</th>
                            <th>Payment Amount</th>
                            <th>Passenger Name</th>
                            <th>Passenger Phone</th>
                            <th>Booked By</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $key = 0;
                        @endphp
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $booking->vehicle->name ?? "N/A"}} <br>
                                    Vehicle No : {{ $booking->vehicle->vehicle_no ?? "N/A"}}</td>
                                <td>
                                    @php $totalTicketPrice = 0; @endphp
                                    @foreach (json_decode($booking->seat_data) as $seat)
                                        {{ $seat->seatNo }}<br>
                                        @php
                                        $seatPrice = $seat->seatPrice; 
                                        $totalTicketPrice += $seatPrice;
                                        @endphp
                                    @endforeach
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->travel_date)->format('d-m-Y') }}</td>
                                <td>
                                    @if ($booking->payments && $booking->payments->payment_method == 'card')
                                        {{ "Card" }}
                                        <br>Card Number: {{ $booking->payments->card_number ?? 'N/A' }}
                                        <br>Expiry: {{ $booking->payments->card_expiry ?? 'N/A' }}
                                        <br>Security Code: {{ $booking->payments->security_code ?? 'N/A' }}
                                    @elseif ($booking->payments && $booking->payments->payment_method == 'mobile_banking')
                                        {{ "Mobile Banking" }}
                                        <br>Transaction ID: {{ $booking->payments->transaction_id ?? 'N/A' }}
                                        <br>Banking Type: {{ $booking->payments->banking_type ?? 'N/A' }}
                                    @elseif ($booking->payments && $booking->payments->payment_method == 'cash')
                                        {{ "Cash" }}
                                    @else
                                        {{ "N/A" }}
                                    @endif
                                </td>
                                <td><strong>Total Price: <span class="text-danger">{{ $totalTicketPrice }} TK</span> </strong></br>
                                    (Ticket Price : {{ $seatPrice }} TK)</td>
                                <td>{{ $booking->passenger_name ?? 'N/A' }}</td>
                                <td>{{ $booking->passenger_phone }}</td>
                                <td>{{ $booking->company->name }}</td>
                                <td>
                                    @if ($booking->type == 'Counter')
                                        <span class="badge bg-warning">Counter</span>
                                    @elseif ($booking->type == 'App')
                                        <span class="badge bg-success">App</span>
                                    @else
                                        <span class="badge bg-secondary">Unknown</span>
                                    @endif
                                </td>
                                
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1 ">
                                        {{-- @can('seats-edit')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$booking->id}}">Edit</button>
                                        @endcan --}}
                                        @can('ticket-print')
                                            <a href="{{ route('generate.pdf', $booking->id) }}"
                                                class="btn btn-primary btn-sm">Print</a>
                                        @endcan
                                        @can('booking-delete')
                                            <a href="{{ route('seat_booking.destroy', $booking->id) }}"
                                                class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $booking->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

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
