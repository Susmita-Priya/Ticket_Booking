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
                            <th>Plane Name</th>
                            <th>Amenities</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plane as $key => $planeData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $planeData->plane_name }}</td>
                                <td>
                                    @php
                                        $planeAmenities = json_decode($planeData->amenities_id, true) ?? [];
                                    @endphp
                                    @foreach ($amenities as $amenity)
                                        @if (in_array($amenity->id, $planeAmenities))
                                            <span class="badge bg-primary">{{ $amenity->name }}</span>
                                        @endif
                                    @endforeach
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
                                                            <label for="plane_name" class="form-label">Plane Name</label>
                                                            <input type="text" id="plane_name" name="plane_name"
                                                                value="{{ $planeData->plane_name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="amenities_id" class="form-label">Amenities</label>
                                                            <select name="amenities_id[]"
                                                                class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($amenities as $amenity)
                                                                    @php
                                                                        $selectedAmenities =
                                                                            json_decode(
                                                                                $planeData->amenities_id,
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
                                <label for="plane_name" class="form-label">Plane Name</label>
                                <input type="text" id="plane_name" name="plane_name" class="form-control"
                                    placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="amenities_id" class="form-label">Amenities</label>
                                <select name="amenities_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                    @endforeach
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

@endsection
