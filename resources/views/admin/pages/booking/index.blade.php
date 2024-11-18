@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Booking!</li>
                    </ol>
                </div>
                <h4 class="page-title">Booking!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            {{-- <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('plane-journey-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add
                            New</button>
                    @endcan
                </div>
            </div> --}}
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            {{-- <th>User</th> --}}
                            <th>Plane</th>
                            <th>From (Location)</th>
                            <th>To (Location)</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Passenger info</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking as $key => $bookingData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @php
                                        $plane = $planes->firstWhere('id', $bookingData->plane_id);
                                    @endphp
                                    {{ $plane ? $plane->plane_name : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $planeJourney = $planeJourneys->firstWhere(
                                            'id',
                                            $bookingData->plane_journey_id,
                                        );
                                        $location = $locations->firstWhere('id', $planeJourney->start_location_id);
                                    @endphp
                                    {{ $location ? $location->name : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $location = $locations->firstWhere('id', $planeJourney->end_location_id);
                                    @endphp
                                    {{ $location ? $location->name : 'N/A' }}
                                </td>

                                <td>{{ $planeJourney->start_date }}</td>
                                <td>{{ $planeJourney->end_date }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#showModalId{{$bookingData->id}}">View</button>

                                </td>
                                <td>
                                    {{-- <div class="d-flex justify-content-end gap-1"> --}}
                                    @can('booking-delete')
                                        <a href="{{ route('booking.destroy', $bookingData->id) }}" class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#danger-header-modal{{ $bookingData->id }}">Delete</a>
                                    @endcan
                                    {{-- </div> --}}
                                </td>

                                <div class="modal fade" id="showModalId{{ $bookingData->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="showModalId{{ $bookingData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="showModalId{{ $bookingData->id }}">Passenger
                                                    Info</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="passergers_name" class="form-label">Name</label>
                                                            @php
                                                                $passengersName =json_decode($bookingData->passengers_name, true) ?? [];
                                                            @endphp
                                                            @foreach ($passengersName as $passengerName)
                                                            <ul>
                                                                <li >{{ $passengerName }}</li>
                                                            </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="passergers_phone" class="form-label">Phone</label>
                                                            @php
                                                                $passengersPhone =json_decode($bookingData->passengers_phone, true) ?? [];
                                                            @endphp
                                                            @foreach ($passengersPhone as $passengerPhone)
                                                            <ul>
                                                                <li >{{ $passengerPhone}}</li>
                                                            </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="passergers_passport" class="form-label">Passport No</label>
                                                            @php
                                                                $passengersPassport =json_decode($bookingData->passengers_passport_no, true) ?? [];
                                                            @endphp
                                                            @foreach ($passengersPassport as $passengerPassport)
                                                            <ul>
                                                                <li >{{ $passengerPassport }}</li>
                                                            </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="passergers_age" class="form-label">Age</label>
                                                            @php
                                                                $passengersAge =json_decode($bookingData->passengers_age, true) ?? [];
                                                            @endphp
                                                            @foreach ($passengersAge as $passengerAge)
                                                            <ul>
                                                                <li >{{ $passengerAge }}</li>
                                                            </ul>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div id="danger-header-modal{{ $bookingData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $bookingData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $bookingData->id }}">
                                                    Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are You Sure You Want to Delete this?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('booking.destroy', $bookingData->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
