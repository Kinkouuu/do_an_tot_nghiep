<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="<?php echo e(route('admin.services.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại dịch vụ</span>
            </div>
            <select class="selectpicker w-75" name="type_service_id" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = $typeServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option data-icon="<?php echo e($typeService->icon); ?>"
                        <?php echo e(old('type_service_id') == $typeService->id ? 'selected' : ''); ?> value=<?php echo e($typeService->id); ?>>
                        <?php echo e($typeService->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên dịch vụ</span>
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả</span>
            </div>
            <textarea class="form-control" placeholder="Mô tả chi tiết"
                      name="description" maxlength="300" style="min-height: 150px"><?php echo e(old('description')); ?></textarea>
        </div>

        <?php $__errorArgs = ['price'];
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giá niêm yết</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="price" min="0" value="<?php echo e(old('price')); ?>">
            <span class="input-group-text" id="basic-addon2">VND</span>
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select" name="status">
                <?php $__currentLoopData = \App\Enums\Service\ServiceStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(old('status') == $status ? 'selected' : ''); ?> value="<?php echo e($status); ?>">
                        <?php echo e($status == \App\Enums\Service\ServiceStatus::DeActive ? 'Chưa cung cấp' : 'Đang cung cấp'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/services/create.blade.php ENDPATH**/ ?>