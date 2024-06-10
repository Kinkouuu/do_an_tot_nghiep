@php
use App\Enums\User\UserGender;
use Illuminate\Support\Carbon;
@endphp
<div class="col-md-11 mx-auto mt-4 py-3" style="background-color: #f1e6b2">
    <div class="row">
        <div class="col-md-3 text-center m-auto">
            <img class="rounded w-100" src="{{ $roomBranch['branch']['avatar'] }}">
        </div>
        <div class="col-md-9 d-flex justify-content-around">
            <div class="col-md-5">
                <h5>Tận hưởng chuyến đi của bạn tại: <br>
                    <span class="text-danger text-bold">{{ $roomBranch['branch']['name'] . ' - ' . $roomBranch['branch']['city']}}</span>
                </h5>
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-location-arrow"></i>
                        <p class="m-0 px-2">Địa chỉ: </p>
                    </div>
                    <p class="text-info m-0">{{ $roomBranch['branch']['address'] . ', ' . $roomBranch['branch']['city'] }}</p>
                </div>
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-phone"></i>
                        <p class="m-0 px-2">Hotline: </p>
                        <a href="tel:{{ $roomBranch['branch']['phone'] }}"
                           class="m-2 text-info">{{ $roomBranch['branch']['phone'] }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                @foreach($roomBranch['rooms'] as $room)
                    <div class="col-md-12 mb-3 p-0">
                        <a href="{{ route('room-type', base64_encode($room['room_type_id'])) }}" data-toggle="tooltip"
                           data-placement="right" title="Xem chi tiết phòng">
                            x {{ count($room['room_ids']) }}
                            <strong class="text-capitalize text-black"> Phòng {{ $room['room_type'] }}</strong>
                            <i class="text-secondary fa-solid fa-circle-info"></i>
                        </a>
                        <div class="d-flex justify-content-around">
                            <div class="col-md-6 border-left border-warning p-0">
                                <ul>
                                    @if($room['single_bed'] > 0)
                                        <li>Giường đơn: x {{ $room['single_bed'] }}</li>
                                    @endif

                                    @if($room['double_bed'] > 0)
                                        <li>Giường đôi: x {{ $room['double_bed'] }}</li>
                                    @endif

                                    @if($room['twin_bed'] > 0)
                                        <li>Giường cặp: x {{ $room['twin_bed'] }}</li>
                                    @endif

                                    @if($room['family_bed'] > 0)
                                        <li>Giường gia đình: x {{ $room['family_bed'] }}</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="col-md-6 border-left border-warning">
                                <p class="text-black">Giá phòng:
                                    <span class="text-info">
                                        {{ number_format($room['total_price_1_room'], 0, ',', '.') }} VND
                                    </span>
                                    <span class="text-secondary">x {{ count($room['room_ids']) }}</span>
                                    <br>
                                    <span class="text-danger" style="font-size: 12px">*Đây là giá của mỗi phòng được tính cho
                                        {{ $time < 24 ? ceil($time) . ' giờ' : ceil($time/24) . ' ngày/đêm'}}
                                    </span>
                                </p>
                                <p class="text-black">Sức chứa tối đa mỗi phòng: <br>
                                    <span class="text-secondary">
                                        {{ $room['adult_capacity'] }} người lớn và {{ $room['children_capacity'] }} trẻ em
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="col-md-12 d-flex justify-content-between border-top border-secondary px-0 pt-2">
                        <h4 class="text-success">Tổng chi
                            phí: {{ number_format($roomBranch['total_amount']['total_price'], 0, ',', '.')  }} VND</h4>

                        <!-- Button trigger modal -->
                        @if($user)
                            <button class="btn btn-warning text-light" wire:click="bookingConfirm({{ $user['id'] }})">
                                Đặt phòng ngay
                            </button>
                        @else
                            <button type="button" class="btn btn-warning text-light"
                                    data-toggle="modal" data-target="#needLogin">
                                Đặt phòng ngay
                            </button>
                        @endif
                    </div>
            </div>
        </div>
    </div>

        <!-- Login Modal -->
        <div wire:ignore.self class="modal fade" id="needLogin" data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title m-auto" id="needLogin">Bạn cần đăng nhập để đặt phòng</h5>
                    </div>
                    <div class="modal-body text-center pt-3">
                        <div>
                            @error('account') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 input-group mb-3">
                            <div class="input-group-prepend col-md-5 p-0">
                                <span class="input-group-text w-100">Số điện thoại</span>
                            </div>
                            <input type="text" class="form-control col-md-7" wire:model.blur="account" placeholder="Số điện thoại đăng nhập"/>
                        </div>
                        <div>
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-12 input-group mb-3">
                            <div class="input-group-prepend col-md-5 p-0">
                                <span class="input-group-text w-100">Mật khẩu</span>
                            </div>
                            <input type="password" class="form-control col-md-7" wire:model.blur="password" placeholder="Mật khẩu đăng nhập"/>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary text-black" data-dismiss="modal" wire:click="resetInput">Để sau</button>
                        <button type="button" class="btn btn-info text-white" wire:click="login">Đăng nhập</button>
                    </div>
                </div>
            </div>
        </div>
</div>

