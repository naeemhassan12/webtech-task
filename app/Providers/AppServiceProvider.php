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
            View::share('pendingTasks', Task::where('status', 0)->get());
            View::share('activeTask', Task::where('status', 1)->get());
        }
    }
}

