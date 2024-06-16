@php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
    use App\Enums\Room\PriceType;
@endphp
@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <div class="container-fluid pb-3">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <img class="rounded w-100" src="{{ $branch['avatar'] }}">
                        <h5 class="text-center text-danger font-italic font-weight-bold mt-2">
                            {{ $branch['name'] . ' - ' . $branch['city']}}
                        </h5>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-arrow"></i>
                                <p class="m-0 px-2">Địa chỉ: </p>
                            </div>
                            <p class="text-info m-0">{{ $branch['address'] . ', ' . $branch['city'] }}</p>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-phone"></i>
                                <p class="m-0 px-2">Hotline: </p>
                                <a href="tel:{{ $branch['phone'] }}"
                                   class="m-2 text-info">{{ $branch['phone'] }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3" style="border: wheat ridge; border-radius: 5px">
                        <h5 class="text-center text-secondary mb-3 text-uppercase"> Danh sách phòng</h5>
                        <div class="row">
                            @foreach($rooms as $room)
                                <div class="col-md-12 border-top border-warning">
                                    <div class="row">
                                        <div class="col-md-6 p-2 ">
                                            <img href="{{ $room['thumb_nail'] }}" src="{{ $room['thumb_nail'] }}"
                                                 alt="Ảnh phòng" class="img-fluid image-popup img-opacity w-100 rounded "
                                                 style="border: double #f1e6b2 4px;" loading="lazy">
                                        </div>
                                        <div class="col-md-6 m-auto">
                                            <div class="section-heading text-left">
                                                <h3 class="mb-1 text-uppercase">Phòng <span
                                                        class="ms-5 m-md-0">{{ $room['room_type'] }}</span>
                                                    <span
                                                        class="text-lowercase text-secondary">x{{ count($room['room_ids']) }}</span>
                                                </h3>
                                            </div>
                                            <ul class="p-0">
                                                @foreach($room['room_ids'] as $roomId => $roomName)
                                                    <li class="p-0">
                                                    @livewire('booking.change-room', [
                                                     'roomId' => $roomId,
                                                     'booking' => $booking,
                                                     ])
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6">
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
                                                </div>
                                                <div class="col-md-6 pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        Giá phòng:
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
                                                    <p class="text-info text-center" style="font-size: large">
                                                        {{ number_format($room['total_price_1_room'], 0, ',', '.')}}
                                                        VND/phòng
                                                        <span class="text-secondary">SL: x{{count($room['room_ids'])}}</span>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-12 m-auto py-4 rounded text-dark bg-light border border-warning">
                        <h5 class="text-center text-secondary mb-3 text-uppercase"> Thông tin chuyến đi</h5>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-user"></i>
                                <span>{{ $booking['gender'] == UserGender::Male ? 'Anh' : 'Chị' }}: {{ $booking['name'] }}</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-mobile-screen-button"></i>
                                <span>Số điện thoại: {{ $booking['phone'] }}</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-passport"></i>
                                <span>Quốc tịch: {{ $booking['country'] }}</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-regular fa-id-card"></i>
                                <span>CCCD/Visa: {{ $booking['citizen_id'] }}</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Địa điểm: Khách sạn {{ $branch['name'] }} - {{ $branch['city'] }}</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-restroom"></i>
                                <span>Số người: {{ $booking['number_of_adults'] }} người lớn và {{ $booking['number_of_children'] }} trẻ em</span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-person-walking-luggage"></i>
                                <span>Ngày nhận phòng: </span>
                            </label>
                            <p class="text-capitalize">{{ Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                                <span>Ngày trả phòng: </span>
                            </label>
                            <p class="text-capitalize">{{Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-calendar-check"></i>
                                <span>Ngày đặt đơn: </span>
                            </label>
                            <p class="text-capitalize">{{Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-clock"></i>
                                <span>
                               Chuyến đi {{ $total['total_time'] }} dành cho {{ $booking['number_of_adults'] + $booking['number_of_children'] }} người
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-door-open"></i>
                                <span>
                               Số lượng phòng: <strong class="text-warning">{{ $total['total_room'] }} phòng</strong>
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-regular fa-money-bill-1"></i>
                                <span>
                              Tổng chi phí: <strong class="text-warning">{{ number_format($total['total_price'], 0, ',', '.') }} VND</strong>
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-cash-register"></i>
                                <span>
                              Phương thức thanh toán: <strong
                                        class="text-warning">{{ PaymentType::getValue($booking['payment_type']) }}</strong>
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-money-bill-transfer"></i>
                                <span>
                               Đã thanh toán: <strong class="text-success">{{ number_format($booking['deposit'], 0, ',', '.') }} VND</strong>
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                <span>
                               Cần thanh toán: <strong class="text-danger"> {{ number_format($total['total_price'] - $booking['deposit'], 0, ',', '.' ) }} VND</strong>
                           </span>
                            </label>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-invoice"></i>
                                <span>
                               Trạng thái:
                                 @if(in_array($booking['status'], BookingStatus::getAwaitingBooking()))
                                        <strong style="color: #ff9100">
                                        {{ BookingStatus::getValue($booking['status']) }}
                                    </strong>
                                    @elseif(in_array($booking['status'], BookingStatus::getConfirmedBooking()))
                                        <strong style="color: #139b65">
                                        {{ BookingStatus::getValue($booking['status']) }}
                                     </strong>
                                    @else
                                        <strong style="color: orangered">
                                        {{ BookingStatus::getValue($booking['status']) }}
                                    </strong>
                                    @endif
                           </span>
                            </label>
                        </div>
                        @if($booking['note'])
                            <div class="col-md-12 mb-2">
                                <label>
                                    <i class="fa-solid fa-file-contract"></i>
                                    Ghi chú: <br>
                                    <span class="text-secondary">
                                        {{ $booking['note'] }}
                                    </span>
                                </label>
                            </div>
                        @endif
                        @if($booking['refuse_reason'])
                            <div class="col-md-12 mb-2">
                                <label>
                                    <i class="fa-solid fa-clipboard"></i>
                                    Lý do hủy:<br>
                                    <span class="text-danger">
                                        {{ $booking['refuse_reason'] }}
                                    </span>
                                </label>
                            </div>
                        @endif
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                @if(!in_array($booking['status'], array_merge(BookingStatus::getDeActiveBooking(), [BookingStatus::Completed['key']])))
                                    <div class="col-md-4 m-auto text-center">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuseModal">
                                            <i class="fa-solid fa-ban"></i>
                                            Từ chối
                                        </button>
                                        <form action="{{route('admin.booking.refuse', $booking)}}" class="modal fade"
                                              id="refuseModal" tabindex="-1" role="dialog" aria-hidden="true"
                                              aria-labelledby="exampleModalLabel" method="POST">
                                            @csrf
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Từ chối đơn đặt</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>Vui lòng nhập lý do hủy</h5>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason">
                                                                </div>
                                                            </div>
                                                            <input type="text" class="form-control" name="reason" placeholder="Lý do khác...">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách hàng muốn hủy">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách hàng muốn hủy</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách muốn thay đổi thời gian đặt">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách muốn thay đổi thời gian đặt</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách muốn thay đổi cách thanh toán">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách muốn thay đổi cách thanh toán</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Khách chưa hoàn tất thanh toán">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Khách chưa hoàn tất thanh toán</div>
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <input type="radio" name="reason" value="Hết phòng">
                                                                </div>
                                                            </div>
                                                            <div class="form-control text-left">Hết phòng</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                @if($booking['status'] == BookingStatus::AwaitingConfirm['key'])
                                    <div class="col-md-4 m-auto text-center">
                                        <a class="btn btn-primary">
                                            <i class="fa-regular fa-circle-check"></i>
                                            Xác nhận
                                        </a>
                                    </div>
                                @endif
                                @if(in_array($booking['status'], [BookingStatus::Confirmed['key'], BookingStatus::Approved['key']]) )
                                    <div class="col-md-8">
                                        @livewire('booking.checkin-checkout', [
                                        'booking' => $booking
                                    ])
                                    </div>
                                @endif
                                    @if($booking['status'] == BookingStatus::Completed['key'])
                                        <div class="col-md-4 m-auto text-center">
                                            <a class="btn btn-warning text-white">
                                                <i class="fa-regular fa-star-half-stroke"></i>
                                                Xem đánh giá
                                            </a>
                                        </div>
                                        <div class="col-md-4 m-auto text-center">
                                            <a class="btn btn-success text-white">
                                                <i class="fa-solid fa-file-invoice-dollar"></i>
                                                In hóa đơn
                                            </a>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
