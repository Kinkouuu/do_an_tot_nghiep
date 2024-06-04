<?php echo $__env->make('user.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="container mt-5 bg-light">
    <div class="col-12 position-relative">
        <div class="position-absolute" style="bottom: 30px; right: 50px">
            <img src="<?php echo e(asset('images/paid.png')); ?>">
        </div>
        <div class="row">
            <div class="col-12 border-bottom border-white bg-warning">
               <div class="col-4">
                   <img src="<?php echo e(asset('images/logo.png')); ?>" class="w-100">
               </div>
                <div class="col-8 text-right text-dark">
                   <p> <?php echo e($booking['created_at']->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    <p>Mã đơn hàng: <?php echo e($booking['id']); ?></p>
                </div>
            </div>
            <div class="col-12 text-dark">
                <p>Kính gửi quý khách hàng <?php echo e($userName); ?>,</p>
                <p>Cảm ơn bạn đã tin tưởng và đặt phòng tại V.V.C Booking！</p>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">Thông tin đơn hàng</th>
                    </tr>
                    </thead>
                    <tbody>
                   <?php $__currentLoopData = $roomInfo['rooms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <tr>
                           <th scope="row"><strong class="text-capitalize"> <?php echo e($room['room_type']); ?> </strong></th>
                           <td>x<?php echo e(count($room['room_ids'])); ?></td>
                           <td><?php echo e(number_format($room['total_price_1_room'], 0, ',', '.')); ?> VND</td>
                       </tr>
                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th>Tổng:</th>
                        <td><?php echo e($roomInfo['total_amount']['total_room']); ?> phòng</td>
                        <td><?php echo e(number_format($roomInfo['total_amount']['total_price'],0, ',', '.')); ?> VND</td>
                    </tr>
                   <tr>
                       <th>Phương thức thanh toán:</th>
                       <td><?php echo e($booking['payment_type']); ?> </td>
                       <td>-<?php echo e(number_format($booking['deposit'], 0, ',', '.')); ?> VND</td>
                   </tr>
                   <tr>
                       <th colspan="3" class="text-right"><?php echo e(number_format($roomInfo['total_amount']['total_price'] - $booking['deposit'], 0, ',', '.')); ?> VND</th>
                   </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <i class="fa-solid fa-location-dot"></i> Địa điểm:
                        <h3 class="text-capitalize"><?php echo e($roomInfo['branch']['name']); ?></h3>
                        <p class="text-capitalize"><?php echo e($roomInfo['branch']['address'] . ', ' .  $roomInfo['branch']['city']); ?></p>
                    </div>
                    <div class="col-12">
                        <i class="fa-regular fa-calendar-days"></i> Thời gian:
                        <p>
                            <span> <?php echo e($booking['booking_checkin']->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                            -
                            <span> <?php echo e($booking['booking_checkout']->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php if($booking['status'] == \App\Enums\Booking\BookingStatus::Refuse['key']): ?>
                <div class="col-12">
                    <h2>Thật tiếc khi phải thông báo đơn hàng của bạn đã bị hủy bởi hệ thống với lý do:
                        <span class="text-danger"> <?php echo e($booking['refuse_reason']); ?></span>
                    </h2>
                    <p>Vui lòng chờ ít phút, chúng tôi sẽ gọi điện tư vấn cho bạn hoặc bạn có thể đặt lại đơn khác theo
                     <a href="<?php echo e(route('search', $roomInfo['condition'])); ?>" style="text-decoration: underline; color: blue">đường dẫn</a>
                    </p>
                    <p class="text-danger">Số tiền đã thanh toán trước (nếu có) của đơn hàng sẽ được hoàn trả sau 24h làm việc.</p>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <?php if($booking['for_relative']): ?>
                        <p class="text-secondary">
                            Chúng tôi cũng sẽ gọi điện với anh/chị <?php echo e($booking['name']); ?> qua số điện thoại <?php echo e($booking['phone']); ?> để xác nhận lại đơn hàng.
                        </p>
                    <?php endif; ?>
                    <p class="text-danger">
                        *Lưu ý: Người đại diện nhận phòng cần mang theo thẻ căn cước, chứng minh thư, hộ chiếu... hoặc các giấy tờ tùy thân tương đương để làm thủ tục nhận phòng.
                    </p>
                    <p class="text-info">
                        Nếu có bất kì thắc mắc cần được tư vấn, vui lòng liên hệ qua số hotline:
                        <a href="tel:<?php echo e($roomInfo['branch']['phone']); ?>"> <?php echo e($roomInfo['branch']['phone']); ?> </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo $__env->make('user.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/emails/bookingCompletedEmail.blade.php ENDPATH**/ ?>