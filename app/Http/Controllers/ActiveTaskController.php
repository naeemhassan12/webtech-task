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
         // Get IDs of users associated with this task
         $taskMembers = $activeTasks->users->pluck('id')->toArray();
        return view('active-task.index', compact( 'activeTasks', 'users','taskMembers'));
    }

    public function addMember($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        // Check if already exists to avoid duplicates (though syncWithoutDetaching or check is good)
        if (!$task->users()->where('user_id', $userId)->exists()) {
            $task->users()->attach($userId);
        }
        return response()->json(['success' => true, 'message' => 'Member added successfully']);
    }

    public function removeMember($taskId, $userId)
    {
        $task = Task::findOrFail($taskId);
        $task->users()->detach($userId);
        return response()->json(['success' => true, 'message' => 'Member removed successfully']);
    }
}
