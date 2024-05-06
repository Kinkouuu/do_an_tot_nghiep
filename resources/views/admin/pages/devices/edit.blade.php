@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.devices.update', $device) }}" method="POST">
        @csrf @method('PUT')
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại thiết bị</span>
            </div>
            <select class="selectpicker w-75" name="type_device_id" data-live-search="true"
                    data-style="bg-white border border-left-0">
                @foreach($typeDevices as $typeDevice)
                    <option data-icon="{{ $typeDevice->icon }}"
                            {{ $device->type_device_id == $typeDevice->id ? 'selected' : '' }} value={{ $typeDevice->id }}>
                        {{ $typeDevice->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên thiết bị</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $device->name }}">
        </div>

        @error('rental_price')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giá cho thuê</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="rental_price" min="0"
                   value="{{ $device->rental_price }}">
            <span class="input-group-text" id="basic-addon2">VND/thiết bị/ngày</span>
        </div>
        @error('quantity')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tổng số lượng</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="quantity" min="0" value="{{ $device->quantity }}">
            <span class="input-group-text" id="basic-addon2">thiết bị</span>
        </div>

        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả thiết bị</span>
            </div>
            <textarea class="ckeditor form-control w-75" id="description" name="description">
                {{ $device->description }}
            </textarea>
        </div>

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <div class="w-75 m-auto d-flex justify-content-around">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="for_rent" id="exampleRadios1"
                           value="0" {{ !$device->for_rent ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleRadios1">
                        Không cho thuê
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="for_rent" id="exampleRadios2"
                           value="1" {{ $device->for_rent ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleRadios2">
                        Cho thuê
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection
