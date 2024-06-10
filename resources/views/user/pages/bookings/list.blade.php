@php
    use Carbon\Carbon;
    use App\Enums\Booking\BookingStatus;
    use App\Enums\Booking\PaymentType;
@endphp
@extends('user.layouts.main')

@section('content')
    <div class="container-fluid">
        @if(is_null($booking_rooms))
            <img src="{{ asset('images/empty-cart.webp') }}" class="w-100">
            <h1 class="mb-3 text-center">Úi! Bạn chưa có đơn đặt phòng nào.</h1>
            <a href="{{ route('homepage') }}" class="btn btn-primary text-center">Đặt phòng ngay</a>
        @else
            <div class="row mt-3">
                <div class="col-md-11 mx-auto mt-4 ">
                    <div class="row">

                        @foreach($booking_rooms as $bookingRoom)
                            <div class="col-md-12 my-2 py-3" style="background-color: #f1e6b2">
                                <div class="row">
                                    <div class="col-md-4 m-auto">
                                        <img class="rounded w-100" src="{{ $bookingRoom['branch']['avatar'] }}">
                                        <h5 class="text-center text-danger font-italic font-weight-bold mt-2">
                                            {{ $bookingRoom['branch']['name'] . ' - ' . $bookingRoom['branch']['city']}}
                                        </h5>
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-location-arrow"></i>
                                                <p class="m-0 px-2">Địa chỉ: </p>
                                            </div>
                                            <p class="text-info m-0">{{ $bookingRoom['branch']['address'] . ', ' . $bookingRoom['branch']['city'] }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center">
                                                <i class="fa-solid fa-phone"></i>
                                                <p class="m-0 px-2">Hotline: </p>
                                                <a href="tel:{{ $bookingRoom['branch']['phone'] }}"
                                                   class="m-2 text-info">{{ $bookingRoom['branch']['phone'] }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-7">
                                                @foreach($bookingRoom['rooms'] as $room)
                                                    <div class="col-md-12 mb-3 p-0">
                                                        <a href="{{ route('room-type', base64_encode($room['room_type_id'])) }}"
                                                           data-toggle="tooltip"
                                                           data-placement="right" title="Xem chi tiết phòng">
                                                            x {{ count($room['room_ids']) }}
                                                            <strong class="text-capitalize text-black">
                                                                Phòng {{ $room['room_type'] }}</strong>
                                                            <i class="text-secondary fa-solid fa-circle-info"></i>
                                                        </a>
                                                        <div class="d-flex justify-content-around">
                                                            <div class="col-md-5 border-left border-warning p-0">
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
                                                                        <li>Giường gia đình:
                                                                            x {{ $room['family_bed'] }}</li>
                                                                    @endif
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-7 border-left border-warning">
                                                                <p class="text-black">
                                                                    Giá phòng:
                                                                    <span class="text-info">
                                                                {{ number_format($room['total_price_1_room'], 0, ',', '.') }} VND
                                                                 </span>
                                                                    <span
                                                                        class="text-secondary">x {{ count($room['room_ids']) }}</span>
                                                                    <br>
                                                                    <span class="text-danger" style="font-size: 12px">
                                                                    *Đây là giá của mỗi phòng được tính cho
                                                                    {{ $bookingRoom['total']['total_time'] }}
                                                                </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="col-md-12 justify-content-between border-top border-secondary pt-2">
                                                    <div class="row">
                                                        <strong class="col-md-3 p-0 text-dark">Tổng cộng:</strong>
                                                        <div class="col-md-9 text-dark row">
                                                            <p class="d-flex align-items-center">
                                                                <i class="fa-regular fa-clock"></i>
                                                                <strong class="px-2">Thời gian:
                                                                    <span
                                                                        class="text-success">{{ $bookingRoom['total']['total_time'] }}</span>
                                                                </strong>
                                                            </p>
                                                            <p class="d-flex align-items-center">
                                                                <i class="fa-solid fa-door-open"></i>
                                                                <strong class="px-2">Số phòng:
                                                                    <span class="text-success">{{ $bookingRoom['total']['total_room'] }} phòng</span>
                                                                </strong>
                                                            </p>
                                                            <p class="d-flex align-items-center">
                                                                <i class="fa-regular fa-money-bill-1"></i>
                                                                <strong class="px-2">Chi phí:
                                                                    <span class="text-success">{{ number_format($bookingRoom['total']['total_price'], 0, ',', '.')  }} VND</span>
                                                                </strong>
                                                            </p>
                                                            <p class="d-flex align-items-center">
                                                                <i class="fa-solid fa-money-bill-transfer"></i>
                                                                <strong class="px-2">Đã thanh toán:
                                                                    <span class="text-info">{{ number_format($bookingRoom['booking']['deposit'], 0, ',', '.')  }} VND</span>
                                                                </strong>
                                                            </p>
                                                            <p class="d-flex align-items-center">
                                                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                                                <strong class="px-2">Cần thanh toán:
                                                                    <span class="text-danger">{{ number_format($bookingRoom['total']['total_price'] - $bookingRoom['booking']['deposit'], 0, ',', '.')  }} VND</span>
                                                                </strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-user-group"></i>
                                                        <p class="m-0 px-2">Số người: </p>
                                                    </div>
                                                    <p class="text-info m-0 text-capitalize">
                                                        {{ $bookingRoom['booking']['number_of_adults'] }} người lớn và
                                                        {{ $bookingRoom['booking']['number_of_children'] }} trẻ em
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-calendar-day"></i>
                                                        <p class="m-0 px-2">Ngày nhận phòng: </p>
                                                    </div>
                                                    <p class="text-info m-0 text-capitalize">
                                                        {{ Carbon::parse($bookingRoom['booking']['booking_checkin'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-calendar-day"></i>
                                                        <p class="m-0 px-2">Ngày trả phòng: </p>
                                                    </div>
                                                    <p class="text-info m-0 text-capitalize">
                                                        {{ Carbon::parse($bookingRoom['booking']['booking_checkout'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-calendar-check"></i>
                                                        <p class="m-0 px-2">Ngày đặt đơn: </p>
                                                    </div>
                                                    <p class="text-info m-0 text-capitalize">
                                                        {{ Carbon::parse($bookingRoom['booking']['created_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-file-invoice"></i>
                                                                <p class="m-0 px-2">Trạng thái: </p>
                                                            </div>
                                                            @if(in_array($bookingRoom['booking']['status'], BookingStatus::getAwaitingBooking()))
                                                                <span style="color: #ff9100" id="status-{{$bookingRoom['booking']['id']}}">
                                                                    {{ BookingStatus::getValue($bookingRoom['booking']['status']) }}
                                                                </span>
                                                            @elseif(in_array($bookingRoom['booking']['status'], BookingStatus::getConfirmedBooking()))
                                                                <span style="color: #139b65">
                                                                    {{ BookingStatus::getValue($bookingRoom['booking']['status']) }}
                                                                </span>
                                                            @else
                                                                <span style="color: orangered">
                                                                    {{ BookingStatus::getValue($bookingRoom['booking']['status']) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa-solid fa-cash-register"></i>
                                                                <p class="m-0 px-2">Phương thức thanh toán: </p>
                                                            </div>
                                                            <span style="color: #06a1b6">
                                                                {{ PaymentType::getValue($bookingRoom['booking']['payment_type'])}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 mt-3 row mx-auto">
                                                    @if($bookingRoom['booking']['status'] == BookingStatus::AwaitingPayment['key'])
                                                        <button class="cancel btn btn-danger text-white mb-1 awaiting-booking-{{$bookingRoom['booking']['id']}}" value="{{ $bookingRoom['booking']['id'] }}">
                                                            <i class="fa-solid fa-ban"></i>
                                                            Tôi muốn hủy đơn
                                                        </button>
                                                        <a class="btn btn-warning text-white mb-1 awaiting-booking-{{$bookingRoom['booking']['id']}}" href="{{ route('booking.payment-request', base64_encode($bookingRoom['booking']['id'])) }}">
                                                            <i class="fa-solid fa-wallet"></i>
                                                            Thanh toán ngay
                                                        </a>
                                                    @elseif($bookingRoom['booking']['status'] == BookingStatus::AwaitingConfirm['key'])
                                                        <button class="cancel btn btn-danger text-white mb-1 awaiting-booking-{{$bookingRoom['booking']['id']}}" value="{{ $bookingRoom['booking']['id'] }}">
                                                            <i class="fa-solid fa-ban"></i>
                                                            Tôi muốn hủy đơn
                                                        </button>
                                                    @elseif($bookingRoom['booking']['status'] == BookingStatus::Completed['key'])
                                                        <a class="btn btn-success text-white mb-1" href="">
                                                            <i class="fa-solid fa-star"></i>
                                                            Đánh giá phòng
                                                        </a>
                                                    @endif
                                                        <a class="btn btn-info text-white" href="{{ route('booking.show', base64_encode($bookingRoom['booking']['id'])) }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                            Xem chi tiết
                                                        </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('script')

    <script>
        $(document).ready(function() {
            $('.cancel').click(function() {
                const id = $(this).val();
                    const url = '{{ route("booking.cancel", ':id') }}'.replace(':id', id);
                    Swal.fire({
                        title: 'Bạn chắc chắn muốn hủy?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hủy đơn',
                        cancelButtonText: 'Tiếp tục đặt phòng'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: response['title'],
                                        text: response['message'],
                                        icon: response['status']
                                    });
                                    $('.awaiting-booking-' + id).remove();
                                    $('#status-' + id).text('Đơn đã bị hủy');
                                    $('#status-' + id).css('color','orangered');
                                },
                                error: function (response) {
                                    Swal.fire({
                                        title: response['title'],
                                        text: response['message'],
                                        icon: response['status']
                                    })
                                }
                            });
                        }
                    })
                });
            });
    </script>
@endpush
