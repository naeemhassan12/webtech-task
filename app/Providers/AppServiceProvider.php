<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Task;



class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (Schema::hasTable('tasks')) {
            // Share tasks based on user role
            View::composer('*', function ($view) {
                $pendingTasks = collect([]);
                $activeTask = collect([]);

                if (auth()->check()) {
                    $user = auth()->user();

                    // Superadmin and admin see all tasks
                    if (in_array($user->role, ['superadmin', 'admin'])) {
                        $pendingTasks = Task::where('status', 0)->get();
                        $activeTask = Task::where('status', 1)->get();
                    } else {
                        // Regular users only see tasks they are assigned to
                        $pendingTasks = Task::where('status', 0)
                            ->whereHas('users', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->get();

                        $activeTask = Task::where('status', 1)
                            ->whereHas('users', function ($query) use ($user) {
                                $query->where('user_id', $user->id);
                            })
                            ->get();
                    }
                }

                $view->with('pendingTasks', $pendingTasks);
                $view->with('activeTask', $activeTask);
            });
        }
    }


}

