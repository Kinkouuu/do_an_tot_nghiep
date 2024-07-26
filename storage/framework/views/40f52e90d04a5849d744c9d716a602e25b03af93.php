<?php
    use App\Enums\Room\PriceType;
?>



<?php $__env->startSection('content'); ?>
    <div class="site-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2 class="mb-5"><?php echo e(__('Danh sách phòng')); ?></h2>
                </div>
            </div>
            <div class="row">
                <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="hotel-room text-center">
                            <a href="<?php echo e(route('room-type', base64_encode($room_type['id']))); ?>"  class="d-block mb-0 thumbnail">
                                <img src="<?php echo e(asset($room_type['thumb_nail'])); ?>" alt="Image" class="img-fluid" loading="lazy">
                            </a>
                            <div class="hotel-room-body">
                                <h3 class="heading mb-0"><a href="#"><?php echo e($room_type['name']); ?></a></h3>
                                <strong class="price">
                                    <?php echo e(number_format($room_type['prices'][PriceType::ListedDayPrice['value']]['price'], 0, ',', '.')); ?>

                                    VND /
                                    <?php echo e($room_type['prices'][PriceType::ListedDayPrice['value']]['type']); ?>

                                </strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>


    <div class="site-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-5 mb-md-0">

                    <div class="img-border">
                        <a href="https://vimeo.com/28959265" class="popup-vimeo image-play">
                  <span class="icon-wrap">
                    <span class="icon icon-play"></span>
                  </span>
                            <img src="<?php echo e(asset('images/img_2.jpg')); ?>" alt="" class="img-fluid" loading="lazy">
                        </a>
                    </div>

                    <img src="<?php echo e(asset('images/img_1.jpg')); ?>" href="<?php echo e(asset('images/img_1.jpg')); ?>" alt="Image"
                         class="img-fluid image-absolute image-popup img-opacity" loading="lazy">

                </div>
                <div class="col-md-5 ml-auto">


                    <div class="section-heading text-left">
                        <h2 class="mb-5"><?php echo e(__('Thông tin')); ?></h2>
                    </div>
                    <p class="mb-4">Khách sạn Hoàng Hôn luôn mang vẻ đẹp hiện đại xen lẫn nét cổ kính. Đặt khách sạn sớm
                        nhất để hưởng trọn ưu đãi, hãy tận hưởng một kì nghỉ tuyệt vời cùng gia đình, bạn bè ...</p>
                    <p><a href="https://vimeo.com/28959265" class="popup-vimeo text-uppercase">Xem Video <span
                                class="icon-arrow-right small"></span></a></p>
                </div>
            </div>
        </div>
    </div>
    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                    <h2 class="mb-5"><?php echo e(__('Dịch vụ nổi bật')); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-heart-pulse display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Chăm sóc sức khỏe')); ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-utensils display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Gọi thức ăn nhanh')); ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-door-open display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Thoát hiểm an toàn')); ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-volleyball display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Sân thể thao')); ?></h2>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-cake-candles display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Tổ chức sự kiện')); ?></h2>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-baby-carriage display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Dịch vụ trông trẻ')); ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-plane-arrival display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Đưa đón sân bay')); ?></h2>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center p-4 item">
                        <i class="fa-solid fa-car display-3 mb-3 d-block text-primary"></i>
                        <h2 class="h5"><?php echo e(__('Thuê xe tự lái')); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-5 upcoming-events"
         style="background-image: url('<?php echo e(asset('images/hero_1.jpg')); ?>'); background-attachment: fixed;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="text-white">Ưu đãi hè</h2>
                    <h5 class="text-white">Tặng voucher 50% cho khách hàng đăng ký lần đầu.</h5>
                    <a href="<?php echo e(route('signup')); ?>" class="text-white btn btn-outline-warning rounded-0 text-uppercase">Đăng
                        ký ngay</a>
                </div>
                <div class="col-md-6">
                    <span class="caption">Chương trình kết thúc sau</span>
                    <div id="date-countdown"></div>
                </div>
            </div>

        </div>
    </div>

    <div class="site-section">
        <div class="row">
            <div class="col-md-6 mx-auto text-center mb-5 section-heading">
                <h2 class="mb-5"><?php echo e(__('Hè này đi đâu?')); ?></h2>
            </div>
        </div>
        <div class="col-md-10 m-auto">
            <div class="row">
                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 mx-auto p-3 border rounded"
                         style=" background-image: linear-gradient(to right, lightpink, lightcyan); height: 250px">
                        <a href="" class="position-relative">
                            <h3 class="branch-city text-bold text-uppercase"><?php echo e($branch->first()->city); ?></h3>
                            <img src="<?php echo e(asset($branch->first()->avatar)); ?>" alt="Image" class="img-fluid w-100 h-100" loading="lazy">
                            <div class="branch-count"><?php echo e(count($branch)); ?> <?php echo e(__('chi nhánh')); ?>

                                <i class="fa-solid fa-circle-chevron-right"></i>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/home.blade.php ENDPATH**/ ?>