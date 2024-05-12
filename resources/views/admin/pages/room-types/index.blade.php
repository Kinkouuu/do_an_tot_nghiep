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
                <option value="name" {{ (request()->input('by') == 'name') ? 'selected' : '' }}>Tên</option>
            </select>
            <select class="form-control w-25" name="sort">
                <option value="0" {{ (request()->input('sort') == '0') ? 'selected' : '' }}>Tăng dần</option>
                <option value="1" {{ (request()->input('sort') == '1') ? 'selected' : '' }}> Giảm dần</option>
            </select>
            <button type="submit" class="btn btn-info">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark text-center">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên loại phòng</th>
            <th scope="col">Ảnh đại diện</th>

            @foreach(\App\Enums\Room\PriceType::asArray() as $priceType)
                <th>{{ $priceType['text'] }}</th>
            @endforeach
            <th scope="col">Trạng thái</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roomTypes as $roomType)
            <tr>
                <th scope="row">{{ $roomType['id'] }}</th>
                <td class="text-capitalize">{{ $roomType['name'] }}</td>
                <td class="w-20">
                    <img class="w-100" src="{{ asset($roomType['thumb_link']) }}">
                </td>
                @foreach(\App\Enums\Room\PriceType::getRoomPriceType() as $key=>$priceType)
                    <td>{{ number_format($roomType['prices'][$key]) }} VND</td>
                @endforeach
                <td class="text-capitalize">{{ $roomType['status'] ? 'Đang hoạt động' : 'Đang tạm dừng'}}</td>
                <td>
                    @isAdmin
                    <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.room-type.edit', ['typeRoom' => $roomType['id']]) }}">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    @endisAdmin
                    <a type="button" class="btn btn-success mb-1" href="{{ route('admin.room-type.images', ['code' =>  $roomType['id']]) }}">
                        <i class="fa-regular fa-image"></i>
                    </a>
                    <a type="button" class="btn btn-info mb-1" href="{{ route('admin.room-type.services', ['code' =>  $roomType['id']]) }}">
                        <i class="fa-solid fa-bell-concierge"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

