<div class="col-12 p-0 d-flex text-center">
        <div class="col-1 py-1 border"><?php echo e($room_device['id']); ?></div>
        <div class="col-2 py-1 border"><?php echo e($room_device['name']); ?></div>
        <div class="col-2 py-1 border"><?php echo e($room_device['type']); ?></div>
        <div class="col-1 py-1  border"><?php echo e($room_device['brand']); ?></div>
        <div class="col-2 py-1 border"><?php echo e($room_device['remain']); ?> thiết bị</div>
        <div class="col-2 py-1 border">
            <input class="form-control" type="number" min="0"
                   max="<?php echo e($room_device['remain'] + $room_device['equipping']); ?>"
                   value="<?php echo e($room_device['equipping']); ?>" <?php echo e((($room_device['remain'] == 0) && ($room_device['equipping'] == 0))  ? 'readonly' : ''); ?>

                   wire:change="updateEquipQuantity($event.target.value)">
            <span class="text-danger"><?php echo e($error); ?></span>
        </div>
        <div class="col-2 py-1 border">
                    <textarea class="form-control" maxlength="50" <?php echo e($room_device['equipping'] == 0  ? 'readonly' : ''); ?>

                    wire:change="updateNote($event.target.value)"><?php echo e($room_device['note']); ?></textarea>
        </div>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/room-device.blade.php ENDPATH**/ ?>