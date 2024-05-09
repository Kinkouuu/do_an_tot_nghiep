@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}} <strong class="text-secondary text-uppercase">[ {{ $type_room['name'] }} ]</strong></h1>

    <div class="container">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-6 border-secondary border-end">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between mb-3">
                                <h3 >Danh sách dịch vụ chưa có sẵn</h3>
                                <button class="btn btn-primary">
                                    <i class="fa-regular fa-square-plus"></i>
                                    Thêm
                                </button>
                            </div>
                            @foreach($services['un_provided_service'] as $typeService)
                                @if(isset($typeService['services']))
                                <div class="col-md-12 bg-gradient-info">
                                    <h5>
                                        <i class="{{ $typeService['type_service_icon'] }}"></i>
                                        {{ $typeService['type_service_name'] }}
                                    </h5>
                                </div>
                                    @foreach($typeService['services'] as $service)
                                        <div class="col-md-12 d-flex justify-content-between my-2">
                                            <div class="col-md-6 px-0">
                                                {{ $service['name'] }}
                                            </div>
                                            <div class="col-md-5 px-0">
                                                {{ number_format($service['price']) }} VND/người/vé
                                            </div>
                                            <div class="col-md-1 px-0">
                                                <input type="checkbox" value="{{ $service['id'] }}" name="add_services[]">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between mb-3">
                                <button class="btn btn-danger">
                                    <i class="fa-regular fa-square-minus"></i>
                                    Xóa
                                </button>
                                <h3 >Danh sách dịch vụ có sẵn</h3>
                            </div>
                            @foreach($services['provided_service'] as $typeService)
                                @if(isset($typeService['services']))
                                    <div class="col-md-12 bg-gradient-info">
                                        <h5>
                                            <i class="{{ $typeService['type_service_icon'] }}"></i>
                                            {{ $typeService['type_service_name'] }}
                                        </h5>
                                    </div>
                                    @foreach($typeService['services'] as $service)
                                        <div class="col-md-12 d-flex justify-content-between my-2 align-items-center">
                                            <div class="col-md-1 px-0">
                                                <input type="checkbox" value="{{ $service['id'] }}" name="remove_services[]">
                                            </div>
                                            <div class="col-md-4 px-0">
                                                {{ $service['name'] }}
                                            </div>
                                            <div class="col-md-4 px-0">
                                                {{ number_format($service['price']) }} VND/người/vé
                                            </div>
                                            <div class="col-md-3 px-0 d-flex align-items-center">
                                                Giảm:
                                                <input type="number" class="w-50 mx-1" value="{{ $service['discount'] }}"> %/vé
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
