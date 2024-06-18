@php
    use App\Enums\Room\RoomStatus;
    use App\Enums\Room\PriceType;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingType;
@endphp
@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center p-3 mb-3">{{$title}}</h1>
            </div>

            @livewire('booking.create-form', [
                'branches' => $branches,
                'roomTypes' => $roomTypes,
            ])
            <form action="{{ route('admin.booking.store') }}" method="POST">
                @csrf
                <input type="hidden" id="checkin" name="checkin" value="{{ request()->get('checkin') }}">
                <input type="hidden" id="checkout" name="checkout" value="{{ request()->get('checkout') }}">
                <div class="col-md-12 p-0 border">
                    <div class="col-md-12 border p-1 px-0 bg-secondary">
                        <h4 class="text-center text-capitalize">Danh sách phòng</h4>
                    </div>
                    <div class="col-md-12 p-0 table-responsive" style="max-height: 55vh">
                        <table class="table table-bordered table-striped table-hover"
                               style="min-width: 100%; width: max-content">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên phòng</th>
                                <th scope="col">Loại phòng</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Bảng giá</th>
                                <th scope="col">Số giường</th>
                                <th scope="col">Sức chứa</th>
                                <th>&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <th scope="row">{{ $room['room']['id'] }}</th>
                                    <td>{{ $room['room']['name'] }}</td>
                                    <td>{{ $room['room']['roomType']['name'] }}</td>
                                    <td>{{ RoomStatus::getValue($room['room']['status']) }}</td>
                                    <td>
                                        @foreach($room['room']['roomType']['roomPrices'] as $price)
                                            @if($price['type_price'] == PriceType::ListedHourPrice['value'])
                                                <li>
                                                    {{ PriceType::ListedHourPrice['text'] . ': ' }}
                                                    <p class="text-danger m-0">
                                                        {{ number_format($price['price'], 0, ',', '.') }}
                                                        VND/phòng/{{ PriceType::ListedDayPrice['type'] }}
                                                    </p>
                                                </li>
                                            @elseif($price['type_price'] == PriceType::ListedDayPrice['value'])
                                                <li>
                                                    {{ PriceType::ListedDayPrice['text'] .': ' }}
                                                    <p class="text-danger m-0">
                                                        {{ number_format($price['price'], 0, ',', '.') }}
                                                        VND/phòng/{{PriceType::ListedDayPrice['type']}}
                                                    </p>
                                                </li>
                                            @elseif($price['type_price'] == PriceType::First2Hours['value'])
                                                <li>
                                                    {{ PriceType::First2Hours['text'] .': '}}
                                                    <p class="text-danger m-0">
                                                        {{ number_format($price['price'], 0, ',', '.') }}
                                                        VND/phòng/{{ PriceType::First2Hours['type']}}
                                                    </p>
                                                </li>
                                            @elseif($price['type_price'] == PriceType::EarlyCheckIn['value'])
                                                <li>
                                                    {{ PriceType::EarlyCheckIn['text'] .': '}}
                                                    <p class="text-danger m-0">
                                                        {{ number_format($price['price'], 0, ',', '.') }}
                                                        VND/phòng/{{ PriceType::EarlyCheckIn['type']}}
                                                    </p>
                                                </li>
                                            @elseif($price['type_price'] == PriceType::LateCheckOut['value'])
                                                <li>
                                                    {{ PriceType::LateCheckOut['text'] .': '}}
                                                    <p class="text-danger m-0">
                                                        {{ number_format($price['price'], 0, ',', '.') }}
                                                        VND/phòng/ {{ PriceType::LateCheckOut['type']}}
                                                    </p>
                                                </li>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <p class="m-0">{{ $room['adult_capacity'] }} người lớn
                                            và {{ $room['children_capacity'] }} trẻ em</p>
                                    </td>
                                    <td>
                                        <div class="form-check m-0 justify-content-center">
                                            <input class="form-check-input room-check" name="rooms[]" type="checkbox"
                                                   value="{{ $room['room']['id'] }}"
                                                   data-id="{{ $room['room']['id'] }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 my-2 text-right">
                        <h2 class="text-success">Tổng
                            <span id="total-room">0</span> phòng | <span id="total_price">0</span> VND
                        </h2>
                    </div>
                </div>
                <div class="col-md-12 mt-3 border">
                    <div class="row">
                        <h4 class="col-md-12 bg-secondary p-1 text-center text-capitalize">Thông tin người nhận
                            phòng</h4>
                        <div class="col-md-12 m-auto py-2">
                            <div class="row">
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Khách hàng</span>
                                    </div>
                                    <select class="form-control selectpicker" name="user_id" data-live-search="true"
                                            id="userSelect" data-style="bg-white border border-left-0">
                                        <option value="">Khách vãng lai</option>
                                        @foreach($users as $user)
                                            <option
                                                {{ old('user_id') == $user['id'] ? 'selected' : '' }} value={{ $user['id'] }}>
                                                {{ $user->customer?->name }}:
                                                {{ $user['phone'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 input-group mb-3">
                                    @error('phone')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số điện thoại</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="phone" id="phone" value="{{ old('phone') }}" required>
                                </div>

                                <div class="col-md-6 input-group mb-3">
                                    @error('name')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Họ tên</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="name" id="name" value="{{ old('name') }}" required>
                                </div>

                                <div class="col-md-6 input-group mb-3">
                                    @error('country')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Quốc tịch</span>
                                    </div>
                                    <input type="text" class=" customer-info form-control col-md-7"
                                           name="country" id="country" value="{{ old('country') }}" required>
                                </div>

                                <div class="col-md-6 input-group mb-3">
                                    @error('citizen_id')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số CCCD</span>
                                    </div>
                                    <input type="text" class="customer-info form-control col-md-7"
                                           name="citizen_id" id="citizen_id" value="{{ old('citizen_id') }}" required>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Giới tính</span>
                                    </div>
                                    <select class="form-select" name="gender" id="gender">
                                        @foreach(UserGender::asArray() as $gender)
                                            <option
                                                {{ old('gender') == $gender ? 'selected' : '' }} value={{ $gender }}>
                                                {{ $gender == UserGender::Male ? 'Nam' : 'Nữ' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    @error('deposit')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đã thanh toán (VND)</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="deposit" id="deposit"
                                           min="0" value="{{ old('deposit') ?? 0 }}" required>
                                </div>
                                <div class="col-md-6 input-group mb-3">
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
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đặt phòng qua</span>
                                    </div>
                                    <select class="form-select" name="type"
                                            data-style="bg-white border border-left-0">
                                        @foreach(BookingType::createTypeForAdmin() as $type)
                                            <option {{ old('type') == $type ? 'selected' : '' }} value={{ $type }}>
                                                @php
                                                    $typeName = match ($type) {
                                                     BookingType::OnSociety => 'Mạng xã hội',
                                                     BookingType::OffLine => 'Tại quầy lễ tân'
                                                    };
                                                    echo $typeName;
                                                @endphp
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Đặt phòng cho</span>
                                    </div>
                                    <select class="form-select" name="for_relative"
                                            data-style="bg-white border border-left-0">
                                        <option {{ old('for_relative') == "0" ? 'selected' : '' }} value="0">
                                            Chính chủ
                                        </option>
                                        <option {{ old('for_relative') == "0" ? 'selected' : '' }} value="1">
                                            Người thân
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-6 input-group mb-3">
                                    @error('adults')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số người lớn</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="adults" min="1"
                                           value="{{ old('adults') ?? 1 }}" required>
                                </div>
                                @error('children')
                                <div class="error">{{ $message }}</div>
                                @enderror
                                <div class="col-md-6 input-group mb-3">
                                    <div class="input-group-prepend col-md-5 p-0">
                                        <span class="input-group-text w-100">Số trẻ em</span>
                                    </div>
                                    <input type="number" class="form-control col-md-7" name="children"
                                           value="{{ old('children') ?? 0}}" required>
                                </div>


                                <div class="col-md-12 input-group mb-3">
                                    @error('note')
                                    <div class="error">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-prepend col-md-2 p-0">
                                        <span class="input-group-text w-100">Ghi chú</span>
                                    </div>
                                    <textarea name="note" cols="1" rows="2" class="form-control col-md-10">
                                        {{ old('note') }}
                                </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center py-4">
                    <button type="submit" id="submit-btn" class="btn btn-success" disabled>Đặt phòng</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            const checkin = $('#checkin').val();
            const checkout = $('#checkout').val();
            let total_room = 0;
            let total_price = 0;
            // handle sự kiện chọn phòng
            $('.room-check').on('change', function () {
                const roomId = $(this).data('id'); // Lấy room_id từ data-room-id của checkbox
                const isChecked = $(this).is(':checked'); // Kiểm tra trạng thái của checkbox
                // Gửi AJAX request
                $.ajax({
                    url: '{{ route("admin.booking.choose-room") }}', // URL để cập nhật trạng thái
                    type: 'POST',
                    data: {
                        room_id: roomId,
                        check_in: checkin,
                        check_out: checkout,
                        _token: '{{ csrf_token() }}' // Token CSRF (nếu cần)
                    },
                    success: function (response) {
                        if (isChecked) {
                            total_room++;
                            total_price += response.total_price_1_room;
                        } else {
                            total_room--;
                            total_price -= response.total_price_1_room
                        }
                        $("#total-room").text(total_room.toString());
                        $("#total_price").text(total_price.toLocaleString());
                        if (total_room > 0) {
                            $("#submit-btn").removeAttr("disabled");
                            $('#deposit').attr("max", total_price);
                        } else {
                            $("#submit-btn").attr("disabled", true);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Xử lý lỗi (nếu có)
                        const event = new CustomEvent('show-alert', {
                            detail: {
                                icon: status,
                                title: error,
                                text: 'Vui lòng load lại trang.'
                            }
                        });
                        window.dispatchEvent(event);
                    }
                });
            });
            // handle sự kiện chọn user customer
            $('#userSelect').change(function () {
                const id = $(this).val();
                if (id === '') {
                    // Reset các trường input của form khi id là null
                    resetForm();
                } else {
                    $.ajax({
                        url: '{{ route("admin.users.show", ':id') }}'.replace(':id', id),
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            // Xử lý response từ server
                            $('#name').val(response.name);
                            $('#phone').val(response.phone);
                            $('#country').val(response.country);
                            $('#citizen_id').val(response.citizen_id);
                            $('#gender').val(response.gender);
                        },
                        error: function (xhr, status, error) {
                            // Xử lý lỗi nếu có
                            console.error(error);
                            // Reset các trường input của form khi có lỗi
                            resetForm();
                        }
                    });
                }
            });
        });

        function resetForm() {
            // Lấy tất cả các phần tử class chứa thông tin khách hàng
            var formElements = $('.customer-info');

            // Duyệt qua từng phần tử và reset giá trị
            formElements.each(function () {
                $(this).val('');
            });
        }
    </script>
@endpush
