@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.customers.store') }}" method="POST">
        @csrf
            <!-- Create new user member account -->
            <div class="container d-flex justify-content-between align-items-center mb-3">
                <button id="create-account" type="button" class="btn btn-info">
                    <i class="fa-solid fa-user-plus"></i>
                    Tạo tài khoản
                </button>
                <button id="cancel-create-account" type="button" class="btn btn-info account-form">
                    <i class="fa-solid fa-user-xmark"></i>
                    Hủy tạo tài khoản
                </button>
            </div>
            <!-- User member account form input -->
            <div class="account-form">
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
                <div class="w-100 input-group input-group-sm mb-3" >
                    <div class="w-25 input-group-prepend">
                        <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tài khoản email</span>
                    </div>
                    <input type="text" class="form-control w-75 input-disable" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-sm" name="email" value="{{ old('email')}}">
                </div>
                @error('phone')
                <div class="error">{{ $message }}</div>
                @enderror
                <div class="w-100 input-group input-group-sm mb-3">
                    <div class="w-25 input-group-prepend">
                        <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
                    </div>
                    <input type="text" class="form-control w-75 input-disable" aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-sm" name="phone" value="{{ old('phone') }}">
                </div>

            </div>

        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Họ và tên</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ old('name') }}">
        </div>

        @error('address')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Địa chỉ thường trú</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="address" value="{{ old('address') }}">
        </div>

        @error('country')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Quốc Tịch</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="country" value="{{ old('country') }}">
        </div>

        @error('citizen_id')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số CCCD/CMT/Visa</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="citizen_id" value="{{ old('citizen_id') }}">
        </div>

        @error('birth_day')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Ngày sinh</span>
            </div>
            <input type="date" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="birth_day" value="{{ old('birth_day') }}">
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giới tính</span>
            </div>
            <select class="form-control" name="gender">
                @foreach(\App\Enums\User\UserGender::asArray() as $gender)
                    <option {{ old('gender') == $gender ? 'selected' : '' }} value={{ $gender }}>
                        {{ $gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Lưu</button>
    </form>
@endsection

@push('script')
    <script>
        // hide|show input create member account form
        $(document).ready(function () {
            let isCreateAccount = localStorage.getItem("isCreateAccount") === "true";
            updateInterface(); // Gọi hàm updateInterface lần đầu để cập nhật giao diện ban đầu

            $(document).on("click", "#create-account", function () {
                isCreateAccount = true;
                localStorage.setItem("isCreateAccount", isCreateAccount);
                updateInterface();
            });

            $(document).on("click", "#cancel-create-account", function () {
                isCreateAccount = false;
                localStorage.setItem("isCreateAccount", isCreateAccount);
                updateInterface();
            });

            function updateInterface() {
                if (isCreateAccount) {
                    $("#create-account").attr("hidden", true);
                    $(".account-form").removeAttr("hidden");
                    $(".input-disable").attr("disabled", false);
                } else {
                    $("#create-account").removeAttr("hidden");
                    $(".account-form").attr("hidden", true);
                    $(".input-disable").attr("disabled", true);
                }
            }
        });
    </script>
@endpush
