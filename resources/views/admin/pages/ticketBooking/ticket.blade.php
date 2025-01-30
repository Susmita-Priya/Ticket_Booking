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
                        {{-- <div class="row">
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
                                            <li><strong>Travel Date:</strong>
                                                {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</li>
                                            <li><strong>Departure Time:</strong>
                                                {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</li>
                                            <li><strong>From:</strong> {{ $route->startCounter->name }}</li>
                                            <li><strong>To:</strong> {{ $route->endCounter->name }}</li>
                                        </ul>

                                        <h4 class="header-title">Selected Seats</h4>
                                        <ul>
                                            @foreach ($seatsData as $seat)
                                                <li>Seat {{ $seat['seatNo'] }} - ৳
                                                    {{ number_format($seat['seatPrice'], 2) }}</li>
                                            @endforeach
                                        </ul>
                                        <h4 class="header-title">Total Price: ৳
                                            {{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="ticket mx-auto">
                            <div class="header d-flex align-items-center">
                                <h3 class="text-nowrap operator text-uppercase">{{ $vehicle->name }}</h3>
                                <h4 class="text-nowrap passenger text-uppercase p-3">Passenger Info</h4>
                            </div>
                            <div class="ticket-details p-3 d-flex">
                                <div class="left operator">
                                    <h5><strong>@if ($vehicle->category == '0')
                                        Economy Class
                                    @elseif ($vehicle->category == '1')
                                        Business Class
                                    @elseif ($vehicle->category == '2')
                                        Sleeping Coach
                                    @endif</strong></h5>
                                    <div class="details row">
                                        <div class="col-12 py-1"><strong>Coach:</strong> {{ $vehicle->vehicle_no }}</div>
                                        <div class="col-6 py-1"><strong>From:</strong> {{ $route->startCounter->name }}</div>
                                        <div class="col-6 py-1"><strong>To:</strong> {{ $route->endCounter->name }}</div>
                                        <div class="col-6 py-1"><strong>Travel Date:</strong> {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</div>
                                        <div class="col-6 py-1"><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</div>
                                        
                                    </div>
                                    <table class="table-fixed table mt-3">
                                        <tbody>
                                            <tr>
                                                <td class="col-6"><strong>Seat:</strong></td>
                                                <td>@foreach ($seatsData as $seat)
                                                    {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                                @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price:</strong></td>
                                                <td>{{ number_format($seat['seatPrice'], 2) }} BDT</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong>{{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }} BDT</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    {{-- <div class="barcode">Ticket No: AA00123456 897 37</div> --}}
                                </div>
                                <div class="right passenger ps-3">
                                    <h5 class=""><strong>Economy Class</strong></h5>
                                    <div class="details">
                                        <div class="py-1"><strong>Name:</strong> {{ $passenger_name }}</div>
                                        <div class="py-1"><strong>Phone:</strong> {{ $passenger_phone }}</div>
                                        <div class="py-1"><strong>Coach:</strong> {{ $vehicle->name }}</div>
                                        <div class="py-1"><strong>From:</strong> {{ $route->startCounter->name }}</div>
                                        <div class="py-1"><strong>To:</strong> {{ $route->endCounter->name }}</div>
                                        <div class="py-1"><strong>Travel Date:</strong>{{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</div>
                                        <div class="py-1"><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse($trip->time)->format('h:i A') }}</div>
                                        <div class="py-1"><strong>Seat:</strong> @foreach ($seatsData as $seat)
                                            {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                         @endforeach</div>
                                    </div>
                                    {{-- <div class="barcode">Ticket No: AA00123456 897 37</div> --}}
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
        .ticket {
        background: white;
        width: 800px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .operator {
        width: 500px;
    }

    .passenger {
        width: 300px;
    }

    .header {
        background-color: #E91E63;
        color: white;
        padding: 16px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .details {
        font-size: 14px;
    }

    .ticket-details {
        gap: 5px;
    }
        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
            }

            .btn {
                display: none;
            }
        }
    </style>
@endsection
