<select class="form-select change-status" data-id="<?php echo e($item->id); ?>" wire:change="changeStatus($event.target.value)">
    <?php $__currentLoopData = \App\Enums\UserStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($status); ?>" <?php echo e($item->status == $status ? 'selected' : ''); ?>>
            <?php echo e(match ($status) {
                   \App\Enums\UserStatus::Cancelled => 'Đã hủy',
                   \App\Enums\UserStatus::Active => 'Đang hoạt động',
                   \App\Enums\UserStatus::Banned => 'Bị cấm',
               }); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/status/change-status.blade.php ENDPATH**/ ?>