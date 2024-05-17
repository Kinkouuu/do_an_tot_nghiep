<footer class="site-footer mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3 class="footer-heading mb-4 text-white">Giới thiệu</h3>
                <p>Định hướng phát triển trở thành công ty về du lịch nghỉ dưỡng có quy mô lớn nhất Đông Nam Á với
                    hệ thống sinh thái thách thức các quy ước, vượt qua giới hạn và nâng tầm mọi tiêu chuẩn.</p>
                <p><a href="<?php echo e(asset(route('introduce'))); ?>" class="btn btn-primary pill text-white px-4">Đọc
                        thêm</a></p>
            </div>
            <div class="col-md-6">
                <h3 class="footer-heading mb-4 text-white">Chi nhánh</h3>
                <ul class="list-unstyled">
                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li> <?php echo e($branch->name); ?>:
                            <br><?php echo e($branch->address); ?> - <?php echo e($branch->city); ?>

                            <br>Hotline: <a href="tel:<?php echo e($branch->phone); ?>"><?php echo e($branch->phone); ?></a>
                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>

            <div class="col-md-3">
                <div class="col-md-12"><h3 class="footer-heading mb-4 text-white">Liên hệ với chúng tôi: </h3></div>
                <div class="col-md-12">
                    <p>
                        <a href="#" class="pb-2 pr-2 pl-0"><span class="icon-facebook"></span></a>
                        <a href="#" class="p-2"><span class="icon-twitter"></span></a>
                        <a href="#" class="p-2"><span class="icon-instagram"></span></a>
                        <a href="#" class="p-2"><span class="icon-vimeo"></span></a>
                    </p>
                </div>
                <div class="col-md-12">
                    <p>
                        <strong>Văn phòng đại diện:</strong>
                        Tầng 4, Grandeur Palace, 138B Giảng Võ, Ba Đình, Hà Nội
                    </p>
                    <p>
                        <strong>Hotline:</strong>
                        <a href="tel:+84397910001">+84 39 79 10001</a></p>
                    <p>
                        <strong>Email :</strong>
                        <a href="mailto:contact@vietnamvacationclub.vn">contact@vietnamvacationclub.vn</a>
                    </p>
                </div>
                <p class="mr-0 d-flex justify-content-center">
                    <a href="<?php echo e(asset(route('contact'))); ?>" class="btn btn-primary pill text-white px-4">Gửi góp ý</a>
                </p>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH E:\DATN\VVCBooking\resources\views/components/footer.blade.php ENDPATH**/ ?>