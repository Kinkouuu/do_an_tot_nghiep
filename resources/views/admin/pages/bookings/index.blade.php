@php
    use App\Enums\Booking\BookingFilterColumns;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\BookingStatus;
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase">{{$title}}</h4>
        </div>
        <form class="col-md-8 d-flex justify-content-around align-items-center" method="GET">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <span class="mr-2">Sắp xếp theo: </span>
                    <select class="form-control w-25" name="by">
                        @foreach(BookingFilterColumns::asArray() as $bookingFilter)
                            <option value="{{$bookingFilter['key']}}" {{ (request()->input('by') == $bookingFilter['key']) ? 'selected' : '' }}>{{ $bookingFilter['value'] }}</option>
                        @endforeach
                    </select>
                    <select class="form-control w-25" name="sort">
                        <option value="0" {{ (request()->input('sort') == '0') ? 'selected' : '' }}>Tăng dần</option>
                        <option value="1" {{ (request()->input('sort') == '1') ? 'selected' : '' }}> Giảm dần</option>
                    </select>
                    <button type="submit" class="btn btn-info">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                </div>
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <span class="mr-2">Trạng thái: </span>
                        @foreach(BookingStatus::asArray() as $key=>$status)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status[]"
                                       value="{{ $status['key'] }}" id="defaultCheck{{$key}}"
                                    {{ request()->get('status') === null || in_array($status['key'], request()->get('status')) ? 'checked' : ''  }}>
                                <label class="form-check-label" for="defaultCheck{{$key}}">
                                    {{ $status['value'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive" style="min-height: 75vh">
        <table class="table table-bordered table-striped mx-1" style="width: max-content">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Chi nhánh</th>
                <th scope="col">Người đặt</th>
                <th scope="col">Họ tên</th>
                <th scope="col">SDT</th>
                <th scope="col">Quốc tịch</th>
                <th scope="col">Loại</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Tổng</th>
                <th scope="col">PT Thanh toán</th>
                <th scope="col">Cần thanh toán</th>
                <th scope="col">Ngày đặt</th>
                <th scope="col">Trạng thái</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <th scope="row">
                        {{ $booking['booking_id'] }}
                        <br>
                        <span style="font-weight: lighter">({{ base64_encode($booking['booking_id']) }})</span>
                    </th>
                    <td class="text-capitalize">{{ $booking['branch_name'] }}</td>
                    @if(isset($booking['user']['customer']))
                        <td class="text-capitalize">
                            <a style="text-decoration: underline" class="text-info" href="{{ route('admin.users.edit', $booking['user']['id']) }}">{{ $booking['user']['customer']['name'] }}</a>
                        </td>
                    @else
                        <td class="text-black">Khách vãng lai</td>
                    @endif
                    <td class="text-capitalize">{{ $booking['gender'] == UserGender::Male ? 'Anh' : 'Chị'}}: {{ $booking['name'] }}</td>
                    <td>{{ $booking['phone'] }}</td>
                    <td class="text-capitalize">{{ $booking['country'] }}</td>
                    <td class="text-capitalize">{{$booking['type']}}</td>
                    <td class="text-capitalize">
                        check-in: {{ Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}
                        <br>
                        check-out: {{ Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}
                    </td>
                    <td class="text-capitalize">
                        Thời gian: <span class="text-info">{{ $booking['total_time'] }}</span>
                        <br>
                        Số phòng: <span class="text-info">{{ $booking['total_room'] }} phòng</span>
                        <br>
                        Chi phí: <span class="text-info">{{ number_format($booking['total_price'], 0, ',', '.') }} VND</span>
                    </td>
                    <td class="text-capitalize">
                        <span class="text-info">{{ $booking['payment_type'] }}</span>
                        <br>
                        <span class="text-danger"> - {{ number_format($booking['deposit'], 0, ',', '.') }} VND</span>
                    </td>
                    <td>
                        <span class="text-warning">{{ number_format($booking['total_price'] - $booking['deposit'], 0, ',', '.') }} VND</span>
                    </td>
                    <td>
                        <span class="text-capitalize"> {{ Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY') }}</span>
                    </td>
                    <td>
                        @php
                            foreach (BookingStatus::asArray() as $bookingStatus) {
                                if($booking['status'] == $bookingStatus['key']) {
                                     $status = $bookingStatus['value'];
                                    break;
                                } else {
                                    $status = null;
                                }
                            }
                        @endphp
                        <span>
                            {{ $status }}
                        </span>
                    </td>
                    <td>
                        <a type="button" class="btn btn-primary mb-1" href="{{ route('admin.booking.edit', $booking['booking_id']) }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        @if($booking['status'] == BookingStatus::Completed['key'])
                            <a type="button" class="btn btn-info mb-1" href="{{ route('admin.booking.show', $booking['booking_id']) }}">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </a>
                            <a type="button" class="btn btn-success mb-1" href="{{ route('admin.feedback.feed-back', $booking['booking_id']) }}">
                                <i class="fa-regular fa-star-half-stroke"></i>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $bookings->links('pagination::bootstrap-4') !!}
@endsection
