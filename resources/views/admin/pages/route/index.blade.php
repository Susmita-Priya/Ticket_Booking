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
                        <li class="breadcrumb-item active">Place!</li>
                    </ol>
                </div>
                <h4 class="page-title">Place!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('route-create')
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
                            <th>Route Name</th>
                            <th>Start Counter</th>
                            <th>Via Counters</th>
                            <th>End Counter</th>
                            <th>Route Manager</th>
                            <th>Checkers</th>
                            <th>Document</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $key => $routeData)
                            {{-- @php
                            $routeParts = explode(' to ', $routeData->name);
                            $from = $routeParts[0] ?? '';
                            $to = $routeParts[1] ?? '';
                            $fromLocation = $locations->firstWhere('id', $from); // Assuming from is a location ID
                            $toLocation = $locations->firstWhere('id', $to); // Assuming to is a location ID
                        @endphp --}}
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td><span class="text-wrap" style="max-width: 120px;">{{ $routeData->company->name }}</span>
                                </td>
                                <td><span class="text-wrap"
                                        style="max-width: 120px;">{{ $routeData->fromLocation->name . ' to ' . $routeData->toLocation->name }}</span>
                                </td>
                                <td><span class="text-wrap"
                                        style="max-width: 120px;">{{ $routeData->startCounter->name }}{{ $routeData->startCounter->counter_no ? ' (' . $routeData->startCounter->counter_no . ' no)' : '' }}</span>
                                </td>
                                <td>
                                    @php
                                        $viaCounters = json_decode($routeData->via_counters_id, true) ?? [];
                                    @endphp
                                    @foreach ($counters as $counter)
                                        @if (in_array($counter->id, $viaCounters))
                                            {{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }} </br>
                                        @endif
                                    @endforeach
                                </td>   
                                <td><span class="text-wrap"
                                        style="max-width: 120px;">{{ $routeData->endCounter->name ?? 'N/A' }}{{ $routeData->endCounter->counter_no ? ' (' . $routeData->endCounter->counter_no . ' no)' : '' }}</span>
                                </td>
                                <td>{{ $routeData->routeManager->name ?? 'N/A' }}
                                </td>
                                <td>
                                    @php
                                        $routeCheckers = json_decode($routeData->checkers_id, true) ?? [];
                                    @endphp
                                    @foreach ($checkers as $checker)
                                        @if (in_array($checker->id, $routeCheckers))
                                            {{ $checker->name }} <br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($routeData->document)
                                        <a href="{{ asset($routeData->document) }}" target="_blank"
                                            class="btn btn-primary btn-sm">Route Permit Doc</a>
                                    @else
                                        No Document
                                    @endif
                                </td>
                                <td>
                                    @if ($routeData->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif

                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('route-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $routeData->id }}">Edit</button>
                                        @endcan
                                        @can('route-delete')
                                            {{-- <a href="{{ route('route.destroy', $routeData->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $routeData->id }}">Delete</a> --}}

                                            <a href="{{ route('route.destroy', $routeData->id) }}"class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $routeData->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>



                                <!-- Delete Modal -->
                                <div id="danger-header-modal{{ $routeData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $routeData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title" id="danger-header-modalLabe{{ $routeData->id }}l">
                                                    Delete</h4>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <a href="{{ route('route.destroy', $routeData->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $routeData->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $routeData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editNewModalLabel{{ $routeData->id }}">Edit
                                                </h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('route.update', $routeData->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="row">

                                                        <div class="col-6 mb-3">
                                                            <label for="from_location_id" class="form-label">From</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button" id="fromDropdownButton"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-from">{{ $routeData->fromLocation ? $routeData->fromLocation->name : 'Select Starting Point' }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="fromDropdownButton"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..." id="from-search"
                                                                        oninput="handleFromSearch()"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($locations as $location)
                                                                        <li><a class="dropdown-item from-dropdown-item"
                                                                                href="#"
                                                                                data-id="{{ $location->id }}"
                                                                                data-name="{{ $location->name }}">{{ $location->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="from" name="from_location_id"
                                                                value="{{ $routeData->fromLocation->id }}">
                                                        </div>

                                                        <div class="col-6 mb-3">
                                                            <label for="to_location_id" class="form-label">To</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button" id="toDropdownButton"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-to">{{ $routeData->toLocation ? $routeData->toLocation->name : 'Select Destination' }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="toDropdownButton"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..." id="to-search"
                                                                        oninput="handleToSearch()"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($locations as $location)
                                                                        <li><a class="dropdown-item to-dropdown-item"
                                                                                href="#"
                                                                                data-id="{{ $location->id }}"
                                                                                data-name="{{ $location->name }}">{{ $location->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="to" name="to_location_id"
                                                                value="{{ $routeData->toLocation->id }}">
                                                        </div>


                                                        <script>
                                                            function handleFromSearch() {
                                                                const searchInput = document.getElementById('from-search');
                                                                const filter = searchInput.value.toLowerCase();
                                                                const items = document.querySelectorAll('.from-dropdown-item');
                                                                items.forEach(item => {
                                                                    const text = item.textContent.toLowerCase();
                                                                    item.style.display = text.includes(filter) ? "block" : "none";
                                                                });
                                                            }

                                                            function handleToSearch() {
                                                                const searchInput = document.getElementById('to-search');
                                                                const filter = searchInput.value.toLowerCase();
                                                                const items = document.querySelectorAll('.to-dropdown-item');
                                                                items.forEach(item => {
                                                                    const text = item.textContent.toLowerCase();
                                                                    item.style.display = text.includes(filter) ? "block" : "none";
                                                                });
                                                            }

                                                            document.querySelectorAll('.from-dropdown-item').forEach(item => {
                                                                item.addEventListener('click', function(event) {
                                                                    event.preventDefault();
                                                                    const selectedLocation = event.target;
                                                                    const locationName = selectedLocation.getAttribute('data-name');
                                                                    const locationId = selectedLocation.getAttribute('data-id');
                                                                    document.getElementById('selected-from').textContent = locationName;
                                                                    document.getElementById('from').value = locationId;
                                                                    document.getElementById('fromDropdownButton').click();
                                                                });
                                                            });

                                                            document.querySelectorAll('.to-dropdown-item').forEach(item => {
                                                                item.addEventListener('click', function(event) {
                                                                    event.preventDefault();
                                                                    const selectedLocation = event.target;
                                                                    const locationName = selectedLocation.getAttribute('data-name');
                                                                    const locationId = selectedLocation.getAttribute('data-id');
                                                                    document.getElementById('selected-to').textContent = locationName;
                                                                    document.getElementById('to').value = locationId;
                                                                    document.getElementById('toDropdownButton').click();
                                                                });
                                                            });
                                                        </script>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6 mb-3">
                                                            <label for="start_counter_id" class="form-label">Start
                                                                Counter</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button" id="dropdownMenuButton2"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span id="selected-counter">
                                                                        {{ $routeData->startCounter->name ?? 'Select Start Counter' }}{{ $routeData->startCounter->counter_no ? ' (' . $routeData->startCounter->counter_no . ' no)' : '' }}
                                                                    </span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="dropdownMenuButton2"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..." id="counter-search"
                                                                        oninput="handleCounterSearch()"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($counters as $counter)
                                                                        <li><a class="dropdown-item counter-dropdown-item"
                                                                                href="#"
                                                                                data-id="{{ $counter->id }}"
                                                                                data-name="{{ $counter->name }}"
                                                                                data-counterNo="{{ $counter->counter_no }}">
                                                                                {{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="start_counter_id"
                                                                name="start_counter_id"
                                                                value="{{ $routeData->start_counter_id }}">
                                                        </div>

                                                        <script>
                                                            function handleCounterSearch() {
                                                                const searchInput = document.getElementById('counter-search');
                                                                const filter = searchInput.value.toLowerCase();
                                                                const items = document.querySelectorAll('.counter-dropdown-item');
                                                                items.forEach(item => {
                                                                    const text = item.textContent.toLowerCase();
                                                                    item.style.display = text.includes(filter) ? "block" : "none";
                                                                });
                                                            }

                                                            document.querySelectorAll('.counter-dropdown-item').forEach(item => {
                                                                item.addEventListener('click', function(event) {
                                                                    event.preventDefault();
                                                                    const selectedCounter = event.target;
                                                                    const counterName = selectedCounter.getAttribute('data-name');
                                                                    const counterId = selectedCounter.getAttribute('data-id');
                                                                    const counterNo = selectedCounter.getAttribute('data-counterNo');
                                                                    document.getElementById('selected-counter').textContent = counterName + (counterNo ? ' (' +
                                                                        counterNo + ' no)' : '');
                                                                    document.getElementById('start_counter_id').value = counterId;
                                                                    document.getElementById('dropdownMenuButton2').click();
                                                                });
                                                            });
                                                        </script>


                                                        <div class="col-6 mb-3">
                                                            <label for="end_counter_id" class="form-label">End
                                                                Counter</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button" id="endDropdownButton"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-end-counter">{{ $routeData->endCounter->name ?? 'Select End Counter' }}{{ $routeData->endCounter->counter_no ? ' (' . $routeData->endCounter->counter_no . ' no)' : '' }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="endDropdownButton"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..." id="end-counter-search"
                                                                        oninput="handleEndCounterSearch()"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($counters as $counter)
                                                                        <li><a class="dropdown-item end-dropdown-item"
                                                                                href="#"
                                                                                data-id="{{ $counter->id }}"
                                                                                data-name="{{ $counter->name }}"
                                                                                data-counterNo="{{ $counter->counter_no }}">{{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="end_counter_id"
                                                                name="end_counter_id"
                                                                value="{{ $routeData->end_counter_id }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="via_counters_id" class="form-label">Via Counters</label>
                                                            <select name="via_counters_id[]" class="select2 form-control select2-multiple"
                                                                data-toggle="select2" multiple="multiple">
                                                                @foreach ($counters as $counter)
                                                                    <option value="{{ $counter->id }}"
                                                                        {{ in_array($counter->id, json_decode($routeData->via_counters_id, true) ?? []) ? 'selected' : '' }}>
                                                                        {{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>  

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="route_manager_id" class="form-label">Route
                                                                Manager</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button" id="routeManagerDropdownButton"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-route-manager">{{ $routeData->routeManager->name ?? 'Select Route Manager' }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="routeManagerDropdownButton"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..." id="route-manager-search"
                                                                        oninput="handleRouteManagerSearch()"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($routeManagers as $routeManager)
                                                                        <li><a class="dropdown-item route-manager-dropdown-item"
                                                                                href="#"
                                                                                data-id="{{ $routeManager->id }}"
                                                                                data-name="{{ $routeManager->name }}">{{ $routeManager->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="route_manager_id"
                                                                name="route_manager_id"
                                                                value="{{ $routeData->route_manager_id }}">
                                                        </div>

                                                        <script>
                                                            function handleEndCounterSearch() {
                                                                const searchInput = document.getElementById('end-counter-search');
                                                                const filter = searchInput.value.toLowerCase();
                                                                const items = document.querySelectorAll('.end-dropdown-item');
                                                                items.forEach(item => {
                                                                    const text = item.textContent.toLowerCase();
                                                                    item.style.display = text.includes(filter) ? "block" : "none";
                                                                });
                                                            }

                                                            function handleRouteManagerSearch() {
                                                                const searchInput = document.getElementById('route-manager-search');
                                                                const filter = searchInput.value.toLowerCase();
                                                                const items = document.querySelectorAll('.route-manager-dropdown-item');
                                                                items.forEach(item => {
                                                                    const text = item.textContent.toLowerCase();
                                                                    item.style.display = text.includes(filter) ? "block" : "none";
                                                                });
                                                            }

                                                            document.querySelectorAll('.end-dropdown-item').forEach(item => {
                                                                item.addEventListener('click', function(event) {
                                                                    event.preventDefault();
                                                                    const selectedCounter = event.target;
                                                                    const counterName = selectedCounter.getAttribute('data-name');
                                                                    const counterId = selectedCounter.getAttribute('data-id');
                                                                    const counterNo = selectedCounter.getAttribute('data-counterNo');
                                                                    document.getElementById('selected-end-counter').textContent = counterName + (counterNo ?
                                                                        ' (' + counterNo + ' no)' : '');
                                                                    document.getElementById('end_counter_id').value = counterId;
                                                                    document.getElementById('endDropdownButton').click();
                                                                });
                                                            });

                                                            document.querySelectorAll('.route-manager-dropdown-item').forEach(item => {
                                                                item.addEventListener('click', function(event) {
                                                                    event.preventDefault();
                                                                    const selectedManager = event.target;
                                                                    const managerName = selectedManager.getAttribute('data-name');
                                                                    const managerId = selectedManager.getAttribute('data-id');
                                                                    document.getElementById('selected-route-manager').textContent = managerName;
                                                                    document.getElementById('route_manager_id').value = managerId;
                                                                    document.getElementById('routeManagerDropdownButton').click();
                                                                });
                                                            });
                                                        </script>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="checkers_id"
                                                                    class="form-label">Checkers</label>
                                                                <select name="checkers_id[]"
                                                                    class="select2 form-control select2-multiple"
                                                                    data-toggle="select2" multiple="multiple">
                                                                    @foreach ($checkers as $checker)
                                                                        <option value="{{ $checker->id }}"
                                                                            {{ in_array($checker->id, json_decode($routeData->checkers_id, true) ?? []) ? 'selected' : '' }}>
                                                                            {{ $checker->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="document" class="form-label">Document</label>
                                                                <input type="file" id="document" name="document"
                                                                    class="form-control">
                                                                @if ($routeData->document)
                                                                    <a href="{{ asset($routeData->document) }}"
                                                                        target="_blank"
                                                                        class="btn btn-primary btn-sm mt-2">View
                                                                        Document</a>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1"
                                                                        {{ $routeData->status == 1 ? 'selected' : '' }}>
                                                                        Active
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ $routeData->status == 0 ? 'selected' : '' }}>
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

                                {{-- <!-- Delete Modal -->
                                <div id="danger-header-modal{{ $routeData->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $routeData->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $routeData->id }}">
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
                                                <a href="{{ route('route.destroy', $routeData->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}





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
                    <form method="post" action="{{ route('route.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="from_location_id" class="form-label">From</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addFromDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-from">Select Starting Point</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addFromDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-from-search" oninput="handleAddFromSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($locations as $location)
                                            <li><a class="dropdown-item add-from-dropdown-item" href="#"
                                                    data-id="{{ $location->id }}"
                                                    data-name="{{ $location->name }}">{{ $location->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-from" name="from_location_id">
                            </div>

                            <div class="col-6 mb-3">
                                <label for="to_location_id" class="form-label">To</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addToDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-to">Select Destination</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addToDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-to-search" oninput="handleAddToSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($locations as $location)
                                            <li><a class="dropdown-item add-to-dropdown-item" href="#"
                                                    data-id="{{ $location->id }}"
                                                    data-name="{{ $location->name }}">{{ $location->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-to" name="to_location_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="add-start-counter-id" class="form-label">Start Counter</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addStartCounterDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-start-counter">Select Start Counter</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" id="addStartCounterDropdownMenu"
                                        aria-labelledby="addStartCounterDropdownButton" style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-start-counter-search"
                                            oninput="handleAddStartCounterSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($counters as $counter)
                                            <li><a class="dropdown-item add-start-counter-dropdown-item" href="#"
                                                    data-id="{{ $counter->id }}" data-name="{{ $counter->name }}"
                                                    data-counterNo="{{ $counter->counter_no }}">{{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-start-counter-id" name="start_counter_id">
                            </div>

                            <div class="col-6 mb-3">
                                <label for="add-end-counter-id" class="form-label">End Counter</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addEndCounterDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-end-counter">Select End Counter</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" id="addEndCounterDropdownMenu"
                                        aria-labelledby="addEndCounterDropdownButton" style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-end-counter-search"
                                            oninput="handleAddEndCounterSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($counters as $counter)
                                            <li><a class="dropdown-item add-end-counter-dropdown-item" href="#"
                                                    data-id="{{ $counter->id }}" data-name="{{ $counter->name }}"
                                                    data-counterNo="{{ $counter->counter_no }}">{{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-end-counter-id" name="end_counter_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="via_counters_id" class="form-label">Via Counters</label>
                                <select name="via_counters_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($counters as $counter)
                                        <option value="{{ $counter->id }}">{{ $counter->name }}{{ $counter->counter_no ? ' (' . $counter->counter_no . ' no)' : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="add-route-manager-id" class="form-label">Route Manager</label>
                                    <div class="dropdown">
                                        <button
                                            class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                            type="button" id="addRouteManagerDropdownButton" data-bs-toggle="dropdown"
                                            aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                            <span id="add-selected-route-manager">Select Route Manager</span>
                                        </button>
                                        <ul class="dropdown-menu pt-0" id="addRouteManagerDropdownMenu"
                                            aria-labelledby="addRouteManagerDropdownButton" style="width: 100%;">
                                            <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                                placeholder="Search..." id="add-route-manager-search"
                                                oninput="handleAddRouteManagerSearch()"
                                                style="width: 100%; padding-left: 10px;">
                                            @foreach ($routeManagers as $routeManager)
                                                <li><a class="dropdown-item add-route-manager-dropdown-item" href="#"
                                                        data-id="{{ $routeManager->id }}"
                                                        data-name="{{ $routeManager->name }}">{{ $routeManager->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" id="add-route-manager-id" name="route_manager_id">
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="checkers_id" class="form-label">Checkers</label>
                                <select name="checkers_id[]" class="select2 form-control select2-multiple"
                                    data-toggle="select2" multiple="multiple">
                                    @foreach ($checkers as $checker)
                                        <option value="{{ $checker->id }}">{{ $checker->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="document" class="form-label">Document</label>
                                <input type="file" id="document" name="document" class="form-control">
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
        function handleAddFromSearch() {
            const searchInput = document.getElementById('add-from-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-from-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        function handleAddToSearch() {
            const searchInput = document.getElementById('add-to-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-to-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        function handleAddStartCounterSearch() {
            const searchInput = document.getElementById('add-start-counter-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-start-counter-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        function handleAddEndCounterSearch() {
            const searchInput = document.getElementById('add-end-counter-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-end-counter-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        function handleAddRouteManagerSearch() {
            const searchInput = document.getElementById('add-route-manager-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-route-manager-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        document.querySelectorAll('.add-from-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedLocation = event.target;
                const locationName = selectedLocation.getAttribute('data-name');
                const locationId = selectedLocation.getAttribute('data-id');
                document.getElementById('add-selected-from').textContent = locationName;
                document.getElementById('add-from').value = locationId;
                document.getElementById('addFromDropdownButton').click();
            });
        });

        document.querySelectorAll('.add-to-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedLocation = event.target;
                const locationName = selectedLocation.getAttribute('data-name');
                const locationId = selectedLocation.getAttribute('data-id');
                document.getElementById('add-selected-to').textContent = locationName;
                document.getElementById('add-to').value = locationId;
                document.getElementById('addToDropdownButton').click();
            });
        });

        document.querySelectorAll('.add-start-counter-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedCounter = event.target;
                const counterName = selectedCounter.getAttribute('data-name');
                const counterId = selectedCounter.getAttribute('data-id');
                const counterNo = selectedCounter.getAttribute('data-counterNo');
                document.getElementById('add-selected-start-counter').textContent = counterName + (
                    counterNo ? ' (' + counterNo + ' no)' : '');
                document.getElementById('add-start-counter-id').value = counterId;
                document.getElementById('addStartCounterDropdownButton').click();
            });
        });

        document.querySelectorAll('.add-end-counter-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedCounter = event.target;
                const counterName = selectedCounter.getAttribute('data-name');
                const counterId = selectedCounter.getAttribute('data-id');
                const counterNo = selectedCounter.getAttribute('data-counterNo');
                document.getElementById('add-selected-end-counter').textContent = counterName + (counterNo ?
                    ' (' + counterNo + ' no)' : '');
                document.getElementById('add-end-counter-id').value = counterId;
                document.getElementById('addEndCounterDropdownButton').click();
            });
        });

        document.querySelectorAll('.add-route-manager-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedManager = event.target;
                const managerName = selectedManager.getAttribute('data-name');
                const managerId = selectedManager.getAttribute('data-id');
                document.getElementById('add-selected-route-manager').textContent = managerName;
                document.getElementById('add-route-manager-id').value = managerId;
                document.getElementById('addRouteManagerDropdownButton').click();
            });
        });
    </script>
@endsection
