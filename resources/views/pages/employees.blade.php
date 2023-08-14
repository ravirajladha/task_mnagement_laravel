@include('includes.header')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Employees</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Employees</li>
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
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Add Employee</button>
                                        <span class="dropdown">
                                            <button class="btn btn-soft-info btn-icon fs-14" type="button" id="dropdownMeuutton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-settings-4-line"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card">
                                    <table class="table align-middle" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="sort" data-sort="Id">Id</th>
                                                <th class="sort" data-sort="Name">Name</th>
                                                <th class="sort" data-sort="Email">Email</th>
                                                <th class="sort" data-sort="Phone No">Phone No</th>
                                                <th class="sort" data-sort="Post">Post</th>
                                                <th class="sort" data-sort="Joining Date">Joining Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <?php
                                            $count = 0;
                                             if (count($employees) > 0) { 
                                                $count++;
                                                ?>
                                                <tr>
                                                    <td class="service_type" colspan="6">Total Employees: <?php echo count($employees); ?></td>
                                                </tr>
                                                <?php foreach ($employees as $employee) { ?>
                                                    <tr>
                                                        <td class="service_type"><?php echo $count ?></td>
                                                        <td class="service_type"><?php echo $employee->name ?></td>
                                                        <td class="service_type"><?php echo $employee->email ?></td>
                                                        <td class="service_type"><?php echo $employee->phone ?></td>
                                                        <td class="service_type"><?php echo $employee->post ?></td>
                                                        <td class="service_type"><?php echo $employee->joining_date ?></td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="service_type" colspan="6">No employees in the database.</td>
                                                </tr>
                                            <?php } ?>
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
                                            <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ url('/') }}/pages/add_employee" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="name-field" class="form-label">Name</label>
                                                            <input type="text" name="name" id="name-field" class="form-control" placeholder="Enter Name" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="email-field" class="form-label">Email</label>
                                                            <input type="email" name="email" id="email-field" class="form-control" placeholder="Enter Email" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="phone-field" class="form-label">Phone Number</label>
                                                            <input type="number" name="phone" id="phone-field" class="form-control" placeholder="Enter Phone Number" maxlength="10" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="post-field" class="form-label">Post</label>
                                                            <input type="text" name="post" id="post-field" class="form-control" placeholder="Enter Post" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="joining-date-field" class="form-label">Joining Date</label>
                                                            <input type="date" name="joining_date" id="joining-date-field" class="form-control" placeholder="Enter Joining Date" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    {{-- <div class="col-lg-12">
                                                        <div>
                                                            <label for="temp-password-field" class="form-label">Temporary Password</label>
                                                            <input type="text" name="temp_password" id="temp-password-field" class="form-control" placeholder="Enter Password" required />
                                                        </div>
                                                    </div> --}}
                                                    <!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Employee</button>

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

@include("includes.footer")