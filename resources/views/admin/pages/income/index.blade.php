@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Income</li>
                    </ol>
                </div>
                <h4 class="page-title">Income</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <form method="GET" action="{{ route('income.section') }}" class="d-flex gap-2">
                        <select name="route_id" id="route_id" class="form-select" style="width: 200px;">
                            <option value="" selected>All Routes</option>
                            @foreach ($routes as $route)
                                <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }}>
                                    {{ $route->fromLocation->name }} to {{ $route->toLocation->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="owner_id" id="owner_id" class="form-select" style="width: 200px;">
                            <option value="" selected>All Owners</option>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>
                                    {{ $owner->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="vehicle_id" id="vehicle_id" class="form-select" style="width: 200px;">
                            <option value="" selected>All Vehicles</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->name }} (Coach - {{ $vehicle->vehicle_no }})
                                </option>
                            @endforeach
                        </select>
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('income.section') }}" class="btn btn-secondary">Reset</a>
                    </form>
                    <div class="d-flex justify-content-between align-items-center ms-2 w-100">
                        <a href="{{ route('income.pdf', request()->all()) }}" class="btn btn-success">Download PDF</a>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive">
                <h3 class="text-center">List of all incomes</h3>
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Route Name</th>
                            <th>Vehicle Name</th>
                            <th>Income</th>
                            <th>Travel Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $groupedIncomes = $incomes->groupBy(function ($income) {
                                return $income->trip->route->id . '-' . $income->vehicle->id . '-' . $income->travel_date;
                            });
                        @endphp
                        @foreach ($groupedIncomes as $key => $group)
                            @php
                                $firstIncome = $group->first();
                                $totalIncome = $group->sum(fn($income) => collect(json_decode($income->seat_data, true) ?? [])->sum('seatPrice'));
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $firstIncome->trip->route->fromLocation->name }} to {{ $firstIncome->trip->route->toLocation->name }}</td>
                                <td>{{ $firstIncome->vehicle->name }} (Coach - {{ $firstIncome->vehicle->vehicle_no }})</td>
                                <td>{{ number_format($totalIncome, 2) }}TK</td>
                                <td>{{ \Carbon\Carbon::parse($firstIncome->travel_date)->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Income:</strong></td>
                            <td><strong><span class="text-success">{{ number_format($groupedIncomes->sum(fn($group) => $group->sum(fn($income) => collect(json_decode($income->seat_data, true) ?? [])->sum('seatPrice'))), 2) }}TK</span></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        function fetchVehicles() {
            const routeId = $('#route_id').val();
            const ownerId = $('#owner_id').val();
            const vehicleSelect = $('#vehicle_id');

            vehicleSelect.html('<option value="" selected>All Vehicles</option>');

            // Fetch vehicles based on route_id and owner_id
            $.ajax({
                url: `/get-vehicles`,
                method: 'GET',
                data: { route_id: routeId, owner_id: ownerId },
                dataType: 'json',
                success: function (data) {
                    if (data.vehicles && data.vehicles.length > 0) {
                        data.vehicles.forEach(vehicle => {
                            vehicleSelect.append(new Option(`${vehicle.name} (Coach - ${vehicle.vehicle_no})`, vehicle.id));
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching vehicles:", error);
                }
            });
        }

        $('#route_id, #owner_id').on('change', fetchVehicles);
    });
</script>

@endsection
