<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
  public function index()
  {
   // Get the logged-in user's ID from the session
   $userId = session()->get('guardian_auth_userid');

   // Fetch tasks from the database where "created_by" matches the user ID
   $tasks = Task::where('created_by', $userId)->paginate(5);

    return view('tasks.index', [
      'tasks' => $tasks,
    ]);
  }

  public function create()
  {
    return view('tasks.create');
  }

  public function profile_details()
  {
    return view('tasks.profile_details');
  }

  public function update_profile_details()
  {
    return view('tasks.update_profile_details');
  }
  
  public function store(TaskRequest $request)
  {
    // return $request->all();
    // $request->validated();
    // $created_by =  session()->get('guardian_auth_userid');

    Task::create([
      'title' => $request->title,
      'description' => $request->description,
      'due_date' => $request->due_date,
      'is_completed' => 0,
      'created_by' =>  $request->created_by,


    ]);
    $request->session()->flash('alert-success', 'Task created successfully');
    return redirect()->route('tasks.index');
  }

  public function show($id)
  {
    $task = Task::find($id);
    if (!$task) {
      return to_route('tasks.index')->withErrors([
        'error' => 'Task not found',
      ]);
    } else {
      return view('tasks.show', ['task' => $task]);
    }
  }
  public function edit($id)
  {
    $task = Task::find($id);
    if (!$task) {
      return to_route('tasks.index')->withErrors([
        'error' => 'Task not found',
      ]);
    } else {
      return view('tasks.edit', ['task' => $task]);
    }
  }
  public function update(TaskRequest $request)
  {
    // return $request->all();
    $task = Task::find($request->id);
    if (!$task) {
      return to_route('tasks.index')->withErrors([
        'error' => 'Task not found',
      ]);
    }
    $task->update([
      'title' => $request->title,
      'description' => $request->description,
      'due_date' => $request->due_date,
      'is_completed' => $request->is_completed,

    ]);
    $request->session()->flash('alert-info', 'Task updated successfully');
    return redirect()->route('tasks.index');
  }
  public function destroy(Request $request)
  {
    $task = Task::find($request->id);
    if (!$task) {
      return to_route('tasks.index')->withErrors([
        'error' => 'Task not found',
      ]);
    }
    $task->delete();
    $request->session()->flash('alert-danger', 'Deleted successfully');
    return redirect()->route('tasks.index');
  }
}
