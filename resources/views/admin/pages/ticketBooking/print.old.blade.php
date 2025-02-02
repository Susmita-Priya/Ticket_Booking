<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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

        .line{
        border: 1px dotted #E91E63;
        margin-left: 15px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-section,
            .print-section * {
                visibility: visible;
            }

            .print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <div class="card print-section">
                <div class="card-body">
                    @if (session()->has('vehicle'))
                        <div class="ticket mx-auto">
                            <div class="header d-flex align-items-center">
                                <h3 class="text-nowrap operator text-uppercase">{{ session('vehicle')->name }}</h3>
                                <h4 class="text-nowrap passenger text-uppercase p-3">Passenger Info</h4>
                            </div>
                            <div class="ticket-details p-3 d-flex">
                                <div class="left operator">
                                    <h5><strong>
                                        @if (session('vehicle')->category == '0')
                                            Economy Class
                                        @elseif (session('vehicle')->category == '1')
                                            Business Class
                                        @elseif (session('vehicle')->category == '2')
                                            Sleeping Coach
                                        @endif
                                    </strong></h5>
                                    <div class="details row">
                                        <div class="col-12 py-1"><strong>Coach:</strong> {{ session('vehicle')->vehicle_no }}</div>
                                        <div class="col-6 py-1"><strong>From:</strong> {{ session('route')->startCounter->name }}</div>
                                        <div class="col-6 py-1"><strong>To:</strong> {{ session('route')->endCounter->name }}</div>
                                        <div class="col-6 py-1"><strong>Travel Date:</strong> {{ \Carbon\Carbon::parse(session('bookingDate'))->format('d M Y') }}</div>
                                        <div class="col-6 py-1"><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse(session('trip')->time)->format('h:i A') }}</div>
                                    </div>
                                    <table class="table-fixed table mt-3">
                                        <tbody>
                                            <tr>
                                                <td class="col-6"><strong>Seat:</strong></td>
                                                <td>
                                                    @foreach (session('seatsData') as $seat)
                                                        {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price:</strong></td>
                                                <td>{{ number_format(session('seatsData')[0]['seatPrice'], 2) }} BDT </td>
                                           
                                            </tr>
                                            <tr>
                                                <td><strong>Quantity:</strong></td>
                                                <td> {{ count(session('seatsData')) }}</td>
                                           
                                            </tr>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong>{{ number_format(array_sum(array_column(session('seatsData'), 'seatPrice')), 2) }} BDT</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="line"></div>
                                <div class="right passenger ps-3">
                                    <h5 class=""><strong>Economy Class</strong></h5>
                                    <div class="details">
                                        <div class="py-1"><strong>Name:</strong> {{ session('passenger_name') ?? 'N/A'}}</div>
                                        <div class="py-1"><strong>Phone:</strong> {{ session('passenger_phone') }}</div>
                                        <div class="py-1"><strong>Coach:</strong> {{ session('vehicle')->name }} - {{ session('vehicle')->vehicle_no }}</div>
                                        <div class="py-1"><strong>From:</strong> {{ session('route')->startCounter->name }}</div>
                                        <div class="py-1"><strong>To:</strong> {{ session('route')->endCounter->name }}</div>
                                        <div class="py-1"><strong>Travel Date:</strong> {{ \Carbon\Carbon::parse(session('bookingDate'))->format('d M Y') }}</div>
                                        <div class="py-1"><strong>Departure Time:</strong> {{ \Carbon\Carbon::parse(session('trip')->time)->format('h:i A') }}</div>
                                        <div class="py-1"><strong>Seat:</strong>
                                            @foreach (session('seatsData') as $seat)
                                                {{ $loop->last ? $seat['seatNo'] : $seat['seatNo'] . ',' }}
                                            @endforeach
                                        </div>
                                        <div class="py-1"><strong>Price:</strong> {{ number_format(session('seatsData')[0]['seatPrice'], 2) }} BDT</div>
                                        <div class="py-1"><strong>Quantity:</strong> {{ count(session('seatsData')) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">No booking data found. Please book a ticket first.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>