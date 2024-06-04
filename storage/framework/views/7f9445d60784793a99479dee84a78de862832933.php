<?php echo $__env->make('user.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container mt-5 text-center">
        <img src="<?php echo e(asset('images/vn_pay.png')); ?>">
       <?php if($data['status'] == 'success'): ?>
            <h1 class="text-success my-5"><?php echo e($data['title']); ?></h1>
            <h3 class="mb-3">
                <strong>Mã giao dịch: </strong>
                <span class="text-info" style="text-decoration: underline"><?php echo e($data['code']); ?> </span>
            </h3>
           <h3>
               <strong>Số tiền: </strong>
                <span class="text-success"> <?php echo e(number_format($data['amount'],0,',','.')); ?> VND</span>
           </h3>
           <a class="btn btn-primary mt-3 text-white" href="<?php echo e(route('booking.show', $booking_id)); ?>">Xem chi tiết đơn đặt</a>
        <?php else: ?>
            <h1 class="text-danger my-5"><?php echo e($data['title']); ?></h1>
            <h3 class="mb-3">
                <strong>Mã lỗi: </strong>
                <span class="text-secondary"><?php echo e($data['code']); ?> </span>
            </h3>
            <a class="btn btn-primary text-white" href="<?php echo e(route('homepage')); ?>">Quay lại trang chủ</a>
       <?php endif; ?>
    </div>
<?php echo $__env->make('user.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/bookings/payment-response.blade.php ENDPATH**/ ?>