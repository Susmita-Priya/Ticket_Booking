<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1 class="text-center" style="margin: 0; padding: 0;">Expense Report</h1>
    <h2 class="text-center" style="color: rgb(3, 3, 102); margin: 0; padding: 0;">{{ auth()->user()->name }}</h2>
    <p class="text-center" style="margin: 0;  padding: 0;">{{ \Carbon\Carbon::now()->format('d F Y, h:i:s A') }}</p>
    <div style="margin-bottom: 20px;"></div>
 
    <table>
        <thead>
            <tr>
                <th>S/N</th>
                <th>Department</th>
                <th>Type</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $key => $expense)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $expense->department }}</td>
                    <td>{{ $expense->type }}</td>
                    <td>
                        {{ $expense->employee->name ?? 
                           ($expense->counter->name ?? 
                           ($expense->vehicle ? $expense->vehicle->name . ' (Coach - ' . $expense->vehicle->vehicle_no . ')' : 
                           ($expense->route->fromLocation->name . ' to ' . $expense->route->toLocation->name ?? 'N/A'))) }}
                    </td>
                    <td>{{ number_format($expense->amount, 2) }} TK</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="text-right"><strong>Total Expense:</strong></td>
                <td><strong>{{ number_format($expenses->sum('amount'), 2) }} TK</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
