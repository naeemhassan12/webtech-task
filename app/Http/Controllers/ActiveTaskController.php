<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class ActiveTaskController extends Controller
{
    public function index($id)
    {
        // Fetch the specific task by ID
        $activeTasks = Task::findOrFail($id);
        return view('active-task.index', compact('activeTasks'));
    }

     public function showUsersModal($id)
    {
        $activeTasks = Task::findOrFail($id);
        $users = User::whereIn('role', ['admin','user'])->get();
         $taskMembers = $activeTasks->members ?? [];
        return view('active-task.index', compact( 'activeTasks', 'users','taskMembers'));
    }
}
