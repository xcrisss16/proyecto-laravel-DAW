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
            <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr id="product-{{ $product->id }}">
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
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
    if(!confirm('Are you sure?')) return;

    axios.delete('/products/' + id)
        .then(res => {
            if(res.data.success) {
                document.getElementById('product-' + id).remove();
            }
        })
        .catch(err => console.log(err));
}
</script>
@endsection
