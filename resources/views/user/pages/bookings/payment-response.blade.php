@include('user.layouts.header')
    <div class="container mt-5 text-center">
        <img src="{{ asset('images/vn_pay.png') }}">
       @if($data['status'] == 'success')
            <h1 class="text-success my-5">{{ $data['title'] }}</h1>
            <h3 class="mb-3">
                <strong>Mã giao dịch: </strong>
                <span class="text-info" style="text-decoration: underline">{{ $data['code'] }} </span>
            </h3>
           <h3>
               <strong>Số tiền: </strong>
                <span class="text-success"> {{ number_format($data['amount'],0,',','.') }} VND</span>
           </h3>
           <a class="btn btn-primary mt-3 text-white" href="{{ route('booking.show', $booking_id) }}">Xem chi tiết đơn đặt</a>
        @else
            <h1 class="text-danger my-5">{{ $data['title'] }}</h1>
            <h3 class="mb-3">
                <strong>Mã lỗi: </strong>
                <span class="text-secondary">{{ $data['code'] }} </span>
            </h3>
            <a class="btn btn-primary text-white" href="{{ route('homepage') }}">Quay lại trang chủ</a>
       @endif
    </div>
@include('user.layouts.footer')
