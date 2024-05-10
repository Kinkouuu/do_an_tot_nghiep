@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="{{ route('admin.room-type.edit' , ['typeRoom' => $type_room['id']]) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                    <h1 class="col-8 my-auto text-center">{{$title}}
                        <br>
                        <strong class="text-secondary text-uppercase">[ {{ $type_room['name'] }} ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="{{ route('admin.room-type.images', ['code' =>  $type_room['id']]) }}">
                            <i class="fa-solid fa-panorama"></i>
                            Ảnh chi tiết
                        </a>
                    </div>
                </div>
                <form class="col-md-6 border-secondary border-end"
                      action="{{ route('admin.room-type.services.add', $type_room) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <h3>Danh sách dịch vụ chưa có sẵn</h3>
                            <button class="btn btn-primary" type="submit">
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
                </form>

                <form class="col-md-6" action="{{ route('admin.room-type.services.remove', $type_room) }}"
                      method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <button class="btn btn-danger">
                                <i class="fa-regular fa-square-minus"></i>
                                Xóa
                            </button>
                            <h3>Danh sách dịch vụ có sẵn</h3>
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
                                    <div
                                        class="col-md-12 d-flex justify-content-between my-2 align-items-center {{ $service['status'] == \App\Enums\Service\ServiceStatus::DeActive ? 'bg-warning' : ''}}">
                                        <div class="col-md-1 px-0">
                                            <input type="checkbox" value="{{ $service['id'] }}"
                                                   name="remove_services[]">
                                        </div>
                                        <div class="col-md-4 px-0">
                                            {{ $service['name'] }}
                                        </div>
                                        <div class="col-md-4 px-0">
                                            {{ number_format($service['price']) }} VND/người/vé
                                        </div>
                                        <div class="col-md-3 px-0 d-flex align-items-center">
                                            @livewire('room-service.change-discount', [
                                                'roomType' => $type_room,
                                                'service' => $service,
                                                'discount' => $service['discount']
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                        </div>
                    </form>
                </div>
            </div>
    </div>
@endsection
