@extends('user.layouts.main')

@section('content')
    <div class="container mt-5">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 p-1">
                        <img href="{{ $room_type['images']['thumb_nail'] }}"
                             src="{{ $room_type['images']['thumb_nail'] }}" class="w-100 rounded image-popup">
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($room_type['images']['details_img'] as $detail_img)
                                <div class="col-md-3 p-1">
                                    <img href="{{ $detail_img}}" src="{{ $detail_img}}"
                                         class="w-100 rounded image-popup img-opacity">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12 p-3" style="background-color: #d5ebdb">
                        <div class="row">
                            <div class="col-md-12 m-auto">
                                <h4 class="text-bold text-secondary">Các dịch vụ có sẵn:</h4>
                                <ul>
                                    @foreach($room_type['services']['provide'] as $service)
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
                            <div class="col-md-12 m-auto">
                                <h5 class="text-bold text-secondary">và nhiều dịch vụ khác:</h5>
                                @foreach($room_type['services']['unProvide'] as $serviceType)
                                    <div class="col-md-12">
                                        <p class="text-dark text-bold text-capitalize">
                                            <i class="{{ $serviceType['icon'] }}"></i>
                                            <strong class="text-capitalize">{{ $serviceType['name'] }}</strong>
                                        </p>
                                        <ul>
                                            @foreach($serviceType['services'] as $service)
                                                <li>
                                                    <p>
                                                        {{ $service['name'] }}
                                                        <span class="text-info">
                                                            {{ number_format( $service['price'], 0 ,',', '.')  }} VND/người
                                                        </span>
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 m-3 m-md-0 p-5" style="background-color: #feeec5">
                    <div class="row">
                        <h1 class="text-uppercase px-3 text-bold" style="border-left: black solid 5px ">
                            Phòng {{ $room_type['name'] }} <span></span></h1>
                        <div class="col-md-12 m-auto text-dark">
                            {!! $room_type['description'] !!}
                        </div>

                        <div class="col-md-12">
                            <h3>Bảng giá:</h3>
                            <ul>
                                @foreach($room_type['prices'] as $price)
                                    <li>
                                        {{ $price['name'] }}:
                                        <strong class="text-danger">{{ number_format($price['price'], 0, ',', '.') }} VND/{{ $price['type'] }}</strong>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <p>Có
                                <strong class="text-bold text-dark">{{ $room_type['branches']->sum('count') }} phòng</strong>
                                 tại
                                <strong class="text-bold text-dark" style="text-decoration: underline">{{ count($room_type['branches']) }}  chi nhánh</strong>
                                trên toàn quốc
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
