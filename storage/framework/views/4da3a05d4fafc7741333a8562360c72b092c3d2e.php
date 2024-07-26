<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>
<!-- .site-mobile-menu -->

<div
    class="<?php echo e(request()->routeIs(config('constants.route_not_include_carousel')) ? 'sticky-top bg-light' : 'site-navbar-wrap js-site-navbar bg-white'); ?>">

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
                                        <a href="<?php echo e(route('homepage')); ?>"><?php echo e(__('Trang chủ')); ?></a>
                                    </li>

                                    <li class="has-children">
                                        <a href="#"><?php echo e(__('Danh mục')); ?></a>
                                        <ul class="dropdown arrow-top">
                                            <li class="has-children">
                                                <a href="#"><?php echo e(__('Loại phòng')); ?></a>
                                                <ul class="dropdown">
                                                    <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>
                                                            <a href="<?php echo e(route('room-type', ['roomType' => base64_encode($room_type['id'])])); ?>"
                                                               class="text-uppercase"><?php echo e($room_type['name']); ?></a></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#"><?php echo e(__('Dịch vụ')); ?></a>
                                                <ul class="dropdown">
                                                    <?php $__currentLoopData = $service_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="<?php echo e(empty( $service_type['services']) ? '' : 'has-children'); ?>">
                                                            <a href="#">
                                                                <i class="<?php echo e($service_type['icon']); ?>"></i>
                                                                <span><?php echo e($service_type['name']); ?></span>
                                                            </a>
                                                            <ul class="dropdown">
                                                                <?php $__currentLoopData = $service_type['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li>
                                                                        <a href="#" class="text-capitalize">
                                                                            <?php echo e($service['name']); ?>

                                                                        </a>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="<?php echo e(request()->is('introduce') ? 'active' : ''); ?>"><a
                                            href="<?php echo e(route('introduce')); ?>"><?php echo e(__('Giới thiệu')); ?></a></li>

                                    <li class="<?php echo e(request()->is('contact') ? 'active' : ''); ?>"><a
                                            href="<?php echo e(route('contact')); ?>"><?php echo e(__('Liên hệ')); ?></a></li>
                                    <li class="has-children">
                                        <a class="pr-4" href="#"><?php echo e(__('Tài khoản')); ?></a>
                                        <ul class="dropdown arrow-top" style="width: max-content">
                                            <?php if(auth()->guard()->guest()): ?>
                                                <li><a href="<?php echo e(route('signup')); ?>"> <?php echo e(__('Đăng ký')); ?></a></li>
                                                <li><a href="<?php echo e(route('login')); ?>"> <?php echo e(__('Đăng nhập')); ?></a></li>
                                            <?php endif; ?>
                                            <?php if(auth()->guard()->check()): ?>
                                                <li class="text-secondary text-uppercase text-center border-bottom pb-2">
                                                    <?php echo e(auth()->user()?->customer->name ?? auth()->user()->phone); ?>

                                                </li>
                                                <li><a href="<?php echo e(route('get-user-info')); ?>"><i
                                                            class="fa-solid fa-user-gear"></i> <?php echo e(__('Thông tin cá nhân')); ?></a>
                                                </li>
                                                <li><a href="<?php echo e(route('change_password')); ?>"><i
                                                            class="fa-solid fa-key"></i> <?php echo e(__('Đổi mật khẩu')); ?></a></li>
                                                <li><a href="<?php echo e(route('booking.list')); ?>"><i
                                                            class="fa-solid fa-clipboard-list"></i> <?php echo e(__('Đơn đã đặt')); ?></a></li>
                                                <li><a href="<?php echo e(route('logout')); ?>"><i
                                                            class="fa-solid fa-power-off"></i> <?php echo e(__('Đăng xuất')); ?></a></li>
                                            <?php endif; ?>
                                            <li class="has-children">
                                                <a href="#"><i class="fa-solid fa-globe"></i> <?php echo e(__('Ngôn ngữ')); ?></a>
                                                <ul class="dropdown">
                                                    <li>
                                                        <a href="<?php echo e(route('language',['vi'])); ?>" class="text-capitalize">
                                                            <img src="<?php echo e(asset('images/vn_flag.png')); ?>" class="flag-icon">
                                                            Tiếng Việt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo e(route('language',['en'])); ?>" class="text-capitalize">
                                                            <img src="<?php echo e(asset('images/en_flag.png')); ?>" class="flag-icon">
                                                            English
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
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