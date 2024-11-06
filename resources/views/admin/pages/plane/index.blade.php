@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Planes!</li>
                    </ol>
                </div>
                <h4 class="page-title">Planes!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('plane-create')
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
                            <th>Name</th>
                            <th>Journey Type</th>
                            <th>Amenities</th>
                            <th>Country</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plane as $key => $planeData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $planeData->name }}</td>
                                <td>
                                    @php
                                        $journey_type = $journey_types->firstWhere('id', $planeData->journey_type_id);
                                    @endphp
                                    {{ $journey_type ? $journey_type->name : 'N/A' }}
                                </td>

                                <td>
                                    @php
                                        $planeAmenities = json_decode($planeData->amenities_ids, true) ?? [];
                                    @endphp
                                    @foreach ($amenities as $amenity)
                                        @if (in_array($amenity->id, $planeAmenities))
                                            <span class="badge bg-primary">{{ $amenity->name }}</span>
                                        @endif
                                    @endforeach
                                </td>

                                <td>
                                    @php
                                        $country = $countries->firstWhere('id', $planeData->country_id);
                                    @endphp
                                    {{ $country ? $country->name : 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $location = $locations->firstWhere('id', $planeData->location_id);
                                    @endphp
                                    {{ $location ? $location->name : 'N/A' }}
                                </td>

                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('plane-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $planeData->id }}">Edit</button>
                                        @endcan
                                        @can('plane-delete')
                                            <a href="{{ route('plane.destroy', $planeData->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $planeData->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $planeData->id }}"
                                    data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="editNewModalLabel{{ $planeData->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $planeData->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('plane.update', $planeData->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $planeData->name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="journey_type_id" class="form-label">Journey
                                                                Type</label>
                                                            <select name="journey_type_id" class="form-select">
                                                                @foreach ($journey_types as $journey_type)
                                                                    <option value="{{ $journey_type->id }}"
                                                                        {{ $planeData->journey_type_id == $journey_type->id ? 'selected' : '' }}>
                                                                        {{ $journey_type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="amenities_ids" class="form-label">Amenities</label>
                                                            <select name="amenities_ids[]"
                                                                class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($amenities as $amenity)
                                                                    @php
                                                                        $selectedAmenities =
                                                                            json_decode(
                                                                                $planeData->amenities_ids,
                                                                                true,
                                                                            ) ?? [];
                                                                    @endphp
                                                                    <option value="{{ $amenity->id }}"
                                                                        {{ in_array($amenity->id, $selectedAmenities) ? 'selected' : '' }}>
                                                                        {{ $amenity->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="country-select-{{ $planeData->id }}" class="form-label">Country</label>
                                                            <select name="country_id" id="country-select-{{ $planeData->id }}" class="form-select edit-country-select" data-plane-id="{{ $planeData->id }}">
                                                                <option selected value="">Select Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ $planeData->country_id == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="location-select-{{ $planeData->id }}" class="form-label">Location</label>
                                                            <select name="location_id" id="location-select-{{ $planeData->id }}" class="form-select">
                                                                {{-- <option selected value="">Select Location</option> --}}
                                                                <!-- Sub categories will be dynamically loaded here -->
                                                                @foreach ($locations as $location)
                                                                    <option value="{{ $location->id }}"
                                                                        {{ $planeData->location_id == $location->id ? 'selected' : '' }}>
                                                                        {{ $location->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
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
                                <div id="danger-header-modal{{ $planeData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $planeData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $planeData->id }}">
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
                                                <a href="{{ route('plane.destroy', $planeData->id) }}"
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
                    <form method="post" action="{{ route('plane.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="journey_type_id" class="form-label">Journey Type</label>
                                <select name="journey_type_id" class="form-select">
                                    <option selected value="">Select Journey Type</option>
                                    @foreach ($journey_types as $journey_type)
                                        <option value="{{ $journey_type->id }}">{{ $journey_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="amenities_ids" class="form-label">Amenities</label>
                                <select name="amenities_ids[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="country-select" class="form-label">Country</label>
                                <select name="country_id" id="country-select" class="form-select">
                                    <option selected value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="location-select" class="form-label">Location</label>
                                <select name="location_id" id="location-select" class="form-select">
                                    <option selected value="">Select Location</option>
                                    <!-- Sub categories will be dynamically loaded here -->
                                </select>
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
                            $(locationSelectId).append('<option value="">Select Location</option>');
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
            $('#country-select').on('change', function() {
                var countryId = $(this).val();
                loadlocations(countryId, '#location-select');
            });

            // Edit Modal Country Change
            $('.edit-country-select').on('change', function() {
                var planeId = $(this).data('plane-id');
                var countryId = $(this).val();
                loadlocations(countryId, '#location-select-' + planeId);
            });

            $('.modal').on('show.bs.modal', function(event) {
                var modal = $(this);
                var planeId = modal.find('.edit-country-select').data('plane-id');
                var countryId = $('#country-select-' + planeId).val();
                var selectedLocationId = modal.find('#location-select-' + planeId)
                .val(); // Current selected location

                loadlocations(countryId, '#location-select-' + planeId, selectedLocationId);
            });
        });
    </script>

@endsection
