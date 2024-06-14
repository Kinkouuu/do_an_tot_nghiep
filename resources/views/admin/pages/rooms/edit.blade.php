@extends('admin.layouts.main')

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="d-flex justify-content-between mt-3 mb-5">
                <div class="col-2 my-auto text-center">
                    <a class="btn btn-outline-success" href="{{ route('admin.room.edit', $room['id']) }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Thông tin chi tiết
                    </a>
                </div>

                <h1 class="text-center p-3"> {{ $title }}
                    <br>
                    <strong class="text-secondary text-uppercase">[{{ $room->name . ' - ' . $room->branch->name . '/' . $room->branch->city }}]</strong>
                </h1>
                <div class="col-2 my-auto text-center">
                    <a class="btn btn-outline-success" href="{{ route('admin.room.devices', ['code' => $room->id]) }}">
                        <i class="fa-solid fa-server"></i>
                       Danh sách thiết bị
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form class="container col-md-8 text-center justify-content-center"
          action="{{ route('admin.room.update', $room) }}" method="POST">
        @csrf @method('PUT')
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Phân loại phòng</span>
            </div>
            <select class="selectpicker w-75" name="room_type_id" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach($room_types as $roomType)
                    <option {{ $room->roomType->id == $roomType->id ? 'selected' : '' }} value={{ $roomType->id }}>
                        {{ $roomType->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chi nhánh</span>
            </div>
            <select class="selectpicker w-75" name="branch_id" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach($branches as $branch)
                    <option {{ $room->branch->id == $branch->id ? 'selected' : '' }} value={{ $branch->id }}>
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
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên phòng</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $room->name }}">
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select w-75" name="status" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach(\App\Enums\Room\RoomStatus::asArray() as $status)
                    <option {{$room->status == $status['key'] ? 'selected' : '' }} value={{ $status['key'] }}>
                        {{ $status['value'] }}
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
                <textarea class="ckeditor" name="description">{{ $room->description }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection
