<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="row">
                <h1 class="text-center text-uppercase">
                    Đánh giá chuyến đi
                </h1>

                <div class="col-md-10 col-12 my-4 mx-auto">
                    <div class="row">
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
                                                <a class="btn btn-outline-success text-light"
                                                   href="<?php echo e(route('booking.show', base64_encode($booking['id']))); ?>">
                                                    <i class="fa-solid fa-eye"></i>
                                                    Chi tiết đơn hàng
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 pb-3" style="background-color: #f1e6b2">
                                    <?php $__currentLoopData = $feedBacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedBack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-12 p-2 mt-3">
                                            <div class="row">
                                                <div class="col-md-12 text-center section-heading">
                                                    <h2 class="mb-3 text-uppercase">Phòng
                                                        <span
                                                            class="ms-5 m-md-0"><?php echo e($feedBack['roomType']['name']); ?></span>
                                                    </h2>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <?php $__currentLoopData = $feedBack['roomType']['roomImages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($key == 0): ?>
                                                            <img href="<?php echo e($image['path']); ?>" src="<?php echo e($image['path']); ?>"
                                                                 alt="Ảnh phòng"
                                                                 class="img-fluid image-popup img-opacity w-75"
                                                                 loading="lazy">
                                                        <?php else: ?>
                                                            <img href="<?php echo e($image['path']); ?>" src="<?php echo e($image['path']); ?>"
                                                                 alt="Ảnh chi tiết"
                                                                 class="img-fluid detail-img-absolute image-popup img-opacity"
                                                                 loading="lazy">
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <div class="col-md-8 pl-5">
                                                    <div class="d-flex align-items-center">
                                                        <?php for($i=1; $i<=5; $i++): ?>
                                                            <span
                                                                class="star <?php echo e($feedBack['rate_stars'] >= $i ? 'hovered' : ''); ?>">★</span>
                                                        <?php endfor; ?>
                                                        <span class="ml-2"> <?php echo e($feedBack['rate_stars']); ?> / 5 </span>
                                                        <span class="mr-0 ml-auto"><?php echo e($feedBack['created_at']); ?></span>
                                                    </div>
                                                    <textarea class="form-control" disabled maxlength="255" cols="1"
                                                              rows="3"><?php echo e($feedBack['comment']); ?>

                                                    </textarea>
                                                    <?php if($feedBack['reply']): ?>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="text-capitalize my-1">
                                                                <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                                                                <?php echo e($feedBack->admin->name); ?> đã phản hồi
                                                                lúc <?php echo e($feedBack['reply_at']); ?>

                                                            </p>
                                                            <span class="text-danger"
                                                                  id="error-<?php echo e($feedBack['id']); ?>"></span>
                                                        </div>
                                                        <div
                                                            class="form-control w-75 ml-auto mr-0"><?php echo e($feedBack['reply']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/feedbacks/show.blade.php ENDPATH**/ ?>