@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.services.store') }}" method="POST">
        @csrf

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại dịch vụ</span>
            </div>
            <select class="selectpicker w-75" name="type_service_id" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach($typeServices as $typeService)
                    <option data-icon="{{ $typeService->icon }}"
                        {{ old('type_service_id') == $typeService->id ? 'selected' : '' }} value={{ $typeService->id }}>
                        {{ $typeService->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('name')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Tên dịch vụ</span>
            </div>
            <input type="text" class="form-control w-75" aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ old('name') }}">
        </div>

        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả</span>
            </div>
            <textarea class="form-control" placeholder="Mô tả chi tiết"
                      name="description" maxlength="300" style="min-height: 150px">{{ old('description') }}</textarea>
        </div>

        @error('price')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giá niêm yết</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="price" min="0" value="{{ old('price') }}">
            <span class="input-group-text" id="basic-addon2">VND</span>
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select" name="status">
                @foreach(\App\Enums\Service\ServiceStatus::asArray() as $status)
                    <option {{ old('status') == $status ? 'selected' : '' }} value="{{ $status }}">
                        {{ $status == \App\Enums\Service\ServiceStatus::DeActive ? 'Chưa cung cấp' : 'Đang cung cấp' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection
