<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Navbar Search -->
    <?php if(!!strpos(request()->route()->action['as'], '.index')): ?>
        <form>
            <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Tìm kiếm" name="search"
                       aria-label="Search" value="<?php echo e(request()->get('search')); ?>">
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    <?php endif; ?>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-danger" data-widget="fullscreen" href="<?php echo e(route('admin.logout')); ?>" role="button">
                <i class="fa-solid fa-power-off"></i>
                Đăng xuất
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
<?php /**PATH E:\DATN\VVCBooking\resources\views/admin/layouts/navbar.blade.php ENDPATH**/ ?>