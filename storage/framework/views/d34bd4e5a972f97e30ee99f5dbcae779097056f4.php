<div>
    <form id="form-search" class="col-md-12 mt-2" action="<?php echo e(route('search')); ?>" method="">
        <?php echo csrf_field(); ?>
        <div class="col-md-6 m-auto py-3 px-5 search-section">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="row">
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Bạn muốn đi đâu?</span>
                            </label>
                            <select class="col-md-10 form-control" name="city">
                                <?php $__currentLoopData = $branchCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch_city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="text-capitalize "
                                            <?php echo e(request()->get('city') == $branch_city ? 'selected' : ''); ?>

                                            value="<?php echo e($branch_city); ?>"><?php echo e($branch_city); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-people-line"></i>
                                <span>Số người</span><span class="text-warning" style="font-size: 11px"> *Mỗi người lớn tối đa đi cùng 2 trẻ em </span>
                            </label>
                            <div class="d-flex justify-content-center">
                                <div class=" col-md-6 input-with-icon">
                                    <i class="fa-solid fa-person"></i>
                                    <input type="number" name="adults"
                                           class="w-100 find-input border-right-0 rounded-left" placeholder="Người lớn"
                                           required value="<?php echo e(request()->get('adults') ?? null); ?>"
                                           min="0" wire:change="setMaxChildren($event.target.value)">
                                </div>
                                <div class=" col-md-6 input-with-icon">
                                    <i class="fa-solid fa-children"></i>
                                    <input type="number" name="children" min="0" max="<?php echo e($maxChildren); ?>"
                                           class="w-100 find-input border-left-0 rounded-right" placeholder="Trẻ em"
                                           value="<?php echo e(request()->get('children') ?? null); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-calendar-plus"></i>
                                <span>Ngày nhận phòng</span>
                            </label>
                            <input type="datetime-local" name="checkin" class="col-md-10 form-control find-input"
                                   min="<?php echo e($minCheckin); ?>" wire:change="setMinCheckOut($event.target.value)"
                                   value="<?php echo e(request()->get('checkin') ?? null); ?>" step="1800" required>

                        </div>
                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-calendar-minus"></i>
                                <span>Ngày trả phòng</span>
                            </label>
                            <input type="datetime-local" name="checkout" class="w-100 form-control find-input"
                                   value="<?php echo e(request()->get('checkout') ?? null); ?>" min="<?php echo e($minCheckout); ?>" required>
                        </div>
                        <div class="col-md-12 pb-2">
                            <div class="col-md-12 text-center pt-2">
                                <button class="btn btn-warning text-white">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/form-search.blade.php ENDPATH**/ ?>