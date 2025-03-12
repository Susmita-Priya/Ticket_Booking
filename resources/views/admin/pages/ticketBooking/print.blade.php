<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Online Ticket Booking</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        @page {
            margin-top: 10px !important;
            margin-right: 10px !important;
            padding: 0 10px !important;
            size: A4;
        }

        .ticket {
            position: relative;
            width: 800px;
            /* border-radius: 10px; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: url("{{ public_path('images/ticket/city_bus_bro1.png') }}") no-repeat center center;
            background-size: cover;
        }

        /* .ticket::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/ticket/city_bus_bro.png') }}") no-repeat center center;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.5); 
        } */

        /* style="display: table; width: 800px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 0 auto; background: url("{{ asset('images/ticket/city_bus_bro1.png') }}") no-repeat center center; background-size: cover; " */
        body {
            margin: 0;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; box-sizing:border-box;">
    <div class="row print-section" style="width: 800px">
        <div class="col-12" style="width: 100%;">
            <div class="card" style="background: transparent; border: none;">
                <div class="card-body" style="padding: 0;">
                    <div class="ticket" >
                        <div class="header" style="background-color: #E91E63; color: white; padding: 16px; display: table;">
                            <div class="d-flex align-items-center" style="display: table; box-sizing:border-box; width: 500px;">
                                <div class="company-logo" style="display: table-cell; width: 100px; height:50px; margin-right: 10px; vertical-align: middle;">
                                    {{-- logo dimention should be (100x50)px --}}
                                    @php
                                    $user = auth()->user();
                                    $companyLogo = \App\Models\SiteSetting::where('company_id', $user->id)->orWhere('company_id', $user->is_registration_by)->first()->logo ?? 'backend/images/bb.png';
                                    @endphp
                    {{-- <img src="{{ URL::to($companyLogo) }}" alt="logo" style="height: 50px;"> --}}
                                    <img src="{{ public_path($companyLogo) }}" alt="logo" style=" width: 100px; height:50px; margin-right: 10px; object-fit: contain;">
                                </div>
                                
                                <h1 class="text-nowrap operator text-uppercase" style="display: table-cell; width:400px; white-space: nowrap; margin: 0; font-size: 24px; vertical-align: middle;">
                                    {{ $vehicle->name }}
                                </h1>
                            </div>

                            {{-- <h1 class="text-nowrap operator text-uppercase" style="display: table-cell; white-space: nowrap; width: 500px; margin: 0; font-size: 24px;">
                                {{ $vehicle->name }}</h1> --}}

                            <h1 class="text-nowrap passenger text-uppercase p-3" style="display: table-cell; box-sizing:border-box; white-space: nowrap; width: 300px; margin: 0; font-size: 20px; padding-left: 16px; vertical-align: middle;">
                                Passenger Info</h1>
                        </div>
                        <div class="ticket-details" style="padding: 20px; display: table; gap: 20px;">
                            <div class="left operator" style="display: table-cell; width: 500px;">
                                <h5 style="margin: 0; font-size: 18px;"><strong>
                                        @if ($vehicle->category == '0')
                                            Economy Class
                                        @elseif ($vehicle->category == '1')
                                            Business Class
                                        @elseif ($vehicle->category == '2')
                                            Sleeping Coach
                                        @endif
                                    </strong></h5>
                                <div class="details" style="font-size: 14px; margin-top: 10px;">
                                    <div class="col-12 py-1" style="padding: 5px 0;"><strong>Coach:</strong>
                                        {{ $vehicle->vehicle_no }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>From:</strong>
                                        {{ $trip->route->startCounter->name }}{{ $trip->route->startCounter->counter_no ? ' (' . $trip->route->startCounter->counter_no . ' no)' : '' }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>To:</strong>
                                        {{ $trip->route->endCounter->name }}{{ $trip->route->endCounter->counter_no ? ' (' . $trip->route->endCounter->counter_no . ' no)' : '' }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>Reporting Time:</strong>
                                            {{ \Carbon\Carbon::parse($trip->reporting_time)->format('h:i A') }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Date & Time:</strong>
                                        {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($trip->start_time)->format('h:i A') }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Date & Time:</strong>
                                        {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}, {{ \Carbon\Carbon::parse($trip->end_time)->format('h:i A') }}</div>
                               
                                </div>
                                <table class="table-fixed table mt-3" style="width: 100%; margin-top: 15px;">
                                    <tbody>
                                        <tr>
                                            <td class="col-6" style="width: 50%; padding: 5px 0;">
                                                <strong>Seat:</strong>
                                            </td>
                                            <td style="padding: 5px 0;">
                                                @foreach ($seatsData as $seat)
                                                    {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Ticket Price:</strong></td>
                                            <td style="padding: 5px 0;">
                                                {{ number_format($seatsData[0]['seatPrice'], 2) }} BDT
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Quantity:</strong></td>
                                            <td style="padding: 5px 0;">{{ count($seatsData) }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Total:</strong></td>
                                            <td style="padding: 5px 0;">
                                                <strong>{{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }}
                                                    BDT
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="line" style="border-left: 1px dotted #E91E63; margin: 0 20px; display: table-cell;"></div>
                            <div class="right passenger ps-3" style="width: 300px; padding-left: 20px; display: table-cell;">
                                {{-- <h5 style="margin: 0; font-size: 18px;"><strong>Economy Class</strong></h5> --}}
                                <h5 style="margin: 0; font-size: 18px;"><strong>
                                    @if ($vehicle->category == '0')
                                        Economy Class
                                    @elseif ($vehicle->category == '1')
                                        Business Class
                                    @elseif ($vehicle->category == '2')
                                        Sleeping Coach
                                    @endif
                                </strong></h5>
                                <div class="details" style="font-size: 14px; margin-top: 10px;">
                                    <div class="py-1" style="padding: 5px 0;"><strong>Name:</strong>
                                        {{ $passenger_name ?? 'N/A' }}</div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Phone:</strong>
                                        {{ $passenger_phone }}</div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Coach:</strong>
                                        {{ $vehicle->name }} - {{ $vehicle->vehicle_no }}
                                    </div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>From:</strong>
                                        {{ $trip->route->startCounter->name }}{{ $trip->route->startCounter->counter_no ? ' (' . $trip->route->startCounter->counter_no . ' no)' : '' }}</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>To:</strong>
                                        {{ $trip->route->endCounter->name }}{{ $trip->route->endCounter->counter_no ? ' (' . $trip->route->endCounter->counter_no . ' no)' : '' }}</div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Date:</strong>
                                            {{ \Carbon\Carbon::parse($trip->start_date)->format('d M Y') }}</div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Date:</strong>
                                            {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}</div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Time:</strong>
                                            {{ \Carbon\Carbon::parse($trip->start_time)->format('h:i A') }}</div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Time:</strong>
                                            {{ \Carbon\Carbon::parse($trip->end_time)->format('h:i A') }}</div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Seat:</strong>
                                        @foreach ($seatsData as $seat)
                                            {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                        @endforeach
                                    </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Price:</strong>
                                        {{ number_format($seatsData[0]['seatPrice'], 2) }} BDT X {{ count($seatsData) }} </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Total: </strong>
                                        {{ number_format(array_sum(array_column($seatsData, 'seatPrice')), 2) }} BDT
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>