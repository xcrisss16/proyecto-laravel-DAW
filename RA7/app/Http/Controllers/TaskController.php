<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $user = $request->user();
        $query = $this->taskQuery($user, $search);

        $tasks = (clone $query)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('completed', false)->count(),
            'completed' => (clone $query)->where('completed', true)->count(),
        ];

        return view('tasks.index', compact('tasks', 'search', 'stats'));
    }

    public function create(): View
    {
        return view('tasks.create', ['task' => new Task()]);
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create([
            ...$request->validated(),
            'completed' => $request->boolean('completed'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'task created successfully');
    }

    public function show(Request $request, Task $task): View
    {
        $this->authorizeTask($request, $task);

        return view('tasks.show', [
            'task' => $task->load('user'),
        ]);
    }

    public function edit(Request $request, Task $task): View
    {
        $this->authorizeTask($request, $task);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $task->update([
            ...$request->validated(),
            'completed' => $request->boolean('completed'),
        ]);

        return redirect()
            ->route('tasks.index')
            ->with('success', 'task updated successfully');
    }

    public function toggle(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $task->update([
            'completed' => ! $task->completed,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'task status updated',
                'task' => $task->fresh('user'),
            ]);
        }

        return back()->with('success', 'task status updated');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($request, $task);

        $task->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'task deleted successfully',
            ]);
        }

        return redirect()
            ->route('tasks.index')
            ->with('success', 'task deleted successfully');
    }

    private function taskQuery(User $user, string $search)
    {
        return Task::query()
            ->with('user')
            ->when(! $user->isAdmin(), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($search !== '', function ($query) use ($search, $user) {
                $query->where(function ($innerQuery) use ($search, $user) {
                    $innerQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');

                    if ($user->isAdmin()) {
                        $innerQuery->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%');
                        });
                    }
                });
            });
    }

    private function authorizeTask(Request $request, Task $task): void
    {
        abort_unless($request->user()->canManageTask($task), 403);
    }
}
