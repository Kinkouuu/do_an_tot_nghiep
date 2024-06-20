<div class="pl-2">
    <div class="d-flex">
        <strong class="pr-1">Phòng: </strong>
        <a href="<?php echo e(route('admin.room.edit', $room['id'])); ?>"> <?php echo e($room['name']); ?></a>
        <?php if($checkin_at && !$checkout_at): ?>
            <p class="text-info pl-2 m-0"> Đã nhận phòng </p>
    </div>
    <p class="text-capitalize m-0"><?php echo e($checkin_at); ?></p>
    <p class="m-0">(<?php echo e($early); ?> so với giờ checkin)</p>
    <?php elseif($checkout_at): ?>
        <p class="text-success pl-2 m-0">Đã trả phòng </p>
</div>
<p class="text-capitalize m-0">
    <i class="fa-solid fa-building-circle-arrow-right"></i>
    <?php echo e($checkin_at); ?></p>
<p class="m-0">(<?php echo e($early); ?> so với giờ checkin)</p>
<p class="text-capitalize m-0">
    <i class="fa-solid fa-building-circle-arrow-right fa-flip-horizontal"></i>
    <?php echo e($checkout_at); ?></p>
<p class="m-0">(<?php echo e($lately); ?> so với giờ checkout)</p>
<?php else: ?>
    <a type="button" class="text-primary pl-2" style="text-decoration: underline" data-toggle="modal"
       data-target="#respective-room-<?php echo e($room['id']); ?>">
        <i class="fa-solid fa-rotate"></i>Đổi phòng
    </a>
    </div>
    <!-- Modal -->
    <form wire:ignore.self class="modal fade" id="respective-room-<?php echo e($room['id']); ?>"
          tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="changeRoom">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="exampleModalLabel">Đổi phòng tương ứng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if($respectiveRooms->isEmpty()): ?>
                        <h5>Hiện không còn phòng tương ứng nào còn trống</h5>
                        <img src="<?php echo e(asset('images/empty-cart.webp')); ?>" class="w-100"
                             alt="Not respective rooms available">
                    <?php else: ?>
                        <?php $__currentLoopData = $respectiveRooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $respectiveRoom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check form-check-inline mb-2">
                                <input class="form-check-input" type="radio" wire:model="roomChangeId"
                                       name="roomChangeId" id="inlineRadio1" value="<?php echo e($respectiveRoom['id']); ?>">
                                <label class="form-check-label"
                                       for="inlineRadio1">Phòng <?php echo e($respectiveRoom['name']); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Đổi</button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
    <?php endif; ?>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/booking/change-room.blade.php ENDPATH**/ ?>