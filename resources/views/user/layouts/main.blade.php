@include('user.layouts.header')

<div class="site-wrap">

    @include('user.layouts.navbar')

    @include('user.layouts.slide')

    @yield('content')

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="footer-heading mb-4 text-white">Giới thiệu</h3>
                    <p>Định hướng phát triển trở thành công ty về du lịch nghỉ dưỡng có quy mô lớn nhất Đông Nam Á với
                        hệ thống sinh thái thách thức các quy ước, vượt qua giới hạn và nâng tầm mọi tiêu chuẩn.</p>
                    <p><a href="{{ asset(route('introduce')) }}" class="btn btn-primary pill text-white px-4">Đọc
                            thêm</a></p>
                </div>
                <div class="col-md-6">
                    <x-branches></x-branches>
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
                        <a href="{{ asset(route('contact')) }}" class="btn btn-primary pill text-white px-4">Gửi góp ý</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div>
@include('user.layouts.footer')
