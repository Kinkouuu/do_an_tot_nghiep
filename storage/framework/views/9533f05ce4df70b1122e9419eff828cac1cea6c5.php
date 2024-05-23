<?php $__env->startSection('content'); ?>
    <section class="container col-md-8 mx-auto my-5">
        <h1 class="text-center text-secondary text-uppercase">&mdash; Cập nhật thông tin cá nhân &mdash;</h1>
        <form method="POST">
            <?php echo csrf_field(); ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Số điện thoại</span>
                </div>
                <input type="text" class="form-control w-75" value="<?php echo e($phone); ?>" disabled>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Địa chỉ email</span>
                </div>
                <input type="text" class="form-control w-75" name="email" value="<?php echo e($email); ?>" disabled>
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
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Họ và tên</span>
                </div>
                <input type="text" class="form-control w-75" name="name" value="<?php echo e($customer['name'] ?? old('name')); ?>">
            </div>
            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Địa chỉ thường trú</span>
                </div>
                <input type="text" class="form-control" name="address" value="<?php echo e($customer['address'] ?? old('address')); ?>">
            </div>
            <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Quốc tịch</span>
                </div>
                <input type="text" class="form-control" name="country" value="<?php echo e($customer['country'] ?? old('country')); ?>">
            </div>
            <?php $__errorArgs = ['citizen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Số CCCD/CMT</span>
                </div>
                <input type="text" class="form-control" name="citizen_id" value="<?php echo e($customer['citizen_id'] ?? old('citizen_id')); ?>">
            </div>
            <?php $__errorArgs = ['birth_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Ngày sinh</span>
                </div>
                <input type="date" class="form-control" name="birth_day" value="<?php echo e($customer['birth_day'] ?? old('birth_day')); ?>">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Giới tính</span>
                </div>

                <select class="form-control" name="gender">
                    <?php $__currentLoopData = \App\Enums\User\UserGender::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($customer['gender'] == $gender ? 'selected' : ''); ?> value=<?php echo e($gender); ?>>
                            <?php echo e($gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ'); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="align-content-center text-center">
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/personal-information.blade.php ENDPATH**/ ?>