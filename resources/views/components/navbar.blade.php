<div class="site-mobile-menu">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>
<!-- .site-mobile-menu -->

<div class="site-navbar-wrap js-site-navbar bg-white">

    <div class="container">
        <div class="site-navbar bg-light">
            <div class="col-md-12 py-1">
                <div class="d-flex align-items-center">
                    <!-- .Logo -->
                    <div class="col-md-3">
                        <img src="{{ asset('images/logo.png') }}">
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
                                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                                        <a href="{{ route('homepage') }}">Trang chủ</a>
                                    </li>

                                    <li class="has-children">
                                        <a href="#">Danh mục</a>
                                        <ul class="dropdown arrow-top">
                                            <li class="has-children">
                                                <a href="#">Loại phòng</a>
                                                <ul class="dropdown">
                                                    @foreach($room_types as $room_type)
                                                        <li><a href="{{ route('room-type', ['roomType' => base64_encode($room_type['id'])]) }}" class="text-uppercase">{{ $room_type['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="has-children">a
                                                <a href="#">Dịch vụ</a>
                                                <ul class="dropdown">
                                                    @foreach($service_types as $service_type)
                                                        <li class= "{{ empty( $service_type['services']) ? '' : 'has-children' }}">
                                                            <a href="#">
                                                                <i class="{{ $service_type['icon'] }}"></i>
                                                                <span>{{ $service_type['name'] }}</span>
                                                            </a>
                                                            <ul class="dropdown">
                                                                @foreach( $service_type['services'] as $service)
                                                                    <li><a href="#" class="text-capitalize">{{ $service['name'] }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ request()->is('introduce') ? 'active' : '' }}"><a href="{{ route('introduce') }}">Giới thiệu</a></li>

                                    <li class="{{ request()->is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Liên hệ</a></li>
                                    <li class="has-children ">
                                        <a class="pr-4" href="#">Tài khoản</a>
                                        @guest()
                                            <ul class="dropdown arrow-top">
                                                <li><a href="{{ route('signup') }}">Đăng ký</a></li>
                                                <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                                            </ul>
                                        @endguest
                                        @auth()
                                            <ul class="dropdown arrow-top">
                                                <li class="text-secondary text-uppercase text-center border-bottom pb-2">
                                                    {{ auth()->user()?->customer->name ?? auth()->user()->phone }}
                                                </li>
                                                <li><a href="{{ route('get-user-info') }}">Thông tin cá nhân</a></li>
                                                <li><a href="{{ route('change_password') }}">Đổi mật khẩu</a></li>
                                                <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                                            </ul>
                                        @endauth
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
