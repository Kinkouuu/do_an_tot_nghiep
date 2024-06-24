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

                    <div class="col-md-12 p-3" style="background-color: #d5ebdb;">
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

                <div class="col-md-6 m-3 m-md-0 p-5" style="background-color: #feeec5;">
                    <div class="row">
                        <div class="col-md-12 mb-3" style="border-left: black solid 5px ">
                            <div class="row">
                                <h1 class="text-uppercase px-3 text-bold">
                                    Phòng <?php echo e($room_type['name']); ?>

                                </h1>
                                <div class="d-flex align-items-center" style="color: orangered">
                                    <strong class="mx-2" style="font-size: xx-large"><?php echo e($feedBacks['avg']); ?></strong>
                                    <i class="fa-solid fa-star fa-2xl"></i>
                                    <strong class="mr-0 ml-auto"><?php echo e(array_sum($feedBacks['number'])); ?> lượt đánh
                                        giá</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 m-auto text-dark">
                            <?php echo $room_type['description']; ?>

                        </div>

                        <div class="col-md-12">
                            <h3>Bảng giá:</h3>
                            <ul>
                                <?php $__currentLoopData = $room_type['prices']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <?php echo e($price['name']); ?>:
                                        <strong class="text-danger"><?php echo e(number_format($price['price'], 0, ',', '.')); ?>

                                            VND/<?php echo e($price['type']); ?></strong>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <p>Có
                                <strong class="text-bold text-dark"><?php echo e($room_type['branches']->sum('count')); ?>

                                    phòng</strong>
                                tại
                                <strong class="text-bold text-dark"
                                        style="text-decoration: underline"><?php echo e(count($room_type['branches'])); ?> chi
                                    nhánh</strong>
                                trên toàn quốc
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-3 block-14" style="background-color: #d6d6d6">

                    <div class="container">

                        <div class="row">
                            <div class="col-md-6 mx-auto text-center mb-3 section-heading">
                                <h2>Phản hồi khách hàng</h2>
                            </div>
                        </div>

                        <div class="nonloop-block-14 owl-carousel">
                            <?php $__currentLoopData = $feedBacks['feed_backs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedBack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border p-3" style="height: 170px;">
                                    <h2 class="h5 m-0 text-capitalize">
                                        <?php echo e($feedBack->booking->user?->customer?->name  ?? $feedBack->booking->user->phone); ?>

                                    </h2>
                                    <div class="d-flex justify-content-around align-items-center">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <span
                                                class="star <?php echo e($feedBack['rate_stars'] >= $i ? 'hovered' : ''); ?> ">★</span>
                                        <?php endfor; ?>
                                        <span class="mr-0 ml-auto"><?php echo e($feedBack['created_at']); ?></span>
                                    </div>
                                    <blockquote class="text-dark">
                                        &ldquo;<?php echo e($feedBack->comment); ?>&rdquo;
                                    </blockquote>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>










<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/rooms/room-type-detail.blade.php ENDPATH**/ ?>