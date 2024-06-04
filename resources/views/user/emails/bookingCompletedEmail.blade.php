@include('user.layouts.header')
<div class="container mt-5 bg-light">
    <div class="col-12 position-relative">
        <div class="position-absolute" style="bottom: 30px; right: 50px">
            <img src="{{ asset('images/paid.png') }}">
        </div>
        <div class="row">
            <div class="col-12 border-bottom border-white bg-warning">
               <div class="col-4">
                   <img src="{{ asset('images/logo.png') }}" class="w-100">
               </div>
                <div class="col-8 text-right text-dark">
                   <p> {{ $booking['created_at']->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                    <p>Mã đơn hàng: {{ $booking['id'] }}</p>
                </div>
            </div>
            <div class="col-12 text-dark">
                <p>Kính gửi quý khách hàng {{ $userName }},</p>
                <p>Cảm ơn bạn đã tin tưởng và đặt phòng tại V.V.C Booking！</p>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">Thông tin đơn hàng</th>
                    </tr>
                    </thead>
                    <tbody>
                   @foreach($roomInfo['rooms'] as $room)
                       <tr>
                           <th scope="row"><strong class="text-capitalize"> {{ $room['room_type'] }} </strong></th>
                           <td>x{{ count($room['room_ids']) }}</td>
                           <td>{{ number_format($room['total_price_1_room'], 0, ',', '.') }} VND</td>
                       </tr>
                   @endforeach
                    <tr>
                        <th>Tổng:</th>
                        <td>{{ $roomInfo['total_amount']['total_room'] }} phòng</td>
                        <td>{{ number_format($roomInfo['total_amount']['total_price'],0, ',', '.') }} VND</td>
                    </tr>
                   <tr>
                       <th>Phương thức thanh toán:</th>
                       <td>{{ $booking['payment_type'] }} </td>
                       <td>-{{ number_format($booking['deposit'], 0, ',', '.') }} VND</td>
                   </tr>
                   <tr>
                       <th colspan="3" class="text-right">{{ number_format($roomInfo['total_amount']['total_price'] - $booking['deposit'], 0, ',', '.') }} VND</th>
                   </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <i class="fa-solid fa-location-dot"></i> Địa điểm:
                        <h3 class="text-capitalize">{{ $roomInfo['branch']['name'] }}</h3>
                        <p class="text-capitalize">{{ $roomInfo['branch']['address'] . ', ' .  $roomInfo['branch']['city'] }}</p>
                    </div>
                    <div class="col-12">
                        <i class="fa-regular fa-calendar-days"></i> Thời gian:
                        <p>
                            <span> {{ $booking['booking_checkin']->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                            -
                            <span> {{ $booking['booking_checkout']->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @if($booking['status'] == \App\Enums\Booking\BookingStatus::Refuse['key'])
                <div class="col-12">
                    <h2>Thật tiếc khi phải thông báo đơn hàng của bạn đã bị hủy bởi hệ thống với lý do:
                        <span class="text-danger"> {{ $booking['refuse_reason'] }}</span>
                    </h2>
                    <p>Vui lòng chờ ít phút, chúng tôi sẽ gọi điện tư vấn cho bạn hoặc bạn có thể đặt lại đơn khác theo
                     <a href="{{ route('search', $roomInfo['condition']) }}" style="text-decoration: underline; color: blue">đường dẫn</a>
                    </p>
                    <p class="text-danger">Số tiền đã thanh toán trước (nếu có) của đơn hàng sẽ được hoàn trả sau 24h làm việc.</p>
                </div>
            @else
                <div class="col-12">
                    @if($booking['for_relative'])
                        <p class="text-secondary">
                            Chúng tôi cũng sẽ gọi điện với anh/chị {{ $booking['name'] }} qua số điện thoại {{ $booking['phone'] }} để xác nhận lại đơn hàng.
                        </p>
                    @endif
                    <p class="text-danger">
                        *Lưu ý: Người đại diện nhận phòng cần mang theo thẻ căn cước, chứng minh thư, hộ chiếu... hoặc các giấy tờ tùy thân tương đương để làm thủ tục nhận phòng.
                    </p>
                    <p class="text-info">
                        Nếu có bất kì thắc mắc cần được tư vấn, vui lòng liên hệ qua số hotline:
                        <a href="tel:{{ $roomInfo['branch']['phone'] }}"> {{ $roomInfo['branch']['phone'] }} </a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@include('user.layouts.footer')
