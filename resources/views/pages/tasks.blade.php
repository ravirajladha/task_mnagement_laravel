@include('includes/header')


<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tasks</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Tasks</li>
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
                                        <!-- <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i>Add Schedule</button> -->
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
                                                <!-- <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                                    </div>
                                                </th> -->
                                                <th class="sort" data-sort="id">Sl no.</th>
                                                <!-- <th class="sort" data-sort="Assigned By">Assigned By</th> -->
                                                <th class="sort" data-sort="Project Name">Project Name</th>
                                                <th class="sort" data-sort="Category Name">Category Name</th>
                                                <th class="sort" data-sort="Sub-Category Name">Sub-Category Name</th>
                                                <th class="sort" data-sort="Task Name">Task Name</th>
                                                <th class="sort" data-sort="Task Name">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <tr>
                                                <?php foreach ($tasks as $task) { ?>
                                                    <!-- <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input task-checkbox" type="checkbox" name="task[]" value="<?php echo $task->id; ?>">
                                                        </div>
                                                    </td> -->
                                                    <td class="service_type"><?php echo $task->id ?></td>
                                                    <td class="service_type"><?php echo $task->project_id ?></td>
                                                    <td class="service_type"><?php echo $task->category_id ?></td>
                                                    <td class="service_type"><?php echo $task->sub_category_id ?></td>
                                                    <td class="service_type"><?php echo $task->task_name ?></td>
                                                    <td class="service_type">
                                                    <select name="" id="<?php echo $task->id; ?>" class="form-control statusDropdown" data-task-id="<?php echo $task->id; ?>">
                                                        <option value="0" <?php if($task->status ==0 ){echo "selected";} ?>>Assigned</option>
                                                        <option value="1" <?php if($task->status ==1 ){echo "selected";} ?>>Started</option>
                                                        <option value="2" <?php if($task->status ==2 ){echo "selected";} ?>>Paused</option>
                                                        <option value="3" <?php if($task->status ==3 ){echo "selected";} ?>>Completed</option>
                                                    </select>    
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

                                <!-- <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <button type="button" class="btn btn-success" id="submit-btn">Submit Selected Tasks</button>
                                       
                                    </div>
                                </div> -->

                            </div>

                            <!-- Modal starts -->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Schedule</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="/ceo/add_schedule" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="title-field" class="form-label">Title</label>
                                                            <input type="text" name="title" id="title-field" class="form-control" placeholder="Enter Schedule Title" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="type-field" class="form-label">Schedule Type</label>
                                                            <select name="type" id="type-field" class="form-control" required />
                                                            <option disabled selected>select Schedule Type</option>
                                                            <option value="meeting">Meeting</option>
                                                            <option value="call">Call</option>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->

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
@include('includes/footer')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.statusDropdown').change(function() {
        var selectedValue = $(this).val();
        var taskId = $(this).data('task-id');
        console.log(selectedValue);
        // Send an AJAX request to update the status in the database
        $.ajax({
            type: 'POST', // You can adjust the HTTP method based on your needs
            url: '/employees/update_status', // The URL where you handle the database update
            data: { taskId: taskId, status: selectedValue },
            success: function(response) {
                // Update the status display
                console.log(response);
                $('#statusDisplay').text(selectedValue);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
</script>
