@extends('layouts.app')

@section('content')
<h1>Product Detail</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p><strong>Description:</strong> {{ $product->description ?? 'N/A' }}</p>
        <p><strong>Price:</strong> {{ $product->price }}</p>
        <p><strong>Stock:</strong> {{ $product->stock }}</p>
        <p><strong>Created:</strong> {{ $product->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

<a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
<a href="{{ route('products.index') }}" class="btn btn-secondary">Back to list</a>
@endsection