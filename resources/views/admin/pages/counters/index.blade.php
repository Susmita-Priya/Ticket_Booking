@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Counters!</li>
                    </ol>
                </div>
                <h4 class="page-title">Counters!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('counter-create')
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
                            <th>Counter Name</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($counters as $key => $counter)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $counter->company->name }}</td>
                                <td>{{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</td>
                                <td>{{ $counter->location->name?? 'N/A' }}</td>
                                <td>{{ $counter->status == 1 ? 'Active' : 'Inactive' }}</td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('counter-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $counter->id }}">Edit</button>
                                        @endcan
                                        @can('counter-delete')
                                            <a href="{{ route('counter.destroy', $counter->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $counter->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $counter->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $counter->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $counter->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('counter.update', $counter->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name"
                                                                value="{{ $counter->name }}" class="form-control"
                                                                locationholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="counter_no" class="form-label">Counter
                                                                    No</label>
                                                                <input type="text" id="counter_no" name="counter_no"
                                                                    value="{{ $counter->counter_no }}" class="form-control"
                                                                    locationholder="Enter counter number">
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="location_id" class="form-label">Location</label>
                                                                <div class="dropdown location-dropdown">
                                                                    <button class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center" 
                                                                            type="button" 
                                                                            data-bs-toggle="dropdown" 
                                                                            aria-expanded="false" 
                                                                            style="text-align: left; padding-left: 10px;">
                                                                        <span class="selected-location">{{ $counter->location->name ?? 'Select Location' }}</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu pt-0" style="width: 100%;">
                                                                        <input type="text" 
                                                                               class="form-control border-0 border-bottom shadow-none mb-2 location-search" 
                                                                               locationholder="Search..."  
                                                                               style="width: 100%; padding-left: 10px;">
                                                                        @foreach($locations as $location)
                                                                            <li>
                                                                                <a class="dropdown-item location-option" href="#" 
                                                                                   data-id="{{ $location->id }}" 
                                                                                   data-name="{{ $location->name }}" 
                                                                                   @if(isset($counter->location_id) && $counter->location_id == $location->id) 
                                                                                       style="font-weight:bold;" 
                                                                                   @endif>
                                                                                    {{ $location->name }}
                                                                                </a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                                <input type="hidden" class="location-id" name="location_id" value="{{ $counter->location_id }}">
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.querySelectorAll('.location-dropdown').forEach(dropdown => {
                                                                const searchInput = dropdown.querySelector('.location-search');
                                                                const items = dropdown.querySelectorAll('.dropdown-item');

                                                                searchInput.addEventListener('input', function() {
                                                                    const searchValue = searchInput.value.toLowerCase();
                                                                    items.forEach(item => {
                                                                        const text = item.textContent.toLowerCase();
                                                                        item.style.display = text.includes(searchValue) ? "block" : "none";
                                                                    });
                                                                });
                                                                dropdown.addEventListener('click', function(event) {
                                                                    if (event.target.classList.contains('location-option')) {
                                                                        event.preventDefault();
                                                                        
                                                                        const selectedValue = event.target.getAttribute('data-name');
                                                                        const locationId = event.target.getAttribute('data-id');
                                                                        dropdown.querySelector('.selected-location').textContent = selectedValue;
                                                                        dropdown.nextElementSibling.value = locationId;
                                                                        dropdown.querySelector('.dropdown-toggle').click();
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1"
                                                                        {{ $counter->status == 1 ? 'selected' : '' }}>
                                                                        Active
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $counter->status == 0 ? 'selected' : '' }}>
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
                                <div id="danger-header-modal{{ $counter->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $counter->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabel{{ $counter->id }}">
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
                                                <a href="{{ route('counter.destroy', $counter->id) }}"
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
                    <form method="post" action="{{ route('counter.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    locationholder="Enter Name" required>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="counter_no" class="form-label">Counter No</label>
                                    <input type="text" id="counter_no" name="counter_no" class="form-control"
                                        locationholder="Enter counter number">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="location_id" class="form-label">Location</label>
                                    <div class="dropdown location-dropdown">
                                        <button class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center" 
                                                type="button" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" 
                                                style="text-align: left; padding-left: 10px;">
                                            <span class="selected-location">Select Location</span>
                                        </button>
                                        <ul class="dropdown-menu pt-0" style="width: 100%;">
                                            <input type="text" 
                                                   class="form-control border-0 border-bottom shadow-none mb-2 location-search" 
                                                   locationholder="Search..."  
                                                   style="width: 100%; padding-left: 10px;">
                                            @foreach($locations as $location)
                                                <li>
                                                    <a class="dropdown-item location-option" href="#" 
                                                       data-id="{{ $location->id }}" 
                                                       data-name="{{ $location->name }}">
                                                        {{ $location->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" class="location-id" name="location_id">
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('.location-dropdown').forEach(dropdown => {
                                    const searchInput = dropdown.querySelector('.location-search');
                                    const items = dropdown.querySelectorAll('.dropdown-item');

                                    searchInput.addEventListener('input', function() {
                                        const searchValue = searchInput.value.toLowerCase();
                                        items.forEach(item => {
                                            const text = item.textContent.toLowerCase();
                                            item.style.display = text.includes(searchValue) ? "block" : "none";
                                        });
                                    });
                                    dropdown.addEventListener('click', function(event) {
                                        if (event.target.classList.contains('location-option')) {
                                            event.preventDefault();
                                            
                                            const selectedValue = event.target.getAttribute('data-name');
                                            const locationId = event.target.getAttribute('data-id');
                                            dropdown.querySelector('.selected-location').textContent = selectedValue;
                                            dropdown.nextElementSibling.value = locationId;
                                            dropdown.querySelector('.dropdown-toggle').click();
                                        }
                                    });
                                });
                            </script>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
