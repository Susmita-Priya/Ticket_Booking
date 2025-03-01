@extends('admin.app')
@section('admin_content')
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Online Ticket Booking</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                            <li class="breadcrumb-item active">Welcome!</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Welcome!</h4>
                </div>
            </div>
        </div>

        @can('cart-list')
        <div class="row">
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-pink">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-store-2-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Counter</h6>
                        <h2 class="my-2">{{ count($counters) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-purple">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-road-map-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Route</h6>
                        <h2 class="my-2">{{ count($routes) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-info">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-user-settings-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Route Manager</h6>
                        <h2 class="my-2">{{ count($routeManagers) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-primary">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-shield-user-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Checker</h6>
                        <h2 class="my-2">{{ count($checkers) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-success">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-user-star-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Owner</h6>
                        <h2 class="my-2">{{ count($owners) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-primary">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-steering-2-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Driver</h6>
                        <h2 class="my-2">{{ count($drivers) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-danger">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-bus-2-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Vehicle</h6>
                        <h2 class="my-2">{{ count($vehicles) }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat text-bg-warning">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-roadster-line widget-icon"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Total Trip</h6>
                        <h2 class="my-2">{{ count($trips) }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        @can('login-log-list')
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                    </div>
                </div>
                <div class="card-body">
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Email</th>
                            <th>IP</th>
                            <th>Browser</th>
                            <th>Platform</th>
                            <th>Last Login</th>
                            <th>User Agent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loginLog as $key=>$loginLogData)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$loginLogData->email}}</td>
                                <td>{{$loginLogData->ip}}</td>
                                <td>{{$loginLogData->browser}}</td>
                                <td>{{$loginLogData->platform}}</td>
                                <td>{{$loginLogData->last_login}}</td>
                                <td>{{$loginLogData->user_agent}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endcan
@endsection
