<?php

namespace App\Http\Controllers;

use App\Models\TaskUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{

    public function index()
    {

        $taskUsers = TaskUser::with(['task', 'user'])->get();


        return view('taskUser.index', compact('taskUsers'));
    }
}
