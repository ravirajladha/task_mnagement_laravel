@include('includes/header')

<style>
    /* #customerTable tbody tr td:nth-child(2n+1) { */
    #customerTable tbody tr:nth-child(odd) {
        background-color: #f5f5f5;
        /* Specify your desired background color */
    }
</style>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Courses</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Courses</li>
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
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#projectModal"><i class="ri-add-line align-bottom me-1"></i>Add Course</button>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#categoryModal"><i class="ri-add-line align-bottom me-1"></i>Add Category</button>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#subcategoryModal"><i class="ri-add-line align-bottom me-1"></i>Add Sub-category</button>
                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#taskModal"><i class="ri-add-line align-bottom me-1"></i>Add Task</button>
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
                           
                            <div class="nav-tabs-horizontal">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="nav nav-tabs flex-column" id="projectTabs" role="tablist">
                                            @foreach ($projectsData as $index => $projectData)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="project-tab-{{ $projectData['project_id'] }}" data-bs-toggle="tab" href="#project-panel-{{ $projectData['project_id'] }}" role="tab" aria-controls="project-panel-{{ $projectData['project_id'] }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                                                        {{ $projectData['project_name'] }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content" id="projectTabContent">
                                            @foreach ($projectsData as $index => $projectData)
                                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="project-panel-{{ $projectData['project_id'] }}" role="tabpanel" aria-labelledby="project-tab-{{ $projectData['project_id'] }}">
                                                    <ul class="nav nav-tabs flex-column" id="categoryTabs-{{ $projectData['project_id'] }}" role="tablist">
                                                        @foreach ($projectData['categories'] as $categoryData)
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="category-tab-{{ $categoryData['category_id'] }}" data-bs-toggle="tab" href="#category-panel-{{ $categoryData['category_id'] }}" role="tab" aria-controls="category-panel-{{ $categoryData['category_id'] }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                    {{ $categoryData['category_name'] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                        @if (count($projectData['categories']) === 0)
                                                            <p>No categories added.</p>
                                                        @endif
                                                    </ul>
                                                    <div class="tab-content" id="categoryTabContent-{{ $projectData['project_id'] }}">
                                                        @foreach ($projectData['categories'] as $categoryData)
                                                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="category-panel-{{ $categoryData['category_id'] }}" role="tabpanel" aria-labelledby="category-tab-{{ $categoryData['category_id'] }}">
                                                                @if (count($categoryData['sub_categories']) === 0)
                                                                    <p>No sub-categories added.</p>
                                                                @else
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Total employees</th>
                                                                                <th>Percentage</th>
                                                                                <th>View</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($categoryData['sub_categories'] as $subCategory)
                                                                                <tr>
                                                                                    <td>{{ $subCategory['sub_category_name'] }}</td>
                                                                                    <td>...</td>
                                                                                    <td>...</td>
                                                                                    <td>
                                                                                        <a href="{{ URL::to('/managers/view_sub_category', [$projectData['project_id'], $categoryData['category_id'], $subCategory['sub_category_id']]) }}" class="btn btn-primary">View</a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        {{-- test --}}
                        <div class="card-body">
                            <div>

                        


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
                            <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ url('/') }}/pages/add_project" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="name-field" class="form-label">Course Name</label>
                                                            <input type="text" name="project_name" id="name-field" class="form-control" placeholder="Enter Project Name" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="type-field" class="form-label">Project Type</label>
                                                            <select name="project_type" id="type-field-1" class="form-control" required>
                                                                <option value="" disabled selected>Select Project Type</option>
                                                                <option value="1">Education</option>
                                                                <option value="2">Content</option>
                                                                <option value="3">Pictorial</option>
                                                                <option value="4">Mangement</option>
                                                                <option value="5">Technical</option>
                                                                <option value="6">Miscellanous</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Project</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--end modal-->

                            <!-- Modal starts -->
                            <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Category2</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ url('/') }}/pages/add_category" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="category-field" class="form-label">Category Name</label>
                                                            <input type="text" name="category_name" id="category-field" class="form-control" placeholder="Enter Category Name" required />
                                                        </div>
                                                    </div>
                                           

                                                    <div class="col-lg-12  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="project-field" class="form-label">Project</label>
                                                            <select name="project_id" id="project-field" class="form-control" required />
                                                            <option disabled selected>select Project</option>
                                                            <?php foreach ($projectsData as $project) {
                                                              ?>
                                                                  {{-- @foreach ($project['categories'] as $category) --}}
                                                                  <option value="{{ $project['project_id'] }}">{{ $project['project_name'] }}</option>
                                                              {{-- @endforeach --}}
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Category</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--end modal-->

                            <!-- Modal starts -->
                            <div class="modal fade" id="categoryModal111" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Category1</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="/managers/add_category" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="category-field" class="form-label">Category Name</label>
                                                            <input type="text" name="category_name" id="category-field" class="form-control" placeholder="Enter Category Name" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <div class="col-lg-12  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="project-field" class="form-label">Project</label>
                                                            <select name="project_id" id="project-field" class="form-control" required>
                                                            <option disabled selected>select Project</option>
                                                            <?php foreach ($projectsData as $project) {  ?>
                                                                @foreach ($project['categories'] as $category)
                                                                <option value="{{ $project['project_id'] }}">{{ $project['project_name'] }}</option>
                                                            @endforeach
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Category</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--end modal-->

                            <!-- Modal starts -->
                            <div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Sub-Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{ url('/') }}/pages/add_subcategory" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="sub-category-field" class="form-label">Sub-Category Name</label>
                                                            <input type="text" name="sub_category_name" id="sub-category-field" class="form-control" placeholder="Enter Sub-Category Name" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="project-field" class="form-label">Project</label>
                                                            <select name="project_id" id="project-field3" class="form-control" required >
                                                            <option disabled selected>select Project</option>
                                                            <?php foreach ($projectsData  as $project) {  ?>
                                                                {{-- @foreach ($project['categories'] as $category) --}}
                                                                <option value="{{ $project['project_id'] }}">{{ $project['project_name'] }}</option>
                                                            {{-- @endforeach --}}
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->

                                                    <div class="col-lg-12  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="category-field" class="form-label">Category</label>
                                                            <select name="category_id" id="category-field3" class="form-control" required>
                                                            <option disabled selected>select Category</option>
                                                        
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->

                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Sub-category</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!--end modal-->

                            <!-- Modal starts -->
                            <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="{{url('/')}}/pages/add_task" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field" />
                                                <div class="row g-3">
                                                    <div class="col-lg-6  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="employee-field" class="form-label">Assign to</label>
                                                            <select name="employee_id" id="employee-field" class="form-control" required>
                                                            <option disabled selected>select Employee</option>
                                                            <?php foreach ($projectsData as $project) { ?>
                                                                <?php foreach ($project['employees'] as $employee) { ?>
                                                                    <option value="<?php echo $employee->user_id ?>"><?php echo $employee->name ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                           
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="task-field" class="form-label">Task Name</label>
                                                            <input type="text" name="task_name" id="task-field" class="form-control" placeholder="Enter Task Name" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6 mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="project-field" class="form-label">Project</label>
                                                            <select name="project_id" id="project-field4" class="form-control" required >
                                                            <option disabled selected> Project</option>
                                                            <?php foreach ($projectsData  as $project) {  ?>
                                                                {{-- @foreach ($project['categories'] as $category) --}}
                                                                <option value="{{ $project['project_id'] }}">{{ $project['project_name'] }}</option>
                                                            {{-- @endforeach --}}
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-6  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="category-field" class="form-label">Category</label>
                                                            <select name="category_id" id="category-field4" class="form-control" required>
                                                            <option disabled selected>select Category</option>
                                                            
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-6  mt-3">
                                                        <div class="dropdown mb-3">
                                                            <label for="sub-category-field" class="form-label">Sub-Category</label>
                                                            <select name="sub_category_id" id="sub-category-field4" class="form-control" required>
                                                            <option disabled selected>select Sub-Category</option>
                                                           
                                                            </select>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="task-field" class="form-label">Url</label>
                                                            <input type="text" name="url" id="task-field" class="form-control" placeholder="Enter Url" required />
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add Task</button>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
 $(document).ready(function () {
    $('#project-field3').on('change', function () {
        var projectId = $(this).val();
        var categorySelect = $('#category-field3');

        if (projectId) {
            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/pages/get_json_categories',
                data: { project_id: projectId },
                success: function (response) {
                    console.log("Response:", response);
                    try {
                        // console.log
                        // var categories = JSON.parse(response);
                        // console.log(categories);

                        var optionsHtml = '<option disabled selected>Select category</option>';
                        $.each(response, function (key, category) {
                            optionsHtml += '<option value="' + category.id + '">' + category.category_name + '</option>';
                        });
                        categorySelect.html(optionsHtml);

                    } catch (e) {
                        console.log("Error parsing JSON:", e);
                        console.log("Response:", response);
                    }
                }
            });
        } else {
            categorySelect.html('<option disabled selected>Select User</option>');
        }
    });
});
 $(document).ready(function () {
    $('#project-field4').on('change', function () {
        var projectId = $(this).val();
        var categorySelect = $('#category-field4');

        if (projectId) {
            $.ajax({
                type: 'GET',
                url: '{{ url('/') }}/pages/get_json_categories',
                data: { project_id: projectId },
                success: function (response) {
                    console.log("Response:", response);
                    try {
                        // console.log
                        // var categories = JSON.parse(response);
                        // console.log(categories);

                        var optionsHtml = '<option disabled selected>Select category</option>';
                        $.each(response, function (key, category) {
                            optionsHtml += '<option value="' + category.id + '">' + category.category_name + '</option>';
                        });
                        categorySelect.html(optionsHtml);

                    } catch (e) {
                        console.log("Error parsing JSON:", e);
                        console.log("Response:", response);
                    }
                }
            });
        } else {
            categorySelect.html('<option disabled selected>Select User</option>');
        }
    });
});



 

// selcting task subcategory
$(document).ready(function () {
        $('#category-field4').on('change', function () {
            var categoryId = $(this).val();
            var sub_categorySelect = $('#sub-category-field4');
            // alert(categoryId);

            if (categoryId) {
                $.ajax({
                    type: 'GET',
                    url: '{{ url('/') }}/pages/get_json_sub_categories', // Replace with the actual URL that fetches user data based on project ID
                    data: {category_id: categoryId},
                    success: function (response) {
                        console.log(response);
                        // var sub_categories = JSON.parse(response);
                        // sub_categories
                        var optionsHtml = '<option disabled selected>Select category</option>';

                        $.each(response, function (key, sub_category) {
                            // console.log(category.id);
                            optionsHtml += '<option value="' + sub_category.id + '">' + sub_category.sub_category_name + '</option>';
                        });
                        sub_categorySelect.html(optionsHtml);
                    },
                    error: function (xhr, status, error) {
        console.log("Ajax Error:", error);
    }
                });
            } else {
                sub_categorySelect.html('<option disabled selected>Select User</option>');
            }
        });
    });

</script>


@if(session()->has('alert'))
    @if(session()->get('alert')['type'] == 'success')
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session()->get('alert')['message'] }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @elseif(session()->get('alert')['type'] == 'warning')
        <script>
            Swal.fire({
                icon: 'warning',
                title: '{{ session()->get('alert')['message'] }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif
    {{ session()->forget('alert') }}
@endif

