@extends('admin.app')


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />



@section('admin_content')
    {{-- CKEditor CDN --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Cupon!</li>
                    </ol>
                </div>
                <h4 class="page-title">Cupon!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('cupon-create')
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
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Minimum Expend</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cupon as $key => $cuponData)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $cuponData->cupon_code }}</td>
                                <td>{{ $cuponData->start_date }}</td>
                                <td>{{ $cuponData->end_date }}</td>
                                <td>{{ $cuponData->minimum_expend }}</td>
                                <td>{{ $cuponData->discount_amount }}</td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('cupon-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $cuponData->id }}">Edit</button>
                                        @endcan
                                        @can('cupon-delete')
                                            <a href="{{ route('cupon.destroy', $cuponData->id) }}"class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $cuponData->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!--Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $cuponData->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $cuponData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $cuponData->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('cupon.update', $cuponData->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-12">

                                                            <div class="mb-3">
                                                                <label for="cupon_code" class="form-label">Cupon
                                                                    Code</label>
                                                                <input type="text" id="cupon_code" name="cupon_code"
                                                                    value="{{ $cuponData->cupon_code }}"
                                                                    class="form-control" placeholder="Enter cupon code"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="start_date_{{$key}}" class="form-label">Start Date</label>
                                                                <input id="start_date_{{$key}}" class="form-control edit-start-date"
                                                                       data-coupon-id="{{$cuponData->coupon_id}}" name="start_date"
                                                                       value="{{$cuponData->start_date}}" placeholder="Enter start date" required>
                                                            </div>
                        
                                                            <div class="mb-3">
                                                                <label for="end_date_{{$key}}" class="form-label">End Date</label>
                                                                <input id="end_date_{{$key}}" class="form-control edit-end-date"
                                                                       data-coupon-id="{{$cuponData->coupon_id}}" name="end_date"
                                                                       value="{{$cuponData->end_date}}" placeholder="Enter end date" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="minimum_expend" class="form-label">Minimum
                                                                    Expend</label>
                                                                <input type="number" id="minimum_expend"
                                                                    name="minimum_expend"
                                                                    value="{{ $cuponData->minimum_expend }}"
                                                                    class="form-control" placeholder="Enter minimum expend"
                                                                    required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="discount_amount" class="form-label">Discount
                                                                    Amount</label>
                                                                <input type="number" id="discount_amount"
                                                                    name="discount_amount"
                                                                    value="{{ $cuponData->discount_amount }}"
                                                                    class="form-control"
                                                                    placeholder="Enter discount amount" required>
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
                                <div id="danger-header-modal{{ $cuponData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $cuponData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabe{{ $cuponData->id }}l">Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('cupon.destroy', $cuponData->id) }}"
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

    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('cupon.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="cupon_code" class="form-label">Cupon Code</label>
                                    <input type="text" id="cupon_code" name="cupon_code" class="form-control"
                                        placeholder="Enter cupon code" required>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" id="start_date" name="start_date"
                                        class="form-control add-start-date" placeholder="Enter start date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" id="end_date" name="end_date"
                                        class="form-control add-end-date" placeholder="Enter end date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="minimum_expend" class="form-label">Minimum Expend</label>
                                    <input type="number" id="minimum_expend" name="minimum_expend" class="form-control"
                                        placeholder="Enter minimum expend" required>

                                </div>

                                <div class="mb-3">
                                    <label for="discount_amount" class="form-label">Discount Amount</label>
                                    <input type="number" id="discount_amount" name="discount_amount"
                                        class="form-control" placeholder="Enter discount amount" required>
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

    <script>
        // $('#start_date').datepicker({
        //     uiLibrary: 'bootstrap4'
        // });

        // $('#end_date').datepicker({
        //     uiLibrary: 'bootstrap4'
        // });



        $('.edit-start-date').each(function() {
    var randomId = $(this).attr('id'); // Get the unique ID
    $('#' + randomId).datepicker({
        uiLibrary: 'bootstrap4'
    });
});

$('.edit-end-date').each(function() {
    var randomId = $(this).attr('id'); // Get the unique ID
    $('#' + randomId).datepicker({
        uiLibrary: 'bootstrap4'
    });
});
    </script>
@endsection
