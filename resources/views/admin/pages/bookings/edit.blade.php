@php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
@endphp
@extends('admin.layouts.main')

@section('content')
    <h1 class="text-center p-3">{{$title}}</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
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
                              Phương thức thanh toán: <strong class="text-warning">{{ PaymentType::getValue($booking['payment_type']) }}</strong>
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
                    @if($booking['note'])
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-contract"></i>
                                <span>
                               Ghi chú:
                                 {{ $booking['note'] }}
                           </span>
                            </label>
                        </div>
                    @endif
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
                    @if($booking['refuse_reason'])
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-invoice"></i>
                                <span>
                              Lý do hủy:
                                 {{ $booking['refuse_reason'] }}
                           </span>
                            </label>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
