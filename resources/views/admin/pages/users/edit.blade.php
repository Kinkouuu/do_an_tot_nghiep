@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')

        <div class="w-100 input-group input-group-sm mb-3">
            @error('email')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tài khoản email</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="email" value="{{ $user->email}}">
        </div>
        @error('phone')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="phone" value="{{ $user->phone}}">
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái tài khoản</span>
            </div>
            <select class="form-control" name="status">
                @foreach(\App\Enums\UserStatus::asArray() as $status)
                    <option {{ $user->status == $status ? 'selected' : '' }} value={{ $status }}>
                        {{  match ($status) {
                                \App\Enums\UserStatus::Cancelled => 'Đã hủy',
                                \App\Enums\UserStatus::Active => 'Đang kích hoạt',
                                \App\Enums\UserStatus::Banned => 'Đang bị cấm',
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $user->customer?->name }}">
        </div>

        @error('address')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Địa chỉ thường trú</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="address" value="{{ $user->customer?->address }}">
        </div>

        @error('country')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Quốc Tịch</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="country" value="{{ $user->customer?->country }}">
        </div>

        @error('citizen_id')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số CCCD/CMT/Visa</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="citizen_id" value="{{ $user->customer?->citizen_id }}">
        </div>

        @error('birth_day')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Ngày sinh</span>
            </div>
            <input type="date" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="birth_day" value="{{ $user->customer?->birth_day }}">
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giới tính</span>
            </div>
            <select class="form-control" name="gender">
                @foreach(\App\Enums\User\UserGender::asArray() as $gender)
                    <option {{ $user->customer?->gender == $gender ? 'selected' : '' }} value={{ $gender }}>
                        {{ $gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection

