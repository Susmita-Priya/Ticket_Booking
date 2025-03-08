@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Trips!</li>
                    </ol>
                </div>
                <h4 class="page-title">Trips!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('trip-create')
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
                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Helper</th>
                            <th>Supervisor</th>
                            <th>Start Date & Time</th>
                            <th>End Date & Time</th>
                            <th>Reporting Time</th>
                            {{-- <th>Start Time</th>
                            <th>End Time</th> --}}
                            <th>Ticket Price</th>
                            <th>Total Route Cost</th>
                            <th>Trip Status</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trips as $key => $trip)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td class="text-wrap">{{ $trip->company->name ?? 'N/A' }}</td>
                                <td>{{ $trip->route->fromLocation->name ?? 'N/A' }} to {{ $trip->route->toLocation->name }}
                                </td>
                                <td>{{ $trip->vehicle->name ?? 'N/A' }} <br>
                                    ({{ $trip->vehicle->vehicle_no ?? 'N/A' }})
                                </td>
                                <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                                <td>{{ $trip->helper->name ?? 'N/A' }}</td>
                                <td>{{ $trip->supervisor->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trip->start_date . ' ' . $trip->start_time)->format('d-m-Y h:i A') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($trip->end_date . ' ' . $trip->end_time)->format('d-m-Y h:i A') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($trip->reporting_time)->format('h:i A') }}</td>
                                {{-- <td>{{ $trip->start_time }}</td>
                                <td>{{ $trip->end_time }}</td> --}}
                                <td>{{ $trip->ticket_price }} TK</td>
                                <td>{{ $trip->total_route_cost }} TK</td>
                                <td>
                                    @if ($trip->trip_status == 0)
                                        <span class="badge bg-warning">Not Assigned</span>
                                    @elseif($trip->trip_status == 1)
                                        @if(\Carbon\Carbon::parse($trip->start_date . ' ' . $trip->start_time)->lte(now()))
                                            <span class="badge bg-primary">Ongoing</span>
                                        @else
                                            <span class="badge bg-primary">Upcoming</span>
                                        @endif
                                    @elseif ($trip->trip_status == 2)
                                        <span class="badge bg-danger">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($trip->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif ($trip->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td style="width: 100px;">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('trip-edit')
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editNewModalId{{ $trip->id }}">Edit</button>
                                        @endcan
                                        @can('trip-delete')
                                            <a href="{{ route('trip.destroy', $trip->id) }}" class="btn btn-danger btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#danger-header-modal{{ $trip->id }}">Delete</a>
                                        @endcan
                                    </div>
                                </td>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editNewModalId{{ $trip->id }}" data-bs-backdrop="static"
                                    tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{ $trip->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="addNewModalLabel{{ $trip->id }}">Edit</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" action="{{ route('trip.update', $trip->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <!-- Route Dropdown -->
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="route_id" class="form-label">Route</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button"
                                                                    id="routeDropdownButton{{ $trip->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span id="selected-route{{ $trip->id }}">
                                                                        {{ $trip->route->fromLocation->name }} to
                                                                        {{ $trip->route->toLocation->name }}
                                                                    </span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="routeDropdownButton{{ $trip->id }}"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..."
                                                                        id="route-search{{ $trip->id }}"
                                                                        oninput="handleRouteSearch({{ $trip->id }})"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($routes as $route)
                                                                        <li>
                                                                            <a class="dropdown-item route-dropdown-item{{ $trip->id }}"
                                                                                href="#"
                                                                                data-id="{{ $route->id }}"
                                                                                data-from-location-id="{{ $route->fromLocation->id }}"
                                                                                data-name="{{ $route->fromLocation->name }} to {{ $route->toLocation->name }}">
                                                                                {{ $route->fromLocation->name }} to
                                                                                {{ $route->toLocation->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="route_id{{ $trip->id }}"
                                                                name="route_id" value="{{ $trip->route_id }}">
                                                        </div>
                                                    </div>

                                                    <!-- Vehicle Dropdown -->
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="vehicle_id" class="form-label">Vehicle</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button"
                                                                    id="vehicleDropdownButton{{ $trip->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span id="selected-vehicle{{ $trip->id }}">
                                                                        {{ $trip->vehicle->name }}
                                                                        ({{ $trip->vehicle->vehicle_no }})
                                                                    </span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="vehicleDropdownButton{{ $trip->id }}"
                                                                    style="width: 100%;"
                                                                    id="vehicle-dropdown-menu{{ $trip->id }}">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..."
                                                                        id="vehicle-search{{ $trip->id }}"
                                                                        oninput="handleVehicleSearch({{ $trip->id }})"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    <!-- Vehicle options will be dynamically populated here -->
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="vehicle_id{{ $trip->id }}"
                                                                name="vehicle_id" value="{{ $trip->vehicle_id }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="driver_id" class="form-label">Driver</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button"
                                                                    id="driverDropdownButton{{ $trip->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-driver{{ $trip->id }}">{{ $trip->driver->name }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="driverDropdownButton{{ $trip->id }}"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..."
                                                                        id="driver-search{{ $trip->id }}"
                                                                        oninput="handleDriverSearch({{ $trip->id }})"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($drivers as $driver)
                                                                        <li><a class="dropdown-item driver-dropdown-item{{ $trip->id }}"
                                                                                href="#"
                                                                                data-id="{{ $driver->id }}"
                                                                                data-name="{{ $driver->name }}">{{ $driver->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="driver_id{{ $trip->id }}"
                                                                name="driver_id" value="{{ $trip->driver_id }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="helper_id" class="form-label">Helper</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button"
                                                                    id="helperDropdownButton{{ $trip->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-helper{{ $trip->id }}">{{ $trip->helper->name }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="helperDropdownButton{{ $trip->id }}"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..."
                                                                        id="helper-search{{ $trip->id }}"
                                                                        oninput="handleHelperSearch({{ $trip->id }})"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($helpers as $helper)
                                                                        <li><a class="dropdown-item helper-dropdown-item{{ $trip->id }}"
                                                                                href="#"
                                                                                data-id="{{ $helper->id }}"
                                                                                data-name="{{ $helper->name }}">{{ $helper->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="helper_id{{ $trip->id }}"
                                                                name="helper_id" value="{{ $trip->helper_id }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="supervisor_id"
                                                                class="form-label">Supervisor</label>
                                                            <div class="dropdown">
                                                                <button
                                                                    class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                                                    type="button"
                                                                    id="supervisorDropdownButton{{ $trip->id }}"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="text-align: left; padding-left: 10px;">
                                                                    <span
                                                                        id="selected-supervisor{{ $trip->id }}">{{ $trip->supervisor->name }}</span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0"
                                                                    aria-labelledby="supervisorDropdownButton{{ $trip->id }}"
                                                                    style="width: 100%;">
                                                                    <input type="text"
                                                                        class="form-control border-0 border-bottom shadow-none mb-2"
                                                                        placeholder="Search..."
                                                                        id="supervisor-search{{ $trip->id }}"
                                                                        oninput="handleSupervisorSearch({{ $trip->id }})"
                                                                        style="width: 100%; padding-left: 10px;">
                                                                    @foreach ($supervisors as $supervisor)
                                                                        <li><a class="dropdown-item supervisor-dropdown-item{{ $trip->id }}"
                                                                                href="#"
                                                                                data-id="{{ $supervisor->id }}"
                                                                                data-name="{{ $supervisor->name }}">{{ $supervisor->name }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" id="supervisor_id{{ $trip->id }}"
                                                                name="supervisor_id" value="{{ $trip->supervisor_id }}">
                                                        </div>
                                                    </div>

                                                    <script>
                                                        function handleRouteSearch(tripId) {
                                                            const searchInput = document.getElementById('route-search' + tripId);
                                                            const filter = searchInput.value.toLowerCase();
                                                            const items = document.querySelectorAll('.route-dropdown-item' + tripId);
                                                            items.forEach(item => {
                                                                const text = item.textContent.toLowerCase();
                                                                item.style.display = text.includes(filter) ? "block" : "none";
                                                            });
                                                        }
                                                        // Handle route selection for Edit Modal
                                                        document.querySelectorAll('.route-dropdown-item{{ $trip->id }}').forEach(item => {
                                                            item.addEventListener('click', function(event) {
                                                                event.preventDefault();
                                                                const selectedRoute = event.target;
                                                                const routeName = selectedRoute.getAttribute('data-name');
                                                                const routeId = selectedRoute.getAttribute('data-id');
                                                                const fromLocationId = selectedRoute.getAttribute('data-from-location-id');

                                                                // Update the selected route display
                                                                document.getElementById('selected-route{{ $trip->id }}').textContent = routeName;
                                                                document.getElementById('route_id{{ $trip->id }}').value = routeId;

                                                                // Fetch vehicles based on the selected route's fromLocationId
                                                                fetchVehiclesForEditModal(fromLocationId, {{ $trip->id }});

                                                                // Close the dropdown
                                                                document.getElementById('routeDropdownButton{{ $trip->id }}').click();
                                                            });
                                                        });

                                                        // Fetch vehicles for Edit Modal
                                                        function fetchVehiclesForEditModal(fromLocationId, tripId) {
                                                            fetch(`/fetch-vehicles?fromLocationId=${fromLocationId}`)
                                                                .then(response => response.json())
                                                                .then(data => {
                                                                    const vehicleDropdownMenu = document.getElementById(`vehicle-dropdown-menu${tripId}`);
                                                                    vehicleDropdownMenu.innerHTML = ''; // Clear existing options

                                                                    // Add a search input
                                                                    const searchInput = document.createElement('input');
                                                                    searchInput.type = 'text';
                                                                    searchInput.className = 'form-control border-0 border-bottom shadow-none mb-2';
                                                                    searchInput.placeholder = 'Search...';
                                                                    searchInput.style.width = '100%';
                                                                    searchInput.style.paddingLeft = '10px';
                                                                    searchInput.oninput = () => handleVehicleSearch(tripId);
                                                                    vehicleDropdownMenu.appendChild(searchInput);

                                                                    // Add vehicles to the dropdown
                                                                    data.vehicles.forEach(vehicle => {
                                                                        const vehicleItem = document.createElement('li');
                                                                        vehicleItem.innerHTML =
                                                                            `<a class="dropdown-item vehicle-dropdown-item${tripId}" href="#" data-id="${vehicle.id}" data-name="${vehicle.name} (${vehicle.vehicle_no})">${vehicle.name} (${vehicle.vehicle_no})</a>`;
                                                                        vehicleDropdownMenu.appendChild(vehicleItem);
                                                                    });

                                                                    // Re-attach event listeners for the new vehicle items
                                                                    document.querySelectorAll(`.vehicle-dropdown-item${tripId}`).forEach(item => {
                                                                        item.addEventListener('click', function(event) {
                                                                            event.preventDefault();
                                                                            const selectedVehicle = event.target;
                                                                            const vehicleName = selectedVehicle.getAttribute('data-name');
                                                                            const vehicleId = selectedVehicle.getAttribute('data-id');
                                                                            document.getElementById(`selected-vehicle${tripId}`).textContent =
                                                                                vehicleName;
                                                                            document.getElementById(`vehicle_id${tripId}`).value = vehicleId;
                                                                            document.getElementById(`vehicleDropdownButton${tripId}`).click();
                                                                        });
                                                                    });
                                                                });
                                                        }

                                                        // Handle vehicle search for Edit Modal
                                                        function handleVehicleSearch(tripId) {
                                                            const searchInput = document.getElementById(`vehicle-search${tripId}`);
                                                            const filter = searchInput.value.toLowerCase();
                                                            const items = document.querySelectorAll(`.vehicle-dropdown-item${tripId}`);
                                                            items.forEach(item => {
                                                                const text = item.textContent.toLowerCase();
                                                                item.style.display = text.includes(filter) ? "block" : "none";
                                                            });
                                                        }

                                                        function handleDriverSearch(tripId) {
                                                            const searchInput = document.getElementById('driver-search' + tripId);
                                                            const filter = searchInput.value.toLowerCase();
                                                            const items = document.querySelectorAll('.driver-dropdown-item' + tripId);
                                                            items.forEach(item => {
                                                                const text = item.textContent.toLowerCase();
                                                                item.style.display = text.includes(filter) ? "block" : "none";
                                                            });
                                                        }
                                                        document.querySelectorAll('.driver-dropdown-item{{ $trip->id }}').forEach(item => {
                                                            item.addEventListener('click', function(event) {
                                                                event.preventDefault();
                                                                const selectedDriver = event.target;
                                                                const driverName = selectedDriver.getAttribute('data-name');
                                                                const driverId = selectedDriver.getAttribute('data-id');
                                                                document.getElementById('selected-driver{{ $trip->id }}').textContent = driverName;
                                                                document.getElementById('driver_id{{ $trip->id }}').value = driverId;
                                                                document.getElementById('driverDropdownButton{{ $trip->id }}').click();
                                                            });
                                                        });

                                                        function handleDriverSearch(tripId) {
                                                            const searchInput = document.getElementById('helper-search' + tripId);
                                                            const filter = searchInput.value.toLowerCase();
                                                            const items = document.querySelectorAll('.helper-dropdown-item' + tripId);
                                                            items.forEach(item => {
                                                                const text = item.textContent.toLowerCase();
                                                                item.style.display = text.includes(filter) ? "block" : "none";
                                                            });
                                                        }
                                                        document.querySelectorAll('.helper-dropdown-item{{ $trip->id }}').forEach(item => {
                                                            item.addEventListener('click', function(event) {
                                                                event.preventDefault();
                                                                const selectedHelper = event.target;
                                                                const helperName = selectedHelper.getAttribute('data-name');
                                                                const helperId = selectedHelper.getAttribute('data-id');
                                                                document.getElementById('selected-helper{{ $trip->id }}').textContent = helperName;
                                                                document.getElementById('helper_id{{ $trip->id }}').value = helperId;
                                                                document.getElementById('helperDropdownButton{{ $trip->id }}').click();
                                                            });
                                                        });

                                                        function handleSupervisorSearch(tripId) {
                                                            const searchInput = document.getElementById('supervisor-search' + tripId);
                                                            const filter = searchInput.value.toLowerCase();
                                                            const items = document.querySelectorAll('.supervisor-dropdown-item' + tripId);
                                                            items.forEach(item => {
                                                                const text = item.textContent.toLowerCase();
                                                                item.style.display = text.includes(filter) ? "block" : "none";
                                                            });
                                                        }
                                                        document.querySelectorAll('.supervisor-dropdown-item{{ $trip->id }}').forEach(item => {
                                                            item.addEventListener('click', function(event) {
                                                                event.preventDefault();
                                                                const selectedSupervisor = event.target;
                                                                const supervisorName = selectedSupervisor.getAttribute('data-name');
                                                                const supervisorId = selectedSupervisor.getAttribute('data-id');
                                                                document.getElementById('selected-supervisor{{ $trip->id }}').textContent =
                                                                    supervisorName;
                                                                document.getElementById('supervisor_id{{ $trip->id }}').value = supervisorId;
                                                                document.getElementById('supervisorDropdownButton{{ $trip->id }}').click();
                                                            });
                                                        });
                                                    </script>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="start_date" class="form-label">Start Date</label>
                                                            <input type="date" id="start_date" name="start_date"
                                                                value="{{ $trip->start_date }}" class="form-control"
                                                                required min="{{ date('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="end_date" class="form-label">End Date</label>
                                                            <input type="date" id="end_date" name="end_date"
                                                                value="{{ $trip->end_date }}" class="form-control"
                                                                required min="{{ date('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="reporting_time" class="form-label">Reporting
                                                                Time</label>
                                                            <input type="time" id="reporting_time" name="reporting_time"
                                                                value="{{ $trip->reporting_time }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="start_time" class="form-label">Start Time</label>
                                                            <input type="time" id="start_time" name="start_time"
                                                                value="{{ $trip->start_time }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="end_time" class="form-label">End Time</label>
                                                            <input type="time" id="end_time" name="end_time"
                                                                value="{{ $trip->end_time }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="ticket_price" class="form-label">Ticket
                                                                Price</label>
                                                            <input type="number" id="ticket_price" name="ticket_price"
                                                                value="{{ $trip->ticket_price }}" class="form-control"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="total_route_cost" class="form-label">Total Route
                                                                Cost</label>
                                                            <input type="number" id="total_route_cost"
                                                                name="total_route_cost"
                                                                value="{{ $trip->total_route_cost }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="trip_status" class="form-label">Trip Status</label>
                                                            <select name="trip_status" class="form-select">
                                                                <option value="1"
                                                                    {{ $trip->status == 1 ? 'selected' : '' }}>Ongoing
                                                                </option>
                                                                <option value="2"
                                                                    {{ $trip->status == 2 ? 'selected' : '' }}>Completed
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1"
                                                                    {{ $trip->status == 1 ? 'selected' : '' }}>Active
                                                                </option>
                                                                <option value="0"
                                                                    {{ $trip->status == 0 ? 'selected' : '' }}>Inactive
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
                                <div id="danger-header-modal{{ $trip->id }}" class="modal fade" tabindex="-1"
                                    role="dialog" aria-labelledby="danger-header-modalLabel{{ $trip->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-danger">
                                                <h4 class="modal-title"
                                                    id="danger-header-modalLabel{{ $trip->id }}">
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
                                                <a href="{{ route('trip.destroy', $trip->id) }}"
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

    {{-- <!-- Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('trip.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="route_id" class="form-label">Route</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addRouteDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-route">Select Route</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addRouteDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-route-search"
                                            oninput="handleAddRouteSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($routes as $route)
                                            <li><a class="dropdown-item add-route-dropdown-item" href="#"
                                                    data-id="{{ $route->id }}"
                                                    data-from-location-id="{{ $route->fromLocation->id }}"
                                                    data-name="{{ $route->fromLocation->name }} to {{ $route->toLocation->name }}">{{ $route->fromLocation->name }}
                                                    to {{ $route->toLocation->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-route" name="route_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="vehicle_id" class="form-label">Vehicle</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addVehicleDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-vehicle">Select Vehicle</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addVehicleDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-vehicle-search"
                                            oninput="handleAddVehicleSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($vehicles as $vehicle)
                                            <li><a class="dropdown-item add-vehicle-dropdown-item" href="#"
                                                    data-id="{{ $vehicle->id }}"
                                                    data-name="{{ $vehicle->name }} ({{ $vehicle->vehicle_no }})">{{ $vehicle->name }}
                                                    ({{ $vehicle->vehicle_no }})</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-vehicle" name="vehicle_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="driver_id" class="form-label">Driver</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addDriverDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-driver">Select Driver</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addDriverDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-driver-search"
                                            oninput="handleAddDriverSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($drivers as $driver)
                                            <li><a class="dropdown-item add-driver-dropdown-item" href="#"
                                                    data-id="{{ $driver->id }}"
                                                    data-name="{{ $driver->name }}">{{ $driver->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-driver" name="driver_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="supervisor_id" class="form-label">Supervisor</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addSupervisorDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-supervisor">Select Supervisor</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addSupervisorDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-supervisor-search"
                                            oninput="handleAddSupervisorSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($supervisors as $supervisor)
                                            <li><a class="dropdown-item add-supervisor-dropdown-item" href="#"
                                                    data-id="{{ $supervisor->id }}"
                                                    data-name="{{ $supervisor->name }}">{{ $supervisor->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-supervisor" name="supervisor_id">
                            </div>
                        </div>

                        <script>
                            function handleAddRouteSearch() {
                                const searchInput = document.getElementById('add-route-search');
                                const filter = searchInput.value.toLowerCase();
                                const items = document.querySelectorAll('.add-route-dropdown-item');
                                items.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(filter) ? "block" : "none";
                                });
                            }

                            document.querySelectorAll('.add-route-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedRoute = event.target;
                                    const routeName = selectedRoute.getAttribute('data-name');
                                    const routeId = selectedRoute.getAttribute('data-id');
                                    const fromLocationId = selectedRoute.getAttribute('data-from-location-id');
                                    document.getElementById('add-selected-route').textContent = routeName;
                                    document.getElementById('add-route').value = routeId;
                                    // Fetch vehicles based on the selected route's fromLocationId
                                    fetchVehicles(fromLocationId);
                                    document.getElementById('addRouteDropdownButton').click();
                                });
                            });

                            // function handleAddVehicleSearch() {
                            //     const searchInput = document.getElementById('add-vehicle-search');
                            //     const filter = searchInput.value.toLowerCase();
                            //     const items = document.querySelectorAll('.add-vehicle-dropdown-item');
                            //     items.forEach(item => {
                            //         const text = item.textContent.toLowerCase();
                            //         item.style.display = text.includes(filter) ? "block" : "none";
                            //     });
                            // }
                            document.querySelectorAll('.add-vehicle-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedVehicle = event.target;
                                    const vehicleName = selectedVehicle.getAttribute('data-name');
                                    const vehicleId = selectedVehicle.getAttribute('data-id');
                                    document.getElementById('add-selected-vehicle').textContent = vehicleName;
                                    document.getElementById('add-vehicle').value = vehicleId;
                                    document.getElementById('addVehicleDropdownButton').click();
                                });
                            });

                            function fetchVehicles(fromLocationId) {
                                fetch(`/fetch-vehicles?fromLocationId=${fromLocationId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const vehicleDropdown = document.getElementById('addVehicleDropdownButton');
                                        const vehicleList = vehicleDropdown.nextElementSibling.querySelector('.dropdown-menu');
                                        vehicleList.innerHTML = ''; // Clear existing options

                                        // Add a search input
                                        const searchInput = document.createElement('input');
                                        searchInput.type = 'text';
                                        searchInput.className = 'form-control border-0 border-bottom shadow-none mb-2';
                                        searchInput.placeholder = 'Search...';
                                        searchInput.style.width = '100%';
                                        searchInput.style.paddingLeft = '10px';
                                        searchInput.oninput = handleAddVehicleSearch;
                                        vehicleList.appendChild(searchInput);

                                        // Add vehicles to the dropdown
                                        data.vehicles.forEach(vehicle => {
                                            const vehicleItem = document.createElement('li');
                                            vehicleItem.innerHTML =
                                                `<a class="dropdown-item add-vehicle-dropdown-item" href="#" data-id="${vehicle.id}" data-name="${vehicle.name} (${vehicle.vehicle_no})">${vehicle.name} (${vehicle.vehicle_no})</a>`;
                                            vehicleList.appendChild(vehicleItem);
                                        });

                                        // Re-attach event listeners for the new vehicle items
                                        document.querySelectorAll('.add-vehicle-dropdown-item').forEach(item => {
                                            item.addEventListener('click', function(event) {
                                                event.preventDefault();
                                                const selectedVehicle = event.target;
                                                const vehicleName = selectedVehicle.getAttribute('data-name');
                                                const vehicleId = selectedVehicle.getAttribute('data-id');
                                                document.getElementById('add-selected-vehicle').textContent = vehicleName;
                                                document.getElementById('add-vehicle').value = vehicleId;
                                                document.getElementById('addVehicleDropdownButton').click();
                                            });
                                        });
                                    });
                            }

                            function handleAddDriverSearch() {
                                const searchInput = document.getElementById('add-driver-search');
                                const filter = searchInput.value.toLowerCase();
                                const items = document.querySelectorAll('.add-driver-dropdown-item');
                                items.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(filter) ? "block" : "none";
                                });
                            }
                            document.querySelectorAll('.add-driver-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedDriver = event.target;
                                    const driverName = selectedDriver.getAttribute('data-name');
                                    const driverId = selectedDriver.getAttribute('data-id');
                                    document.getElementById('add-selected-driver').textContent = driverName;
                                    document.getElementById('add-driver').value = driverId;
                                    document.getElementById('addDriverDropdownButton').click();
                                });
                            });

                            function handleAddSupervisorSearch() {
                                const searchInput = document.getElementById('add-supervisor-search');
                                const filter = searchInput.value.toLowerCase();
                                const items = document.querySelectorAll('.add-supervisor-dropdown-item');
                                items.forEach(item => {
                                    const text = item.textContent.toLowerCase();
                                    item.style.display = text.includes(filter) ? "block" : "none";
                                });
                            }
                            document.querySelectorAll('.add-supervisor-dropdown-item').forEach(item => {
                                item.addEventListener('click', function(event) {
                                    event.preventDefault();
                                    const selectedSupervisor = event.target;
                                    const supervisorName = selectedSupervisor.getAttribute('data-name');
                                    const supervisorId = selectedSupervisor.getAttribute('data-id');
                                    document.getElementById('add-selected-supervisor').textContent = supervisorName;
                                    document.getElementById('add-supervisor').value = supervisorId;
                                    document.getElementById('addSupervisorDropdownButton').click();
                                });
                            });
                        </script>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" id="start_time" name="start_time" class="form-control" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" id="end_time" name="end_time" class="form-control" required>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="ticket_price" class="form-label">Ticket Price</label>
                                <input type="number" id="ticket_price" name="ticket_price" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="total_route_cost" class="form-label">Total Route Cost</label>
                                <input type="number" id="total_route_cost" name="total_route_cost" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

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
                    <form method="post" action="{{ route('trip.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Route Dropdown -->
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="route_id" class="form-label">Route</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addRouteDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-route">Select Route</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addRouteDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-route-search"
                                            oninput="handleAddRouteSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($routes as $route)
                                            <li><a class="dropdown-item add-route-dropdown-item" href="#"
                                                    data-id="{{ $route->id }}"
                                                    data-from-location-id="{{ $route->fromLocation->id }}"
                                                    data-name="{{ $route->fromLocation->name }} to {{ $route->toLocation->name }}">{{ $route->fromLocation->name }}
                                                    to {{ $route->toLocation->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-route" name="route_id">
                            </div>
                        </div>

                        <!-- Vehicle Dropdown -->
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="vehicle_id" class="form-label">Vehicle</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addVehicleDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-vehicle">Select Vehicle</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addVehicleDropdownButton"
                                        style="width: 100%;" id="vehicle-dropdown-menu">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-vehicle-search"
                                            oninput="handleAddVehicleSearch()" style="width: 100%; padding-left: 10px;">
                                        <!-- Vehicle options will be dynamically populated here -->
                                    </ul>
                                </div>
                                <input type="hidden" id="add-vehicle" name="vehicle_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="driver_id" class="form-label">Driver</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addDriverDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-driver">Select Driver</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addDriverDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-driver-search"
                                            oninput="handleAddDriverSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($drivers as $driver)
                                            <li><a class="dropdown-item add-driver-dropdown-item" href="#"
                                                    data-id="{{ $driver->id }}"
                                                    data-name="{{ $driver->name }}">{{ $driver->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-driver" name="driver_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="helper_id" class="form-label">Helper</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addHelperDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-helper">Select Helper</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addHelperDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-helper-search"
                                            oninput="handleAddHelperSearch()" style="width: 100%; padding-left: 10px;">
                                        @foreach ($helpers as $helper)
                                            <li><a class="dropdown-item add-helper-dropdown-item" href="#"
                                                    data-id="{{ $helper->id }}"
                                                    data-name="{{ $helper->name }}">{{ $helper->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-helper" name="helper_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="supervisor_id" class="form-label">Supervisor</label>
                                <div class="dropdown">
                                    <button
                                        class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center"
                                        type="button" id="addSupervisorDropdownButton" data-bs-toggle="dropdown"
                                        aria-expanded="false" style="text-align: left; padding-left: 10px;">
                                        <span id="add-selected-supervisor">Select Supervisor</span>
                                    </button>
                                    <ul class="dropdown-menu pt-0" aria-labelledby="addSupervisorDropdownButton"
                                        style="width: 100%;">
                                        <input type="text" class="form-control border-0 border-bottom shadow-none mb-2"
                                            placeholder="Search..." id="add-supervisor-search"
                                            oninput="handleAddSupervisorSearch()"
                                            style="width: 100%; padding-left: 10px;">
                                        @foreach ($supervisors as $supervisor)
                                            <li><a class="dropdown-item add-supervisor-dropdown-item" href="#"
                                                    data-id="{{ $supervisor->id }}"
                                                    data-name="{{ $supervisor->name }}">{{ $supervisor->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <input type="hidden" id="add-supervisor" name="supervisor_id">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control" required
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control" required
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="reporting_time" class="form-label
                                    ">Reporting Time</label>
                                <input type="time" id="reporting_time" name="reporting_time" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" id="start_time" name="start_time" class="form-control" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" id="end_time" name="end_time" class="form-control" required>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="ticket_price" class="form-label">Ticket Price</label>
                                <input type="number" id="ticket_price" name="ticket_price" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="total_route_cost" class="form-label">Total Route Cost</label>
                                <input type="number" id="total_route_cost" name="total_route_cost" class="form-control"
                                    required>
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
        // Handle route selection
        document.querySelectorAll('.add-route-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedRoute = event.target;
                const routeName = selectedRoute.getAttribute('data-name');
                const routeId = selectedRoute.getAttribute('data-id');
                const fromLocationId = selectedRoute.getAttribute('data-from-location-id');

                // Update the selected route display
                document.getElementById('add-selected-route').textContent = routeName;
                document.getElementById('add-route').value = routeId;

                // Fetch vehicles based on the selected route's fromLocationId
                fetchVehicles(fromLocationId);

                // Close the dropdown
                document.getElementById('addRouteDropdownButton').click();
            });
        });

        // Fetch vehicles based on fromLocationId
        function fetchVehicles(fromLocationId) {
            fetch(`/fetch-vehicles?fromLocationId=${fromLocationId}`)
                .then(response => response.json())
                .then(data => {
                    const vehicleDropdownMenu = document.getElementById('vehicle-dropdown-menu');
                    vehicleDropdownMenu.innerHTML = ''; // Clear existing options

                    // Add a search input
                    const searchInput = document.createElement('input');
                    searchInput.type = 'text';
                    searchInput.className = 'form-control border-0 border-bottom shadow-none mb-2';
                    searchInput.placeholder = 'Search...';
                    searchInput.style.width = '100%';
                    searchInput.style.paddingLeft = '10px';
                    searchInput.oninput = handleAddVehicleSearch;
                    vehicleDropdownMenu.appendChild(searchInput);

                    // Add vehicles to the dropdown
                    data.vehicles.forEach(vehicle => {
                        const vehicleItem = document.createElement('li');
                        vehicleItem.innerHTML =
                            `<a class="dropdown-item add-vehicle-dropdown-item" href="#" data-id="${vehicle.id}" data-name="${vehicle.name} (${vehicle.vehicle_no})">${vehicle.name} (${vehicle.vehicle_no})</a>`;
                        vehicleDropdownMenu.appendChild(vehicleItem);
                    });

                    // Re-attach event listeners for the new vehicle items
                    document.querySelectorAll('.add-vehicle-dropdown-item').forEach(item => {
                        item.addEventListener('click', function(event) {
                            event.preventDefault();
                            const selectedVehicle = event.target;
                            const vehicleName = selectedVehicle.getAttribute('data-name');
                            const vehicleId = selectedVehicle.getAttribute('data-id');
                            document.getElementById('add-selected-vehicle').textContent = vehicleName;
                            document.getElementById('add-vehicle').value = vehicleId;
                            document.getElementById('addVehicleDropdownButton').click();
                        });
                    });
                });
        }

        // Handle vehicle search
        function handleAddVehicleSearch() {
            const searchInput = document.getElementById('add-vehicle-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-vehicle-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }

        function handleAddDriverSearch() {
            const searchInput = document.getElementById('add-driver-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-driver-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }
        document.querySelectorAll('.add-driver-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedDriver = event.target;
                const driverName = selectedDriver.getAttribute('data-name');
                const driverId = selectedDriver.getAttribute('data-id');
                document.getElementById('add-selected-driver').textContent = driverName;
                document.getElementById('add-driver').value = driverId;
                document.getElementById('addDriverDropdownButton').click();
            });
        });

        function handleAddHelperSearch() {
            const searchInput = document.getElementById('add-helper-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-helper-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }
        document.querySelectorAll('.add-helper-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedHelper = event.target;
                const helperName = selectedHelper.getAttribute('data-name');
                const helperId = selectedHelper.getAttribute('data-id');
                document.getElementById('add-selected-helper').textContent = helperName;
                document.getElementById('add-helper').value = helperId;
                document.getElementById('addDriverDropdownButton').click();
            });
        });

        function handleAddSupervisorSearch() {
            const searchInput = document.getElementById('add-supervisor-search');
            const filter = searchInput.value.toLowerCase();
            const items = document.querySelectorAll('.add-supervisor-dropdown-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "block" : "none";
            });
        }
        document.querySelectorAll('.add-supervisor-dropdown-item').forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const selectedSupervisor = event.target;
                const supervisorName = selectedSupervisor.getAttribute('data-name');
                const supervisorId = selectedSupervisor.getAttribute('data-id');
                document.getElementById('add-selected-supervisor').textContent = supervisorName;
                document.getElementById('add-supervisor').value = supervisorId;
                document.getElementById('addSupervisorDropdownButton').click();
            });
        });
    </script>
@endsection
