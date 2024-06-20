@php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
@endphp
@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-11 mt-4 border mx-auto bg-white" id="invoice" style="font-family: 'DejaVu Sans';">
               <div class="col-md-8 mx-auto my-3" style="text-align: center">
                   <img src="{{ asset('images/logo.png') }}">
                   <h3 class="mt-5 mb-3" >CÔNG TY TNHH THƯƠNG MẠI VÀ DỊCH VỤ VVC</h3>
                   <h4 style="text-transform: capitalize; margin-bottom: 10px; font-weight: bolder">
                       {{ $booking['branch']['name'] }}
                       - {{ $booking['branch']['address'] . ', ' . $booking['branch']['city'] }}
                   </h4>
                   <h5 class="mt-3">Hóa Đơn Thanh Toán Dịch Vụ Đặt Phòng</h5>
               </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="text-transform: capitalize; margin: 0">
                                <strong>{{ $booking['booking']['gender'] ==  UserGender::Male ? 'Anh' : 'Chị'}}: </strong>
                                {{ $booking['booking']['name'] }}
                            </p>
                            <p style="text-transform: capitalize; margin: 0">
                               <strong>Mã đơn hàng:</strong>
                               {{ base64_encode($booking['booking']['id'])  }}
                           </p>
                            <p style="text-transform: capitalize; margin: 0">
                                <strong>Ngày đặt đơn: </strong>
                                <span style="text-transform: capitalize"> {{ $booking['booking']['created_at']->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                            </p>
                            <p style="text-transform: capitalize; margin: 0">
                                <strong>Ngày hẹn nhận phòng: </strong>
                                <span style="text-transform: capitalize"> {{ Carbon::parse($booking['booking']['booking_checkin'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                            </p>
                            <p style="text-transform: capitalize; margin: 0">
                                <strong>Ngày hẹn trả phòng: </strong>
                                <span style="text-transform: capitalize"> {{ Carbon::parse($booking['booking']['booking_checkout'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                            </p>
                            <p style="text-transform: capitalize; margin: 0">
                               <strong>Ngày in hóa đơn: </strong>
                               <span style="text-transform: capitalize"> {{ Carbon::now()->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                           </p>
                            <p style="text-transform: capitalize; margin: 0">
                                <strong>Nhân viên thu ngân: </strong>
                                <span style="text-transform: capitalize"> {{ auth()->guard('admins')->user()->name }}</span>
                            </p>
                        </div>
                        <div class="col-md-12 table-responsive mb-3" style="border: lightgrey solid 2px; padding: 0 0 10px; margin-top: 30px">
                            <table class=" table table-hover" style="width: max-content; min-width: 100%; text-align: center; page-break-inside: avoid;">
                                <thead class="thead-dark" style="background-color: #0f0f0f; color: whitesmoke">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Phòng</th>
                                    <th scope="col">Loại phòng</th>
                                    <th scope="col">Giá phòng</th>
                                    <th scope="col">Phụ phí</th>
                                    <th scope="col">Nhận|Trả phòng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking['rooms'] as $key=>$room)
                                        <tr style="background-color: whitesmoke">
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td class="text-capitalize">
                                                {{ $room['room_name'] }}
                                            </td>
                                            <td class="text-uppercase">
                                                {{ $room['room_type'] }}
                                            </td>
                                            <td class="text-uppercase">
                                                {{ number_format($room['price'], 0, ',' , '.') }} VND
                                            </td>
                                            <td>
                                                <ul class="p-1" style="text-align: left">
                                                    <li class="text-{{ $room['early_time'] > 0 ? 'danger' : 'primary'}}">
                                                        <strong>Checkin sớm({{ $room['early_time'] }} giờ): </strong> <br>
                                                        {{ number_format($room['early_fee'], 0, ',' , '.') }} VND
                                                    </li>
                                                    <li class="text-{{ $room['lately_time'] > 0 ? 'danger' : 'primary'}}">
                                                        <strong>Checkout muộn({{ $room['lately_time'] }} giờ):  </strong> <br>
                                                        {{ number_format($room['lately_fee'], 0, ',' , '.') }} VND
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="p-1" style="text-align: left">
                                                    <li>
                                                        <strong>Checkin: </strong><br>
                                                        <span class="text-capitalize" style="text-transform: capitalize">{{ Carbon::parse( $room['checkin_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY')  }}</span>
                                                    </li>
                                                    <li>
                                                        <strong>Checkout: </strong><br>
                                                        <span class="text-capitalize" style="text-transform: capitalize">{{ Carbon::parse( $room['checkout_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY')  }}</span>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td style="color: #0c84ff">
                                                <strong>{{ number_format($room['price'] + $room['early_fee'] + $room['lately_fee'], 0, ',', '.') }} VND</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th scope="row">TỔNG </th>
                                        <td colspan="4" class="text-capitalize" style="text-align: right">
                                            <strong>Thời gian thuê phòng:</strong>
                                            {{ $booking['total']['total_time'] }}
                                        </td>
                                        <td>
                                            <strong>Số lượng phòng:</strong>
                                            {{ $booking['total']['total_room'] }}
                                        </td>
                                        <td style="color: green">
                                            <strong>{{ number_format($booking['total']['total_cost'], 0 , ',', '.') }} VND</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="5" scope="row" style="text-align: left">Phương thức thanh toán: </th>
                                        <td class="text-capitalize">
                                            <strong style="color: darkorange">
                                                {{ PaymentType::getValue($booking['booking']['payment_type']) }}
                                            </strong>
                                        </td>
                                        <td style="color: darkorange">
                                            <strong>-{{ number_format($booking['booking']['deposit'], 0 , ',', '.') }} VND</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="6" scope="row" style="text-align: left">Cần thanh toán: </th>
                                        <td style="color: red">
                                            <strong>{{ number_format($booking['total']['total_cost'] - $booking['booking']['deposit'], 0 , ',', '.') }} VND</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-12 m-auto" style="text-align: center; margin-top: 30px">
                            <strong>Kính chào quý khách và hẹn gặp lại!!!</strong>
                            <p>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ qua hotline:  {{ $booking['branch']['phone'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mx-auto my-3 d-flex justify-content-around">
                <a class="btn btn-outline-info mr-4" href="{{ route('admin.booking.edit', $booking['booking']) }}">
                    <i class="fa-solid fa-angles-left"></i>
                    Quay lại
                </a>
                @if($booking['booking']['status'] == BookingStatus::Completed['key'])
                    <a class="btn btn-success" href="{{ route('admin.booking.invoice-create', $booking['booking']) }}">
                        <i class="fa-solid fa-print" id="print-invoice"></i>
                        In hóa đơn
                    </a>
                @else
                    <a class="btn btn-success" href="{{ route('admin.booking.complete', $booking['booking']) }}">
                        <i class="fa-solid fa-print"></i>
                        Hoàn thành và in hóa đơn
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

