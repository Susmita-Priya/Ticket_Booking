@extends('admin.app')
@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Seat!</li>
                    </ol>
                </div>
                <h4 class="page-title">Seat!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('seats-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Vehicle</th>
                        <th>Seat No</th>
                        <th>Is Booked?</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($seats as $key=>$seatData)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>
                                @php
                                    $vehicle = $vehicles->firstWhere('id', $seatData->vehicle_id);
                                @endphp
                                {{ $vehicle ? $vehicle->name : 'N/A' }} ({{ $vehicle ? $vehicle->engin_no : 'N/A' }})
                            </td>
                            <td>{{$seatData->seat_no}}</td>
                            <td>{{$seatData->is_booked==1? 'Yes':'No'}}</td>
                            <td>{{$seatData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    @can('seats-edit')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$seatData->id}}">Edit</button>
                                    @endcan
                                    @can('seats-delete')
                                        <a href="{{route('seats.destroy',$seatData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$seatData->id}}">Delete</a>
                                    @endcan
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$seatData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$seatData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$seatData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('seats.update',$seatData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label for="vehicle_id" class="form-label">Vehicle</label>
                                                        <select name="vehicle_id" class="form-select">
                                                            @foreach ($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->id }}"
                                                                    {{ $seatData->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                                    {{ $vehicle->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="seat_no" class="form-label">Seat No</label>
                                                            <input type="text" id="seat_no" name="seat_no" value="{{$seatData->seat_no}}"
                                                                   class="form-control" placeholder="Enter Seat No" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Is Booked</label>
                                                            <select name="is_booked" class="form-select">
                                                                <option value="1" {{ $seatData->is_booked === 1 ? 'selected' : '' }}>Yes</option>
                                                                <option value="0" {{ $seatData->is_booked === 0 ? 'selected' : '' }}>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $seatData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $seatData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
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
                            <div id="danger-header-modal{{$seatData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$seatData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$seatData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('seats.destroy',$seatData->id)}}" class="btn btn-danger">Delete</a>
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
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('seats.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="vehicle_id" class="form-label">Vehicle</label>
                                <select name="vehicle_id" class="form-select">
                                    @foreach ($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->name }} ( {{ $vehicle->engin_no }} )</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="seat_no" class="form-label">Seat No</label>
                                    <input type="text" id="seat_no" name="seat_no"
                                           class="form-control" placeholder="Enter Seat No" required>
                                </div>
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
