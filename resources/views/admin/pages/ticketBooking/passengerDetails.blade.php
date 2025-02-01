@extends('admin.app')

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
                            <form method="POST" action="{{ route('ticket_booking.store') }}">
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
@endsection
