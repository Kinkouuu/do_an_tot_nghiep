<?php
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
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
                                <div class="col-md-9">
                                    <p><i class="fa-solid fa-phone-volume"></i>
                                        <strong>Gọi cho chúng tôi để được tư vấn:</strong>
                                        <?php echo e($branch['phone']); ?>

                                    </p>
                                    <p><i class="fa-solid fa-map-location-dot"></i>
                                        <strong>Địa chỉ:</strong>
                                        <?php echo e($branch['address']); ?>, <?php echo e($branch['city']); ?>

                                    </p>
                                </div>
                                <div class="col-md-3 row text-right">
                                    <a class="text-danger">
                                        <i class="btn fa-regular fa-heart fa-xl" style="color: #ff0000;"></i> Yêu thích
                                    </a>
                                    <a class="" style="color: #0c84ff">
                                        <i class="btn fa-solid fa-share-nodes fa-xl" style="color: #0c84ff"></i> Chia sẻ
                                    </a>
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
                                                    <h5><i class="fa-solid fa-people-roof"></i> Sức chứa tối đa</h5>
                                                    <ul>
                                                        <li>Người lớn: <?php echo e($room['adult_capacity']); ?></li>
                                                        <li>Trẻ em: <?php echo e($room['children_capacity']); ?></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 border-bottom border-warning pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        Bảng giá:
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
                            <div class="col-md-12 text-right">
                                <h4>Tổng số phòng:
                                    <span class="text-info"><?php echo e($total_amount['total_room']); ?></span>
                                    phòng
                                </h4>
                                <h4>Tổng tiền:
                                    <span
                                        class="text-success"><?php echo e(number_format($total_amount['total_price'], 0, ',', '.')); ?></span>
                                    VND
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="col-12 m-auto py-4 rounded text-white" style="background-color:#a6a6a6">
                    <h5 class="text-center text-light mb-3"> Thông tin chuyến đi</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Địa điểm: Khách sạn <?php echo e($branch['name']); ?> - <?php echo e($branch['city']); ?></span>
                        </label>
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
                <form class="col-md-12 mt-3 border rounded bg-light" method="POST" action="<?php echo e(route('booking.booking')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12 border-bottom p-3 px-0">
                            <h4 class="text-center text-capitalize">Thông tin người nhận phòng</h4>
                        </div>
                        <div class="col-md-12 m-auto py-2">
                            <div class="d-flex">
                                <p class="col-7 text-danger text-sm-left" style="font-size: 12px">
                                    *Nếu người nhận phòng không phải bạn, hãy chọn đặt cho người thân
                                </p>
                                <div class="col-5 form-check form-switch text-right">
                                    <input class="form-check-input" name="forRelative" type="checkbox" role="switch">
                                    <span>Đặt cho người thân</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Email</span>
                                    </div>
                                    <div class="form-control col-md-7">
                                        <p class="m-auto"><?php echo e($user->email); ?></p>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số điện thoại</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="phone"
                                           value="<?php echo e($user->phone); ?>">
                                </div>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Họ tên</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="name"
                                           value="<?php echo e($user->customer?->name ?? old('name')); ?>">
                                </div>
                                <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Quốc tịch</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="country"
                                           value="<?php echo e($user->customer?->country ?? old('country')); ?>">
                                </div>
                                <?php $__errorArgs = ['citizen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số CCCD</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="citizen_id"
                                           value="<?php echo e($user->customer?->citizen_id ?? old('citizen_id')); ?>">
                                </div>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Giới tính</span>
                                    </div>
                                    <select class="form-select" name="gender">
                                        <?php $__currentLoopData = UserGender::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option
                                                <?php echo e($user->customer?->gender == $gender ? 'selected' : ''); ?> value=<?php echo e($gender); ?>>
                                                <?php echo e($gender == UserGender::Male ? 'Nam' : 'Nữ'); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Thanh toán bằng</span>
                                    </div>
                                    <select class="form-control selectpicker" name="payment"
                                            data-style="bg-white border border-left-0">
                                        <?php $__currentLoopData = PaymentType::getPaymentType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option data-icon="<?php echo e($payment['icon']); ?>"
                                                    <?php echo e(old('payment') == $payment ? 'selected' : ''); ?> value=<?php echo e($payment['type']); ?>>
                                                <?php echo e($payment['name']); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="error"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Ghi chú</span>
                                    </div>
                                    <textarea name="note" cols="1" rows="3" class="form-control col-md-7">
                                        <?php echo e(old('note')); ?>

                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center border-top py-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" checked id="confirm-btn">
                                <label class="form-check-label text-left" for="confirm-btn" style="font-size: 12px">
                                    Tôi cam đoan thông tin trên trùng khớp với thông tin định danh trên thẻ CCCD/Visa
                                    của người đại diện nhận phòng.
                                </label>
                            </div>
                            <button type="submit" id="submit-btn" class="btn btn-success">Đặt phòng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        // Lấy phần tử checkbox và nút
        const confirmBtn = document.getElementById('confirm-btn');
        const submitBtn = document.getElementById('submit-btn');

        // Kiểm tra trạng thái của checkbox khi trang được tải
        if (confirmBtn.checked) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }

        // Lắng nghe sự kiện thay đổi trạng thái của checkbox
        confirmBtn.addEventListener('change', function () {
            if (this.checked) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/bookings/booking-confirm.blade.php ENDPATH**/ ?>