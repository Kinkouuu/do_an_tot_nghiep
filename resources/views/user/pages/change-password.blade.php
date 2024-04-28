@include('user.layouts.header')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Đổi mật khẩu đăng nhập</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                    <form action="" class="change-password-form" method="POST">
                        @csrf
                        @auth()
                            @error('old-password')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <div class="form-group d-flex position-relative">
                                <input id="old-password-field" type="password" class="form-control" name="old-password" placeholder="Mật khẩu cũ">
                                <span toggle="#old-password-field" class="fa fa-fw fa-eye field-icon toggle-old-password position-absolute" style="top:30%; right: 15px"></span>
                            </div>
                        @endauth
                        @error('new-password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group d-flex position-relative">
                            <input id="password-field" type="password" class="form-control" name="new-password" placeholder="Mật khẩu mới">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-re-password position-absolute" style="top:30%; right: 15px"></span>
                        </div>
                        @error('re-password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="form-group position-relative">
                            <input id="re-password-field" type="password" class="form-control" name="re-password" placeholder="Nhập lại mật khẩu mới">
                            <span toggle="#re-password-field" class="fa fa-fw fa-eye field-icon toggle-re-password position-absolute" style="top:30%; right: 15px"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">XÁC NHẬN</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>

@push('script')
    <script src="{{asset('js/app.js')}}"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"87551f7f2d97850e","version":"2024.3.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>\
@endpush

@include('user.layouts.footer')

