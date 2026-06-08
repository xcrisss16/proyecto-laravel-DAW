@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-3xl rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">detail</p>
        <h1 class="mt-2 text-3xl font-black text-white">{{ $task->title }}</h1>

        <div class="mt-5 flex flex-wrap gap-3 text-sm">
            <span class="rounded-full px-3 py-1 font-semibold {{ $task->completed ? 'bg-emerald-400/15 text-emerald-200' : 'bg-amber-400/15 text-amber-200' }}">{{ $task->completed ? 'completed' : 'pending' }}</span>
            <span class="rounded-full bg-white/10 px-3 py-1 font-semibold text-slate-200">owner {{ $task->user?->name ?? 'unknown' }}</span>
        </div>

        <div class="mt-6 rounded-3xl border border-white/10 bg-slate-950/50 p-5 text-slate-200">
            <p class="whitespace-pre-line">{{ $task->description ?: 'no description yet' }}</p>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('tasks.edit', $task) }}" class="rounded-full bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">edit</a>
            <a href="{{ route('tasks.index') }}" class="rounded-full border border-white/10 px-5 py-3 font-semibold text-slate-200 transition hover:border-white/30 hover:text-white">back</a>
        </div>
    </section>
@endsection