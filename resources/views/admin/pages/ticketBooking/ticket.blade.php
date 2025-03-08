{{-- <!DOCTYPE html>
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
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: url("{{ asset('images/ticket/city_bus_bro1.png') }}") no-repeat center center;
            background-size: cover;
        }

        .ticket::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ asset('images/ticket/city_bus_bro1.png') }}") no-repeat center center;
            background-size: cover;
            background-color: rgba(255, 255, 255, 0.5); 
            z-index: -1;
            opacity: 0.2;
        }

        style="display: table; width: 800px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 0 auto;background: url("{{ asset('images/ticket/city_bus_bro1.png') }}") no-repeat center center; background-size: cover;"

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
                    <div class="ticket">
                        <div class="header" style="background-color: #E91E63; color: white; padding: 16px; display: table;">
                            <div class="d-flex align-items-center" style="display: table; box-sizing:border-box; width: 500px;">
                                <div class="company-logo" style="display: table-cell; width: 100px; height:50px; margin-right: 10px; vertical-align: middle;">
                                    <img src="{{ asset('images/ticket/company-logo.png') }}" alt="logo" style=" width: 100px; height:50px; object-fit: contain;">
                                </div>
                                
                                <h1 class="text-nowrap operator text-uppercase" style="display: table-cell; width:400px; white-space: nowrap; margin: 0; font-size: 24px; vertical-align: middle;">
                                    vehicle name
                                </h1>
                            </div>
                            <h1 class="text-nowrap passenger text-uppercase p-3" style="display: table-cell; box-sizing:border-box; white-space: nowrap; width: 300px; margin: 0; font-size: 20px; vertical-align: middle;">
                                Passenger Info</h1>
                        </div>
                        <div class="ticket-details" style="padding: 20px; display: table; gap: 20px;">
                            <div class="left operator" style="display: table-cell; width: 500px;">
                                <h5 style="margin: 0; font-size: 18px;"><strong>
                                       vehicle category
                                    </strong></h5>
                                <div class="details" style="font-size: 14px; margin-top: 10px;">
                                    <div class="col-12 py-1" style="padding: 5px 0;"><strong>Coach:</strong>
                                        vehicle_no</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>From:</strong>
                                        from location</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>To:</strong>
                                       to location</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Date:</strong>
                                       start date</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Date:</strong>
                                        end date</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Time:</strong>
                                        start time</div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Time:</strong>
                                        end time</div>
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
                                                seat no
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Ticket Price:</strong></td>
                                            <td style="padding: 5px 0;">
                                                price BDT
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Quantity:</strong></td>
                                            <td style="padding: 5px 0;">quantity</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 0;"><strong>Total:</strong></td>
                                            <td style="padding: 5px 0;">
                                                <strong>
                                                    BDT
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="line" style="border-left: 1px dotted #E91E63; margin: 0 20px; display: table-cell;"></div>
                            <div class="right passenger ps-3" style="width: 300px; padding-left: 20px; display: table-cell;">
                                <h5 style="margin: 0; font-size: 18px;"><strong>Economy Class</strong></h5>
                                <h5 style="margin: 0; font-size: 18px;"><strong>
                                    vehicle category
                                </strong></h5>
                                <div class="details" style="font-size: 14px; margin-top: 10px;">
                                    <div class="py-1" style="padding: 5px 0;"><strong>Name:</strong>
                                       </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Phone:</strong>
                                        </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Coach:</strong>
                                       
                                    </div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>From:</strong>
                                     </div>
                                    <div class="col-6 py-1" style="padding: 5px 0;"><strong>To:</strong>
                                        </div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Date:</strong>
                                            </div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Date:</strong>
                                            </div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>Start Time:</strong>
                                            </div>
                                        <div class="col-6 py-1" style="padding: 5px 0;"><strong>End Time:</strong>
                                            </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Seat:</strong>
                                        @foreach ($seatsData as $seat)
                                            {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                        @endforeach
                                    </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Price:</strong>
                                         </div>
                                    <div class="py-1" style="padding: 5px 0;"><strong>Total: </strong>
                                         BDT
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
 --}}
