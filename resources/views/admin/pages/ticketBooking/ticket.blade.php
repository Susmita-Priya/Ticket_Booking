@extends('admin.app')

@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Print Ticket (This is one time)</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($vehicle)  
                   
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="text-center">{{ $vehicle->name }}</h3>
                    <h4 class="text-center">
                        @if ($vehicle->category == '0')
                            Economy Class
                        @elseif ($vehicle->category == '1')
                            Business Class
                        @elseif ($vehicle->category == '2')
                            Sleeping Coach
                        @endif
                    </h4>
                                    <h4 class="header-title">Booking Details</h4>
                                    <ul type="none">
                                        <li><strong>Passenger Name:</strong> {{ $passenger_name }}</li>
                                        <li><strong>Passenger Phone:</strong> {{ $passenger_phone }}</li>
                                        <li><strong>Coach:</strong> {{ $vehicle->vehicle_no }}</li>
                                        <li><strong>Travel Date:</strong> {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</li>
                                        <li><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</li>
                                        <li><strong>From:</strong> {{ $route->startCounter->name }}</li>
                                        <li><strong>To:</strong> {{ $route->endCounter->name }}</li>
                                    </ul>

                                    <h4 class="header-title">Selected Seats</h4>
                                    <ul>
                                        @foreach ($seatsData as $seat)
                                            <li>Seat {{ $seat['seatNo'] }} - ৳ {{ number_format($seat['seatPrice'], 2) }}</li>
                                        @endforeach
                                    </ul>
                                    <h4 class="header-title">Total Price: ৳ {{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center">
            <button onclick="window.print()" class="btn btn-primary">Print Ticket</button>
            @endif
            <a href="{{ route('ticket_booking.section') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .btn {
                display: none;
            }
        }
    </style>
@endsection