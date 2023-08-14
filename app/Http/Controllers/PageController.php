<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Project;
use App\Models\Category;
use App\Models\Sub_category;
use App\Models\Todo;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ScheduleRequest;
use Dotenv\Exception\ValidationException;

class PageController extends Controller
{
  public function index()
  {
    return view('pages.index');
  }

  public function schedules()
  {
    // Get the logged-in user's ID from the session
    $userId = session()->get('kods_auth_userid');

    // Fetch tasks from the database where "created_by" matches the user ID
    $schedules = Schedule::where('created_by', $userId)->paginate(5);

    $data = [
      'schedules' => $schedules,
    ];
    return view('pages.schedules', $data);
  }

  public function groups()
  {
    // Get the logged-in user's ID from the session
    $userId = session()->get('kods_auth_userid');

    // Fetch tasks from the database where "created_by" matches the user ID
    $schedules = Schedule::where('created_by', $userId)->paginate(5);

    $data = [
      'schedules' => $schedules,
    ];
    return view('pages.schedules', $data);
  }

  public function add_schedule(ScheduleRequest $request)
  {
    try {
      $validatedData = $request->validated();

      Schedule::create([
        'title' => $validatedData['title'],
        'type' => $validatedData['type'],
        'date_time' => $validatedData['date_time'],
        'is_completed' => 0,
        'created_by' => session('kods_auth_userid'),
      ]);

      $request->session()->flash('alert-success', 'Schedule created successfully');
      return redirect()->route('pages.schedules');
    } catch (ValidationException $e) {
      return redirect()->back()->withErrors($e->errors())->withInput();
    }
  }

  public function managers()
  {
    // Get the logged-in user's ID from the session
    //  $userId = session()->get('kods_auth_userid');

    // Fetch tasks from the database where "created_by" matches the user ID
    $managers = Employee::where('user_type', "manager")->paginate(20);

    $data = [
      'managers' => $managers,
    ];
    return view('pages.managers', $data);
  }
  public function employees()
  {
    // Get the logged-in user's ID from the session
    //  $userId = session()->get('kods_auth_userid');

    // Fetch tasks from the database where "created_by" matches the user ID
    $employees = Employee::where('user_type', "employee")->paginate(20);

    $data = [
      'employees' => $employees,
    ];
    return view('pages.employees', $data);
  }
  public function course_groups()
  {
    $user_id = session('kods_auth_userid');

    $projects = Project::where('created_by', $user_id)->get();
    $categories = Category::where('created_by', $user_id)->get();
    $subCategories = Sub_category::where('created_by', $user_id)->get();
    $employees = Employee::where('user_type', "employee")->where('created_by', $user_id)->get();
    $projectsData = [];

    foreach ($projects as $project) {
      $projectData = [
        'project_id' => $project->id,
        'project_name' => $project->project_name,
        'categories' => [],
        'employees' => $employees,
      ];

      foreach ($categories as $category) {
        if ($category->project_id === $project->id) {
          $categoryData = [
            'category_id' => $category->id,
            'category_name' => $category->category_name,
            'sub_categories' => [],
          ];

          foreach ($subCategories as $subCategory) {
            if ($subCategory->category_id === $category->id) {
              $categoryData['sub_categories'][] = [
                'sub_category_id' => $subCategory->id,
                'sub_category_name' => $subCategory->sub_category_name,
              ];
            }
          }

          $projectData['categories'][] = $categoryData;
        }
      }

      $projectsData[] = $projectData;
    }

    return view('pages.course_groups', compact('projectsData'));
  }


  public function add_employee(Request $req)
  {
    $emailExists = User::where('email', $req->email)->exists();
    // dd(session('kods_auth_user_type'));
    if (session('kods_auth_user_type') == "sr_manager") {
      $user_type = "manager";
    } elseif (session('kods_auth_user_type') == "manager") {
      $user_type = "employee";
    }
    // dd($user_type);
    if (!$emailExists) {
      try {
        DB::beginTransaction();

        // Create a new user
        $user = User::create([
          'name' => $req->name,
          'email' => $req->email,
          'user_type' => $user_type,
          'password' => Hash::make('abc123@!'), // Set a default
        ]);

        // Create a new employee linked to the user
        Employee::create([
          'user_id' => $user->id, // Assuming there's a user_id column in the employees table
          'name' => $req->name,
          'email' => $req->email,
          'phone' => $req->phone,
          'post' => $req->post,
          'user_type' => $user_type,
          'joining_date' => $req->joining_date,
          'created_by' => session('kods_auth_userid'),
        ]);

        DB::commit();
        if ($user_type == "manager") {
          $req->session()->flash("alert-success", "Manager created successfully");
          return redirect()->route("pages.managers");
        } elseif ($user_type == "employee") {
          $req->session()->flash("alert-success", "Employee created successfully");
          return redirect()->route("pages.employees");
        }
      } catch (\Exception $e) {
        DB::rollback();
        // Handle the exception, show an error message, or log it
        if ($user_type == "manager") {
          return redirect()->route('pages.managers')->with('error', 'Duplicate phone or email found');
        } elseif ($user_type == "employee") {
          return redirect()->route('pages.employees')->with('error', 'Duplicate phone or email found');
        }
      }
    } else {
      // Email already exists, show an error message or handle it appropriately
      if ($user_type == "manager") {
        return to_route('pages.managers')->withErrors([
          'error' => 'Duplicate email found',
        ]);
      } elseif ($user_type == "employee") {
        // return redirect()->route('pages.employees')->with('error', 'Duplicate phone or email found');
        return to_route('pages.employees')->withErrors([
          'error' => 'Duplicate email found',
        ]);
      }
    }
  }


