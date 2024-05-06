@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
            <span class="mr-2">Sắp xếp theo: {{( request()->input('by') === 'name') ? 'selected' : '' }}</span>
            <select class="form-control w-25" name="by">
                <option value="id" {{ (request()->input('by') == 'id') ? 'selected' : '' }}>ID</option>
                <option value="type_service_id" {{ (request()->input('by') == 'type_service_id') ? 'selected' : '' }}>Loại dịch vụ</option>
                <option value="country" {{ (request()->input('by') == 'status') ? 'selected' : '' }}>Trạng Thái</option>
                <option value="name" {{ (request()->input('by') == 'name') ? 'selected' : '' }}>Tên</option>
            </select>
            <select class="form-control w-25" name="sort">
                <option value="ASC" {{ (request()->input('sort') == 'ASC') ? 'selected' : '' }}>Tăng dần</option>
                <option value="DESC" {{ (request()->input('sort') == 'DESC') ? 'selected' : '' }}> Giảm dần</option>
            </select>
            <button type="submit" class="btn btn-info">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Loại dịch vụ</th>
            <th scope="col">Tên dịch vụ</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Giá niêm yết</th>
            <th scope="col">Trạng thái</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($services as $service)
            <tr id="service-{{ $service->id }}">
                <th scope="row">{{ $service->id }}</th>
                <td class="text-capitalize">{{ $service->typeService->name }}</td>
                <td class="text-capitalize">{{ $service->name }}</td>
                <td class="text-capitalize">{{ $service->description }}</td>
                <td>{{ number_format($service->price) }} VND</td>

                <td>{{ $service->status ==\App\Enums\Service\ServiceStatus::Active ? 'Đang cung cấp' : 'Dừng cung cấp' }}</td>
                <td>
                    <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.services.edit', $service) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger delete-btn" value="{{ $service->id }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $services->links('pagination::bootstrap-4') !!}
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                const id = $(this).val();
                const url = '{{ route("admin.services.destroy", ':id') }}'.replace(':id', id);
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
                                $('#service-' + id).remove();
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
