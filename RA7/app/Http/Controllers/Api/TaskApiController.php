<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    public function index()
    {
        $tasks = Task::with('user')->latest()->get();

        return response()->json([
            'data' => $tasks,
            'total' => $tasks->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'completed'   => ['nullable', 'boolean'],
            'user_id'     => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $task = Task::create([
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'completed'   => $validated['completed'] ?? false,
            'user_id'     => $validated['user_id'] ?? null,
        ]);

        return response()->json([
            'message' => 'task created successfully',
            'data'    => $task->load('user'),
        ], 201);
    }

    public function show(Task $task)
    {
        return response()->json([
            'data' => $task->load('user'),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title'       => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'completed'   => ['nullable', 'boolean'],
            'user_id'     => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'task updated successfully',
            'data'    => $task->fresh('user'),
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'task deleted successfully',
        ]);
    }
}