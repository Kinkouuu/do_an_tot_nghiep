<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <div class="row">
            <div class="d-flex justify-content-between mt-3 mb-5">
                <div class="col-2 my-auto text-center">
                    <a class="btn btn-outline-success" href="<?php echo e(route('admin.room-type.edit', $room['roomType']['id'])); ?>">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Xem giá phòng
                    </a>
                </div>

                <h1 class="text-center p-3"> <?php echo e($title); ?>

                    <br>
                    <strong class="text-secondary text-uppercase">[<?php echo e($room->name . ' - ' . $room->branch->name . '/' . $room->branch->city); ?>]</strong>
                </h1>
                <div class="col-2 my-auto text-center">
                    <a class="btn btn-outline-success" href="<?php echo e(route('admin.room.devices', ['code' => $room->id])); ?>">
                        <i class="fa-solid fa-server"></i>
                       Danh sách thiết bị
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form class="container col-md-8 text-center justify-content-center"
          action="<?php echo e(route('admin.room.update', $room)); ?>" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Phân loại phòng</span>
            </div>
            <select class="selectpicker w-75" name="room_type_id" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($room->roomType->id == $roomType->id ? 'selected' : ''); ?> value=<?php echo e($roomType->id); ?>>
                        <?php echo e($roomType->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chi nhánh</span>
            </div>
            <select class="selectpicker w-75" name="branch_id" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($room->branch->id == $branch->id ? 'selected' : ''); ?> value=<?php echo e($branch->id); ?>>
                        <?php echo e($branch->name . ' - ' . $branch->city); ?>

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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên phòng</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e($room->name); ?>">
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select w-75" name="status" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = \App\Enums\Room\RoomStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($room->status == $status['key'] ? 'selected' : ''); ?> value=<?php echo e($status['key']); ?>>
                        <?php echo e($status['value']); ?>

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
                <textarea class="ckeditor" name="description"><?php echo e($room->description); ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/rooms/edit.blade.php ENDPATH**/ ?>