@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-3xl rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
        <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">edit</p>
        <h1 class="mt-2 text-3xl font-black text-white">edit task</h1>

        @include('partials.errors')

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="mt-6">
            @include('tasks._form', ['submitLabel' => 'update task'])
        </form>
    </section>
@endsection