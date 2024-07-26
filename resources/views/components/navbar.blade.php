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
    class="{{ request()->routeIs(config('constants.route_not_include_carousel')) ? 'sticky-top bg-light' : 'site-navbar-wrap js-site-navbar bg-white' }}">

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
                                        <a href="{{ route('homepage') }}">{{__('Trang chủ')}}</a>
                                    </li>

                                    <li class="has-children">
                                        <a href="#">{{__('Danh mục')}}</a>
                                        <ul class="dropdown arrow-top">
                                            <li class="has-children">
                                                <a href="#">{{__('Loại phòng')}}</a>
                                                <ul class="dropdown">
                                                    @foreach($room_types as $room_type)
                                                        <li>
                                                            <a href="{{ route('room-type', ['roomType' => base64_encode($room_type['id'])]) }}"
                                                               class="text-uppercase">{{ $room_type['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li class="has-children">
                                                <a href="#">{{__('Dịch vụ')}}</a>
                                                <ul class="dropdown">
                                                    @foreach($service_types as $service_type)
                                                        <li class="{{ empty( $service_type['services']) ? '' : 'has-children' }}">
                                                            <a href="#">
                                                                <i class="{{ $service_type['icon'] }}"></i>
                                                                <span>{{ $service_type['name'] }}</span>
                                                            </a>
                                                            <ul class="dropdown">
                                                                @foreach( $service_type['services'] as $service)
                                                                    <li>
                                                                        <a href="#" class="text-capitalize">
                                                                            {{ $service['name'] }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ request()->is('introduce') ? 'active' : '' }}"><a
                                            href="{{ route('introduce') }}">{{__('Giới thiệu')}}</a></li>

                                    <li class="{{ request()->is('contact') ? 'active' : '' }}"><a
                                            href="{{ route('contact') }}">{{__('Liên hệ')}}</a></li>
                                    <li class="has-children">
                                        <a class="pr-4" href="#">{{__('Tài khoản')}}</a>
                                        <ul class="dropdown arrow-top" style="width: max-content">
                                            @guest()
                                                <li><a href="{{ route('signup') }}"> {{__('Đăng ký')}}</a></li>
                                                <li><a href="{{ route('login') }}"> {{__('Đăng nhập')}}</a></li>
                                            @endguest
                                            @auth()
                                                <li class="text-secondary text-uppercase text-center border-bottom pb-2">
                                                    {{ auth()->user()?->customer->name ?? auth()->user()->phone }}
                                                </li>
                                                <li><a href="{{ route('get-user-info') }}"><i
                                                            class="fa-solid fa-user-gear"></i> {{__('Thông tin cá nhân')}}</a>
                                                </li>
                                                <li><a href="{{ route('change_password') }}"><i
                                                            class="fa-solid fa-key"></i> {{__('Đổi mật khẩu')}}</a></li>
                                                <li><a href="{{ route('booking.list') }}"><i
                                                            class="fa-solid fa-clipboard-list"></i> {{__('Đơn đã đặt')}}</a></li>
                                                <li><a href="{{ route('logout') }}"><i
                                                            class="fa-solid fa-power-off"></i> {{__('Đăng xuất')}}</a></li>
                                            @endauth
                                            <li class="has-children">
                                                <a href="#"><i class="fa-solid fa-globe"></i> {{__('Ngôn ngữ')}}</a>
                                                <ul class="dropdown">
                                                    <li>
                                                        <a href="{{ route('language',['vi']) }}" class="text-capitalize">
                                                            <img src="{{asset('images/vn_flag.png')}}" class="flag-icon">
                                                            Tiếng Việt
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('language',['en']) }}" class="text-capitalize">
                                                            <img src="{{asset('images/en_flag.png')}}" class="flag-icon">
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
