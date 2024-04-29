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
            <div class="py-1">
                <div class="row align-items-center">
                    <!-- .Logo -->
                    <div class="col-3">
                        <h2 class="mb-0 site-logo"><a href="{{ route('homepage') }}">{{ env('APP_NAME') }}</a></h2>
                    </div>
                    <!-- .Navigate bar -->
                    <div class="col-9">
                        <nav class="site-navigation text-right" role="navigation">
                            <div class="container">
                                <div class="d-inline-block d-lg-none  ml-md-0 mr-auto py-3">
                                    <a href="#" class="site-menu-toggle js-menu-toggle">
                                        <span class="icon-menu h3"></span>
                                    </a>
                                </div>
                                <ul class="site-menu js-clone-nav d-none d-lg-block">
                                    <li class="active">
                                        <a href="{{ route('homepage') }}">Trang chủ</a>
                                    </li>

                                    <li class="has-children">
                                        <a href="#">Phòng</a>
                                        <ul class="dropdown arrow-top">
                                            <li><a href="#">Hiện có</a></li>
                                            <li><a href="#">Phòng đơn</a></li>
                                            <li><a href="#">Phòng đôi</a></li>
                                            <li><a href="#">Phòng gia đình</a></li>
                                            <li class="has-children">
                                                <a href="#">Dịch vụ</a>
                                                <ul class="dropdown">
                                                    <li><a href="#">Phòng cao cấp</a></li>
                                                    <li><a href="#">Tắm hơi</a></li>
                                                    lo
                                                    <li><a href="#">Ăn uống</a></li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('introduce') }}">Giới thiệu</a></li>

                                    <li><a href="{{ route('contact') }}">Liên hệ</a></li>
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
