@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Planes Journey!</li>
                    </ol>
                </div>
                <h4 class="page-title">Planes Journey!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('plane-journey-create')
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
                            <th>Plane</th>
                            <th>Journey Type</th>
                            <th>From (Country)</th>
                            <th>From (Location)</th>
                            <th>To (Country)</th>
                            <th>To (Location)</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Seats</th>
                            <th>Available Seats</th>
                            <th>Published Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plane_journey as $key => $plane_journeyData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td> 
                                    @php
                                    $plane = $planes->firstWhere('id', $plane_journeyData->plane_id);
                                    @endphp
                                    {{ $plane ? $plane->plane_name : 'N/A' }}
                                </td>
                                    
                                <td>
                                    @php
                                        $planeJourneyType = json_decode($plane_journeyData->journey_types_id, true) ?? [];
                                    @endphp
                                    @foreach ($journey_types as $journey_type)
                                        @if (in_array($journey_type->id, $planeJourneyType))
                                            <span class="badge bg-primary">{{ $journey_type->name }}</span>
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @php
                                        $country = $countries->firstWhere('id', $plane_journeyData->from_country_id);
                                    @endphp
                                    {{ $country ? $country->name : 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $location = $locations->firstWhere('id', $plane_journeyData->start_location_id);
                                    @endphp
                                    {{ $location ? $location->name : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $country = $countries->firstWhere('id', $plane_journeyData->to_country_id);
                                    @endphp
                                    {{ $country ? $country->name : 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $location = $locations->firstWhere('id', $plane_journeyData->end_location_id);
                                    @endphp
                                    {{ $location ? $location->name : 'N/A' }}
                                </td>

                                <td>{{ $plane_journeyData->start_date }}</td>
                                <td>{{ $plane_journeyData->end_date }}</td>
                                <td>{{ $plane_journeyData->total_seats }}</td>
                                <td>{{ $plane_journeyData->available_seats }}</td>
                                <td>{{ $plane_journeyData->published_status ? 'Published' : 'Unpublished' }}</td>
                                

                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('plane-journey-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $plane_journeyData->id }}">Edit</button>
                                        @endcan
                                        @can('plane-journey-delete')
                                            <a href="{{ route('plane_journey.destroy', $plane_journeyData->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $plane_journeyData->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $plane_journeyData->id }}"
                                    data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="editNewModalLabel{{ $plane_journeyData->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $plane_journeyData->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('plane_journey.update', $plane_journeyData->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="plane_id" class="form-label">Plane</label>
                                                            <select name="plane_id" class="form-select">
                                                                <option value="">Select Plane</option>
                                                                @foreach ($planes as $plane)
                                                                    <option value="{{ $plane->id }}" {{ $plane->id == $plane_journeyData->plane_id ? 'selected' : '' }}>
                                                                        {{ $plane->plane_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="journey_type_id" class="form-label">Journey Type</label>
                                                            <select name="journey_types_id[]" class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple">
                                                                @foreach ($journey_types as $journey_type)

                                                                    @php
                                                                        $selectedJourney_types =
                                                                            json_decode(
                                                                                $plane_journeyData->journey_types_id,
                                                                                true,
                                                                            ) ?? [];
                                                                    @endphp
                                                                    <option value="{{ $journey_type->id }}"
                                                                        {{ in_array($journey_type->id , $selectedJourney_types) ? 'selected' : '' }}>
                                                                        {{ $journey_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="from-country-select-{{ $plane_journeyData->id }}" class="form-label">From Country</label>
                                                            <select name="from_country_id" id="from-country-select-{{ $plane_journeyData->id }}" class="form-select edit-from-country-select" data-plane-id="{{ $plane_journeyData->id }}">
                                                                <option selected value="">Select From Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ $plane_journeyData->from_country_id == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="start-location-select-{{ $plane_journeyData->id }}" class="form-label">From Location</label>
                                                            <select name="start_location_id" id="start-location-select-{{ $plane_journeyData->id }}" class="form-select">
                                                                <!-- Sub categories will be dynamically loaded here -->
                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}"
                                                                        {{ $plane_journeyData->start_location_id == $location->id ? 'selected' : '' }}>
                                                                        {{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>                                                   
                                                    
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="to-country-select-{{ $plane_journeyData->id }}" class="form-label">To Country</label>
                                                            <select name="to_country_id" id="to-country-select-{{ $plane_journeyData->id }}" class="form-select edit-to-country-select" data-plane-id="{{ $plane_journeyData->id }}">
                                                                <option selected value="">Select From Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ $plane_journeyData->to_country_id == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="end-location-select-{{ $plane_journeyData->id }}" class="form-label">To Location</label>
                                                            <select name="end_location_id" id="end-location-select-{{ $plane_journeyData->id }}" class="form-select">
                                                                
                                                                <!-- Sub categories will be dynamically loaded here -->
                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}"
                                                                        {{ $plane_journeyData->end_location_id == $location->id ? 'selected' : '' }}>
                                                                        {{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="start_date" class="form-label">Start Date</label>
                                                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $plane_journeyData->start_date }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="end_date" class="form-label">End Date</label>
                                                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $plane_journeyData->end_date }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="total_seats" class="form-label">Total Seats</label>
                                                            <input type="number" id="total_seats" name="total_seats" class="form-control" value="{{ $plane_journeyData->total_seats }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="available_seats" class="form-label">Available Seats</label>
                                                            <input type="number" id="available_seats" name="available_seats" class="form-control" value="{{ $plane_journeyData->available_seats }}" required>
                                                        </div>
                                                    </div>

                                                    <div class=row>
                                                        <div class="col-12 mb-3">
                                                            <label for="published_status" class="form-label">Published Status</label>
                                                            <select name="published_status" class="form-select">
                                                                <option value="1" {{ $plane_journeyData->published_status == 1 ? 'selected' : '' }}>Published</option>
                                                                <option value="0" {{ $plane_journeyData->published_status == 0 ? 'selected' : '' }}>Unpublished</option>
                                                            </select>
                                                        </div>
                                                    

                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div id="danger-header-modal{{ $plane_journeyData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $plane_journeyData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $plane_journeyData->id }}">
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
                                                <a href="{{ route('plane_journey.destroy', $plane_journeyData->id) }}"
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
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('plane_journey.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="plane_id" class="form-label">Plane</label>
                                <select name="plane_id" class="form-select">
                                    <option selected value="">Select Plane</option>
                                    @foreach ($planes as $plane)
                                        <option value="{{ $plane->id }}">{{ $plane->plane_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3"> 
                                <label for="journey_type_id" class="form-label">Journey Type</label>
                                    <select name="journey_types_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    {{-- <option selected value="">Select Journey Type</option> --}}
                                    @foreach ($journey_types as $journey_type)
                                        <option value="{{ $journey_type->id }}">{{ $journey_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="from_country_id" class="form-label">From Country</label>
                                <select name="from_country_id" id="from_country-select" class="form-select">
                                    <option selected value="">Select From Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_location_id" class="form-label">From Location</label>
                                <select name="start_location_id" id="start_location-select" class="form-select">
                                    <option selected value="">Select From Location</option>
                                    <!-- Sub categories will be dynamically loaded here -->
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="to_country_id" class="form-label">To Country</label>
                                <select name="to_country_id" id="to_country-select" class="form-select">
                                    <option selected value="">Select To Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_location_id" class="form-label">To Location</label>
                                <select name="end_location_id" id="end_location-select" class="form-select">
                                    <option selected value="">Select To Location</option>
                                    <!-- Sub categories will be dynamically loaded here -->
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                    placeholder="Enter Start Date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                    placeholder="Enter End Date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="total_seats" class="form-label">Total Seats</label>
                                <input type="number" id="total_seats" name="total_seats" class="form-control"
                                    placeholder="Enter Total Seats" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="available_seats" class="form-label">Available Seats</label>
                                <input type="number" id="available_seats" name="available_seats" class="form-control"
                                    placeholder="Enter Available Seats" required>
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
            function loadlocations(countryId, locationSelectId, selectedLocationId = null) {
                if (countryId) {
                    $.ajax({
                        url: '/countries/' + countryId + '/locations',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $(locationSelectId).empty();
                            var defaultOptionText = 'Select Location';
                    if (locationSelectId === '#start_location-select') {
                        defaultOptionText = 'Select From Location';
                    } else if (locationSelectId === '#end_location-select') {
                        defaultOptionText = 'Select To Location';
                    }

                    $(locationSelectId).append('<option value="">' + defaultOptionText + '</option>');
                    
                    $.each(data, function(key, value) {
                        var selected = selectedLocationId == value.id ? 'selected' : '';
                        $(locationSelectId).append('<option value="' + value.id + '" ' +
                            selected + '>' + value.name + '</option>');
                    });
                },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                } else {
                    $(locationSelectId).empty();
                    $(locationSelectId).append('<option value="">Select Location</option>');
                }
            }

            // Add Modal Country Change
            $('#from_country-select').on('change', function() {
                var countryId = $(this).val();
                loadlocations(countryId, '#start_location-select');
            });

            // Add Modal Country Change
            $('#to_country-select').on('change', function() {
                var countryId = $(this).val();
                loadlocations(countryId, '#end_location-select');
            });

            // Edit Modal Country Change
            $('.edit-from-country-select').on('change', function() {
                var planeId = $(this).data('plane-id');
                var countryId = $(this).val();
                loadlocations(countryId, '#start-location-select-' + planeId);
            });

            $('.modal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var planeId = modal.find('.edit-from-country-select').data('plane-id');
                var countryId = $('#from-country-select-' + planeId).val();
                var selectedLocationId = modal.find('#start-location-select-' + planeId)
                .val(); // Current selected location

                loadlocations(countryId, '#start-location-select-' + planeId, selectedLocationId);
            });

            $('.edit-to-country-select').on('change', function() {
                var planeId = $(this).data('plane-id');
                var countryId = $(this).val();
                loadlocations(countryId, '#end-location-select-' + planeId);
            });

            $('.modal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var planeId = modal.find('.edit-to-country-select').data('plane-id');
                var countryId = $('#to-country-select-' + planeId).val();
                var selectedLocationId = modal.find('#end-location-select-' + planeId)
                .val(); // Current selected location

                loadlocations(countryId, '#end-location-select-' + planeId, selectedLocationId);
            });
        });
    </script>

@endsection
