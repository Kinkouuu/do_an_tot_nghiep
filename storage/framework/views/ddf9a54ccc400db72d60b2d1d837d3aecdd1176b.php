<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <form class="container col-md-8 text-center justify-content-center"
          action="" method="POST">
        <?php echo csrf_field(); ?>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên loại phòng</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e(old('name')); ?>">
        </div>

        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả chi tiết</span>
            </div>
            <div class="w-75">
                <textarea class="ckeditor" name="description"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>
        <?php $__currentLoopData = \App\Enums\Room\PriceType::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__errorArgs = ['price.' . $priceType['value']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="w-100 input-group input-group-sm mb-3">
                <div class="w-25 input-group-prepend">
                    <span class="input-group-text w-100" id="inputGroup-sizing-sm"><?php echo e($priceType['text']); ?></span>
                </div>
                <input type="number" min="0" class="form-control w-auto" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-sm"
                       name="price[<?php echo e($priceType['value']); ?>]" value="<?php echo e(old("price." .  $priceType['value'])); ?>">
                <span class="input-group-text w-10" id="inputGroup-sizing-sm">VND/<?php echo e($priceType['type']); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Thêm mới</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/create.blade.php ENDPATH**/ ?>