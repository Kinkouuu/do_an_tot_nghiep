@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.staffs.store') }}" method="POST">
        @csrf
        @error('account_name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên đăng nhập</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="account_name" value="{{ old('account_name') }}">
        </div>

        @error('password')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mật khẩu</span>
            </div>
            <input type="password" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="password">
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chức vụ</span>
            </div>
            <select class="form-select" name="status">
                @foreach(\App\Enums\RoleAccount::isStaff() as $role)
                    <option {{ old('role') == $role ? 'selected' : '' }} value={{ $role }}>
                        {{  match ($role) {
                                \App\Enums\RoleAccount::Employee => 'Nhân viên',
                                \App\Enums\RoleAccount::Manager => 'Quản lý',
                                \App\Enums\RoleAccount::Admin => 'Quản trị viên',
                            }
                        }}
                    </option>
                @endforeach
            </select>
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

        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Email</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="email" value="{{ old('email')}}">
        </div>
        @error('phone')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="phone" value="{{ old('phone')}}">
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

