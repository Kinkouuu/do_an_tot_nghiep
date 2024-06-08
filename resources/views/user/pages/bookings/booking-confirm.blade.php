@php
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
@endphp
@extends('user.layouts.main')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 mb-3 text-white"
                             style="background-image: url({{ asset($branch['avatar']) }}); background-repeat: no-repeat; background-size: cover">
                            <h3 class="text-light"
                                style="font-size: xxx-large; font-style: oblique">{{ $branch['name'] }}</h3>
                            <div class="row">
                                <div class="col-md-9">
                                    <p><i class="fa-solid fa-phone-volume"></i>
                                        <strong>Gọi cho chúng tôi để được tư vấn:</strong>
                                        {{ $branch['phone'] }}
                                    </p>
                                    <p><i class="fa-solid fa-map-location-dot"></i>
                                        <strong>Địa chỉ:</strong>
                                        {{ $branch['address'] }}, {{ $branch['city'] }}
                                    </p>
                                </div>
                                <div class="col-md-3 row text-right">
                                    <a class="text-danger">
                                        <i class="btn fa-regular fa-heart fa-xl" style="color: #ff0000;"></i> Yêu thích
                                    </a>
                                    <a class="" style="color: #0c84ff">
                                        <i class="btn fa-solid fa-share-nodes fa-xl" style="color: #0c84ff"></i> Chia sẻ
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pt-3" style="background-color: #f1e6b2">
                            <div class="row align-items-center">
                                @foreach($rooms as $room)
                                    <div class="col-md-4 p-2">
                                        <img href="{{ $room['thumb_nail'] }}" src="{{ $room['thumb_nail'] }}"
                                             alt="Ảnh phòng"
                                             class="img-fluid image-popup img-opacity w-75" loading="lazy">
                                        @foreach($room['detail_images'] as $detailImage)
                                            <img href="{{ $detailImage }}" src="{{ $detailImage }}" alt="Ảnh chi tiết"
                                                 class="img-fluid detail-img-absolute image-popup img-opacity"
                                                 loading="lazy">
                                        @endforeach

                                    </div>
                                    <div class="col-md-8">
                                        <div class="section-heading text-left">
                                            <h2 class="mb-5 text-uppercase">Phòng <span
                                                    class="ms-5 m-md-0">{{ $room['room_type'] }}</span>
                                                <span
                                                    class="text-lowercase text-secondary">x{{ count($room['room_ids']) }}</span>
                                            </h2>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6 border-bottom border-warning">
                                                    <h5><i class="fa-solid fa-bed"></i> Số giường</h5>
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
                                                    <h5><i class="fa-solid fa-bell-concierge"></i> Dịch vụ có sẵn</h5>
                                                    <ul>
                                                        @foreach($room['services']['provide'] as $service)
                                                            <li>
                                                                <p>
                                                                    {{ $service['service_name'] }}
                                                                    @if($service['discount'] == 100)
                                                                        <span class="text-danger"> (miễn phí) </span>
                                                                    @else
                                                                        <span class="text-info">{{ number_format($service['price'], 0, ',', '.') }} VND/người</span>
                                                                        <span class="text-danger">(-{{ $service['discount'] }}%)</span>
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <h5><i class="fa-solid fa-people-roof"></i> Sức chứa tối đa</h5>
                                                    <ul>
                                                        <li>Người lớn: {{ $room['adult_capacity'] }}</li>
                                                        <li>Trẻ em: {{ $room['children_capacity'] }}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 border-bottom border-warning pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        Bảng giá:
                                                    </h5>
                                                    <ul class="text-dark">
                                                        @foreach($room['price_unit'] as $key=>$price)
                                                            @if($key == PriceType::ListedHourPrice['value'])
                                                                <li>
                                                                    {{ PriceType::ListedHourPrice['text'] . ': ' }}
                                                                    <p class="text-danger">
                                                                        {{ number_format($price, 0, ',', '.') }}
                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            @elseif($key == PriceType::ListedDayPrice['value'])
                                                                <li>
                                                                    {{ PriceType::ListedDayPrice['text'] .': ' }}
                                                                    <p class="text-danger">
                                                                        {{ number_format($price, 0, ',', '.') }}
                                                                        VND/phòng/ngày
                                                                    </p>
                                                                </li>
                                                            @elseif($key == PriceType::First2Hours['value'])
                                                                <li>
                                                                    {{ PriceType::First2Hours['text'] .': '}}
                                                                    <p class="text-danger">
                                                                        {{ number_format($price, 0, ',', '.') }}
                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            @elseif($key == PriceType::EarlyCheckIn['value'])
                                                                <li>
                                                                    {{ PriceType::EarlyCheckIn['text'] .': '}}
                                                                    <p class="text-danger">
                                                                        {{ number_format($price, 0, ',', '.') }}
                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            @elseif($key == PriceType::LateCheckOut['value'])
                                                                <li>
                                                                    {{ PriceType::LateCheckOut['text'] .': '}}
                                                                    <p class="text-danger">
                                                                        {{ number_format($price, 0, ',', '.') }}
                                                                        VND/phòng/giờ
                                                                    </p>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                    <h5><i class="fa-solid fa-money-bill-wave"></i>
                                                        Thành tiền:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        {{ number_format(count($room['room_ids']) * $room['total_price_1_room'], 0, ',', '.')}}
                                                        VND/{{count($room['room_ids'])}} phòng
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 text-right">
                                <h4>Tổng số phòng:
                                    <span class="text-info">{{ $total_amount['total_room'] }}</span>
                                    phòng
                                </h4>
                                <h4>Tổng tiền:
                                    <span
                                        class="text-success">{{ number_format($total_amount['total_price'], 0, ',', '.') }}</span>
                                    VND
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="col-12 m-auto py-4 rounded text-white" style="background-color:#a6a6a6">
                    <h5 class="text-center text-light mb-3"> Thông tin chuyến đi</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Địa điểm: Khách sạn {{ $branch['name'] }} - {{ $branch['city'] }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-restroom"></i>
                            <span>Số người: {{ $condition['adults'] }} người lớn và {{ $condition['children'] }} trẻ em</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <span>Ngày nhận phòng: </span>
                        </label>
                        <p class="text-capitalize">{{ $condition['checkin']->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                            <span>Ngày trả phòng: </span>
                        </label>
                        <p class="text-capitalize">{{ $condition['checkout']->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                               Chuyến đi {{ $condition['duration'] }} dành cho {{ $condition['adults'] + $condition['children'] }} người
                           </span>
                        </label>
                    </div>
                </div>
                <form class="col-md-12 mt-3 border rounded bg-light" method="POST" action="{{ route('booking.booking') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 border-bottom p-3 px-0">
                            <h4 class="text-center text-capitalize">Thông tin người nhận phòng</h4>
                        </div>
                        <div class="col-md-12 m-auto py-2">
                            <div class="d-flex">
                                <p class="col-7 text-danger text-sm-left" style="font-size: 12px">
                                    *Nếu người nhận phòng không phải bạn, hãy chọn đặt cho người thân
                                </p>
                                <div class="col-5 form-check form-switch text-right">
                                    <input class="form-check-input" name="forRelative" type="checkbox" role="switch">
                                    <span>Đặt cho người thân</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Email</span>
                                    </div>
                                    <div class="form-control col-md-7">
                                        <p class="m-auto">{{ $user->email }}</p>
                                    </div>
                                </div>
                                @error('phone')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số điện thoại</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="phone"
                                           value="{{ $user->phone }}">
                                </div>
                                @error('name')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Họ tên</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="name"
                                           value="{{ $user->customer?->name ?? old('data.name') }}">
                                </div>
                                @error('country')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Quốc tịch</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="country"
                                           value="{{ $user->customer?->country ?? old('data.country') }}">
                                </div>
                                @error('citizen_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số CCCD</span>
                                    </div>
                                    <input type="text" class="form-control col-md-7" name="citizen_id"
                                           value="{{ $user->customer?->citizen_id ?? old('data.citizen_id') }}">
                                </div>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Giới tính</span>
                                    </div>
                                    <select class="form-select" name="gender">
                                        @foreach(UserGender::asArray() as $gender)
                                            <option
                                                {{ $user->customer?->gender == $gender ? 'selected' : '' }} value={{ $gender }}>
                                                {{ $gender == UserGender::Male ? 'Nam' : 'Nữ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Thanh toán bằng</span>
                                    </div>
                                    <select class="form-control selectpicker" name="payment"
                                            data-style="bg-white border border-left-0">
                                        @foreach(PaymentType::getPaymentType() as $payment)
                                            <option data-icon="{{ $payment['icon'] }}"
                                                    {{ old('payment') == $payment ? 'selected' : '' }} value={{ $payment['type'] }}>
                                                {{ $payment['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('note')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-12 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Ghi chú</span>
                                    </div>
                                    <textarea name="note" cols="1" rows="3" class="form-control col-md-7">
                                        {{ old('note') }}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center border-top py-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" checked id="confirm-btn">
                                <label class="form-check-label text-left" for="confirm-btn" style="font-size: 12px">
                                    Tôi cam đoan thông tin trên trùng khớp với thông tin định danh trên thẻ CCCD/Visa
                                    của người đại diện nhận phòng.
                                </label>
                            </div>
                            <button type="submit" id="submit-btn" class="btn btn-success">Đặt phòng</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Lấy phần tử checkbox và nút
        const confirmBtn = document.getElementById('confirm-btn');
        const submitBtn = document.getElementById('submit-btn');

        // Kiểm tra trạng thái của checkbox khi trang được tải
        if (confirmBtn.checked) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }

        // Lắng nghe sự kiện thay đổi trạng thái của checkbox
        confirmBtn.addEventListener('change', function () {
            if (this.checked) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>
@endpush

