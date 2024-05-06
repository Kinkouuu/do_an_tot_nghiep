@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
            <span class="mr-2">Sắp xếp theo: </span>
            <select class="form-control w-25" name="by">
                <option value="id" {{ (request()->input('by') == 'id') ? 'selected' : '' }}>ID</option>
                <option value="type_device_id" {{ (request()->input('by') == 'type_device_id') ? 'selected' : '' }}>Loại thiết bị</option>
                <option value="name" {{ (request()->input('by') == 'name') ? 'selected' : '' }}>Tên</option>
                <option value="compensation_price" {{ (request()->input('by') == 'compensation_price') ? 'selected' : '' }}>Giá</option>
                <option value="brand" {{ (request()->input('by') == 'brand') ? 'selected' : '' }}>Nhãn hiệu</option>
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
            <th scope="col">Loại thiết bị</th>
            <th scope="col">Tên thiết bị</th>
            <th scope="col">Nhãn hiệu</th>
            <th scope="col">Giá cho thuê</th>
            <th scope="col">Tổng số lượng</th>
            <th scope="col">Cho thuê thiết bị</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($devices as $device)
            <tr>
                <th scope="row">{{ $device->id }}</th>
                <th class="text-capitalize">{{ $device->typeDevice->name }}</th>
                <td class="text-capitalize">{{ $device->name }}</td>
                <td class="text-capitalize">{{ $device->brand }}</td>
                <td>{{ number_format($device->rental_price) }} VND/thiết bị/ngày</td>
                <td>{{ number_format($device->quantity) }} thiết bị</td>

                <td>{{ $device->for_rent ? 'Cho thuê' : 'Không cho thuê' }}</td>
                <td>
                    <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.devices.edit', $device) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $devices->links('pagination::bootstrap-4') !!}
@endsection

