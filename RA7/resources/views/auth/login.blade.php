@extends('layouts.guest')

@section('content')
    <section class="grid w-full gap-8 lg:grid-cols-[1fr_0.9fr] lg:items-center">
        <div class="max-w-xl">
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">ra8 login</p>
            <h1 class="mt-3 text-4xl font-black text-white sm:text-6xl">enter the task manager</h1>
            <p class="mt-4 text-lg text-slate-300">authentication keeps the app complete and lets each user manage only its own data unless the role is admin.</p>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <h2 class="text-2xl font-bold text-white">sign in</h2>

            @include('partials.errors')

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-200">password</label>
                    <input id="password" type="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <label class="flex items-center gap-3 text-sm text-slate-300">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-white/20 bg-white/10 text-cyan-400">
                    remember me
                </label>
                <button type="submit" class="w-full rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">login</button>
            </form>

            <p class="mt-4 text-sm text-slate-300">dont have account? <a href="{{ route('register') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">register here</a></p>
        </div>
    </section>
@endsection