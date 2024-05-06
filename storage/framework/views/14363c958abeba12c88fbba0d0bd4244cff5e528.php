<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('dist/img/AdminLTELogo.png')); ?>" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Kinkou Management</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="text-center mt-3">
            <p class="text-secondary text-capitalize"><?php echo e(auth()->guard('admins')->user()->name); ?></p>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-user-tie"></i>
                        <p>
                            Quản lý khách hàng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách khách hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.customers.create')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm khách hàng mới</p>
                            </a>
                        </li>
                    </ul>

                
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-user-large"></i>
                        <p>
                            Quản lý tài khoản
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.users.index')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tài khoản người dùng</p>
                            </a>
                        </li>
                        <?php if(Auth::guard('admins')->user()->role == \App\Enums\RoleAccount::Admin ): ?>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.staffs.index')); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tài khoản nhân viên</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>

                
                <?php if(Auth::guard('admins')->user()->role == \App\Enums\RoleAccount::Admin ): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-bell-concierge"></i>
                        <p>
                            Quản lý dịch vụ
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.services.index')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dịch vụ cung cấp</p>
                            </a>
                        </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.services.create')); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm dịch vụ mới</p>
                                </a>
                            </li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-house-laptop"></i>
                        <p>
                            Quản lý thiết bị
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.devices.index')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách thiết bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.devices.create')); ?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm thiết bị mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH E:\DATN\VVCBooking\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>