@php
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
    use Carbon\Carbon;
    use App\Enums\Booking\BookingStatus;
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
                                <div class="col-md-12 d-flex">
                                   <div class="col-md-6">
                                       <p><i class="fa-solid fa-phone-volume"></i>
                                           <strong>Hotline:</strong>
                                           {{ $branch['phone'] }}
                                       </p>
                                       <p><i class="fa-solid fa-map-location-dot"></i>
                                           <strong>{{__('Địa chỉ')}}:</strong>
                                           {{ $branch['address'] }}, {{ $branch['city'] }}
                                       </p>
                                   </div>
                                    <div class="col-md-6 text-left">
                                        <!-- -->
                                        @if($booking['payment_type'] != PaymentType::Cash
                                            && $booking['status'] == BookingStatus::AwaitingPayment['key'])
                                            <p class="text-danger bg-white p-2">
                                                *{{__('Lưu ý: Hệ thống sẽ tự động hủy đơn lúc')}} <br>
                                                <strong>{{' ' .$booking->created_at->addMinutes(15) . ' ' }}</strong>
                                                {{__('nếu bạn vẫn chưa hoàn thành thanh toán')}}
                                            </p>
                                            @endif
                                    </div>
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
                                            <h2 class="mb-5 text-uppercase">{{__('Phòng')}} <span
                                                    class="ms-5 m-md-0">{{ $room['room_type'] }}</span>
                                                <span
                                                    class="text-lowercase text-secondary">x{{ count($room['room_ids']) }}</span>
                                            </h2>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="row">
                                                <div class="col-md-6 border-bottom border-warning">
                                                    <h5><i class="fa-solid fa-bed"></i> {{__('Số giường')}}</h5>
                                                    <ul>
                                                        @if($room['single_bed'] > 0)
                                                            <li>{{__('Giường đơn')}}: x {{ $room['single_bed'] }}</li>
                                                        @endif

                                                        @if($room['double_bed'] > 0)
                                                            <li>{{__('Giường đôi')}}: x {{ $room['double_bed'] }}</li>
                                                        @endif

                                                        @if($room['twin_bed'] > 0)
                                                            <li>{{__('Giường cặp')}}: x {{ $room['twin_bed'] }}</li>
                                                        @endif

                                                        @if($room['family_bed'] > 0)
                                                            <li>{{__('Giường gia đình')}}: x {{ $room['family_bed'] }}</li>
                                                        @endif
                                                    </ul>
                                                    <h5><i class="fa-solid fa-bell-concierge"></i> {{__('Dịch vụ có sẵn')}}</h5>
                                                    <ul>
                                                        @foreach($room['services']['provide'] as $service)
                                                            <li>
                                                                <p>
                                                                    {{ $service['service_name'] }}
                                                                    @if($service['discount'] == 100)
                                                                        <span class="text-danger"> ({{__('miễn phí')}}) </span>
                                                                    @else
                                                                        <span class="text-info">{{ number_format($service['price'], 0, ',', '.') }} VND/{{__('người')}}</span>
                                                                        <span class="text-danger">(-{{ $service['discount'] }}%)</span>
                                                                    @endif
                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="col-md-6 border-bottom border-warning pt-3 p-md-0">
                                                    <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                                        {{__('Giá phòng')}}:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        {{ number_format($room['total_price_1_room'], 0, ',', '.')}}
                                                        VND/{{__('phòng')}}
                                                    </p>
                                                    <h5><i class="fa-solid fa-money-bill-wave"></i>
                                                        {{__('Thành tiền')}}:
                                                    </h5>
                                                    <p class="text-info text-center" style="font-size: large ">
                                                        {{ number_format(count($room['room_ids']) * $room['total_price_1_room'], 0, ',', '.')}}
                                                        VND/{{count($room['room_ids'])}} {{__('phòng')}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0">
                <div class="col-12 m-auto py-4 rounded text-dark bg-light border border-warning">
                    <h5 class="text-center text-secondary mb-3 text-uppercase"> {{__('Thông tin chuyến đi')}}</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-user"></i>
                            <span>{{ $booking['gender'] == UserGender::Male ? __('Anh') : __('Chị') }}: {{ $booking['name'] }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-mobile-screen-button"></i>
                            <span>{{__('Số điện thoại')}}: {{ substr_replace($booking['phone'], str_repeat('*', 4), 3, 3) }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-passport"></i>
                            <span>{{__('Quốc tịch')}}: {{ $booking['country'] }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-id-card"></i>
                            <span>{{__('CCCD')}}/Visa: {{ substr_replace($booking['citizen_id'], str_repeat('*', 9), 0, 9) }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{__('Địa điểm')}}: {{__('Khách sạn')}} {{ $branch['name'] }} - {{ $branch['city'] }}</span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-restroom"></i>
                            <span>{{__('Số người')}}: {{ $booking['number_of_adults'] . ' ' . __('người lớn')}}  &
                                {{ $booking['number_of_children'] . ' ' . __('trẻ em')}} </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage"></i>
                            <span>{{__('Ngày nhận phòng')}}: </span>
                        </label>
                        <p class="text-capitalize">{{ Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                            <span>{{__('Ngày trả phòng')}}: </span>
                        </label>
                        <p class="text-capitalize">{{Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-calendar-check"></i>
                            <span>{{__('Ngày đặt đơn')}}: </span>
                        </label>
                        <p class="text-capitalize">{{Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                {{ __('Chuyến đi') . ' '. $total['total_time'] . ' ' . __('cho') . ' '. $booking['number_of_adults'] + $booking['number_of_children'] . ' '. __('người') }}
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-door-open"></i>
                            <span>
                               {{__('Số lượng phòng')}}: <strong class="text-warning">{{ $total['total_room'] }} {{__('phòng')}}</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-regular fa-money-bill-1"></i>
                            <span>
                              {{__('Tổng chi phí')}}: <strong class="text-warning">{{ number_format($total['total_price'], 0, ',', '.') }} VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-cash-register"></i>
                            <span>
                              {{__('Phương thức thanh toán')}}: <strong class="text-warning">{{ __(PaymentType::getValue($booking['payment_type'])) }}</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-money-bill-transfer"></i>
                            <span>
                               {{__('Đã thanh toán')}}: <strong class="text-success">{{ number_format($booking['deposit'], 0, ',', '.') }} VND</strong>
                           </span>
                        </label>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                            <span>
                               {{__('Cần thanh toán')}}: <strong class="text-danger"> {{ number_format($total['total_price'] - $booking['deposit'], 0, ',', '.' ) }} VND</strong>
                           </span>
                        </label>
                    </div>
                    @if($booking['note'])
                        <div class="col-md-12 mb-2">
                            <label>
                                <i class="fa-solid fa-file-contract"></i>
                                <span>
                               {{__('Ghi chú')}}:
                                 {{ $booking['note'] }}
                           </span>
                            </label>
                        </div>
                    @endif
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>
                               {{__('Trạng thái')}}:
                                 @if(in_array($booking['status'], BookingStatus::getAwaitingBooking()))
                                    <strong style="color: #ff9100">
                                        {{ __(BookingStatus::getValue($booking['status'])) }}
                                    </strong>
                                @elseif(in_array($booking['status'], BookingStatus::getConfirmedBooking()))
                                    <strong style="color: #139b65">
                                        {{ __(BookingStatus::getValue($booking['status'])) }}
                                     </strong>
                                @else
                                    <strong style="color: orangered">
                                        {{ __(BookingStatus::getValue($booking['status'])) }}
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
                              {{__('Lý do hủy')}}:
                                 {{ $booking['refuse_reason'] }}
                           </span>
                            </label>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="row justify-content-around">
                            @if(in_array($booking['status'], BookingStatus::getAwaitingBooking()))
                                <button id="cancel-booking" class="col-md-5 btn btn-outline-danger" value="{{ $booking['id'] }}">
                                    <i class="fa-solid fa-ban"></i>
                                    {{__('Hủy đơn')}}
                                </button>
                            @endif

                            @if($booking['status'] == BookingStatus::AwaitingPayment['key'])
                                <a class="col-md-5 btn btn-outline-warning" href="{{ route('booking.payment-request', base64_encode($booking['id'])) }}">
                                    <i class="fa-solid fa-wallet"></i>
                                    {{__('Thanh toán ngay')}}
                                </a>
                            @endif

                            @if($booking['status'] == BookingStatus::Completed['key'])
                                <a href="" class="col-md-5 btn btn-outline-success">
                                    <i class="fa-solid fa-star"></i>
                                    {{__('Đánh giá')}}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script>
        $(document).ready(function() {
            $('#cancel-booking').click(function() {
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
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Refresh the page
                                        location.reload();
                                    }
                                })
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

