<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserTaskController;
use App\Http\Controllers\PendingTaskController;
use App\Http\Controllers\ActiveTaskController;
use App\Http\Controllers\showUsersModal;
use App\Http\Controllers\addMember;
use App\Http\Controllers\removeMember;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskUserController;

Route::get('/taskUsers', [TaskUserController::class, 'index'])->name('taskUser.index');


Route::get('/pending/{id}', [PendingTaskController::class, 'index'])
    ->name('pending.index');

Route::get('/pending/{id}', [PendingTaskController::class, 'showUsersModal'])->name('pending.index');
// active task route
Route::get('/active/{id}', [ActiveTaskController::class, 'index'])->name('active.index');
// active task routes fetch through id
Route::get('/active/{id}', [ActiveTaskController::class, 'showUsersModal'])->name('active-task.index');

//Route::get('/pending/{id}',[PendingTaskController::class, 'index'])->name('pending.index');
Route::get('/task/{id}', [TaskController::class, 'show'])
    ->name('task.show');

Route::get('/dashboard', [DashboardController::class, 'create'])->name('dashboard.create');

// Route::resource('user', UserController::class);
// route users table
Route::get('/user', [UserController::class, 'create'])->name('user.create');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
//Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);

// routes task tables
Route::get('/task', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/task/store', [TaskController::class,'store'])->name('tasks.store');

Route::get('/task/index', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');


 Route::get('/',function(){
     return view('welcome');
 });

// Route::get('/', [DashboardController::class, 'create'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
