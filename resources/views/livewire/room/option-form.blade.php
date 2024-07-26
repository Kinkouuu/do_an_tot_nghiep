@php
    use App\Enums\Room\PriceType;
@endphp
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 mb-3 text-white"
                 style="background-image: url({{ asset($branch['avatar']) }}); background-repeat: no-repeat; background-size: cover">
                <h3 class="text-light"
                    style="font-size: xxx-large; font-style: oblique">{{ $branch['name'] }}</h3>
                <p><i class="fa-solid fa-phone-volume"></i>
                    <strong>{{__('Gọi cho chúng tôi để được tư vấn')}}:</strong>
                    {{ $branch['phone'] }}
                </p>
                <p><i class="fa-solid fa-map-location-dot"></i>
                    <strong>{{__('Địa chỉ')}}:</strong>
                    {{ $branch['address'] }}, {{ $branch['city'] }}
                </p>
            </div>
        </div>
    </div>
    <div class="col-12 m-auto p-4" style="background-color: #f1e6b2">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @foreach($rooms as $index => $room)
                        <div class="col-md-3 p-2">
                            <div class="section-heading text-left">
                                <h2 class="mb-5 text-uppercase">{{__('Phòng')}}
                                    <span class="ms-5 m-md-0">{{ $room['room_type'] }}</span>
                                </h2>
                            </div>
                            <img href="{{ $room['thumb_nail'] }}" src="{{ $room['thumb_nail'] }}"
                                 alt="Ảnh phòng"
                                 class="img-fluid image-popup img-opacity w-75" loading="lazy">
                            @foreach($room['detail_images'] as $detailImage)
                                <img href="{{ $detailImage }}" src="{{ $detailImage }}" alt="Ảnh chi tiết"
                                     class="img-fluid detail-img-absolute image-popup img-opacity"
                                     loading="lazy" style="bottom: 30px">
                            @endforeach

                        </div>

                        <div class="col-md-9 border-bottom border-warning mt-4" style="min-height: 40vh">

                            <div class="col-12 mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5><i class="fa-solid fa-money-bill-1-wave"></i>
                                            {{__('Bảng giá')}}:
                                        </h5>
                                        <ul class="text-dark">
                                            @foreach($room['price_unit'] as $key=>$price)
                                                @if($key == PriceType::ListedHourPrice['value'])
                                                    <li>
                                                        {{ __(PriceType::ListedHourPrice['text']) . ': ' }}
                                                        <p class="text-danger">
                                                            {{ number_format($price, 0, ',', '.') }}
                                                            VND/{{__('phòng/giờ')}}
                                                        </p>
                                                    </li>
                                                @elseif($key == PriceType::ListedDayPrice['value'])
                                                    <li>
                                                        {{__(PriceType::ListedDayPrice['text']) .': ' }}
                                                        <p class="text-danger">
                                                            {{ number_format($price, 0, ',', '.') }}
                                                            VND/{{__('phòng/ngày')}}
                                                        </p>
                                                    </li>
                                                @elseif($key == PriceType::First2Hours['value'])
                                                    <li>
                                                        {{ __(PriceType::First2Hours['text']) .': '}}
                                                        <p class="text-danger">
                                                            {{ number_format($price, 0, ',', '.') }}
                                                            VND/{{__('phòng/giờ')}}
                                                        </p>
                                                    </li>
                                                @elseif($key == PriceType::EarlyCheckIn['value'])
                                                    <li>
                                                        {{ __(PriceType::EarlyCheckIn['text']) .': '}}
                                                        <p class="text-danger">
                                                            {{ number_format($price, 0, ',', '.') }}
                                                            VND/{{__('phòng/giờ')}}
                                                        </p>
                                                    </li>
                                                @elseif($key == PriceType::LateCheckOut['value'])
                                                    <li>
                                                        {{ __(PriceType::LateCheckOut['text']) .': '}}
                                                        <p class="text-danger">
                                                            {{ number_format($price, 0, ',', '.') }}
                                                            VND/{{__('phòng/giờ')}}
                                                        </p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="col-md-5">
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

                                    <div class="col-md-3">
                                        <h5><i class="fa-solid fa-bed"></i>{{__('Số giường')}}</h5>
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
                                        <h5><i class="fa-solid fa-people-roof"></i> {{__('Sức chứa tối đa')}}</h5>
                                        <ul>
                                            <li>{{__('Người lớn')}}: {{ $room['adult_capacity'] }}</li>
                                            <li>{{__('Trẻ em')}}: {{ $room['children_capacity'] }}</li>
                                        </ul>

                                        <div class="quantity mx-auto mx-md-0">
                                            <button class="minus" aria-label="Decrease" wire:click.prevent="decrease({{ $index }})">&minus;</button>
                                            <input type="number" class="input-box" value="{{ $room['quantity'] ?? 0 }}"
                                                   min="0" max="{{ count($room['room_ids']) }}">
                                            <button class="plus" aria-label="Increase"  wire:click.prevent="increase({{ $index }})">&plus;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-9 mr-0 ml-auto mt-3">
               <div class="row">
                   <div class="col-md-7">
                       <h3>{{__('Số lượng')}}:
                       <span class="text-{{$isValidQuantity ? 'success' : 'danger'}}"> {{ $totalRoomSelected }} {{__('phòng')}} </span>
                       </h3>
                       <h3>{{__('Sức chứa tối đa')}}:
                           <span class="text-{{$isValidQuantity ? 'success' : 'danger'}}">{{ $adultsCapacity }} {{__('người lớn')}} & {{ $childrenCapacity }} {{__('trẻ em')}}</span>
                       </h3>
                   </div>
                   <div class="col-md-5 text-end">
                       <h3>{{__('Tổng chi phí')}}:
                           <span class="text-info"> {{ number_format($totalPrice, 0 , ',', '.') }} VND</span>
                       </h3>
                       <button class="btn btn-warning text-white"  wire:click.prevent="bookingConfirm()"
                           {{ $isValidQuantity ? '' : 'disabled' }}>
                           {{__('Đặt phòng ngay')}}
                       </button>
                   </div>
               </div>

            </div>
        </div>
    </div>
</div>
