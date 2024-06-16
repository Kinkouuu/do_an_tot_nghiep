<div class="row">
    <?php if(!$check_in_rooms->isEmpty()): ?>
        <div class="col-md-6 m-auto text-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#checkInModal">
                <i class="fa-solid fa-person-walking-arrow-right"></i>
                Check In
            </button>
        </div>

        <!-- Modal -->
        <form wire:ignore.self class="modal fade" id="checkInModal" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="checkin">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn phòng check-in</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ms-3 mb-2 form-check form-switch">
                            <input class="form-check-input" wire:click.prevent="quickCheckIn"
                                   type="checkbox" id="selectAll" <?php echo e($selectAllInRooms ? 'checked' :''); ?>>
                            <label class="form-check-label" for="selectAll">
                                Chọn tất cả
                            </label>
                        </div>
                        <?php $__currentLoopData = $check_in_rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" wire:model.sync="inRooms" type="checkbox"
                                       value="<?php echo e($room['id']); ?>" id="<?php echo e($room['id']); ?>" >
                                <label class="form-check-label" for="<?php echo e($room['id']); ?>">
                                    <?php echo e($room['name']); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
    <?php if(!$check_out_rooms->isEmpty()): ?>
            <div class="col-md-6 m-auto text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#checkOutModal">
                    <i class="fa-solid fa-person-walking-arrow-right fa-flip-horizontal"></i>
                    Check Out
                </button>
            </div>

            <!-- Modal -->
            <form wire:ignore.self class="modal fade" id="checkOutModal" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="checkout">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chọn phòng check-out</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="ms-3 mb-2 form-check form-switch">
                                <input class="form-check-input" wire:click.prevent="quickCheckOut"
                                       type="checkbox" id="selectAll" <?php echo e($selectAllOutRooms ? 'checked' :''); ?>>
                                <label class="form-check-label" for="selectAll">
                                    Chọn tất cả
                                </label>
                            </div>
                            <?php $__currentLoopData = $check_out_rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input class="form-check-input" wire:model.sync="outRooms" type="checkbox"
                                           value="<?php echo e($room['id']); ?>" id="<?php echo e($room['id']); ?>" >
                                    <label class="form-check-label" for="<?php echo e($room['id']); ?>">
                                        <?php echo e($room['name']); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </form>
    <?php endif; ?>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/booking/checkin-checkout.blade.php ENDPATH**/ ?>