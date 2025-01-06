@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Published Vehicles!</li>
                    </ol>
                </div>
                <h4 class="page-title">Published Vehicles!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('vehicle-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add
                            New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Company Name</th>
                        <th>Vehicle Name & No</th>
                        <th>Start Location</th>
                        <th>End Location</th>
                        <th>Journey Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($vehiclePublished as $key => $vehiclePublishedData)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{$vehiclePublishedData->company->name}}</td>
                            <td>{{$vehiclePublishedData->vehicle->name}}-{{$vehiclePublishedData->vehicle->engin_no}}</td>
                            <td>{{$vehiclePublishedData->startDivision->name}} - {{$vehiclePublishedData->startDistrict->name}}</td>
                            <td>{{$vehiclePublishedData->endDivision->name}} - {{$vehiclePublishedData->endDistrict->name}}</td>
                            <td>{{$vehiclePublishedData->journey_date}}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $vehiclePublishedData->start_time)->format('h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $vehiclePublishedData->end_time)->format('h:i A') }}</td>

                            <td style="width: 100px;">
                                <div class="d-flex  gap-1">
                                    @can('published-vehicle-delete')
                                        <a href="{{ route('published.vehicle.destroy', $vehiclePublishedData->id) }}" class="btn btn-danger btn-sm"
                                           data-bs-toggle="modal"
                                           data-bs-target="#danger-header-modal{{ $vehiclePublishedData->id }}">Delete</a>
                                    @endcan
                                </div>
                            </td>


                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{ $vehiclePublishedData->id }}" class="modal fade" tabindex="-1"
                                 role="dialog" aria-labelledby="danger-header-modalLabel{{ $vehiclePublishedData->id }}"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabel{{ $vehiclePublishedData->id }}">
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
                                            <a href="{{ route('published.vehicle.destroy', $vehiclePublishedData->id) }}"
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

    <!-- Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add Vehicle</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('published.vehicle.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Vehicle</label>
                                <select name="vehicle_id"  class="form-select">
                                    <option selected value="">Select Vehicle</option>
                                    @foreach ($vehicle as $vehicleData)
                                        <option value="{{ $vehicleData->id }}">{{ $vehicleData->name }}-{{ $vehicleData->engin_no }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_division_id" class="form-label">Start Division</label>
                                <select name="start_division_id" id="start_division_id" class="form-select">
                                    <option selected value="">Select Division</option>
                                    @foreach ($division as $divisionData)
                                        <option value="{{ $divisionData->id }}">{{ $divisionData->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_district_id" class="form-label">Start District</label>
                                <select name="start_district_id" id="start_district_id" class="form-select">
                                    <option selected value="">Select District</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_division_id" class="form-label">End Division</label>
                                <select name="end_division_id" id="end_division_id" class="form-select">
                                    <option selected value="">Select Division</option>
                                    @foreach ($division as $divisionData)
                                        <option value="{{ $divisionData->id }}">{{ $divisionData->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_district_id" class="form-label">End District</label>
                                <select name="end_district_id" id="end_district_id" class="form-select">
                                    <option selected value="">Select District</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="journey_date" class="form-label">Journey Date</label>
                                <input type="date" name="journey_date" id="journey_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time"  class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time"  class="form-control" required>
                            </div>
                        </div>



                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch districts based on selected division
            $('#start_division_id').change(function() {
                var divisionId = $(this).val();
                fetchDistricts(divisionId, '#start_district_id');
            });

            $('#end_division_id').change(function() {
                var divisionId = $(this).val();
                fetchDistricts(divisionId, '#end_district_id');
            });

            // Fetch districts based on division ID
            function fetchDistricts(divisionId, districtSelectId) {
                if (divisionId) {
                    $.ajax({
                        url: '/districts/' + divisionId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var districtSelect = $(districtSelectId);
                            districtSelect.empty();
                            districtSelect.append('<option selected value="">Select District</option>');

                            $.each(data, function(index, district) {
                                districtSelect.append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                        },
                        error: function() {
                            alert('Unable to fetch districts.');
                        }
                    });
                } else {
                    $(districtSelectId).empty().append('<option selected value="">Select District</option>');
                }
            }
        });
    </script>
@endsection
