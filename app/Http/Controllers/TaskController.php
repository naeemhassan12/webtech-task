<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create()
    {
        $tasks = Task::all();
        $task_datas = config('task_status');
        return view('task.index', compact('tasks', 'task_datas'));
    }



    public function store(Request $request)
    {
        $task_datas = config('task_status');

        $validated = $request->validate([
            'tasksTitle' => 'required|max:255',
            'clientsName' => 'required|max:255',
            'TasksDescription' => 'required|max:1000',
            'task_status' => 'required|integer|in:' . implode(',', array_keys($task_datas)),
        ]);

        $task = Task::create([
            'task_title' => $validated['tasksTitle'],
            'client_name' => $validated['clientsName'],
            'description' => $validated['TasksDescription'],
            'status' => $validated['task_status'],
        ]);

        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task
        ]);
    }

    public function edit($id)
    {
        $tasks = Task::findOrFail($id);
        return response()->json(['task' => $tasks]);
    }
   public function update(Request $request, $id)
{
    $task_datas = config('task_status');

    $validated = $request->validate([
        'tasksTitle' => 'required|max:255',
        'clientsName' => 'required|max:255',
        'TasksDescription' => 'required|max:1000',
        'status' => 'required|integer|in:' . implode(',', array_keys($task_datas)),
    ]);

    $task = Task::findOrFail($id);
    $task->update([
        'task_title' => $validated['tasksTitle'],
        'client_name' => $validated['clientsName'],
        'description' => $validated['TasksDescription'],
        'status' => $validated['status'],
    ]);

    return response()->json([
        'message' => 'Task updated successfully!',
        'task' => $task
    ]);
}

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully!'
        ]);
    }

    public function getSidebarUpdates()
    {
        $pendingTasks = \App\Models\Task::where('status', 0)->get();
        $activeTask = \App\Models\Task::where('status', 1)->get();

        return response()->json([
            'pendingHtml' => view('layouts.sidebar_tasks', ['tasks' => $pendingTasks, 'type' => 'pending'])->render(),
            'activeHtml' => view('layouts.sidebar_tasks', ['tasks' => $activeTask, 'type' => 'active'])->render()
        ]);
    }





}
