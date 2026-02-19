<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PendingTaskController;
use App\Http\Controllers\ActiveTaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/* Home Route */
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

/* Authenticated Routes */
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'create'])->name('dashboard');

    /* Profile Routes*/
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /* User Management Routes */
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');
    });

    /* Task Routes */
    Route::prefix('task')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/{id}', [TaskController::class, 'show'])->name('task.show');
        Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/{id}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

        Route::get('/sidebar/updates', [TaskController::class, 'getSidebarUpdates'])->name('sidebar.updates');
    });

    /* Pending Task Routes  */
    Route::prefix('pending')->group(function () {
        Route::get('/{id}', [PendingTaskController::class, 'showUsersModal'])->name('pending.index');
        Route::post('/{taskId}/add-member/{userId}', [PendingTaskController::class, 'addMember'])->name('task.addMember');
        Route::delete('/{taskId}/remove-member/{userId}', [PendingTaskController::class, 'removeMember'])->name('task.removeMember');
    });

    /* Active Task Routes */
    Route::prefix('active')->group(function () {
        Route::get('/{id}', [ActiveTaskController::class, 'index'])->name('active.index');
        Route::get('/{id}/manage', [ActiveTaskController::class, 'showUsersModal'])->name('active-task.index');
        Route::post('/{taskId}/add-member/{userId}', [ActiveTaskController::class, 'addMember'])->name('active.addMember');
        
        Route::delete('/{taskId}/remove-member/{userId}', [ActiveTaskController::class, 'removeMember'])->name('active.removeMember');
    });

});

require __DIR__.'/auth.php';
