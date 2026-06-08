<?php $__env->startSection('content'); ?>
<h1>Products</h1>
<a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary mb-3">Create Product</a>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr id="product-<?php echo e($product->id); ?>">
            <td><?php echo e($product->id); ?></td>
            <td><?php echo e($product->name); ?></td>
            <td><?php echo e($product->price); ?></td>
            <td><?php echo e($product->stock); ?></td>
            <td>
                <a href="<?php echo e(route('products.edit', $product)); ?>" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger" onclick="deleteProduct('<?php echo e($product->id); ?>')">Delete</button>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($products->links()); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cristian/ra7-api/resources/views/products/index.blade.php ENDPATH**/ ?>