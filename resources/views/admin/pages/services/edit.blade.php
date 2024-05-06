@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <form class="container col-md-6 text-center justify-content-center"
          action="{{ route('admin.services.update', $service) }}" method="POST">
        @csrf @method('PUT')

        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại dịch vụ</span>
            </div>
            <select class="selectpicker w-75" name="type_service_id" data-live-search="true" data-style="bg-white border border-left-0">
                @foreach($typeServices as $typeService)
                    <option data-tokens="{{ $typeService->name }}"
                        {{ $service->type_service_id == $typeService->id ? 'selected' : '' }} value={{ $typeService->id }}>
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ $service->name }}">
        </div>

        @error('description')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Mô tả chi tiết</span>
            </div>
            <textarea class="ckeditor" placeholder="Mô tả chi tiết"
                      name="description" id="description" maxlength="300" style="min-height: 150px">{{ $service->description }}</textarea>
        </div>

        @error('price')
        <div class="error">{{ $message }}</div>
        @enderror
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Giá niêm yết</span>
            </div>
            <input type="number" class="form-control w-auto " aria-label="Sizing example input"
                   aria-describedby="inputGroup-sizing-sm" name="price" min="0" value="{{ $service->price }}">
            <span class="input-group-text" id="basic-addon2">VND</span>
        </div>
        <div class="w-100 input-group input-group-sm mb-3">
            <div class="w-25 input-group-prepend">
                <span class="input-group-text w-100" id="inputGroup-sizing-sm">Trạng thái</span>
            </div>
            <select class="form-select" name="status">
                @foreach(\App\Enums\Service\ServiceStatus::asArray() as $status)
                    <option {{ $service->status == $status ? 'selected' : '' }} value="{{ $status }}">
                        {{ $status == \App\Enums\Service\ServiceStatus::Active ? 'Đang cung cấp' : 'Dừng cung cấp' }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Cập nhật</button>
    </form>
@endsection
