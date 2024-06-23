<?php
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
    use Carbon\Carbon;
    use App\Enums\Booking\BookingStatus;
?>


<?php $__env->startSection('content'); ?>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-3 text-white"
                             style="background-image: url(<?php echo e(asset($branch['avatar'])); ?>); background-repeat: no-repeat; background-size: cover">
                            <h3 class="text-light"
                                style="font-size: xxx-large; font-style: oblique"><?php echo e($branch['name']); ?></h3>
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                   <div class="col-md-6">
                                       <p><i class="fa-solid fa-phone-volume"></i>
                                           <strong>Hotline:</strong>
                                           <?php echo e($branch['phone']); ?>

                                       </p>
                                       <p><i class="fa-solid fa-map-location-dot"></i>
                                           <strong>Địa chỉ:</strong>
                                           <?php echo e($branch['address']); ?>, <?php echo e($branch['city']); ?>

                                       </p>
                                   </div>
                                    <div class="col-md-6 text-right">
                                        <a class="btn btn-outline-warning text-light" href="<?php echo e(route('feedback.show', base64_encode($booking['id']))); ?>">
                                            <i class="fa-regular fa-star-half-stroke"></i>
                                            Đánh giá chuyến đi
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pt-3" style="background-color: #f1e6b2">
                            <div class="row align-items-center">
                                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4 p-2">
                                        <img href="<?php echo e($room['thumb_nail']); ?>" src="<?php echo e($room['thumb_nail']); ?>"
                                             alt="Ảnh phòng"
                                             class="img-fluid image-popup img-opacity w-75" loading="lazy">
                                        <?php $__currentLoopData = $room['detail_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <img href="<?php echo e($detailImage); ?>" src="<?php echo e($detailImage); ?>" alt="Ảnh chi tiết"
                                                 class="img-fluid detail-img-absolute image-popup img-opacity"
                                                 loading="lazy">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="section-heading text-left">
                                            <h2 class="mb-5 text-uppercase">Phòng <span
                                                    class="ms-5 m-md-0"><?php echo e($room['room_type']); ?></span>
                                                <span
                                                    class="text-lowercase text-secondary">x<?php echo e(count($room['room_ids'])); ?></span>
                                            </h2>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6 border-bottom border-warning">
                                                    <h5><i class="fa-solid fa-bed"></i> Số giường</h5>
                                                    <ul>
                                                        <?php if($room['single_bed'] > 0): ?>
                                                            <li>Giường đơn: x <?php echo e($room['single_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['double_bed'] > 0): ?>
                                                            <li>Giường đôi: x <?php echo e($room['double_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['twin_bed'] > 0): ?>
                                                            <li>Giường cặp: x <?php echo e($room['twin_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['family_bed'] > 0): ?>
                                                            <li>Giường gia đình: x <?php echo e($room['family_bed']); ?></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <h5><i class="fa-solid fa-bell-concierge"></i> Dịch vụ có sẵn</h5>
                                                    <ul>
                                                        <?php $__currentLoopData = $room['services']['provide']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <p>
                                                                    <?php echo e($service['service_name']); ?>

                                                                    <?php if($service['discount'] == 100): ?>
                                                                        <span class="text-danger"> (miễn phí) </span>
                                                                    <?php else: ?>
                                                                        <span class="text-info"><?php echo e(number_format($service['price'], 0, ',', '.')); ?> VND/người</span>
                                                                        <span class="text-danger">(-<?php echo e($service['discount']); ?>%)</span>
                                                                    <?php endif; ?>
                                                                </p>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 border-bottom border-warning pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        Giá phòng:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        <?php echo e(number_format($room['total_price_1_room'], 0, ',', '.')); ?>

                                                        VND/phòng
                                                    </p>
                                                    <h5><i class="fa-solid fa-money-bill-wave"></i>
                                                        Thành tiền:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        <?php echo e(number_format(count($room['room_ids']) * $room['total_price_1_room'], 0, ',', '.')); ?>

                                                        VND/<?php echo e(count($room['room_ids'])); ?> phòng
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
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
                            <span>Số điện thoại: <?php echo e(substr_replace($booking['phone'], str_repeat('*', 4), 3, 3)); ?></span>
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
                            <span>CCCD/Visa: <?php echo e(substr_replace($booking['citizen_id'], str_repeat('*', 9), 0, 9)); ?></span>
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
                    <div class="col-md-12">
                        <div class="row justify-content-around">
                            <?php if(in_array($booking['status'], BookingStatus::getAwaitingBooking())): ?>
                                <button class="col-md-5 btn btn-outline-danger">
                                    <i class="fa-solid fa-ban"></i>
                                    Hủy đơn
                                </button>
                            <?php endif; ?>

                            <?php if($booking['status'] == BookingStatus::AwaitingPayment['key']): ?>
                                <a class="col-md-5 btn btn-outline-warning" href="<?php echo e(route('booking.payment-request', base64_encode($bookingRoom['booking']['id']))); ?>">
                                    <i class="fa-solid fa-wallet"></i>
                                    Thanh toán ngay
                                </a>
                            <?php endif; ?>

                            <?php if($booking['status'] == BookingStatus::Completed['key']): ?>
                                <a href="" class="col-md-5 btn btn-outline-success">
                                    <i class="fa-solid fa-star"></i>
                                    Đánh giá
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/bookings/detail.blade.php ENDPATH**/ ?>