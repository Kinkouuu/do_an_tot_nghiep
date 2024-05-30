<?php $__env->startSection('content'); ?>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
               <div class="col-12 m-auto py-4 rounded text-white" style="background-color:#a6a6a6">
                    <h5 class="text-center text-light mb-3"> Thông tin chuyến đi</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Địa điểm: Khách sạn <?php echo e($branch['name']); ?> - <?php echo e($branch['city']); ?></span>
                        </label>
                        <p> <?php echo e($branch['address']); ?>, <?php echo e($branch['city']); ?></p>
                    </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-restroom"></i>
                           <span>Số người: <?php echo e($condition['adults']); ?> người lớn và <?php echo e($condition['children']); ?> trẻ em</span>
                       </label>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-person-walking-luggage"></i>
                           <span>Ngày nhận phòng: </span>
                       </label>
                       <p class="text-capitalize"><?php echo e($condition['checkin']->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                           <span>Ngày trả phòng: </span>
                       </label>
                       <p class="text-capitalize"><?php echo e($condition['checkout']->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-clock"></i>
                           <span>
                               Chuyến đi <?php echo e($condition['duration']); ?> dành cho <?php echo e($condition['adults'] + $condition['children']); ?> người
                           </span>
                       </label>
                   </div>
               </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <img src="<?php echo e($branch['avatar']); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>









































































<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/bookings/booking-confirm.blade.php ENDPATH**/ ?>