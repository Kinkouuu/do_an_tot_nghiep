<div>
    <form id="form-search" class="col-md-12 mt-2" action="" method="">
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
                            <select class="selectpicker col-md-10 p-0" name="city" data-live-search="true" data-style="bg-white border border-left-0" style="height: 47px">
                               <?php $__currentLoopData = $branch_cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch_city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option class="text-capitalize" value="<?php echo e($branch_city->first()->city); ?>"><?php echo e($branch_city->first()->city); ?></option>
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-6 pb-2">
                            <label class="text-white">
                                <i class="fa-solid fa-people-line"></i>
                                <span>Số người</span>
                            </label>
                            <div class="d-flex justify-content-center">
                                <input type="number" name="people" class="col-md-6 find-input border-right-0 rounded-left" placeholder="Người lớn">
                                <input type="number" name="children" class="col-md-6 find-input border-left-0 rounded-right" placeholder="Trẻ em">
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <div class="row">
                                <div class="col-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-calendar-plus"></i>
                                        <span>Ngày nhận phòng</span>
                                    </label>
                                    <div class="d-flex justify-content-between">
                                        <input type="datetime-local" name="checkin" class="col-md-10 form-control find-input"
                                        min="2024-06-17 12:00">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-calendar-minus"></i>
                                        <span>Ngày trả phòng</span>
                                    </label>
                                    <div class="d-flex justify-content-between">
                                        <input type="datetime-local" name="checkout" class="col-md-10 form-control find-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pb-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="text-white">
                                        <i class="fa-solid fa-hotel"></i>
                                        <span>Loại phòng</span>
                                    </label>
                                    <select class="selectpicker col-md-12 p-0" name="type" data-live-search="true" data-style="bg-white border border-left-0" style="height: 47px">
                                       <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                           <option value="<?php echo e($type['id']); ?>" class="text-capitalize"><?php echo e($type['name']); ?></option>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-12 text-center pt-5">
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
        </div>
    </form>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/components/room-search.blade.php ENDPATH**/ ?>