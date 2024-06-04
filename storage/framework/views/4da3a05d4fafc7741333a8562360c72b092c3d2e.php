<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>
<!-- .site-mobile-menu -->

<div class="<?php echo e(request()->is('booking-confirm') ? 'sticky-top bg-light' : 'site-navbar-wrap js-site-navbar bg-white'); ?>">

    <div class="container">
        <div class="site-navbar bg-light">
            <div class="col-md-12 py-1">
                <div class="d-flex align-items-center">
                    <!-- .Logo -->
                    <div class="col-md-3">
                        <img src="<?php echo e(asset('images/logo.png')); ?>">
                    </div>
                    <!-- .Navigate bar -->
                    <div class="col-md-9">
                        <nav class="site-navigation text-right" role="navigation">
                            <div class="container">
                                <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3">
                                    <a href="#" class="site-menu-toggle js-menu-toggle">
                                        <span class="icon-menu h3"></span>
                                    </a>
                                </div>
                                <ul class="site-menu js-clone-nav d-none d-lg-block">
                                    <li class="<?php echo e(request()->is('/') ? 'active' : ''); ?>">
                                        <a href="<?php echo e(route('homepage')); ?>">Trang chủ</a>
                                    </li>

                                    <li class="has-children">
                                        <a href="#">Danh mục</a>
                                        <ul class="dropdown arrow-top">
                                            <li class="has-children">
                                                <a href="#">Loại phòng</a>
                                                <ul class="dropdown">
                                                    <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a href="<?php echo e(route('room-type', ['roomType' => base64_encode($room_type['id'])])); ?>" class="text-uppercase"><?php echo e($room_type['name']); ?></a></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#">Dịch vụ</a>
                                                <ul class="dropdown">
                                                    <?php $__currentLoopData = $service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class= "<?php echo e(empty( $service_type['services']) ? '' : 'has-children'); ?>">
                                                            <a href="#">
                                                                <i class="<?php echo e($service_type['icon']); ?>"></i>
                                                                <span><?php echo e($service_type['name']); ?></span>
                                                            </a>
                                                            <ul class="dropdown">
                                                                <?php $__currentLoopData = $service_type['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li><a href="#" class="text-capitalize"><?php echo e($service['name']); ?></a></li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="<?php echo e(request()->is('introduce') ? 'active' : ''); ?>"><a href="<?php echo e(route('introduce')); ?>">Giới thiệu</a></li>

                                    <li class="<?php echo e(request()->is('contact') ? 'active' : ''); ?>"><a href="<?php echo e(route('contact')); ?>">Liên hệ</a></li>
                                    <li class="has-children ">
                                        <a class="pr-4" href="#">Tài khoản</a>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <ul class="dropdown arrow-top">
                                                <li><a href="<?php echo e(route('signup')); ?>">Đăng ký</a></li>
                                                <li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
                                            </ul>
                                        <?php endif; ?>
                                        <?php if(auth()->guard()->check()): ?>
                                            <ul class="dropdown arrow-top">
                                                <li class="text-secondary text-uppercase text-center border-bottom pb-2">
                                                    <?php echo e(auth()->user()?->customer->name ?? auth()->user()->phone); ?>

                                                </li>
                                                <li><a href="<?php echo e(route('get-user-info')); ?>">Thông tin cá nhân</a></li>
                                                <li><a href="<?php echo e(route('change_password')); ?>">Đổi mật khẩu</a></li>
                                                <li><a href="<?php echo e(route('logout')); ?>">Đăng xuất</a></li>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/components/navbar.blade.php ENDPATH**/ ?>