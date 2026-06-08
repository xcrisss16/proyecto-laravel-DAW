@extends('layouts.app')

@section('content')
<h1>Products</h1>
<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create Product</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>

            <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th><td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
            
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr id="product-{{ $product->id }}">
            <td>{{ $product->id }}</td>
            <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct('{{ $product->id }}')">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}
@endsection

@section('scripts')
<script>
function deleteProduct(id) {
    id = parseInt(id);
    if(!confirm('Are you sure you want to delete this product?')) return;

    axios.delete('/products/' + id)
        .then(res => {
            if(res.data.success) {
                document.getElementById('product-' + id).remove();
                showAlert('Product deleted successfully', 'success');
            }
        })
        .catch(err => {
            showAlert('Error deleting product', 'danger');
            console.error(err);
        });
}

function showAlert(message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.querySelector('.container').prepend(alert);
    setTimeout(() => alert.remove(), 3000);
}
</script>
@endsection
