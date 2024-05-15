@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>

                    <h1 class="col-8 my-auto text-center">{{$title}}
                        <br>
                        <strong
                            class="text-secondary text-uppercase">[{{ $room->name  . ' - ' . $room->branch->name . '/' .  $room->branch->city}}
                            ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 d-flex text-center p-0 bg-gradient-secondary">
                    <div class="col-1 p-0 border">Mã thiết bị</div>
                    <div class="col-2 p-0 border">Tên thiết bị</div>
                    <div class="col-2 p-0 border">Phân loại</div>
                    <div class="col-1 p-0 border">Nhãn hiệu</div>
                    <div class="col-2 p-0 border">Số lượng dự trữ</div>
                    <div class="col-2 p-0 border">Số lượng trang bị</div>
                    <div class="col-2 p-0 border">Ghi chú</div>
        </div>
            @foreach($room_devices as $room_device)
                @livewire('room.room-device', ['room' => $room, 'room_device' => $room_device])
            @endforeach
    </div>
@endsection
