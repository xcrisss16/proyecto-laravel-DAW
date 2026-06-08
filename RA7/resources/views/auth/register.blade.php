@extends('layouts.guest')

@section('content')
    <section class="grid w-full gap-8 lg:grid-cols-[1fr_0.9fr] lg:items-center">
        <div class="max-w-xl">
            <p class="text-sm uppercase tracking-[0.3em] text-cyan-200/70">ra8 register</p>
            <h1 class="mt-3 text-4xl font-black text-white sm:text-6xl">create your user</h1>
            <p class="mt-4 text-lg text-slate-300">the form uses server side validation and stores the password hashed by laravel.</p>
        </div>

        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
            <h2 class="text-2xl font-bold text-white">register</h2>

            @include('partials.errors')

            <form method="POST" action="{{ route('register.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-200">name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-200">email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-200">password</label>
                    <input id="password" type="password" name="password" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-200">confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition focus:border-cyan-300 focus:bg-white/10">
                </div>
                <button type="submit" class="w-full rounded-2xl bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">create account</button>
            </form>

            <p class="mt-4 text-sm text-slate-300">already have account? <a href="{{ route('login') }}" class="font-semibold text-cyan-300 hover:text-cyan-200">login here</a></p>
        </div>
    </section>
@endsection