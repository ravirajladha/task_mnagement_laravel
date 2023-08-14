@include('includes/header')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Teams</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Teams</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

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
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Create Teams</button>
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
                                                <th class="sort" data-sort="Id">Name</th>
                                                <th class="sort" data-sort="Name">Team Lead</th>
                                                <th class="sort" data-sort="Name">Members</th>
                                               
                                                
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <tr>
                                                
                                            <?php
                                            foreach ($allTeams as $team) { ?>
                                                <td class="service_type"><?php echo $team->name ?></td>
                                                <td class="service_type">{{ $team->teamLead->name }}</td>

                                                <td class="service_type">
                                                    <?php
                                                    $team_member_ids = explode(',', $team->team_members);
                                                    $team_member_names = [];
                                                    
                                                    foreach ($team_member_ids as $memberId) {
                                                        foreach ($allEmployees as $employee) {
                                                            if ($employee->user_id == $memberId) {
                                                                $team_member_names[] = $employee->name;
                                                                break;
                                                            }
                                                        }
                                                    }
                                        
                                                    echo implode(', ', $team_member_names);
                                                    ?>
                                                </td>

                                          
                                                
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
                                        <form action="{{url('/')}}/pages/create_teams" method="post">
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

                                                    <div class="col-lg-6">
                                                        <div>
                                                        <label for="" class="form-label">Select Team Members</label>
                                                        @foreach ($allEmployees as $employee)
                                                        @if (!in_array($employee->user_id, $allTeamMembers))
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="team_members[]" type="checkbox" value="{{ $employee->user_id }}" id="flexCheckDefault{{ $employee->user_id }}">
                                                                <label class="form-check-label" for="flexCheckDefault{{ $employee->user_id }}">
                                                                    {{ $employee->name }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-6">
                                                        <div>
                                                        <label for="" class="form-label">Select Team Lead</label>
                                                        @foreach ($allEmployees as $employee)
                                                        @if (!in_array($employee->user_id, $allTeamMembers))
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="{{ $employee->user_id }}" name="team_lead" id="flexRadioDefault{{ $employee->user_id }}">
                                                                <label class="form-check-label" for="flexRadioDefault{{ $employee->user_id }}">
                                                                    {{ $employee->name }}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Create Team</button>

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