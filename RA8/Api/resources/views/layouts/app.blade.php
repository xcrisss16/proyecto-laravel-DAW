<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('products.index') }}">Product Manager</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
            <a class="nav-link" href="{{ route('products.create') }}">Add Product</a>
            @auth
                <span class="nav-link text-light">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm ms-2">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@yield('scripts')
</body>
</html>