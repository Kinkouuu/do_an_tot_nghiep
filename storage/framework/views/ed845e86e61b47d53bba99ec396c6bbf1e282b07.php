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
                                           <strong><?php echo e(__('Địa chỉ')); ?>:</strong>
                                           <?php echo e($branch['address']); ?>, <?php echo e($branch['city']); ?>

                                       </p>
                                   </div>
                                    <div class="col-md-6 text-left">
                                        <!-- -->
                                        <?php if($booking['payment_type'] != PaymentType::Cash
                                            && $booking['status'] == BookingStatus::AwaitingPayment['key']): ?>
                                            <p class="text-danger bg-white p-2">
                                                *<?php echo e(__('Lưu ý: Hệ thống sẽ tự động hủy đơn lúc')); ?> <br>
                                                <strong><?php echo e(' ' .$booking->created_at->addMinutes(15) . ' '); ?></strong>
                                                <?php echo e(__('nếu bạn vẫn chưa hoàn thành thanh toán')); ?>

                                            </p>
                                            <?php endif; ?>
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
                                            <h2 class="mb-5 text-uppercase"><?php echo e(__('Phòng')); ?> <span
                                                    class="ms-5 m-md-0"><?php echo e($room['room_type']); ?></span>
                                                <span
                                                    class="text-lowercase text-secondary">x<?php echo e(count($room['room_ids'])); ?></span>
                                            </h2>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6 border-bottom border-warning">
                                                    <h5><i class="fa-solid fa-bed"></i> <?php echo e(__('Số giường')); ?></h5>
                                                    <ul>
                                                        <?php if($room['single_bed'] > 0): ?>
                                                            <li><?php echo e(__('Giường đơn')); ?>: x <?php echo e($room['single_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['double_bed'] > 0): ?>
                                                            <li><?php echo e(__('Giường đôi')); ?>: x <?php echo e($room['double_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['twin_bed'] > 0): ?>
                                                            <li><?php echo e(__('Giường cặp')); ?>: x <?php echo e($room['twin_bed']); ?></li>
                                                        <?php endif; ?>

                                                        <?php if($room['family_bed'] > 0): ?>
                                                            <li><?php echo e(__('Giường gia đình')); ?>: x <?php echo e($room['family_bed']); ?></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <h5><i class="fa-solid fa-bell-concierge"></i> <?php echo e(__('Dịch vụ có sẵn')); ?></h5>
                                                    <ul>
                                                        <?php $__currentLoopData = $room['services']['provide']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li>
                                                                <p>
                                                                    <?php echo e($service['service_name']); ?>

                                                                    <?php if($service['discount'] == 100): ?>
                                                                        <span class="text-danger"> (<?php echo e(__('miễn phí')); ?>) </span>
                                                                    <?php else: ?>
                                                                        <span class="text-info"><?php echo e(number_format($service['price'], 0, ',', '.')); ?> VND/<?php echo e(__('người')); ?></span>
                                                                        <span class="text-danger">(-<?php echo e($service['discount']); ?>%)</span>
                                                                    <?php endif; ?>
                                                                </p>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 border-bottom border-warning pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        <?php echo e(__('Giá phòng')); ?>:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        <?php echo e(number_format($room['total_price_1_room'], 0, ',', '.')); ?>

                                                        VND/<?php echo e(__('phòng')); ?>

                                                    </p>
                                                    <h5><i class="fa-solid fa-money-bill-wave"></i>
                                                        <?php echo e(__('Thành tiền')); ?>:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        <?php echo e(number_format(count($room['room_ids']) * $room['total_price_1_room'], 0, ',', '.')); ?>

                                                        VND/<?php echo e(count($room['room_ids'])); ?> <?php echo e(__('phòng')); ?>

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
                    <h5 class="text-center text-secondary mb-3 text-uppercase"> <?php echo e(__('Thông tin chuyến đi')); ?></h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-user"></i>
                            <span><?php echo e($booking['gender'] == UserGender::Male ? __('Anh') : __('Chị')); ?>: <?php echo e($booking['name']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            <span><?php echo e(__('Số điện thoại')); ?>: <?php echo e(substr_replace($booking['phone'], str_repeat('*', 4), 3, 3)); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-passport"></i>
                            <span><?php echo e(__('Quốc tịch')); ?>: <?php echo e($booking['country']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-id-card"></i>
                            <span><?php echo e(__('CCCD')); ?>/Visa: <?php echo e(substr_replace($booking['citizen_id'], str_repeat('*', 9), 0, 9)); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span><?php echo e(__('Địa điểm')); ?>: <?php echo e(__('Khách sạn')); ?> <?php echo e($branch['name']); ?> - <?php echo e($branch['city']); ?></span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-restroom"></i>
                            <span><?php echo e(__('Số người')); ?>: <?php echo e($booking['number_of_adults'] . ' ' . __('người lớn')); ?>  &
                                <?php echo e($booking['number_of_children'] . ' ' . __('trẻ em')); ?> </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <span><?php echo e(__('Ngày nhận phòng')); ?>: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                            <span><?php echo e(__('Ngày trả phòng')); ?>: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-calendar-check"></i>
                            <span><?php echo e(__('Ngày đặt đơn')); ?>: </span>
                        </label>
                        <p class="text-capitalize"><?php echo e(Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                <?php echo e(__('Chuyến đi') . ' '. $total['total_time'] . ' ' . __('cho') . ' '. $booking['number_of_adults'] + $booking['number_of_children'] . ' '. __('người')); ?>

                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-door-open"></i>
                            <span>
                               <?php echo e(__('Số lượng phòng')); ?>: <strong class="text-warning"><?php echo e($total['total_room']); ?> <?php echo e(__('phòng')); ?></strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-money-bill-1"></i>
                            <span>
                              <?php echo e(__('Tổng chi phí')); ?>: <strong class="text-warning"><?php echo e(number_format($total['total_price'], 0, ',', '.')); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-cash-register"></i>
                            <span>
                              <?php echo e(__('Phương thức thanh toán')); ?>: <strong class="text-warning"><?php echo e(__(PaymentType::getValue($booking['payment_type']))); ?></strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            <span>
                               <?php echo e(__('Đã thanh toán')); ?>: <strong class="text-success"><?php echo e(number_format($booking['deposit'], 0, ',', '.')); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span>
                               <?php echo e(__('Cần thanh toán')); ?>: <strong class="text-danger"> <?php echo e(number_format($total['total_price'] - $booking['deposit'], 0, ',', '.' )); ?> VND</strong>
                           </span>
                        </label>
                    </div>
                    <?php if($booking['note']): ?>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-contract"></i>
                                <span>
                               <?php echo e(__('Ghi chú')); ?>:
                                 <?php echo e($booking['note']); ?>

                           </span>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>
                               <?php echo e(__('Trạng thái')); ?>:
                                 <?php if(in_array($booking['status'], BookingStatus::getAwaitingBooking())): ?>
                                    <strong style="color: #ff9100">
                                        <?php echo e(__(BookingStatus::getValue($booking['status']))); ?>

                                    </strong>
                                <?php elseif(in_array($booking['status'], BookingStatus::getConfirmedBooking())): ?>
                                    <strong style="color: #139b65">
                                        <?php echo e(__(BookingStatus::getValue($booking['status']))); ?>

                                     </strong>
                                <?php else: ?>
                                    <strong style="color: orangered">
                                        <?php echo e(__(BookingStatus::getValue($booking['status']))); ?>

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
                              <?php echo e(__('Lý do hủy')); ?>:
                                 <?php echo e($booking['refuse_reason']); ?>

                           </span>
                            </label>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12">
                        <div class="row justify-content-around">
                            <?php if(in_array($booking['status'], BookingStatus::getAwaitingBooking())): ?>
                                <button id="cancel-booking" class="col-md-5 btn btn-outline-danger" value="<?php echo e($booking['id']); ?>">
                                    <i class="fa-solid fa-ban"></i>
                                    <?php echo e(__('Hủy đơn')); ?>

                                </button>
                            <?php endif; ?>

                            <?php if($booking['status'] == BookingStatus::AwaitingPayment['key']): ?>
                                <a class="col-md-5 btn btn-outline-warning" href="<?php echo e(route('booking.payment-request', base64_encode($booking['id']))); ?>">
                                    <i class="fa-solid fa-wallet"></i>
                                    <?php echo e(__('Thanh toán ngay')); ?>

                                </a>
                            <?php endif; ?>

                            <?php if($booking['status'] == BookingStatus::Completed['key']): ?>
                                <a href="" class="col-md-5 btn btn-outline-success">
                                    <i class="fa-solid fa-star"></i>
                                    <?php echo e(__('Đánh giá')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

    <script>
        $(document).ready(function() {
            $('#cancel-booking').click(function() {
                const id = $(this).val();
                const url = '<?php echo e(route("booking.cancel", ':id')); ?>'.replace(':id', id);
                Swal.fire({
                    title: 'Bạn chắc chắn muốn hủy?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hủy đơn',
                    cancelButtonText: 'Tiếp tục đặt phòng'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: response['title'],
                                    text: response['message'],
                                    icon: response['status']
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page
                                        location.reload();
                                    }
                                })
                            },
                            error: function (response) {
                                Swal.fire({
                                    title: response['title'],
                                    text: response['message'],
                                    icon: response['status']
                                })
                            }
                        });
                    }
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/bookings/detail.blade.php ENDPATH**/ ?>