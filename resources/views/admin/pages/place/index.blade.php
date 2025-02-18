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
                    @can('place-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>District</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($place as $key=>$placeData)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$placeData->district->name}}</td>
                            <td>{{$placeData->name}}</td>
                            <td>{{$placeData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    @can('place-edit')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$placeData->id}}">Edit</button>
                                    @endcan
                                    @can('place-delete')
                                        <a href="{{route('place.destroy',$placeData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$placeData->id}}">Delete</a>
                                    @endcan
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$placeData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$placeData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$placeData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('place.update',$placeData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name" value="{{$placeData->name}}"
                                                                   class="form-control" placeholder="Enter Name" required>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">District</label>
                                                            <div class="dropdown district-dropdown">
                                                                <button class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center" 
                                                                        type="button" 
                                                                        data-bs-toggle="dropdown" 
                                                                        aria-expanded="false" 
                                                                        style="text-align: left; padding-left: 10px;">
                                                                    <span class="selected-district">
                                                                        {{ $placeData->district->name ?? 'Select District' }}
                                                                    </span>
                                                                </button>
                                                                <ul class="dropdown-menu pt-0" style="width: 100%;">
                                                                    <input type="text" 
                                                                           class="form-control border-0 border-bottom shadow-none mb-2 district-search" 
                                                                           placeholder="Search..."  
                                                                           style="width: 100%; padding-left: 10px;">
                                                                    @foreach($district as $districtData)
                                                                        <li>
                                                                            <a class="dropdown-item district-option" href="#" 
                                                                               data-id="{{ $districtData->id }}" 
                                                                               data-name="{{ $districtData->name }}" 
                                                                               @if(isset($placeData->district_id) && $placeData->district_id == $districtData->id) 
                                                                                   style="font-weight:bold;" 
                                                                               @endif>
                                                                                {{ $districtData->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <input type="hidden" class="district-id" name="district_id" value="{{ $placeData->district_id }}">
                                                        </div>
                                                    </div>

                                                </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="example-select" class="form-label">Status</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1" {{ $placeData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                    <option value="0" {{ $placeData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary" type="submit">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Delete Modal -->
                            <div id="danger-header-modal{{$placeData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$placeData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$placeData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('place.destroy',$placeData->id)}}" class="btn btn-danger">Delete</a>
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
    <!--Add Modal -->
    <div class="modal fade" id="addNewModalId" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addNewModalLabel">Add</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('place.store')}}">
                        @csrf
                        <div class="row">

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">District</label>
                                    <div class="dropdown">
                                        <button class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center" 
                                                type="button" 
                                                id="dropdownMenuButton1" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" 
                                                style="text-align: left; padding-left: 10px;">
                                            <span id="selected-district">Select District</span>
                                        </button>
                                        <ul class="dropdown-menu pt-0" aria-labelledby="dropdownMenuButton1" style="width: 100%;">
                                            <input type="text" 
                                                   class="form-control border-0 border-bottom shadow-none mb-2" 
                                                   placeholder="Search..." 
                                                   id="district-search" 
                                                   oninput="handleInput()" 
                                                   style="width: 100%; padding-left: 10px;">
                                            @foreach($district as $districtData)
                                                <li><a class="dropdown-item" href="#" data-id="{{$districtData->id}}" data-name="{{$districtData->name}}">{{$districtData->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" id="district_id" name="district_id">
                                </div>
                            </div>
                                                                                   
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control" placeholder="Enter Name" required>
                                </div>
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
        function handleInput() {
            const searchValue = document.getElementById("district-search").value.toLowerCase();
            const items = document.querySelectorAll(".dropdown-menu .dropdown-item");
    
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        }
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectedValue = item.textContent;
                const districtId = item.getAttribute('data-id');
                document.getElementById("selected-district").textContent = selectedValue;
                document.getElementById("district_id").value = districtId;
                document.getElementById("dropdownMenuButton1").click();
            });
        });
    </script>

    <script>
        document.querySelectorAll('.district-dropdown').forEach(dropdown => {
            const searchInput = dropdown.querySelector('.district-search');
            const items = dropdown.querySelectorAll('.dropdown-item');

            searchInput.addEventListener('input', function() {
                const searchValue = searchInput.value.toLowerCase();
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchValue) ? "block" : "none";
                });
            });
            dropdown.addEventListener('click', function(event) {
                if (event.target.classList.contains('district-option')) {
                    event.preventDefault();
                    
                    const selectedValue = event.target.getAttribute('data-name');
                    const districtId = event.target.getAttribute('data-id');
                    dropdown.querySelector('.selected-district').textContent = selectedValue;
                    dropdown.nextElementSibling.value = districtId;
                    dropdown.querySelector('.dropdown-toggle').click();
                }
            });
        });
    </script>
    
@endsection
