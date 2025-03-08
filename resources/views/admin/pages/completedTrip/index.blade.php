@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Completed Trips!</li>
                    </ol>
                </div>
                <h4 class="page-title">Completed Trips!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Helper</th>
                            <th>Supervisor</th>
                            <th>Start Date & Time</th>
                            <th>End Date & Time</th>
                            <th>Ticket Price</th>
                            <th>Total Route Cost</th>
                            <th>Trip Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $key => $trip)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-wrap">{{ $trip->company->name ?? 'N/A' }}</td>
                                <td>{{ $trip->route->fromLocation->name ?? 'N/A' }} to {{ $trip->route->toLocation->name }}
                                </td>
                                <td>{{ $trip->vehicle->name ?? 'N/A' }} <br>
                                    ({{ $trip->vehicle->vehicle_no ?? 'N/A' }})
                                </td>
                                <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                                <td>{{ $trip->helper->name ?? 'N/A' }}</td>
                                <td>{{ $trip->supervisor->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->start_date . ' ' . $trip->start_time)->format('d-m-Y h:i A') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($trip->end_date . ' ' . $trip->end_time)->format('d-m-Y h:i A') }}
                                </td>
                                <td>{{ $trip->ticket_price }} TK</td>
                                <td>{{ $trip->total_route_cost }} TK</td>
                                <td>
                                    @if ($trip->trip_status == 0)
                                        <span class="badge bg-warning">Not Assigned</span>
                                    @elseif($trip->trip_status == 1)
                                        <span class="badge bg-success">Ongoing</span>
                                    @elseif ($trip->trip_status == 2)
                                        <span class="badge bg-danger">Completed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
@endsection