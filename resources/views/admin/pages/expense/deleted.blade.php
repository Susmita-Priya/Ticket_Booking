@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Resource</a></li>
                        <li class="breadcrumb-item active">Deleted Expenses!</li>
                    </ol>
                </div>
                <h4 class="page-title">Deleted Expenses!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                </div>
            </div>
            <div class="card-body table-responsive">
                <table id="basic-datatable" class="table table-striped nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company Name</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedExpenses as $expense)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $expense->company->name }}</td>
                                <td>
                                    @if ($expense->department == 'Checker')
                                        <span class="badge bg-primary">Checker</span>
                                    @elseif($expense->department == 'Driver')
                                        <span class="badge bg-secondary">Driver</span>
                                    @elseif($expense->department == 'Helper')
                                        <span class="badge bg-success">Helper</span>
                                    @elseif($expense->department == 'Supervisor')
                                        <span class="badge bg-danger">Supervisor</span>
                                    @elseif($expense->department == 'Route Manager')
                                        <span class="badge bg-warning">Route Manager</span>
                                    @elseif($expense->department == 'Owner')
                                        <span class="badge bg-info">Owner</span>
                                    @else
                                        <span class="badge bg-dark">{{ $expense->department }}</span>
                                    @endif
                                </td>
                                <td>{{ $expense->type }}</td>
                                <td>{{ $expense->employee->name ?? ($expense->counter->name ?? ($expense->vehicle->name ?? ($expense->route->fromLocation->name . ' to ' . $expense->route->toLocation->name ?? 'N/A'))) }}
                                </td>
                                <td>{{ number_format($expense->amount, 2) }}TK</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td>{{ $expense->deleted_at }}</td>
                                <td>
                                    <form action="{{ route('expense.restore', $expense->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('expense.forceDelete', $expense->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
