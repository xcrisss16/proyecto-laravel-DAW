<?php $__env->startSection('content'); ?>
<h1>Create Product</h1>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
    </div>
<?php endif; ?>

<form action="<?php echo e(route('products.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>">
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control"><?php echo e(old('description')); ?></textarea>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo e(old('price')); ?>">
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" value="<?php echo e(old('stock')); ?>">
    </div>
    <button class="btn btn-success">Create</button>
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Back</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/cristian/ra7-api/resources/views/products/create.blade.php ENDPATH**/ ?>