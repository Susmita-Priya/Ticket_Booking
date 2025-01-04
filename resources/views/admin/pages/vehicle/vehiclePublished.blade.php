@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Vehicles!</li>
                    </ol>
                </div>
                <h4 class="page-title">Vehicles!</h4>
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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($vehiclePublished as $key => $vehiclePublishedData)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>11</td>
                            <td>11</td>
                            <td>11</td>
                            <td>11</td>
                            <td>11</td>
                            <td>{{ $vehiclePublishedData->status == 1 ? 'Active' : 'Inactive' }}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
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
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('published.vehicle.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="category_id" class="form-label">Company</label>
                                <select name="category_id" class="form-select">
                                    <option selected value="">Select Company</option>
                                    @foreach ($company as $companyData)
                                        <option value="{{ $companyData->id }}">{{ $companyData->name }}</option>
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
