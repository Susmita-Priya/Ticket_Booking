@extends('admin.app')
@section('admin_content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Permission Manage</a></li>
                        <li class="breadcrumb-item active">Users Management!</li>
                    </ol>
                </div>
                <h4 class="page-title">Users Management!</h4>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="col-12">
        <div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-end">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
    </div>
    <br>

    <div class="card-body table-responsive">
        <table id="basic-datatable" class="table table-striped nowrap w-100">
            <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Status</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <label>{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td>{{$user->status==1? 'Active':'Inactive'}}</td>
                <td>
                    <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>

    {{-- {{ $data->links('pagination::bootstrap-4') }} --}}
    {{-- {!! $data->render() !!} --}}


@endsection
