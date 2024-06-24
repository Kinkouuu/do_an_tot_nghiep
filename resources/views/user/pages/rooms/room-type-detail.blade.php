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

                    <div class="col-md-12 p-3" style="background-color: #d5ebdb;">
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

                <div class="col-md-6 m-3 m-md-0 p-5" style="background-color: #feeec5;">
                    <div class="row">
                        <div class="col-md-12 mb-3" style="border-left: black solid 5px ">
                            <div class="row">
                                <h1 class="text-uppercase px-3 text-bold">
                                    Phòng {{ $room_type['name'] }}
                                </h1>
                                <div class="d-flex align-items-center" style="color: orangered">
                                    <strong class="mx-2" style="font-size: xx-large">{{ $feedBacks['avg'] }}</strong>
                                    <i class="fa-solid fa-star fa-2xl"></i>
                                    <strong class="mr-0 ml-auto">{{ array_sum($feedBacks['number']) }} lượt đánh
                                        giá</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 m-auto text-dark">
                            {!! $room_type['description'] !!}
                        </div>

                        <div class="col-md-12">
                            <h3>Bảng giá:</h3>
                            <ul>
                                @foreach($room_type['prices'] as $price)
                                    <li>
                                        {{ $price['name'] }}:
                                        <strong class="text-danger">{{ number_format($price['price'], 0, ',', '.') }}
                                            VND/{{ $price['type'] }}</strong>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <p>Có
                                <strong class="text-bold text-dark">{{ $room_type['branches']->sum('count') }}
                                    phòng</strong>
                                tại
                                <strong class="text-bold text-dark"
                                        style="text-decoration: underline">{{ count($room_type['branches']) }} chi
                                    nhánh</strong>
                                trên toàn quốc
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-3 block-14" style="background-color: #d6d6d6">

                    <div class="container">

                        <div class="row">
                            <div class="col-md-6 mx-auto text-center mb-3 section-heading">
                                <h2>Phản hồi khách hàng</h2>
                            </div>
                        </div>

                        <div class="nonloop-block-14 owl-carousel">
                            @foreach($feedBacks['feed_backs'] as $feedBack)
                                <div class="border p-3" style="height: 170px;">
                                    <h2 class="h5 m-0 text-capitalize">
                                        {{ $feedBack->booking->user?->customer?->name  ?? $feedBack->booking->user->phone}}
                                    </h2>
                                    <div class="d-flex justify-content-around align-items-center">
                                        @for($i=1; $i<=5; $i++)
                                            <span
                                                class="star {{ $feedBack['rate_stars'] >= $i ? 'hovered' : '' }} ">★</span>
                                        @endfor
                                        <span class="mr-0 ml-auto">{{ $feedBack['created_at'] }}</span>
                                    </div>
                                    <blockquote class="text-dark">
                                        &ldquo;{{ $feedBack->comment }}&rdquo;
                                    </blockquote>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
{{--<div class="col-md-4 row" style="color: orangered">--}}
{{--    @for($i=5; $i>=1; $i--)--}}
{{--        <span>{{ $feedBacks['number'][$i] ?? 0 }}--}}
{{--            @for($j=1; $j<=$i; $j++)--}}
{{--                ★--}}
{{--            @endfor--}}
{{--                                        </span>--}}
{{--    @endfor--}}
{{--</div>--}}
