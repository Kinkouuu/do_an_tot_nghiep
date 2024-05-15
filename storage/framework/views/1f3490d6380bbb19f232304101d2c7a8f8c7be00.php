<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">

                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.room-type.images', ['code' => $type_room['id']])); ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Ảnh chi tiết
                        </a>
                    </div>
                    <h1 class="col-8 my-auto text-center"><?php echo e($title); ?>

                        <br>
                        <strong class="text-secondary text-uppercase">[ <?php echo e($type_room['name']); ?> ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.room-type.services', ['code' =>  $type_room['id']])); ?>">
                            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                            Chi tiết dịch vụ
                        </a>
                    </div>
                </div>
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
                               aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e($type_room->name); ?>">
                    </div>
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
                        </div>
                        <select class="form-select" name="status">
                            <?php $__currentLoopData = \App\Enums\Service\ServiceStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e($type_room->status == $status ? 'selected' : ''); ?> value=<?php echo e($status); ?>>
                                    <?php echo e(match ($status) {
                                            \App\Enums\Service\ServiceStatus::DeActive => 'Dừng hoạt động',
                                             \App\Enums\Service\ServiceStatus::Active => 'Đang kích hoạt',
                                        }); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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
                            <textarea class="ckeditor" name="description"><?php echo e($type_room->description); ?></textarea>
                        </div>
                    </div>
                    <?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $__errorArgs = ['price.' . $price['id']];
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
                                <span class="input-group-text w-100" id="inputGroup-sizing-sm"><?php echo e($price['name']); ?></span>
                            </div>
                            <input type="number" min="0" class="form-control w-auto" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm"
                                   name="price[<?php echo e($price['id']); ?>]" value="<?php echo e($price['price']); ?>">
                            <span class="input-group-text w-10" id="inputGroup-sizing-sm">VND/<?php echo e($price['type']); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/edit.blade.php ENDPATH**/ ?>