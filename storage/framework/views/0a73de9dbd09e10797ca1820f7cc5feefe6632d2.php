<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <form class="container col-md-8 text-center justify-content-center"
          action="<?php echo e(route('admin.room.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Phân loại phòng</span>
            </div>
            <select class="selectpicker w-75" name="room_type_id" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(old('room_type_id') == $roomType->id ? 'selected' : ''); ?> value=<?php echo e($roomType->id); ?>>
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
                    <option <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?> value=<?php echo e($branch->id); ?>>
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="<?php echo e(old('name')); ?>">
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select w-75" name="status" data-live-search="true" data-style="bg-white border border-left-0">
                <?php $__currentLoopData = \App\Enums\Room\RoomStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e(old('$status') == $status['key'] ? 'selected' : ''); ?> value=<?php echo e($status['key']); ?>>
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
                <textarea class="ckeditor" name="description"><?php echo e(old('description')); ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Thêm mới</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/rooms/create.blade.php ENDPATH**/ ?>