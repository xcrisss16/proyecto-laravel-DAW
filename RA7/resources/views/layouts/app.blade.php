<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | tasks</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#07111f] text-slate-100">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.22),_transparent_28%),linear-gradient(180deg,_#08101d_0%,_#0f172a_55%,_#111827_100%)]">
        <header class="border-b border-white/10 bg-slate-950/40 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('tasks.index') }}" class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-cyan-400 text-slate-950 font-black shadow-lg shadow-cyan-400/30">R8</span>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-200/80">ra8 project</p>
                        <p class="text-lg font-bold text-white">task manager</p>
                    </div>
                </a>

                <nav class="flex items-center gap-3 text-sm">
                    <a href="{{ route('tasks.index') }}" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 transition hover:border-cyan-300/50 hover:text-white">dashboard</a>
                    <a href="{{ route('tasks.create') }}" class="rounded-full bg-cyan-400 px-4 py-2 font-semibold text-slate-950 transition hover:bg-cyan-300">new task</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full border border-white/10 px-4 py-2 text-slate-200 transition hover:border-rose-300/50 hover:text-white">logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</body>
</html>