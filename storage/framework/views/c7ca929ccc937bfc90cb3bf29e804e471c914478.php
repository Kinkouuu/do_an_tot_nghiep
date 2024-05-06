<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="<?php echo e(route('admin.devices.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại thiết bị</span>
            </div>
            <select class="selectpicker w-75" name="type_device_id" data-live-search="true"
                    data-style="bg-white border border-left-0">
                <?php $__currentLoopData = $typeDevices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeDevice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option data-icon="<?php echo e($typeDevice->icon); ?>"
                            <?php echo e(old('type_device_id') == $typeDevice->id ? 'selected' : ''); ?> value=<?php echo e($typeDevice->id); ?>>
                        <?php echo e($typeDevice->name); ?>

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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên thiết bị</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e(old('name')); ?>">
        </div>

        <?php $__errorArgs = ['rental_price'];
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giá cho thuê</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="rental_price" min="0"
                   value="<?php echo e(old('rental_price')); ?>">
            <span class="input-group-text" id="basic-addon2">VND/thiết bị/ngày</span>
        </div>
        <?php $__errorArgs = ['quantity'];
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tổng số lượng</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="quantity" min="0" value="<?php echo e(old('quantity')); ?>">
            <span class="input-group-text" id="basic-addon2">thiết bị</span>
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả thiết bị</span>
            </div>
            <textarea class="ckeditor form-control w-75" id="description" name="description">
                <?php echo e(old('description')); ?>

            </textarea>
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <div class="w-75 m-auto d-flex justify-content-around">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="for_rent" id="exampleRadios1" value="0" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Không cho thuê
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="for_rent" id="exampleRadios2"
                           value="1" <?php echo e(old('for_rent') ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="exampleRadios2">
                        Cho thuê
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Thêm mới</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/devices/create.blade.php ENDPATH**/ ?>