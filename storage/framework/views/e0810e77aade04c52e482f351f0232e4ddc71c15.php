    <select class="form-select change-status" wire:change="changeStatus($event.target.value)">
        <?php $__currentLoopData = \App\Enums\Room\RoomStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($status['key']); ?>" <?php echo e($room->status == $status['key'] ? 'selected' : ''); ?>>
                <?php echo e($status['value']); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/room-status.blade.php ENDPATH**/ ?>