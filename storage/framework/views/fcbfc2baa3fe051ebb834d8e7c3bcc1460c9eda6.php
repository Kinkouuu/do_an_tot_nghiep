<?php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
?>


<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                    <img class="rounded w-100" src="<?php echo e($branch['avatar']); ?>">
                    <h5 class="text-center text-danger font-italic font-weight-bold mt-2">
                        <?php echo e($branch['name'] . ' - ' . $branch['city']); ?>

                    </h5>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-location-arrow"></i>
                            <p class="m-0 px-2">Địa chỉ: </p>
                        </div>
                        <p class="text-info m-0"><?php echo e($branch['address'] . ', ' . $branch['city']); ?></p>
                    </div>
                    <div class="col-md-12">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-phone"></i>
                            <p class="m-0 px-2">Hotline: </p>
                            <a href="tel:<?php echo e($branch['phone']); ?>"
                               class="m-2 text-info"><?php echo e($branch['phone']); ?></a>
                        </div>
                    </div>
            </div>
            <div class="col-md-6">
                <div class="col-12 m-auto py-4 rounded text-dark bg-light border border-warning">
                    <h5 class="text-center text-secondary mb-3 text-uppercase"> Thông tin chuyến đi</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-user"></i>
                            <span><?php echo e($booking['gender'] == UserGender::Male ? 'Anh' : 'Chị'); ?>: <?php echo e($booking['name']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            <span>Số điện thoại: <?php echo e($booking['phone']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-passport"></i>
                            <span>Quốc tịch: <?php echo e($booking['country']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-id-card"></i>
                            <span>CCCD/Visa: <?php echo e($booking['citizen_id']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Địa điểm: Khách sạn <?php echo e($branch['name']); ?> - <?php echo e($branch['city']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-restroom"></i>
                            <span>Số người: <?php echo e($booking['number_of_adults']); ?> người lớn và <?php echo e($booking['number_of_children']); ?> trẻ em</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <span>Ngày nhận phòng: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                            <span>Ngày trả phòng: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>Ngày đặt đơn: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                               Chuyến đi <?php echo e($total['total_time']); ?> dành cho <?php echo e($booking['number_of_adults'] + $booking['number_of_children']); ?> người
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-door-open"></i>
                            <span>
                               Số lượng phòng: <strong class="text-warning"><?php echo e($total['total_room']); ?> phòng</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-money-bill-1"></i>
                            <span>
                              Tổng chi phí: <strong class="text-warning"><?php echo e(number_format($total['total_price'], 0, ',', '.')); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-cash-register"></i>
                            <span>
                              Phương thức thanh toán: <strong class="text-warning"><?php echo e(PaymentType::getValue($booking['payment_type'])); ?></strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            <span>
                               Đã thanh toán: <strong class="text-success"><?php echo e(number_format($booking['deposit'], 0, ',', '.')); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span>
                               Cần thanh toán: <strong class="text-danger"> <?php echo e(number_format($total['total_price'] - $booking['deposit'], 0, ',', '.' )); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <?php if($booking['note']): ?>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-contract"></i>
                                <span>
                               Ghi chú:
                                 <?php echo e($booking['note']); ?>

                           </span>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>
                               Trạng thái:
                                 <?php if(in_array($booking['status'], BookingStatus::getAwaitingBooking())): ?>
                                    <strong style="color: #ff9100">
                                        <?php echo e(BookingStatus::getValue($booking['status'])); ?>

                                    </strong>
                                <?php elseif(in_array($booking['status'], BookingStatus::getConfirmedBooking())): ?>
                                    <strong style="color: #139b65">
                                        <?php echo e(BookingStatus::getValue($booking['status'])); ?>

                                     </strong>
                                <?php else: ?>
                                    <strong style="color: orangered">
                                        <?php echo e(BookingStatus::getValue($booking['status'])); ?>

                                    </strong>
                                <?php endif; ?>
                           </span>
                        </label>
                    </div>
                    <?php if($booking['refuse_reason']): ?>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-invoice"></i>
                                <span>
                              Lý do hủy:
                                 <?php echo e($booking['refuse_reason']); ?>

                           </span>
                            </label>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>




















































<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/edit.blade.php ENDPATH**/ ?>