@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Owners!</li>
                    </ol>
                </div>
                <h4 class="page-title">Owners!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('owner-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add
                            New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Company Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Nid</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($owners as $key => $owner)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $owner->company->name }}</td>
                                <td>{{ $owner->name }}</td>
                                <td>{{ $owner->email }}</td>
                                <td>{{ $owner->phone }}</td>
                                <td>{{ $owner->address }}</td>
                                <td>{{ $owner->nid }}</td>
                                <td>{{ $owner->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('owner-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $owner->id }}">Edit</button>
                                        @endcan
                                        @can('owner-delete')
                                            <a href="{{ route('owner.destroy', $owner->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $owner->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $owner->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $owner->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $owner->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('owner.update', $owner->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $owner->name }}" class="form-control"
                                                                placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" id="email" name="email"
                                                                value="{{ $owner->email }}" class="form-control"
                                                                placeholder="Enter Email" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="phone" class="form-label">Phone</label>
                                                            <input type="text" id="phone" name="phone"
                                                                value="{{ $owner->phone }}" class="form-control"
                                                                placeholder="Enter Phone" required maxlength="15" pattern="\d{11,15}" title="Phone number must be between 11 to 15 digits">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input type="text" id="address" name="address"
                                                                value="{{ $owner->address }}" class="form-control"
                                                                placeholder="Enter Address" required>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="nid" class="form-label">Nid</label>
                                                            <input type="text" id="nid" name="nid"
                                                                value="{{ $owner->nid }}" class="form-control"
                                                                placeholder="Enter Nid" required maxlength="10">
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $owner->status == 1 ? 'selected' : '' }}>
                                                                    Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $owner->status == 0 ? 'selected' : '' }}>
                                                                    Inactive
                                                                </option>
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
                                <div id="danger-header-modal{{ $owner->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $owner->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $owner->id }}">
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
                                                <a href="{{ route('owner.destroy', $owner->id) }}"
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
                    <form method="post" action="{{ route('owner.store') }}">
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
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="Enter Phone" required maxlength="15" pattern="\d{11,15}" title="Phone number must be between 11 to 15 digits">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="Enter Address" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="nid" class="form-label">Nid</label>
                                <input type="text" id="nid" name="nid" class="form-control"
                                    placeholder="Enter Nid" required maxlength="10">
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
