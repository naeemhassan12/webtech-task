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
        // Fix default string length for older MySQL versions
        Schema::defaultStringLength(191);

        // Share pending tasks with all views
        View::share('pendingTasks', Task::where('status', 0)->get());

        // Share active tasks with all views
        View::share('activeTask', Task::where('status', 1)->get());
    }
}

?>
