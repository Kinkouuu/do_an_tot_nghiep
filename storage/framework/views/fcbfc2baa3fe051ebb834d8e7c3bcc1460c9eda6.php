<?php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
    use App\Enums\Room\PriceType;
?>


<?php $__env->startSection('content'); ?>
    <h1 class="text-center p-3"><?php echo e($title); ?></h1>
    <div class="container-fluid pb-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <img class="rounded w-100" src="<?php echo e($branch['avatar']); ?>">
                        <h5 class="text-center text-danger font-italic font-weight-bold mt-2">
                            <?php echo e($branch['name'] . ' - ' . $branch['city']); ?>

                        </h5>
                        <?php if(isset($booking['bookingCreator']['name'])): ?>
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-headset"></i>
                                    <p class="m-0 px-2">Người tạo: </p>
                                    <p class="text-info text-capitalize m-2"><?php echo e($booking['bookingCreator']['name']); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-arrow"></i>
                                <p class="m-0 px-2">Địa chỉ: </p>
                                <p class="text-info m-2"><?php echo e($branch['address'] . ', ' . $branch['city']); ?></p>
                            </div>
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
                    <div class="col-md-12 pt-3" style="border: wheat ridge; border-radius: 5px">
                        <h5 class="text-center text-secondary mb-3 text-uppercase"> Danh sách phòng</h5>
                        <div class="row">
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-12 border-top border-warning">
                                    <div class="row">
                                        <div class="col-md-6 p-2 ">
                                            <img href="<?php echo e($room['thumb_nail']); ?>" src="<?php echo e($room['thumb_nail']); ?>"
                                                 alt="Ảnh phòng" class="img-fluid image-popup img-opacity w-100 rounded "
                                                 style="border: double #f1e6b2 4px;" loading="lazy">
                                        </div>
                                        <div class="col-md-6 m-auto">
                                            <div class="section-heading text-left">
                                                <h3 class="mb-1 text-uppercase">Phòng <span
                                                        class="ms-5 m-md-0"><?php echo e($room['room_type']); ?></span>
                                                    <span
                                                        class="text-lowercase text-secondary">x<?php echo e(count($room['room_ids'])); ?></span>
                                                </h3>
                                            </div>
                                            <ul class="p-0">
                                                <?php $__currentLoopData = $room['room_ids']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomId => $roomName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="p-0">
                                                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('booking.change-room', [
                                                     'roomId' => $roomId,
                                                     'booking' => $booking,
                                                     ])->html();
} elseif ($_instance->childHasBeenRendered('oPwhxob')) {
    $componentId = $_instance->getRenderedChildComponentId('oPwhxob');
    $componentTag = $_instance->getRenderedChildComponentTagName('oPwhxob');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('oPwhxob');
} else {
    $response = \Livewire\Livewire::mount('booking.change-room', [
                                                     'roomId' => $roomId,
                                                     'booking' => $booking,
                                                     ]);
    $html = $response->html();
    $_instance->logRenderedChild('oPwhxob', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                                    </li>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6">
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
                                                <div class="col-md-6 pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        Giá phòng:
                                                    </h5>
                                                    <ul class="text-dark">
                                                        <?php $__currentLoopData = $room['price_unit']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($key == PriceType::ListedHourPrice['value']): ?>
                                                                <li>
                                                                    <?php echo e(PriceType::ListedHourPrice['text'] . ': '); ?>

                                                                    <p class="text-danger">
                                                                        <?php echo e(number_format($price, 0, ',', '.')); ?>

                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            <?php elseif($key == PriceType::ListedDayPrice['value']): ?>
                                                                <li>
                                                                    <?php echo e(PriceType::ListedDayPrice['text'] .': '); ?>

                                                                    <p class="text-danger">
                                                                        <?php echo e(number_format($price, 0, ',', '.')); ?>

                                                                        VND/phòng/ngày
                                                                    </p>
                                                                </li>
                                                            <?php elseif($key == PriceType::First2Hours['value']): ?>
                                                                <li>
                                                                    <?php echo e(PriceType::First2Hours['text'] .': '); ?>

                                                                    <p class="text-danger">
                                                                        <?php echo e(number_format($price, 0, ',', '.')); ?>

                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            <?php elseif($key == PriceType::EarlyCheckIn['value']): ?>
                                                                <li>
                                                                    <?php echo e(PriceType::EarlyCheckIn['text'] .': '); ?>

                                                                    <p class="text-danger">
                                                                        <?php echo e(number_format($price, 0, ',', '.')); ?>

                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            <?php elseif($key == PriceType::LateCheckOut['value']): ?>
                                                                <li>
                                                                    <?php echo e(PriceType::LateCheckOut['text'] .': '); ?>

                                                                    <p class="text-danger">
                                                                        <?php echo e(number_format($price, 0, ',', '.')); ?>

                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>

                                                    <h5><i class="fa-solid fa-money-bill-wave"></i>
                                                        Thành tiền:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large">
                                                        <?php echo e(number_format(count($room['room_ids']) * $room['total_price_1_room'], 0, ',', '.')); ?>

                                                        VND / <?php echo e(count($room['room_ids'])); ?> phòng
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                              Phương thức thanh toán: <strong
                                        class="text-warning"><?php echo e(PaymentType::getValue($booking['payment_type'])); ?></strong>
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
                        <?php if($booking['note']): ?>
                            <div class="col-md-12 mb-2">
                                <label>
                                    <i class="fa-solid fa-file-contract"></i>
                                    Ghi chú: <br>
                                    <span class="text-secondary">
                                        <?php echo e($booking['note']); ?>

                                    </span>
                                </label>
                            </div>
                        <?php endif; ?>
                        <?php if($booking['refuse_reason']): ?>
                            <div class="col-md-12 mb-2">
                                <label>
                                    <i class="fa-solid fa-clipboard"></i>
                                    Lý do hủy:<br>
                                    <span class="text-danger">
                                        <?php echo e($booking['refuse_reason']); ?>

                                    </span>
                                </label>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <?php if(!in_array($booking['status'], array_merge(BookingStatus::getDeActiveBooking(), [BookingStatus::Completed['key']]))): ?>
                                    <div class="col-md-4 m-auto text-center">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuseModal">
                                            <i class="fa-solid fa-ban"></i>
                                            Từ chối
                                        </button>
                                        <form action="<?php echo e(route('admin.booking.refuse', $booking)); ?>" class="modal fade"
                                              id="refuseModal" tabindex="-1" role="dialog" aria-hidden="true"
                                              aria-labelledby="exampleModalLabel" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Từ chối đơn đặt</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Vui lòng nhập lý do hủy</h5>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason">
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" name="reason" placeholder="Lý do khác...">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách hàng muốn hủy">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách hàng muốn hủy</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách muốn thay đổi thời gian đặt">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách muốn thay đổi thời gian đặt</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách muốn thay đổi cách thanh toán">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách muốn thay đổi cách thanh toán</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách chưa hoàn tất thanh toán">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách chưa hoàn tất thanh toán</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Hết phòng">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Hết phòng</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php endif; ?>
                                <?php if($booking['status'] == BookingStatus::AwaitingConfirm['key']): ?>
                                    <div class="col-md-4 m-auto text-center">
                                        <a class="btn btn-primary">
                                            <i class="fa-regular fa-circle-check"></i>
                                            Xác nhận
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if(in_array($booking['status'], [BookingStatus::Confirmed['key'], BookingStatus::Approved['key']]) ): ?>
                                    <div class="col-md-8">
                                        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('booking.checkin-checkout', [
                                        'booking' => $booking
                                    ])->html();
} elseif ($_instance->childHasBeenRendered('blAFlvR')) {
    $componentId = $_instance->getRenderedChildComponentId('blAFlvR');
    $componentTag = $_instance->getRenderedChildComponentTagName('blAFlvR');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('blAFlvR');
} else {
    $response = \Livewire\Livewire::mount('booking.checkin-checkout', [
                                        'booking' => $booking
                                    ]);
    $html = $response->html();
    $_instance->logRenderedChild('blAFlvR', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                    </div>
                                <?php endif; ?>
                                    <?php if($booking['status'] == BookingStatus::Completed['key']): ?>
                                        <div class="col-md-4 m-auto text-center">
                                            <a class="btn btn-success text-white" href="<?php echo e(route('admin.booking.show', $booking)); ?>">
                                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                                Xem hóa đơn
                                            </a>
                                        </div>
                                        <div class="col-md-4 m-auto text-center">
                                            <a class="btn btn-warning text-white" href="<?php echo e(route('admin.feedback.feed-back', $booking)); ?>">
                                                <i class="fa-regular fa-star-half-stroke"></i>
                                                Xem đánh giá
                                            </a>
                                        </div>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/edit.blade.php ENDPATH**/ ?>