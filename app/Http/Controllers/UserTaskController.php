<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function UserTask()
    {
        return view('user.task_user');
    }
}
