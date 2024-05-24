<form class="col-md-11 mx-auto mt-4 py-3" style="background-color: #f1e6b2" wire:submit.prevent="confirmBooking">
    <div class="row">
        <div class="col-md-3 text-center m-auto">
            <img class="rounded w-100" src="<?php echo e($roomBranch['branch']['avatar']); ?>">
        </div>
        <div class="col-md-9 d-flex justify-content-around">
            <div class="col-md-5">
                <h5>Tận hưởng chuyến đi của bạn tại: <span
                        class="text-primary"><?php echo e($roomBranch['branch']['name'] . ' - ' . $roomBranch['branch']['city']); ?></span>
                </h5>
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-arrow"></i>
                        <p class="m-0 px-2">Địa chỉ: </p>
                    </div>
                    <p class="text-info m-0"><?php echo e($roomBranch['branch']['address'] . ', ' . $roomBranch['branch']['city']); ?></p>
                </div>
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-phone"></i>
                        <p class="m-0 px-2">Hotline: </p>
                        <a href="tel:<?php echo e($roomBranch['branch']['phone']); ?>"
                           class="m-2 text-info"><?php echo e($roomBranch['branch']['phone']); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <?php $__currentLoopData = $roomBranch['rooms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-12 mb-3 p-0">
                        <p>
                            <strong class="text-capitalize text-black"> Phòng <?php echo e($room['room_type']); ?></strong>
                            x <?php echo e(count($room['room_ids'])); ?>

                        </p>
                        <div class="d-flex justify-content-around">
                            <div class="col-md-6 border-left border-warning p-0">
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
                            </div>

                            <div class="col-md-6 border-left border-warning">
                                <p class="text-black">Giá phòng:
                                    <span class="text-info">
                                        <?php echo e(number_format($room['total_price_1_room'], 0, ',', '.')); ?> VND
                                    </span>
                                    <span class="text-secondary">x <?php echo e(count($room['room_ids'])); ?></span>
                                    <span class="text-danger" style="font-size: 12px">*Đây là giá của mỗi phòng được tính cho
                                        <?php echo e($time < 24 ? ceil($time) . ' giờ' : ceil($time/24) . ' ngày/đêm'); ?>

                                    </span>
                                </p>
                                <p class="text-black">Sức chứa tối đa mỗi phòng: <br>
                                    <span class="text-secondary">
                                        <?php echo e($room['adult_capacity']); ?> người lớn và <?php echo e($room['children_capacity']); ?> trẻ em
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-between border-top border-secondary px-0 pt-2">
                        <h4 class="text-success">Tổng chi
                            phí: <?php echo e(number_format($roomBranch['total_price'], 0, ',', '.')); ?> VND</h4>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning text-light" data-toggle="modal" data-target="#staticBackdrop">
                           Đặt phòng ngay
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Điền thông tin cá nhân</h5>
                                        <?php if($user): ?>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        <?php else: ?>
                                            <a href="<?php echo e(route('login')); ?>"> Đăng nhập</a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-success">Đặt phòng</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</form>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/booking-form.blade.php ENDPATH**/ ?>