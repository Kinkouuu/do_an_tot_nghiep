<?php echo $__env->make('user.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="text-center">
    <h3 class="text-black">
        Mã xác thực  <span class="text-lowercase"> <?php echo e($subject); ?> </span> của bạn là: <span class="text-secondary"> <?php echo e($verifyCode); ?> </span>
    </h3>
    <p class="text-danger">
        * Lưu ý: Mã xác thực chỉ có hạn trong 5 phút. Vui lòng không chia sẻ mã này với bất kỳ người khác!
    </p>
</section>

<?php echo $__env->make('user.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php /**PATH E:\DATN\VVCBooking\resources\views/user/emails/verificationEmail.blade.php ENDPATH**/ ?>