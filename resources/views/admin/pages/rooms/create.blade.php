@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-8 text-center justify-content-center"
          action="{{ route('admin.room.store') }}" method="POST">
        @csrf
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Phân loại phòng</span>
            </div>
            <select class="selectpicker w-75" name="room_type_id" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach($room_types as $roomType)
                    <option {{ old('room_type_id') == $roomType->id ? 'selected' : '' }} value={{ $roomType->id }}>
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
                    <option {{ old('branch_id') == $branch->id ? 'selected' : '' }} value={{ $branch->id }}>
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ old('name') }}">
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select w-75" name="status" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach(\App\Enums\Room\RoomStatus::asArray() as $status)
                    <option {{ old('$status') == $status['key'] ? 'selected' : '' }} value={{ $status['key'] }}>
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
                <textarea class="ckeditor" name="description">{{ old('description') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Thêm mới</button>
    </form>
@endsection
