<?php $__env->startSection('content'); ?>
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 p-1">
                        <img href="<?php echo e($room_type['images']['thumb_nail']); ?>"
                             src="<?php echo e($room_type['images']['thumb_nail']); ?>" class="w-100 rounded image-popup">
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <?php $__currentLoopData = $room_type['images']['details_img']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3 p-1">
                                    <img href="<?php echo e($detail_img); ?>" src="<?php echo e($detail_img); ?>"
                                         class="w-100 rounded image-popup img-opacity">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="col-md-12 p-3" style="background-color: #d5ebdb">
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <h4 class="text-bold text-secondary">Các dịch vụ có sẵn:</h4>
                                <ul>
                                    <?php $__currentLoopData = $room_type['services']['provide']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                            <div class="col-md-12 m-auto">
                                <h5 class="text-bold text-secondary">và nhiều dịch vụ khác:</h5>
                                <?php $__currentLoopData = $room_type['services']['unProvide']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12">
                                        <p class="text-dark text-bold text-capitalize">
                                            <i class="<?php echo e($serviceType['icon']); ?>"></i>
                                            <strong class="text-capitalize"><?php echo e($serviceType['name']); ?></strong>
                                        </p>
                                        <ul>
                                            <?php $__currentLoopData = $serviceType['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <p>
                                                        <?php echo e($service['name']); ?>

                                                        <span class="text-info">
                                                            <?php echo e(number_format( $service['price'], 0 ,',', '.')); ?> VND/người
                                                        </span>
                                                    </p>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 m-3 m-md-0 p-5" style="background-color: #feeec5">
                    <div class="row">
                        <h1 class="text-uppercase px-3 text-bold" style="border-left: black solid 5px ">
                            Phòng <?php echo e($room_type['name']); ?> <span></span></h1>
                        <div class="col-md-12 m-auto text-dark">
                            <?php echo $room_type['description']; ?>

                        </div>

                        <div class="col-md-12">
                            <h3>Bảng giá:</h3>
                            <ul>
                                <?php $__currentLoopData = $room_type['prices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <?php echo e($price['name']); ?>:
                                        <strong class="text-danger"><?php echo e(number_format($price['price'], 0, ',', '.')); ?> VND/<?php echo e($price['type']); ?></strong>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <p>Có
                                <strong class="text-bold text-dark"><?php echo e($room_type['branches']->sum('count')); ?> phòng</strong>
                                 tại
                                <strong class="text-bold text-dark" style="text-decoration: underline"><?php echo e(count($room_type['branches'])); ?>  chi nhánh</strong>
                                trên toàn quốc
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/rooms/room-type-detail.blade.php ENDPATH**/ ?>