  public function add_project(Request $req)
  {
    //  return $req->all();

    // if (session('kods_auth_user_type') == "sr_manager") {
    //     $user_type = "sr_manager";
    // } elseif (session('kods_auth_user_type') == "manager") {
    //     $user_type = "manager";
    // }

    // Check for duplicate project name
    $existingProject = Project::where('project_name', $req->project_name)->first();

    // if ($existingProject) {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Project name already exists'
    //     ]);
    // }

    // If project name is not duplicate, create the project
    if (!$existingProject) {
      $project = Project::create([
        'project_name' => $req->project_name,
        'project_type' => $req->project_type,
        'created_by' => session('kods_auth_userid'),
      ]);
    }

    if ($existingProject) {
      session()->put('failed', 'Duplicate Project Name Detected');
      return redirect('/pages/course_groups');
    } else {
      session()->put('success', 'New Project Created');
      return redirect('/pages/course_groups');
    }
  }
  public function add_category(Request $req)
  {

    $existingCategory = Category::where('project_id', $req->project_id)->where('category_name', $req->category_name)->first();

    if (!$existingCategory) {
      $category = Category::create([
        'project_id' => $req->project_id,
        'category_name' => $req->category_name,
        'created_by' => session('kods_auth_userid'),
      ]);
    }

    if ($existingCategory) {
      session()->put('failed', 'Duplicate Category Name Detected');
      return redirect('/pages/course_groups');
    } else {
      session()->put('success', ' New Category Created');
      return redirect('/pages/course_groups');
    }
  }

  public function get_json_categories(Request $request)
  {
    $project_id = $request->input('project_id');
    $categories = Category::where('project_id', $project_id)->get();

    return response()->json($categories);
  }
  public function get_json_sub_categories(Request $request)
  {
    $category_id = $request->input('category_id');
    $sub_categories = Sub_category::where('category_id', $category_id)->get();
    return response()->json($sub_categories);
  }

  public function add_subcategory(Request $req)
  {
    // return $req->all();
    $existingSubcategory = Sub_category::where('project_id', $req->project_id)->where('category_id', $req->category_id)->where('sub_category_name', $req->sub_category_name)->first();

    if (!$existingSubcategory) {
      $category = Sub_category::create([
        'project_id' => $req->project_id,
        'sub_category_name' => $req->sub_category_name,
        'category_id' => $req->category_id,
        'created_by' => session('kods_auth_userid'),
      ]);
    }
    if ($existingSubcategory) {
      session()->put('failed', 'Duplicate Sub-category Name Detected');
      return redirect('/pages/course_groups');
    } else {
      session()->put('success', ' New Sub-category Created');
      return redirect('/pages/course_groups');
    }
  }
  public function add_task(Request $req)
  {
    // return $req->all();
    // $existingSubcategory = Todo::where('project_id', $req->project_id)->where('category_id', $req->category_id)->where('sub_category_name', $req->sub_category_name)->first();


      $todo = Todo::create([
        'task_name' => $req->task_name,
        'project_id' => $req->project_id,
        'category_id' => $req->category_id,
        'sub_category_id' => $req->sub_category_id,
        'employee_id' => $req->employee_id,
        'url' => $req->url,
        'created_by' => session('kods_auth_userid'),
      ]);
    
    if (!$todo) {
      session()->put('failed', 'Error Detected');
      return redirect('/pages/course_groups');
    } else {
      session()->put('success', ' New Task Created');
      return redirect('/pages/course_groups');
    }
  }
  public function teams()
  {
    $current_manager_user_id = session('kods_auth_userid');
      $allTeams = Team::where('created_by', $current_manager_user_id)->get(); // Adjust the method name according to your actual implementation
      $allTeamMembers = [];

      foreach ($allTeams as $team) {
          $teamMembers = explode(',', $team->team_members);
          $allTeamMembers = array_merge($allTeamMembers, $teamMembers);
      }

      $allEmployees = Employee::where('created_by',$current_manager_user_id)->get(); // Adjust the method name according to your actual implementation
      
      return view('pages.teams', [
          'allTeams' => $allTeams,
          'allEmployees' => $allEmployees,
          'allTeamMembers' => $allTeamMembers,
      ]);
  }


  

  public function create_teams(Request $request)
  {
      //need to check the team_members and team_lead already present int the databse, as error will occure

      $teamMembers = implode(',', $request->input('team_members'));
      $teamLead = $request->input('team_lead');

      $createTeams = Team::create([
        'name' =>  $request->input('name'),
        'team_members' => implode(',', $request->input('team_members')),
        'team_lead' => $request->input('team_lead'),
        
        'created_by' => session('kods_auth_userid'),
      ]);



      if ($createTeams) {
          session()->flash('success', 'Team added successfully');
      } else {
          session()->flash('error', 'Error Occurred!');
      }

      return redirect()->route('pages.teams'); // Redirect back to the teams index page
  }




public function tasks(){
  $user_id = session('kods_auth_userid');

  $all_tasks_alloted = Todo::where('employee_id', $user_id)->get();

  return view('pages.tasks', [
    'tasks' => $all_tasks_alloted,
  ]);
}
}
