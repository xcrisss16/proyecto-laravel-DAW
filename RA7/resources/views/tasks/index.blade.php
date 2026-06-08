@extends('layouts.app')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">dynamic web app</p>
                    <h1 class="mt-2 text-3xl font-black text-white sm:text-5xl">tasks dashboard</h1>
                    <p class="mt-3 max-w-2xl text-slate-300">crud web con validacion server side busqueda paginacion roles y una accion ajax sin recargar la pagina.</p>
                </div>
                <a href="{{ route('tasks.create') }}" class="rounded-full bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">create task</a>
            </div>

            <form method="GET" action="{{ route('tasks.index') }}" class="mt-6 flex flex-col gap-3 rounded-3xl border border-white/10 bg-slate-950/40 p-4 sm:flex-row">
                <input type="search" name="search" value="{{ $search }}" placeholder="search title description or owner"
                    class="flex-1 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-300 focus:bg-white/10">
                <button type="submit" class="rounded-2xl bg-white px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-100">search</button>
                @if ($search !== '')
                    <a href="{{ route('tasks.index') }}" class="rounded-2xl border border-white/10 px-5 py-3 font-semibold text-slate-200 transition hover:border-white/30 hover:text-white">clear</a>
                @endif
            </form>

            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <article class="rounded-3xl border border-white/10 bg-slate-950/50 p-4">
                    <p class="text-sm text-slate-400">total</p>
                    <p class="mt-2 text-3xl font-black text-white">{{ $stats['total'] }}</p>
                </article>
                <article class="rounded-3xl border border-white/10 bg-slate-950/50 p-4">
                    <p class="text-sm text-slate-400">pending</p>
                    <p class="mt-2 text-3xl font-black text-amber-300">{{ $stats['pending'] }}</p>
                </article>
                <article class="rounded-3xl border border-white/10 bg-slate-950/50 p-4">
                    <p class="text-sm text-slate-400">completed</p>
                    <p class="mt-2 text-3xl font-black text-emerald-300">{{ $stats['completed'] }}</p>
                </article>
            </div>
        </div>

        <aside class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">session info</p>
            <h2 class="mt-2 text-2xl font-black text-white">{{ auth()->user()->name }}</h2>
            <p class="mt-2 text-slate-300">{{ auth()->user()->email }}</p>

            <div class="mt-6 space-y-3 text-sm text-slate-200">
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                    role: <span class="font-semibold text-cyan-300">{{ auth()->user()->role }}</span>
                </div>
                <div class="rounded-2xl border border-white/10 bg-slate-950/40 px-4 py-3">
                    permissions: <span class="font-semibold text-white">{{ auth()->user()->isAdmin() ? 'all tasks' : 'only own tasks' }}</span>
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-cyan-300/20 bg-cyan-400/10 p-4 text-sm text-cyan-50">
                ajax is active on complete and delete actions so the list updates without full reload.
            </div>
        </aside>
    </section>

    <section class="mt-8 rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">task list</p>
                <h2 class="mt-2 text-2xl font-bold text-white">latest records</h2>
            </div>
            <p class="text-sm text-slate-400">page {{ $tasks->currentPage() }} of {{ $tasks->lastPage() }}</p>
        </div>

        <div data-flash-slot class="mt-5"></div>

        @if ($tasks->isEmpty())
            <div class="mt-6 rounded-3xl border border-dashed border-white/15 bg-slate-950/40 p-8 text-center text-slate-300">
                no tasks found yet. create one to start the demo.
            </div>
        @else
            <div class="mt-6 grid gap-4">
                @foreach ($tasks as $task)
                    <article id="task-{{ $task->id }}" class="rounded-3xl border border-white/10 bg-slate-950/50 p-5 transition hover:border-cyan-300/40">
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="text-xl font-bold text-white">{{ $task->title }}</h3>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $task->completed ? 'bg-emerald-400/15 text-emerald-200' : 'bg-amber-400/15 text-amber-200' }}" data-task-status="{{ $task->id }}">
                                        {{ $task->completed ? 'completed' : 'pending' }}
                                    </span>
                                    @if ($task->user_id === auth()->id())
                                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-slate-200">my task</span>
                                    @elseif(auth()->user()->isAdmin())
                                        <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-slate-200">owner {{ $task->user?->name }}</span>
                                    @endif
                                </div>
                                <p class="mt-3 text-slate-300">{{ $task->description ?: 'no description yet' }}</p>
                                <p class="mt-3 text-xs uppercase tracking-[0.2em] text-slate-500">created {{ $task->created_at->diffForHumans() }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:border-white/30 hover:text-white">view</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="rounded-full border border-cyan-300/20 px-4 py-2 text-sm font-semibold text-cyan-200 transition hover:border-cyan-300/50 hover:text-cyan-100">edit</a>
                                <button type="button" data-task-toggle data-task-id="{{ $task->id }}" data-url="{{ route('tasks.toggle', $task) }}" class="rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-cyan-300">
                                    toggle
                                </button>
                                <button type="button" data-task-delete data-task-id="{{ $task->id }}" data-url="{{ route('tasks.destroy', $task) }}" class="rounded-full bg-rose-500/90 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-500">
                                    delete
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif
    </section>
@endsection