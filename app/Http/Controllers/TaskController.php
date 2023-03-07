<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Tasks/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return back()->with('toast', ['type' => 'success', 'message' => 'Task created successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->completion = $request->completion;
        $task->save();

        return back()->with('toast', ['type' => 'success', 'message' => 'Task updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id != Auth::user()->id)
            return back()->with('toast', ['type' => 'failed', 'message' => 'You are not authorized to delete this task.']);

        $task->delete();

        return back()->with('toast', ['type' => 'success', 'message' => 'Task deleted successfully!']);
    }

    /**
     * Get resources in specified limit.
     */
    public function get(Request $request)
    {
        $tasks = $request->allTasks == 'all' ? Task::paginate(5) : Task::where('user_id', $request->user()->id)->paginate(5);

        return TaskResource::collection($tasks);
    }
}
