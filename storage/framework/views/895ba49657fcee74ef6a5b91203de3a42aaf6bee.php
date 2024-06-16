
<div class="col-md-12">
    <form class="row" action="<?php echo e(route('admin.booking.create')); ?>" method="">
        <?php echo csrf_field(); ?>
        <div class="col-md-9 m-auto">
            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3" wire:ignore>
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chi nhánh</span>
                        </div>
                        <select class="selectpicker w-75" data-live-search="true"
                                data-style="bg-white border border-left-0" name="branch" required>
                            <option value=""> Chọn chi nhánh </option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option class="text-capitalize" value="<?php echo e($branch['id']); ?>"
                                    <?php echo e(request()->get('branch') == $branch['id'] ? 'selected' : ''); ?>>
                                    <?php echo e($branch['name']); ?> - <?php echo e($branch['city']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3" wire:ignore>
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại phòng</span>
                        </div>
                        <select class="selectpicker w-75" name="room_type" data-live-search="true"
                               data-style="bg-white border border-left-0">
                            <option value=""> Tất cả </option>
                            <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option class="text-capitalize" value=<?php echo e($roomType['id']); ?>

                                    <?php echo e(request()->get('room_type') == $roomType['id'] ? 'selected' : ''); ?>>
                                    <?php echo e($roomType['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Check in</span>
                        </div>
                        <input type="datetime-local" class="col-md-10 form-control find-input" min="<?php echo e($minCheckin); ?>"
                               name="checkin" wire:change="setMinCheckOut($event.target.value)"
                               value="<?php echo e(request()->get('checkin') ?? null); ?>" required>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Check out</span>
                        </div>
                        <input type="datetime-local" class="col-md-10 form-control find-input" name="checkout"
                               value="<?php echo e(request()->get('checkout') ?? null); ?>" min="<?php echo e($minCheckout); ?>" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-auto">
            <button type="submit" class="btn btn-warning text-white">
                <i class="fa-solid fa-magnifying-glass"></i>
                Tìm kiếm
            </button>
        </div>
    </form>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/booking/create-form.blade.php ENDPATH**/ ?>