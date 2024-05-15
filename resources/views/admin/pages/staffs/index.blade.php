@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-9 d-flex">
            <div class="col-md-6 d-flex justify-content-around align-items-center" method="GET">
                <span class="mr-2">Sắp xếp theo: {{( request()->input('by') === 'country') ? 'selected' : '' }}</span>
                <select class="form-control w-25" name="by">
                    <option value="id" {{ (request()->input('by') == 'id') ? 'selected' : '' }}>ID</option>
                    <option value="account_name" {{ (request()->input('by') == 'account_name') ? 'selected' : '' }}>Tên tài khoản</option>
                    <option value="email" {{ (request()->input('by') == 'email') ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ (request()->input('by') == 'phone') ? 'selected' : '' }}>SDT</option>
                    <option value="status" {{ (request()->input('by') == 'status') ? 'selected' : '' }}>Trạng Thái</option>
                    <option value="role" {{ (request()->input('by') == 'role') ? 'selected' : '' }}>Chức vụ</option>
                    <option value="branch_id" {{ (request()->input('by') == 'branch_id') ? 'selected' : '' }}>Chi nhánh</option>
                </select>
                <select class="form-control w-25" name="sort">
                    <option value="DESC" {{ (request()->input('sort') == 'DESC') ? 'selected' : '' }}> Giảm dần</option>
                    <option value="ASC" {{ (request()->input('sort') == 'ASC') ? 'selected' : '' }}>Tăng dần</option>
                </select>

            </div>
            <div class="col-md-6 d-flex justify-content-around align-items-center">
                <div class="d-flex">
                    <span class="mr-2">Trạng thái: </span>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="{{ \App\Enums\UserStatus::Cancelled }}" id="defaultCheck1"
                            {{ (request()->get('status') != null) && in_array(\App\Enums\UserStatus::Cancelled,request()->get('status')) ? 'checked' : ''  }}>
                        <label class="form-check-label" for="defaultCheck1">
                            Cancelled
                        </label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="{{ \App\Enums\UserStatus::Active }}" id="defaultCheck2"
                            {{ (request()->get('status') != null) && in_array(\App\Enums\UserStatus::Active,request()->get('status')) ? 'checked' : ''  }}>
                        <label class="form-check-label" for="defaultCheck2">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="{{ \App\Enums\UserStatus::Banned }}" id="defaultCheck3"
                            {{ (request()->get('status') != null) && in_array(\App\Enums\UserStatus::Banned,request()->get('status')) ? 'checked' : ''  }}>
                        <label class="form-check-label" for="defaultCheck3">
                            Banned
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-info">
                    <i class="fa-solid fa-filter"></i>
                    Lọc
                </button>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Tài khoản</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">CCCD/CMT</th>
            <th scope="col">Ngày sinh</th>
            <th scope="col">Giới tính</th>
            <th scope="col">Trạng thái tài khoản</th>
            <th scope="col">Chức vụ</th>
            <th scope="col">Chi nhánh</th>
            <th>
                <a type="button" class="btn btn-success" href="{{ route('admin.staffs.create') }}">
                    <i class="fa-solid fa-user-plus"></i>
                    Thêm
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($staffs as $staff)
            <tr>
                <th scope="row">{{ $staff->id }}</th>
                <td class="text-capitalize">{{ $staff->name }}</td>
                <td class="text-capitalize">{{ $staff->account_name }}</td>
                <td>{{ $staff->email }}</td>
                <td>{{ $staff->phone }}</td>
                <td>{{ $staff->citizen_id }}</td>
                <td>{{ $staff->birth_day }}</td>
                <td>{{ $staff->gender == \App\Enums\User\UserGender::Female ? 'Nữ' : 'Nam' }}</td>
                <td style="min-width: 180px">
                    @livewire('status.change-status', ['item' => $staff])
                </td>
                <td class="text-capitalize">{{ $staff->role }}</td>
                <td class="text-capitalize">{{ $staff->branch?->name . ' - ' . $staff->branch?->city  }}</td>

                <td>
                    <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.staffs.edit', $staff) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $staff->id }}">
                        <i class="fa-solid fa-arrow-down-up-lock text-light"></i>
                    </button>

                    <!-- Modal -->
                    <form action="{{ route('admin.staffs.reset-password', $staff) }}" method="POST">
                        @csrf
                        <div class="modal fade" id="exampleModal-{{ $staff->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Cấp lại mật khẩu cho
                                            <span class="text-secondary text-bold">{{ $staff->account_name }}</span>
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="password" class="form-control mb-3" placeholder="Mật khẩu mới"
                                               name="password">
                                        <input type="password" class="form-control mb-3" placeholder="Nhập lại mật khẩu mới"
                                               name="re-password">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                                        </button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Modal -->
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $staffs->links('pagination::bootstrap-4') !!}
@endsection

