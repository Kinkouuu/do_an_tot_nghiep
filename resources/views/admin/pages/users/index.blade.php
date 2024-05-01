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
                    <option value="email" {{ (request()->input('by') == 'email') ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ (request()->input('by') == 'phone') ? 'selected' : '' }}>SDT</option>
                    <option value="status" {{ (request()->input('by') == 'status') ? 'selected' : '' }}>Trạng Thái
                    </option>
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
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">Tên</th>
            <th scope="col">Quốc tịch</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">CCCD/CMT/Visa</th>
            <th scope="col">Trạng thái tài khoản</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->email }}</td>
                <td class="text-capitalize">{{ $user->phone }}</td>
                <td class="text-capitalize">{{ $user->customer?->name }}</td>
                <td class="text-capitalize">{{ $user->customer?->country }}</td>
                <td class="text-capitalize">{{ $user->customer?->address }}</td>
                <td>{{ $user->customer?->citizen_id }}</td>

                <td style="min-width: 180px">
                    @livewire('status.change-status', ['item' => $user])
                </td>
                <td>
                    <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.users.edit', $user) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $users->links('pagination::bootstrap-4') !!}
@endsection

