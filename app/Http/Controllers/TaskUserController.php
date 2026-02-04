<?php

namespace App\Http\Controllers;
use App\Models\TaskUser;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    /**
     * Display a listing of task-user assignments.
     */
    public function index()
    {
        // Eager load task and user relationships
        $taskUsers = TaskUser::with(['task', 'user'])->get();

        // Pass data to view
        return view('taskUser.index', compact('taskUsers'));
    }
}
