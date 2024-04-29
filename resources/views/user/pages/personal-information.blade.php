@extends('user.layouts.main')

@section('content')
    <section class="container col-md-8 mx-auto my-5">
        <h1 class="text-center text-secondary text-uppercase">&mdash; Cập nhật thông tin cá nhân &mdash;</h1>
        <form method="POST">
            @csrf
            @error('name')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Họ và tên</span>
                </div>
                <input type="text" class="form-control w-75" name="name" value="{{ $customer['name'] ?? old('name') }}">
            </div>
            @error('address')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Địa chỉ thường trú</span>
                </div>
                <input type="text" class="form-control" name="address" value="{{ $customer['address'] ?? old('address')}}">
            </div>
            @error('country')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Quốc tịch</span>
                </div>
                <input type="text" class="form-control" name="country" value="{{ $customer['country'] ?? old('country')}}">
            </div>
            @error('citizen_id')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Số CCCD/CMT</span>
                </div>
                <input type="text" class="form-control" name="citizen_id" value="{{ $customer['citizen_id'] ?? old('citizen_id')}}">
            </div>
            @error('birth_day')
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Ngày sinh</span>
                </div>
                <input type="date" class="form-control" name="birth_day" value="{{ $customer['birth_day'] ?? old('birth_day')}}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">Giới tính</span>
                </div>

                <select class="form-control" name="gender">
                    @foreach(\App\Enums\User\UserGender::asArray() as $gender)
                        <option {{ $customer['gender'] == $gender ? 'selected' : '' }} value={{ $gender }}>
                            {{ $gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="align-content-center text-center">
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </section>
@endsection
