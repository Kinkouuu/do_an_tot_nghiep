<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Branch Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link bg-gradient-secondary text-center">
        <img src="{{ asset('images/logo.png') }}" alt="AdminLTE Logo"
              style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class=" brand-link">
            <img src="{{asset('dist/img/AdminLTELogo.png')}}"  class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light text-capitalize">{{ auth()->guard('admins')->user()->name }}</span>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                {{--CUSTOMER--}}
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
                            <a href="{{ route('admin.customers.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách khách hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.customers.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm khách hàng mới</p>
                            </a>
                        </li>
                    </ul>

                {{--ACCOUNT--}}
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
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tài khoản người dùng</p>
                            </a>
                        </li>
                        @isAdmin
                            <li class="nav-item">
                                <a href="{{ route('admin.staffs.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tài khoản nhân viên</p>
                                </a>
                            </li>
                        @endisAdmin
                    </ul>
                </li>

                {{--Services--}}
                @isAdmin
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
                            <a href="{{ route('admin.services.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dịch vụ cung cấp</p>
                            </a>
                        </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.services.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm dịch vụ mới</p>
                                </a>
                            </li>
                    </ul>
                </li>
                @endisAdmin
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
                            <a href="{{ route('admin.devices.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách thiết bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.devices.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm thiết bị mới</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fa-solid fa-hotel"></i>
                        <p>
                            Quản lý phòng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.room-type.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách loại phòng</p>
                            </a>
                        </li>
                        @isAdmin
                        <li class="nav-item">
                            <a href="{{ route('admin.room-type.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm loại phòng mới</p>
                            </a>
                        </li>
                        @endisAdmin
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
