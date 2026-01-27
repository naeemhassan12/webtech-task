<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
//use App\Http\Controllers\UserTaskController;
use Illuminate\Support\Facades\Route;

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
