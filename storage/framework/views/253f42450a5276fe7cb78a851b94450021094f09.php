<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="<?php echo e(route('admin.customers.update', $customer)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <?php if($customer->user): ?>
            <div class="w-100 input-group input-group-sm mb-3">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="w-25 input-group-prepend">
                    <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tài khoản email</span>
                </div>
                <input type="text" class="form-control w-75" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-sm" name="email" value="<?php echo e($customer->user->email); ?>">
            </div>
            <div class="w-100 input-group input-group-sm mb-3">
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="w-25 input-group-prepend">
                    <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
                </div>
                <input type="text" class="form-control w-75" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-sm" name="phone" value="<?php echo e($customer->user->phone); ?>">
            </div>
            <div class="w-100 input-group input-group-sm mb-3">
                <div class="w-25 input-group-prepend">
                    <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái tài khoản</span>
                </div>
                <select class="form-control" name="status">
                    <?php $__currentLoopData = \App\Enums\UserStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php echo e($customer->user->status == $status ? 'selected' : ''); ?> value=<?php echo e($status); ?>>
                            <?php echo e(match ($status) {
                                    \App\Enums\UserStatus::Cancelled => 'Đã hủy',
                                    \App\Enums\UserStatus::Active => 'Đang kích hoạt',
                                    \App\Enums\UserStatus::Banned => 'Đang bị cấm',
                                }); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        <?php else: ?>
            <!-- Create new user member account -->
            <div class="container d-flex justify-content-between align-items-center mb-3">
                <p class="text-danger-opacity-5 m-0 p-0">Khách hàng chưa có tài khoản...</p>
                <button id="create-account" type="button" class="btn btn-info">
                    <i class="fa-solid fa-user-plus"></i>
                    Tạo tài khoản
                </button>
                <button id="cancel-create-account" type="button" class="btn btn-info account-form" hidden>
                    <i class="fa-solid fa-user-xmark"></i>
                    Hủy tạo tài khoản
                </button>
            </div>
            <!-- User member account form input -->
            <div class="account-form" hidden>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="w-100 input-group input-group-sm mb-3" >
                    <div class="w-25 input-group-prepend">
                        <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tài khoản email</span>
                    </div>
                    <input type="text" class="form-control w-75 input-disable" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-sm" name="email" value="<?php echo e(old('email')); ?>">
                </div>
                <?php $__errorArgs = ['phone'];
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
                        <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
                    </div>
                    <input type="text" class="form-control w-75 input-disable" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-sm" name="phone" value="<?php echo e(old('phone')); ?>">
                </div>

            </div>
        <?php endif; ?>

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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Họ và tên</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e($customer->name); ?>">
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
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Địa chỉ thường trú</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="address" value="<?php echo e($customer->address); ?>">
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
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Quốc Tịch</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="country" value="<?php echo e($customer->country); ?>">
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
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số CCCD/CMT/Visa</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="citizen_id" value="<?php echo e($customer->citizen_id); ?>">
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
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Ngày sinh</span>
            </div>
            <input type="date" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="birth_day" value="<?php echo e($customer->birth_day); ?>">
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giới tính</span>
            </div>
            <select class="form-control" name="gender">
                <?php $__currentLoopData = \App\Enums\User\UserGender::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($customer->gender == $gender ? 'selected' : ''); ?> value=<?php echo e($gender); ?>>
                        <?php echo e($gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ'); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        // hide|show input create member account form
        $(document).ready(function () {
            let isCreateAccount = localStorage.getItem("isCreateAccount") === "true";
            updateInterface(); // Gọi hàm updateInterface lần đầu để cập nhật giao diện ban đầu

            $(document).on("click", "#create-account", function () {
                isCreateAccount = true;
                localStorage.setItem("isCreateAccount", isCreateAccount);
                updateInterface();
            });

            $(document).on("click", "#cancel-create-account", function () {
                isCreateAccount = false;
                localStorage.setItem("isCreateAccount", isCreateAccount);
                updateInterface();
            });

            function updateInterface() {
                if (isCreateAccount) {
                    $("#create-account").attr("hidden", true);
                    $(".account-form").removeAttr("hidden");
                    $(".input-disable").attr("disabled", false);
                } else {
                    $("#create-account").removeAttr("hidden");
                    $(".account-form").attr("hidden", true);
                    $(".input-disable").attr("disabled", true);
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/customers/edit.blade.php ENDPATH**/ ?>