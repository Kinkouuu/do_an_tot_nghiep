<?php
use App\Enums\User\UserGender;
use Illuminate\Support\Carbon;
?>
<div class="col-md-11 mx-auto mt-4 py-3" style="background-color: #f1e6b2">
    <div class="row">
        <div class="col-md-3 text-center m-auto">
            <img class="rounded w-100" src="<?php echo e($roomBranch['branch']['avatar']); ?>">
        </div>
        <div class="col-md-9 d-flex justify-content-around">
            <div class="col-md-5">
                <h5>Tận hưởng chuyến đi của bạn tại: <br>
                    <span class="text-danger text-bold"><?php echo e($roomBranch['branch']['name'] . ' - ' . $roomBranch['branch']['city']); ?></span>
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
                        <a href="<?php echo e(route('room-type', base64_encode($room['room_type_id']))); ?>" data-toggle="tooltip"
                           data-placement="right" title="Xem chi tiết phòng">
                            x <?php echo e(count($room['room_ids'])); ?>

                            <strong class="text-capitalize text-black"> Phòng <?php echo e($room['room_type']); ?></strong>
                            <i class="text-secondary fa-solid fa-circle-info"></i>
                        </a>
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
                                    <br>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-12 d-flex justify-content-between border-top border-secondary px-0 pt-2">
                        <h4 class="text-success">Tổng chi
                            phí: <?php echo e(number_format($roomBranch['total_amount']['total_price'], 0, ',', '.')); ?> VND</h4>

                        <!-- Button trigger modal -->
                        <?php if($user): ?>
                            <button class="btn btn-warning text-light" wire:click="bookingConfirm(<?php echo e($user['id']); ?>)">
                                Đặt phòng ngay
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-warning text-light"
                                    data-toggle="modal" data-target="#needLogin">
                                Đặt phòng ngay
                            </button>
                        <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>

        <!-- Login Modal -->
        <div wire:ignore.self class="modal fade" id="needLogin" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-auto" id="needLogin">Bạn cần đăng nhập để đặt phòng</h5>
                    </div>
                    <div class="modal-body text-center pt-3">
                        <div>
                            <?php $__errorArgs = ['account'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-12 input-group mb-3">
                            <div class="input-group-prepend col-md-5 p-0">
                                <span class="input-group-text w-100">Số điện thoại</span>
                            </div>
                            <input type="text" class="form-control col-md-7" wire:model.blur="account" placeholder="Số điện thoại đăng nhập"/>
                        </div>
                        <div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-12 input-group mb-3">
                            <div class="input-group-prepend col-md-5 p-0">
                                <span class="input-group-text w-100">Mật khẩu</span>
                            </div>
                            <input type="password" class="form-control col-md-7" wire:model.blur="password" placeholder="Mật khẩu đăng nhập"/>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary text-black" data-dismiss="modal" wire:click="resetInput">Để sau</button>
                        <button type="button" class="btn btn-info text-white" wire:click="login">Đăng nhập</button>
                    </div>
                </div>
            </div>
        </div>
</div>

<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/room/booking-form.blade.php ENDPATH**/ ?>