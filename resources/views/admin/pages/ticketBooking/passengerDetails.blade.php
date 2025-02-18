{{-- @extends('admin.app')

@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Passenger Details</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-center">{{ $trip->vehicle->name }} </h3>
                    <h4 class="text-center"> @if ($trip->vehicle->category == '0')
                        Economy Class
                    @elseif ($trip->vehicle->category == '1')
                        Business Class
                    @elseif ($trip->vehicle->category == '2')
                        Sleeping Coach
                    @endif </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('ticket_booking.store') }}" id="booking-form">
                                @csrf
                                <input type="hidden" id="trip-id" name="trip_id" value="{{ $trip->id }}">
                                <input type="hidden" id="seats-data" name="seats_data" value="{{ json_encode($seatsData) }}">
                                <input type="hidden" id="vehicle-id" name="vehicle_id" value="{{ $trip->vehicle->id }}">
                                <input type="hidden" id="booking-date" name="booking_date" value="{{ $trip->date }}">
                                <input type="hidden" name="selected_seats" value="{{ json_encode($seatsData) }}">

                                <div class="mb-3">
                                    <label for="passenger_name" class="form-label">Passenger Name</label>
                                    <input type="text" id="passenger_name" name="passenger_name" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="passenger_phone" class="form-label">Passenger Phone <span style="color: red;">*</span></label>
                                    <input type="text" id="passenger_phone" name="passenger_phone" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Booking Details</h4>
                                    <ul type="none">
                                        <li><strong>Coach : </strong> {{ $trip->vehicle->vehicle_no }}</li>
                                        <li><strong>Travel Date : </strong> {{ \Carbon\Carbon::parse($trip->date)->format('d M Y') }}</li>
                                        <li><strong>Departure Time : </strong> {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</li>
                                        <li><strong>From : </strong> {{ $trip->route->startCounter->name }}</li>
                                        <li><strong>To : </strong> {{ $trip->route->endCounter->name }}</li>
                                    </ul>

                                    <h4 class="header-title">Selected Seats</h4>
                                    <ul>
                                        @foreach ($seatsData as $seat)
                                            <li>Seat {{ $seat['seatNo'] }} - ৳ {{ number_format($seat['seatPrice'], 2) }}</li>
                                        @endforeach
                                    </ul>
                                    <h4 class="header-title">Total Price : ৳ {{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }}</h4>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Download Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you want to download the ticket?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="{{ route('generate.pdf') }}" id="download-link" class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
    @section('scripts')
    <script>
        document.getElementById('booking-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
    
            // Show the confirmation modal
            $('#confirmationModal').modal('show');
        });
    
        document.getElementById('download-link').addEventListener('click', function(event) {
            // Submit the form after the download link is clicked
            document.getElementById('booking-form').submit();
        });
    </script>
@endsection --}}
