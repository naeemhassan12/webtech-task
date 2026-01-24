<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'create'])->name('dashboard.create');
Route::get('/user', [UserController::class, 'create'])->name('user.create');
Route::get('/task', [TaskController::class, 'show'])->name('user.show');

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
