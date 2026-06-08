<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | access</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#07111f] text-slate-100">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.24),_transparent_30%),linear-gradient(180deg,_#08101d_0%,_#111827_100%)]">
        <main class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</body>
</html>