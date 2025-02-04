<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Online Ticket Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.ico') }}">
    <!-- Select2 css -->
    <link href="{{ asset('backend/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Datatables css -->
    <link href="{{ asset('backend/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('backend/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backend/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}">
    <script src="{{ asset('backend/js/config.js') }}"></script>
    <link href="{{ asset('backend/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Include Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- datepicker --}}
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
    {{-- Custom Css File here --}}
    <script src="{{ asset('backend/js/chart.js') }}"></script>
    <script src="{{ asset('backend/js/echarts.min.js') }}"></script>
</head>

<body>
    <div class="wrapper">
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-1">
                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line fs-22"></i>
                        </a>
                    </li>
                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode">
                            <i class="ri-moon-line fs-22"></i>
                        </div>
                    </li>
                    <li class="dropdown">
                        @php
                            $admin = auth()->user();
                        @endphp
                        <a class="nav-link dropdown-toggle arrow-none nav-user" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="d-lg-block d-none">
                                <h5 class="my-0 fw-normal">{{ $admin->name }}
                                    <i class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                                </h5>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>
                            <a href="#" class="dropdown-item">
                                <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                                <span>My Account</span>
                            </a>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="leftside-menu">
            <a href="{{ route('dashboard') }}" class="logo logo-light">
                <span class="logo-lg">
                    <img src="{{ URL::to('backend/images/bb.png') }}" alt="logo" style="height: 50px;">
                </span>
                <span class="logo-sm">
                    <img src="{{ URL::to('backend/images/bb.png') }}" alt="small logo">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <ul class="side-nav">
                    <li class="side-nav-title">Main</li>
                    <li class="side-nav-item">
                        <a href="{{ route('dashboard') }}" class="side-nav-link">
                            <i class="ri-dashboard-3-line"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>


                    @can('amenities-list')
                        <li class="side-nav-item">
                            <a href="{{ route('amenities.section') }}" class="side-nav-link">
                                <i class=" ri-pencil-fill"></i>
                                <span> Amenities </span>
                            </a>
                        </li>
                    @endcan

                    @can('cupon-list')
                        <li class="side-nav-item">
                            <a href="{{ route('cupon.section') }}" class="side-nav-link">
                                <i class=" ri-pencil-fill"></i>
                                <span> Coupon </span>
                            </a>
                        </li>
                    @endcan

                    @can('menu-list-for-bus')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPages102" aria-expanded="false"
                               aria-controls="sidebarPages102" class="side-nav-link">
                                <i class="ri-rotate-lock-line"></i>
                                <span>For Bus</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPages102">
                                <ul class="side-nav-second-level">
                                    @can('division-list')
                                        <li>
                                            <a href="{{ route('division.section') }}">Division</a>
                                        </li>
                                    @endcan

                                    @can('district-list')
                                        <li>
                                            <a href="{{ route('district.section') }}">District</a>
                                        </li>
                                    @endcan

                                    @can('counter-list')
                                        <li>
                                            <a href="{{ route('counter.section') }}">Counter</a>
                                        </li>                                 
                                    @endcan

                                    @can('route-manager-list')
                                        <li>
                                            <a href="{{ route('routeManager.section') }}">Route Manager</a>
                                        </li>
                                    @endcan

                                    @can('checker-list')
                                        <li>
                                            <a href="{{ route('checker.section') }}">Checker</a>
                                        </li>
                                    @endcan

                                    @can('owner-list')
                                        <li>
                                            <a href="{{ route('owner.section') }}">Owner</a>
                                        </li>
                                    @endcan

                                    @can('driver-list')
                                        <li>
                                            <a href="{{ route('driver.section') }}">Driver</a>
                                        </li>
                                    @endcan

                                    @can('supervisor-list')
                                        <li>
                                            <a href="{{ route('supervisor.section') }}">Supervisor</a>
                                        </li>
                                    @endcan

                                    @can('type-list')
                                        <li>
                                            <a href="{{ route('type.section') }}">Type</a>
                                        </li>
                                    @endcan

                                    @can('vehicle-list')
                                        <li>
                                            <a href="{{ route('vehicle.section') }}">Vehicle</a>
                                        </li>
                                    @endcan
                                    

                                    @can('route-list')
                                        <li>
                                            <a href="{{ route('route.section') }}">Route</a>
                                        </li>
                                    @endcan

                                    @can('trip-list')
                                        <li>
                                            <a href="{{ route('trip.section') }}">Trip</a>
                                        </li>
                                    @endcan

                                    @can('ticket-booking-list')
                                        <li>
                                            <a href="{{ route('ticket_booking.section') }}">Ticket Booking</a>
                                        </li>
                                    @endcan

                                </ul>
                            </div>
                        </li>
                    @endcan


                    @can('menu-list-for-plane')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPages103" aria-expanded="false"
                               aria-controls="sidebarPages103" class="side-nav-link">
                                <i class="ri-rotate-lock-line"></i>
                                <span>For Flight</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPages103">
                                <ul class="side-nav-second-level">

                                    @can('country-list')
                                        <li>
                                            <a href="{{ route('country.section') }}"> Country</a>
                                        </li>
                                    @endcan
                                    @can('location-list')
                                        <li>
                                            <a href="{{ route('location.section') }}">Location</a>
                                        </li>
                                    @endcan

                                    @can('journey_type-list')
                                        <li>
                                            <a href="{{ route('journey_type.section') }}"> Journey Type</a>
                                        </li>
                                    @endcan
                                    @can('plane-list')
                                        <li>
                                            <a href="{{ route('plane.section') }}">Plane</a>
                                        </li>
                                    @endcan

                                    @can('plane-journey-list')
                                        <li>
                                            <a href="{{ route('plane_journey.section') }}">Plane Journey</a>
                                        </li>
                                    @endcan


                                    @can('booking-list')
                                        <li>
                                            <a href="{{ route('booking.section') }}">Plane Booking</a>
                                        </li>
                                    @endcan



                                </ul>
                            </div>
                        </li>
                    @endcan

                @can('admin-menu-list')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPages101" aria-expanded="false"
                               aria-controls="sidebarPages101" class="side-nav-link">
                                <i class="ri-rotate-lock-line"></i>
                                <span>Admin Menu </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPages101">
                                <ul class="side-nav-second-level">

                                    @can('slider-list')
                                        <li>
                                            <a href="{{ route('slider.section') }}" class="side-nav-link">Slider</a>
                                        </li>
                                    @endcan

                                    @can('about-list')
                                        <li>
                                            <a href="{{ route('about.section') }}">About</a>
                                        </li>
                                    @endcan

                                    @can('blog-list')
                                        <li>
                                            <a href="{{ route('blog.section') }}">Blog</a>
                                        </li>
                                    @endcan

                                    @can('service-list')
                                        <li>
                                            <a href="{{ route('service.section') }}">Service</a>
                                        </li>
                                    @endcan

                                     @can('faq-list')
                                        <li>
                                            <a href="{{ route('faq.section') }}">Faq</a>
                                        </li>
                                     @endcan

                                    @can('category-list')
                                        <li>
                                            <a href="{{ route('category.section') }}">Category</a>
                                        </li>
                                    @endcan

                                    @can('offer-list')
                                        <li>
                                            <a href="{{ route('offer.section') }}">Offer</a>
                                        </li>
                                    @endcan

                                    @can('terms-list')
                                        <li>
                                            <a href="{{ route('terms.section') }}">Terms & Condition</a>
                                        </li>
                                    @endcan

                                    @can('site-setting')
                                        <li>
                                            <a href="{{ route('site.setting') }}">Site Setting</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan

                    @can('role-and-permission-list')
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarPages1" aria-expanded="false"
                                aria-controls="sidebarPages" class="side-nav-link">
                                <i class="ri-rotate-lock-line"></i>
                                <span>Permission Manage </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPages1">
                                <ul class="side-nav-second-level">
                                    @can('user-list')
                                        <li>
                                            <a href="{{ url('users') }}">Create User</a>
                                        </li>
                                    @endcan

                                    @can('role-list')
                                        <li>
                                            <a href="{{ url('roles') }}">Role & Permission</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @yield('admin_content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Online Ticket Booking</b>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('backend/js/vendor.min.js') }}"></script>
    <!-- Dropzone File Upload js -->
    <script src="{{ asset('backend/vendor/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('backend/js/pages/fileupload.init.js') }}"></script>
    <!--  Select2 Plugin Js -->
    <script src="{{ asset('backend/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('backend/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
    </script>
    <!-- Ckeditor Here -->
    <script src="{{ asset('backend/js/sdmg.ckeditor.js') }}"></script>
    <!-- Datatables js -->
    <script src="{{ asset('backend/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script>
    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('backend/js/pages/datatable.init.js') }}"></script>
    <script src="{{ asset('backend/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('backend/js/app.min.js') }}"></script>
    
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000,
            extendedTimeOut: 1000,
        };
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor.create(document.querySelector('#content'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor.create(document.querySelector('#contentAdd'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <!-- Include JS for Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-control[multiple]').select2({
                allowClear: true
            });
        });
    </script>

</body>

</html>
