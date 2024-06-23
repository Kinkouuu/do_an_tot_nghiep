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
                                                    <a class="btn btn-outline-success text-light" href="<?php echo e(route('booking.show', base64_encode($booking['id']))); ?>">
                                                        <i class="fa-solid fa-eye"></i>
                                                        Chi tiết đơn hàng
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="col-md-12 pt-3" style="background-color: #f1e6b2" method="POST"
                                          action="<?php echo e(route('feedback.store', base64_encode($booking['id']))); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="row align-items-center">
                                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                        <div class="d-flex align-items-center">
                                                            <?php for($i=1; $i<=5; $i++): ?>
                                                                <span onclick="rate(<?php echo e($i); ?>, <?php echo e($key); ?>)" class="star <?php echo e($key); ?>" >★</span>
                                                            <?php endfor; ?>
                                                            <span id="rating-<?php echo e($key); ?>">
                                                               0/5
                                                            </span>
                                                            <span class="ml-2" id="text-<?php echo e($key); ?>"></span>
                                                            <?php $__errorArgs = ['feedback.' . $room['room_type_id']  . '.point'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger"><?php echo e($message); ?></span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                        <input type="number" hidden name="feedback[<?php echo e($room['room_type_id']); ?>][point]" id="point-<?php echo e($key); ?>">
                                                        <?php $__errorArgs = ['feedback.' . $room['room_type_id']  . '.comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        <textarea name="feedback[<?php echo e($room['room_type_id']); ?>][comment]" class="form-control"
                                                                  maxlength="255" cols="1" rows="5" placeholder="Chia sẻ trải nghiêm của bạn...">
                                                        </textarea>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <div class="mx-auto text-center mb-3">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fa-regular fa-comment"></i>
                                                    Đánh giá
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
            // Cập nhật rating
            function rate(n, id) {
                let stars = document.getElementsByClassName("star " + id);
                let rating = document.getElementById("rating-" + id);
                let text = document.getElementById("text-" + id);
                removeRate(stars, id);
                for (let i = 0; i < n; i++) {
                    stars[i].classList.add("hovered");
                }
                rating.innerText = n + "/5";
                document.getElementById('point-' + id).value = n;
                text.innerText = getRateText(n);
            }

            // Xóa rating
            function removeRate(stars, id) {
                let i = 0;
                while (i < 5) {
                    stars[i].className = "star " + id;
                    i++;
                }
            }
            // Hiển thị mức đánh giá
            function getRateText(n)
            {
                if(n === 1) return 'Tệ';
                if(n === 2) return 'Khá thất vọng';
                if(n === 3) return 'Khá ổn';
                if(n === 4) return 'Tốt';
                if(n === 5) return 'Tuyệt vời';
            }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/feedbacks/create.blade.php ENDPATH**/ ?>