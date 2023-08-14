@include('includes.header')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Schedules</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Schedules</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            @if(Session::has('alert-success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('alert-success')}}
            </div>
            @endif
            @if(Session::has('alert-info'))
            <div class="alert alert-info" role="alert">
                {{Session::get('alert-info')}}
            </div>
            @endif
            @if(Session::has('alert-danger'))
            <div class="alert alert-danger" role="alert">
                {{Session::get('alert-danger')}}
            </div>
            @endif
            @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="leadsList">
                        <div class="card-header border-0">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm-3">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" placeholder="Search for...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-auto">
                                    <div class="hstack gap-2">
                                        <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                        <button type="button" class="btn btn-info" data-bs-toggle="offcanvas" href="#ple"><i class="ri-filter-3-line align-bottom me-1"></i> Filters</button>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Add Schedule</button>
                                        <span class="dropdown">
                                            <button class="btn btn-soft-info btn-icon fs-14" type="button" id="dropdownMeuutton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-settings-4-line"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @error('type')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                            @error('date_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="card-body">
                         
                            <div>
                                <div class="table-responsive table-card">
                                    <table class="table align-middle" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="id">Sl no.</th>
                                                <th class="sort" data-sort="Title">Title</th>
                                                <th class="sort" data-sort="Type">Type</th>
                                                <th class="sort" data-sort="Scheduled At">Scheduled At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            @forelse ($schedules as $schedule)
                                                <tr>
                                                    <td class="service_type">{{ $schedule->id }}</td>
                                                    <td class="service_type">{{ $schedule->title }}</td>
                                                    <td class="service_type">
                                                        @if ($schedule->type == 1)
                                                            Meeting
                                                        @elseif ($schedule->type == 2)
                                                            Call
                                                        @else
                                                            Unknown Type
                                                        @endif
                                                    </td>
                                                    <td class="service_type">
                                                        <?php
                                                        $originalDateTime = $schedule->date_time;
                                                        $dateTimeObject = new DateTime($originalDateTime);
                                                        $formattedDateTime = $dateTimeObject->format('d-m-Y h:i A');
                                                        echo $formattedDateTime;
                                                        ?>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">No schedules available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        
                                    </table>
                                    <div class="noresult" style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                            </lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">We've searched more than 150+ leads We
                                                did not find any
                                                leads for you search.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <!-- Modal starts -->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Schedule</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ url('/') }}/pages/add_schedule" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <input type="text" name="user_type" value="manager" hidden/>
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="title-field" class="form-label">Title</label>
                                                            <input type="text" name="title" id="title-field" class="form-control" placeholder="Enter Schedule Title"  />
                                                           
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                        
                                                    <div class="col-lg-12 mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="type-field" class="form-label">Schedule Type</label>
                                                            <select name="type" id="type-field" class="form-control" required>
                                                                <option disabled selected>select Schedule Type</option>
                                                                <option value="1">Meeting</option>
                                                                <option value="2">Call</option>
                                                            </select>
                                                          
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                        
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="datetimeInput" class="form-label">Schedule Date & Time</label>
                                                            <input type="datetime-local" name="date_time" id="datetimeInput" class="form-control" required />
                                                            
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Schedule</button>
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div><!--end modal-->

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!--end col-->
            </div><!--end row-->
        </div><!-- container-fluid -->
    </div><!-- End Page-content -->


</div>
<!-- end main content-->

@include('includes.footer')