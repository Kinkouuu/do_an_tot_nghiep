<div class="w-100">
    <div class="d-flex">
        Giảm:
        <input type="number" class="discount w-50 mx-1" value="<?php echo e($discount); ?>"
               <?php echo e($service['status'] == \App\Enums\Service\ServiceStatus::DeActive ? 'readonly' : ''); ?>

               min="0" max="100" wire:change="update($event.target.value)"
        > %/vé
    </div>
    <span class="text-danger text-sm"><?php echo e($error); ?></span>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room-service/change-discount.blade.php ENDPATH**/ ?>