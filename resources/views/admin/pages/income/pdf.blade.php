<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1 class="text-center" style="margin: 0; padding: 0;">Income Report</h1>
    <h2 class="text-center" style="color: rgb(3, 3, 102); margin: 0; padding: 0;">{{ auth()->user()->name }}</h2>
    <p class="text-center" style="margin: 0; padding: 0;">{{ \Carbon\Carbon::now()->format('d F Y, h:i:s A') }}</p>
    <div style="margin-bottom: 20px;"></div>

    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Route</th>
                <th>Vehicle</th>
                <th>Amount</th>
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
                    $totalIncome = $group->sum(
                        fn($income) => collect(json_decode($income->seat_data, true) ?? [])->sum('seatPrice'),
                    );
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $firstIncome->trip->route->fromLocation->name }} to
                        {{ $firstIncome->trip->route->toLocation->name }}</td>
                    <td>{{ $firstIncome->vehicle->name }} (Coach - {{ $firstIncome->vehicle->vehicle_no }})</td>
                    <td>{{ number_format($totalIncome, 2) }}TK</td>
                    <td>{{ \Carbon\Carbon::parse($firstIncome->travel_date)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-right"><strong>Total Income:</strong></td>
                <td><strong><span
                    class="text-success">{{ number_format($groupedIncomes->sum(fn($group) => $group->sum(fn($income) => collect(json_decode($income->seat_data, true) ?? [])->sum('seatPrice'))), 2) }}TK</span></strong>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
