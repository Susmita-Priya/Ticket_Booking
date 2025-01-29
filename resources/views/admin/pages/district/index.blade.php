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
                        <li class="breadcrumb-item active">District!</li>
                    </ol>
                </div>
                <h4 class="page-title">District!</h4>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-end">
                    @can('district-create')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNewModalId">Add New</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Division</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($district as $key=>$districtData)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$districtData->division->name}}</td>
                            <td>{{$districtData->name}}</td>
                            <td>{{$districtData->status==1? 'Active':'Inactive'}}</td>
                            <td style="width: 100px;">
                                <div class="d-flex justify-content-end gap-1">
                                    @can('district-edit')
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editNewModalId{{$districtData->id}}">Edit</button>
                                    @endcan
                                    @can('district-delete')
                                        <a href="{{route('district.destroy',$districtData->id)}}"class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-header-modal{{$districtData->id}}">Delete</a>
                                    @endcan
                                </div>
                            </td>
                            <!--Edit Modal -->
                            <div class="modal fade" id="editNewModalId{{$districtData->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editNewModalLabel{{$districtData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="addNewModalLabel{{$districtData->id}}">Edit</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{route('district.update',$districtData->id)}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name</label>
                                                            <input type="text" id="name" name="name" value="{{$districtData->name}}"
                                                                   class="form-control" placeholder="Enter Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Division</label>
                                                            <select name="division_id" class="form-select">
                                                                <option selected>Select Division</option>
                                                                @foreach($division as $divisionData)
                                                                <option value="{{$divisionData->id}}" {{$districtData->division_id === $divisionData->id ? 'selected' : ''}}>{{$divisionData->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="example-select" class="form-label">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="1" {{ $districtData->status === 1 ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ $districtData->status === 0 ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
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
                            <div id="danger-header-modal{{$districtData->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="danger-header-modalLabel{{$districtData->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header modal-colored-header bg-danger">
                                            <h4 class="modal-title" id="danger-header-modalLabe{{$districtData->id}}l">Delete</h4>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="mt-0">Are You Went to Delete this ? </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <a href="{{route('district.destroy',$districtData->id)}}" class="btn btn-danger">Delete</a>
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
                    <form method="post" action="{{route('district.store')}}">
                        @csrf
                        <div class="row">
                            {{-- <div class="col-12">
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Division</label>
                                    <select name="division_id" class="form-select">
                                        <option selected>Select Division</option>
                                        @foreach($division as $divisionData)
                                        <option value="{{$divisionData->id}}">{{$divisionData->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="example-select" class="form-label">Division</label>
                                    <div class="dropdown">
                                        <button class="btn form-control dropdown-toggle border d-flex justify-content-between align-items-center" 
                                                type="button" 
                                                id="dropdownMenuButton1" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false" 
                                                style="text-align: left; padding-left: 10px;">
                                            <span id="selected-division">Select Division</span>
                                        </button>
                                        <ul class="dropdown-menu pt-0" aria-labelledby="dropdownMenuButton1" style="width: 100%;">
                                            <input type="text" 
                                                   class="form-control border-0 border-bottom shadow-none mb-2" 
                                                   placeholder="Search..." 
                                                   id="division-search" 
                                                   oninput="handleInput()" 
                                                   style="width: 100%; padding-left: 10px;">
                                            @foreach($division as $divisionData)
                                                <li><a class="dropdown-item" href="#" data-id="{{$divisionData->id}}" data-name="{{$divisionData->name}}">{{$divisionData->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="hidden" id="division_id" name="division_id">
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
        // Function to handle input search functionality
        function handleInput() {
            const searchValue = document.getElementById("division-search").value.toLowerCase();
            const items = document.querySelectorAll(".dropdown-menu .dropdown-item");
    
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchValue)) {
                    item.style.display = "block";  // Show item if it matches search
                } else {
                    item.style.display = "none";   // Hide item if it doesn't match
                }
            });
        }
    
        // Function to handle the selection of an item from the dropdown
        document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function() {
                const selectedValue = item.textContent;
                const divisionId = item.getAttribute('data-id');  // Get the division ID
    
                // Update the text inside the button
                document.getElementById("selected-division").textContent = selectedValue;
    
                // Set the division_id in the hidden input for form submission
                document.getElementById("division_id").value = divisionId;
    
                // Optionally, you can close the dropdown after selection (this depends on your preference)
                document.getElementById("dropdownMenuButton1").click();  // This will toggle the dropdown
            });
        });
    </script>
    
@endsection
