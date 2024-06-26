@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">

                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="{{ route('admin.room-type.images', ['code' => $type_room['id']]) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Ảnh chi tiết
                        </a>
                    </div>
                    <h1 class="col-8 my-auto text-center">{{$title}}
                        <br>
                        <strong class="text-secondary text-uppercase">[ {{ $type_room['name'] }} ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="{{ route('admin.room-type.services', ['code' =>  $type_room['id']]) }}">
                            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                            Chi tiết dịch vụ
                        </a>
                    </div>
                </div>
                <form class="container col-md-8 text-center justify-content-center"
                      action="" method="POST">
                    @csrf
                    @error('name')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên loại phòng</span>
                        </div>
                        <input type="text" class="form-control w-75" aria-label="Sizing example input"
                               aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $type_room->name }}">
                    </div>
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
                        </div>
                        <select class="form-select" name="status">
                            @foreach(\App\Enums\Service\ServiceStatus::asArray() as $status)
                                <option {{ $type_room->status == $status ? 'selected' : '' }} value={{ $status }}>
                                    {{  match ($status) {
                                            \App\Enums\Service\ServiceStatus::DeActive => 'Dừng hoạt động',
                                             \App\Enums\Service\ServiceStatus::Active => 'Đang kích hoạt',
                                        }
                                    }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @error('description')
                    <div class="error">{{ $message }}</div>
                    @enderror
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả chi tiết</span>
                        </div>
                        <div class="w-75">
                            <textarea class="ckeditor" name="description">{{ $type_room->description }}</textarea>
                        </div>
                    </div>
                    @foreach($prices as $price)
                        @error('price.' . $price['id'])
                        <div class="error">{{ $message }}</div>
                        @enderror
                        <div class="w-100 input-group input-group-sm mb-3">
                            <div class="w-25 input-group-prepend">
                                <span class="input-group-text w-100" id="inputGroup-sizing-sm">{{ $price['name'] }}</span>
                            </div>
                            <input type="number" min="0" class="form-control w-auto" aria-label="Sizing example input"
                                   aria-describedby="inputGroup-sizing-sm"
                                   name="price[{{ $price['id'] }}]" value="{{ $price['price'] }}">
                            <span class="input-group-text w-10" id="inputGroup-sizing-sm">VND/{{ $price['type'] }}</span>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
