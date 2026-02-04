<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class PendingTaskController extends Controller
{
    public function index($id)
    {

        $pendingtask = Task::findOrFail($id);
        return view('pending.index', compact('pendingtask'));
    }

    public function showUsersModal($id)
    {
        $pendingtasks = Task::findOrFail($id);
        $users = User::whereIn('role', ['admin','user'])->get();
        $taskMembers = $pendingtask->members ?? [];
        return view('pending.index', compact( 'pendingtasks', 'users','taskMembers'));
    }


}
