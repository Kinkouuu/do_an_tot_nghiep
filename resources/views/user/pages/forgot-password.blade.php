
@include('user.layouts.header')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Quên mật khẩu</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <form action="" class="forgot-password-form" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="account" name="account" placeholder="Email hoặc Số điện thoại đăng nhập">
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit-button" class="form-control btn btn-primary submit px-3" disabled>XÁC NHẬN</button>
                        </div>
                    </form>
                    <div class="w-100 text-center mt-5">
                        <a href="{{ route('signin') }}" class="w-100 text-center" >&mdash; Quay lại trang đăng nhập &mdash;</a>
                    </div >
                </div>
            </div>
        </div>
    </div>

@push('script')
    <script>
        // validation input verify-code input
        $(document).ready(function () {
            let typingTimer;
            const doneTypingInterval = 100;

            $(document).on("input", "#account", function () {
                clearTimeout(typingTimer);

                typingTimer = setTimeout(function () {
                    const input = $('#account').val();

                    function checkInput(inputStr) {
                        // Kiểm tra định dạng email
                        const emailRegex = /^[\w.-]+@[\w.-]+\.\w+$/;
                        if (emailRegex.test(inputStr)) {
                            return true;
                        }
                        // Kiểm tra số bắt đầu từ số 0 và có 10 chữ số
                        if (/^0\d{9}$/.test(inputStr)) {
                            return true;
                        }
                        return false;
                    }

                    if (checkInput(input)) {
                        $("#submit-button").removeAttr("disabled");
                    } else {
                        $("#submit-button").attr("disabled", true);
                    }
                }, doneTypingInterval);
            });
        });
    </script>
@endpush

@include('user.layouts.footer')

