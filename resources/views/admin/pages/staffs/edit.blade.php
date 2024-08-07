@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.staffs.update', $staff) }}" method="POST">
        @csrf @method('PUT')
        @error('account_name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên đăng nhập</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="account_name" value="{{ $staff->account_name}}" readonly >
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái tài khoản</span>
            </div>
            <select class="form-select" name="status">
                @foreach(\App\Enums\UserStatus::asArray() as $status)
                    <option {{ $staff->status == $status ? 'selected' : '' }} value={{ $status }}>
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

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chức vụ</span>
            </div>
            <select class="form-select" name="role">
                @foreach(\App\Enums\RoleAccount::isStaff() as $role)
                    <option {{ $staff->role == $role ? 'selected' : '' }} value={{ $role }}>
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

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chi nhánh</span>
            </div>
            <select class="selectpicker w-75" name="branch_id" data-live-search="true" data-style="bg-white border border-left-0">
                <option value=""></option>
                @foreach($branches as $branch)
                    <option {{ $staff->branch_id == $branch->id ? 'selected' : '' }} value={{ $branch->id }}>
                        {{ $branch->name . ' - ' . $branch->city }}
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $staff->name }}">
        </div>

        @error('email')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Email</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="email" value="{{ $staff->email}}">
        </div>
        @error('phone')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số điện thoại</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="phone" value="{{ $staff->phone}}">
        </div>

        @error('citizen_id')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Số CCCD/CMT/Visa</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="citizen_id" value="{{ $staff->citizen_id }}">
        </div>

        @error('birth_day')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Ngày sinh</span>
            </div>
            <input type="date" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="birth_day" value="{{ $staff->birth_day }}">
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giới tính</span>
            </div>
            <select class="form-control" name="gender">
                @foreach(\App\Enums\User\UserGender::asArray() as $gender)
                    <option {{ $staff->gender == $gender ? 'selected' : '' }} value={{ $gender }}>
                        {{ $gender == \App\Enums\User\UserGender::Male ? 'Nam' : 'Nữ' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection

