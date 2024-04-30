@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-6 d-flex justify-content-around align-items-center" method="GET">
                <span class="mr-2">Sắp xếp theo: {{( request()->input('by') === 'country') ? 'selected' : '' }}</span>
                <select class="form-control w-50" name="by">
                    <option value="id" {{ (request()->input('by') == 'id') ? 'selected' : '' }}>ID</option>
                    <option value="country" {{ (request()->input('by') == 'country') ? 'selected' : '' }}>Quốc tịch</option>
                    <option value="name" {{ (request()->input('by') == 'name') ? 'selected' : '' }}>Họ tên</option>
                    <option value="created_by" {{ (request()->input('by') == 'created_by') ? 'selected' : '' }}>Người tạo</option>
                </select>
                <select class="form-control w-25" name="sort">
                    <option value="DESC" {{ (request()->input('sort') == 'DESC') ? 'selected' : '' }}> Giảm dần</option>
                    <option value="ASC" {{ (request()->input('by') == 'ASC') ? 'selected' : '' }}>Tăng dần</option>
                </select>
                <button type="submit" class="btn btn-info">
                    <i class="fa-solid fa-filter"></i>
                </button>
        </form>
        <div class="col-md-3 d-flex justify-content-around">
            <div class="d-flex ">
                <div class="border bg-light text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">No account</span>
                </div>
                <div class="bg-secondary text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Cancel</span>
                </div>
                <div class="bg-success text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Active</span>
                </div>
                <div class="bg-warning text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Banned</span>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Quốc tịch</th>
            <th scope="col">Giới tính</th>
            <th scope="col">CCCD/CMT/Visa</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
{{--            <th scope="col">Trạng thái tài khoản</th>--}}
            <th scope="col">Người tạo</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
       @foreach($customers as $customer)
           <tr id="customer-{{ $customer->id }}"
               class="{{ isset($customer->user->status)
                      ? match ($customer->user->status) {
                        \App\Enums\UserStatus::Cancelled => 'bg-secondary',
                        \App\Enums\UserStatus::Active => 'bg-success',
                        \App\Enums\UserStatus::Banned => 'bg-warning',
                       }
                    : null }}"
           >
               <th scope="row">{{ $customer->id }}</th>
               <td class="text-capitalize">{{ $customer->name }}</td>
               <td class="text-capitalize">{{ $customer->country }}</td>
               <td>{{ $customer->gender == \App\Enums\User\UserGender::Female ? 'Nữ' : 'Nam' }}</td>
               <td>{{ $customer->citizen_id }}</td>
               <td>{{ $customer->user->email ?? null }}</td>
               <td>{{ $customer->user->phone ?? null }}</td>
{{--               <td>{{ isset($customer->user->status)--}}
{{--                      ? match ($customer->user->status) {--}}
{{--                        \App\Enums\UserStatus::Cancelled => 'Đã hủy',--}}
{{--                        \App\Enums\UserStatus::Active => 'Đang hoạt động',--}}
{{--                        \App\Enums\UserStatus::Banned => 'Bị cấm',--}}
{{--                       }--}}
{{--                    : 'Chưa có tài khoản' }}--}}
{{--               </td>--}}
               <td class="text-capitalize">{{ $customer->created_by }}</td>
               <td>
                   <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.customers.edit', $customer) }}">
                       <i class="fa-regular fa-pen-to-square"></i>
                   </a>
                   <button type="button" class="btn btn-danger delete-btn" value="{{ $customer->id }}">
                       <i class="fa-solid fa-trash"></i>
                   </button>
               </td>
           </tr>
       @endforeach
        </tbody>
    </table>
{{--    {!! $customers->links('pagination::bootstrap-4') !!}--}}
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                const id = $(this).val();
                const url = '{{ route("admin.customers.destroy", ':id') }}'.replace(':id', id);
                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa?',
                    text: "Bạn sẽ không thể hoàn tác lại hành động này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            $('#customer-' + id).remove();
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                                })
                        },
                        error: function (response) {
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                            })
                        }
                    });
                }
                })
            });
        });
    </script>
@endpush
