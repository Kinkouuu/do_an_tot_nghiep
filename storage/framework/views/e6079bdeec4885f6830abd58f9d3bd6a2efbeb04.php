<?php echo $__env->make('user.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="site-wrap">

    <?php echo $__env->make('user.layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('user.layouts.slide', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <footer class="site-footer">
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
                    <?php if (isset($component)) { $__componentOriginal649e5376371f10adb70769650f0a59d5e696dc6a = $component; } ?>
<?php $component = App\View\Components\Branches::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('branches'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Branches::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal649e5376371f10adb70769650f0a59d5e696dc6a)): ?>
<?php $component = $__componentOriginal649e5376371f10adb70769650f0a59d5e696dc6a; ?>
<?php unset($__componentOriginal649e5376371f10adb70769650f0a59d5e696dc6a); ?>
<?php endif; ?>
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
</div>
<?php echo $__env->make('user.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/layouts/main.blade.php ENDPATH**/ ?>