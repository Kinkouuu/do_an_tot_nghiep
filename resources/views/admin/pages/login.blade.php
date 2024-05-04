@include('admin.layouts.header')

<div class="hold-transition login-page">
    <div class=" login-box">
        <div class="login-logo">
            <img src="{{ asset('images/logo.png') }}">
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Administrator</p>
                <form action="" method="POST">
                    @csrf
                    @error('account_name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Tên đăng nhập" name="account_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                        </div>
                    </div>
                    @error('password')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fa-solid fa-user-lock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-block btn-primary">
                            Sign in
                        </button>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>
</div>

@include('admin.layouts.footer')
