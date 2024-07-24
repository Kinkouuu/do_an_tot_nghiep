<?php
    use App\Enums\Room\PriceType;
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 mb-3 text-white"
                 style="background-image: url(<?php echo e(asset($branch['avatar'])); ?>); background-repeat: no-repeat; background-size: cover">
                <h3 class="text-light"
                    style="font-size: xxx-large; font-style: oblique"><?php echo e($branch['name']); ?></h3>
                <p><i class="fa-solid fa-phone-volume"></i>
                    <strong>Gọi cho chúng tôi để được tư vấn:</strong>
                    <?php echo e($branch['phone']); ?>

                </p>
                <p><i class="fa-solid fa-map-location-dot"></i>
                    <strong>Địa chỉ:</strong>
                    <?php echo e($branch['address']); ?>, <?php echo e($branch['city']); ?>

                </p>
            </div>
        </div>
    </div>
    <div class="col-12 m-auto p-4" style="background-color: #f1e6b2">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 p-2">
                            <div class="section-heading text-left">
                                <h2 class="mb-5 text-uppercase">Phòng
                                    <span class="ms-5 m-md-0"><?php echo e($room['room_type']); ?></span>
                                </h2>
                            </div>
                            <img href="<?php echo e($room['thumb_nail']); ?>" src="<?php echo e($room['thumb_nail']); ?>"
                                 alt="Ảnh phòng"
                                 class="img-fluid image-popup img-opacity w-75" loading="lazy">
                            <?php $__currentLoopData = $room['detail_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detailImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img href="<?php echo e($detailImage); ?>" src="<?php echo e($detailImage); ?>" alt="Ảnh chi tiết"
                                     class="img-fluid detail-img-absolute image-popup img-opacity"
                                     loading="lazy" style="bottom: 30px">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                        <div class="col-md-9 border-bottom border-warning mt-4" style="min-height: 40vh">

                            <div class="col-12 mb-4">
                                <div class="row">
                                    <div class="col-md-4">
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
                                    </div>

                                    <div class="col-md-5">
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

                                    <div class="col-md-3">
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
                                        <h5><i class="fa-solid fa-people-roof"></i> Sức chứa tối đa</h5>
                                        <ul>
                                            <li>Người lớn: <?php echo e($room['adult_capacity']); ?></li>
                                            <li>Trẻ em: <?php echo e($room['children_capacity']); ?></li>
                                        </ul>

                                        <div class="quantity mx-auto">
                                            <button class="minus" aria-label="Decrease" wire:click.prevent="decrease(<?php echo e($index); ?>)">&minus;</button>
                                            <input type="number" class="input-box" value="<?php echo e($room['quantity'] ?? 0); ?>"
                                                   min="0" max="<?php echo e(count($room['room_ids'])); ?>">
                                            <button class="plus" aria-label="Increase"  wire:click.prevent="increase(<?php echo e($index); ?>)">&plus;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-md-9 mr-0 ml-auto mt-3">
               <div class="row">
                   <div class="col-md-7">
                       <h3>Số lượng:
                       <span class="text-<?php echo e($isValidQuantity ? 'success' : 'danger'); ?>"> <?php echo e($totalRoomSelected); ?> phòng </span>
                       </h3>
                       <h3>Sức chứa tối đa:
                           <span class="text-<?php echo e($isValidQuantity ? 'success' : 'danger'); ?>"><?php echo e($adultsCapacity); ?> người lớn và <?php echo e($childrenCapacity); ?> trẻ em</span>
                       </h3>
                   </div>
                   <div class="col-md-5 text-end">
                       <h3>Tổng chi phí:
                           <span class="text-info"> <?php echo e(number_format($totalPrice, 0 , ',', '.')); ?> VND</span>
                       </h3>
                       <button class="btn btn-warning text-white"  wire:click.prevent="bookingConfirm()"
                           <?php echo e($isValidQuantity ? '' : 'disabled'); ?>>
                           Đặt phòng ngay
                       </button>
                   </div>
               </div>

            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/option-form.blade.php ENDPATH**/ ?>