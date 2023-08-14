<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PageController;




// Routes for login and registration (accessible only to non-authenticated users)
Route::middleware(['RedirectIfAuthenticatedForLoginRegister'])->group(function () {
    Route::controller(LoginRegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/store', 'store')->name('store');
        Route::get('/', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');
    });
});
Route::middleware(['RedirectIfAuthenticated'])->group(function () {
    Route::controller(LoginRegisterController::class)->group(function () {
        Route::post('/logout', 'logout')->name('logout');
        Route::put('/edit_profile_details', 'edit_profile_details')->name('edit_profile_details');
    });

    Route::prefix('tasks')->as('tasks.')->controller(TaskController::class)->middleware('auth')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('show/{id}', 'show')->name('show');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update', 'update')->name('update');
        Route::delete('destroy', 'destroy')->name('destroy');
        Route::get('profile_details', 'profile_details')->name('profile_details');
        Route::get('update_profile_details', 'update_profile_details')->name('update_profile_details');
    });
});


Route::get('/pages/index', [PageController::class, 'index'])->name('pages.index');
Route::get('/pages/schedules', [PageController::class, 'schedules'])->name('pages.schedules');
Route::get('/pages/managers', [PageController::class, 'managers'])->name('pages.managers');
Route::get('/pages/employees', [PageController::class, 'employees'])->name('pages.employees');
Route::get('/pages/groups', [PageController::class, 'groups'])->name('pages.groups');
Route::get('/pages/course_groups', [PageController::class, 'course_groups'])->name('pages.course_groups');
Route::post('/pages/add_schedule', [PageController::class, 'add_schedule'])->name('pages.add_schedule');
Route::post('/pages/add_employee', [PageController::class, 'add_employee'])->name('pages.add_employee');
Route::post('/pages/add_project', [PageController::class, 'add_project'])->name('pages.add_project');
Route::post('/pages/add_category', [PageController::class, 'add_category'])->name('pages.add_category');
Route::post('/pages/add_subcategory', [PageController::class, 'add_subcategory'])->name('pages.add_subcategory');
Route::post('/pages/add_task', [PageController::class, 'add_task'])->name('pages.add_task');
Route::get('/pages/debug', function () {
    return "Debug route accessed";
});
Route::get('/pages/teams', [PageController::class, 'teams'])->name('pages.teams');
Route::post('/pages/create_teams', [PageController::class, 'create_teams'])->name('pages.create_teams');
Route::get('/pages/tasks', [PageController::class, 'tasks'])->name('pages.tasks');


//ajax call
Route::get('/pages/get_json_categories', [PageController::class, 'get_json_categories'])->name('pages.get_json_categories');
Route::get('/pages/get_json_sub_categories', [PageController::class, 'get_json_sub_categories'])->name('pages.get_json_sub_categories');
