@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
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
                   aria-describedby="inputGroup-sizing-sm" name="name" value="{{ old('name') }}">
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
        @foreach(\App\Enums\Room\PriceType::asArray() as $priceType)
            @error('price.' . $priceType['value'])
            <div class="error">{{ $message }}</div>
            @enderror
            <div class="w-100 input-group input-group-sm mb-3">
                <div class="w-25 input-group-prepend">
                    <span class="input-group-text w-100" id="inputGroup-sizing-sm">{{ $priceType['text'] }}</span>
                </div>
                <input type="number" min="0" class="form-control w-auto" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-sm"
                       name="price[{{ $priceType['value'] }}]" value="{{ old("price[" .  $priceType['value'] . "]") }}">
                <span class="input-group-text w-10" id="inputGroup-sizing-sm">VND/{{ $priceType['type'] }}</span>
            </div>
        @endforeach

        <button type="submit" class="btn btn-outline-success text-uppercase text-center m-auto">Thêm mới</button>
    </form>
@endsection
