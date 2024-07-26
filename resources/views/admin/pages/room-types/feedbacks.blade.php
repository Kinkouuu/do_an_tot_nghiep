@php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="{{ route('admin.room-type.edit' , ['typeRoom' => $type_room['id']]) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                    <h1 class="col-8 my-auto text-center">{{$title}}
                        <br>
                        <strong class="text-secondary text-uppercase">[ {{ $type_room['name'] }} ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="{{ route('admin.room-type.images', ['code' =>  $type_room['id']]) }}">
                            <i class="fa-solid fa-panorama"></i>
                            Ảnh chi tiết
                        </a>
                    </div>
                </div>
                <div class="col-md-10 col-12 my-4 mx-auto">
                    <div class="row">
                        @if($feedBacks->isEmpty())
                            <h3 class="text-center">Hiện chưa có đánh giá nào</h3>
                        @else
                            <div class="col-md-12 pb-3" style="background-color: #f1e6b2">
                                @foreach($feedBacks as $feedBack)
                                    <div class="col-md-12 p-2 mt-3">
                                        <div class="row">
                                            <div class="col-md-12 mb-3 border-bottom border-warning">
                                                <div class="d-flex justify-content-center align-items-center" style="color: orangered">
                                                    <strong class="mx-2" style="font-size: xx-large">{{ $rating['avg'] }}</strong>
                                                    <i class="fa-solid fa-star fa-2xl"></i>
                                                    <strong class="ml-3">{{ array_sum($rating['number']) }} lượt đánh
                                                        giá</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-file-invoice"></i>
                                                        <a>Mã đơn hàng: {{ base64_encode($feedBack['booking']['id']) }}</a>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-user"></i>
                                                        <span>{{ $feedBack['booking']['gender'] == UserGender::Male ? 'Anh' : 'Chị' }}: {{ $feedBack['booking']['name'] }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                                        <span>Số điện thoại: {{ $feedBack['booking']['phone'] }}</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        <span>Chi nhánh: Khách sạn
                                                            {{ $feedBack['booking']['bookingRooms']->first()->branch['name'] }}
                                                            - {{ $feedBack['booking']['bookingRooms']->first()->branch['city'] }}
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-restroom"></i>
                                                        <span>Số người: {{ $feedBack['booking']['number_of_adults'] }} người lớn và {{ $feedBack['booking']['number_of_children'] }} trẻ em</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-calendar-check"></i>
                                                        <span>Ngày đặt đơn: </span>
                                                        <span class="text-capitalize">{{Carbon::parse($feedBack['booking']['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </span>
                                                    </label>

                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <a class="text-capitalize" href="{{ route('admin.booking.edit', $feedBack['booking']['id']) }}">
                                                        Xem chi tiết đơn hàng->
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-3">
                                                <div class="d-flex align-items-center">
                                                    @for($i=1; $i<=5; $i++)
                                                        <span
                                                            class="star {{ $feedBack['rate_stars'] >= $i ? 'hovered' : '' }}">★</span>
                                                    @endfor
                                                    <span class="ml-2"> {{ $feedBack['rate_stars'] }} / 5 </span>
                                                    <span class="mr-0 ml-auto">{{ $feedBack['created_at'] }}</span>
                                                </div>
                                                <textarea class="form-control" disabled maxlength="255" cols="1"
                                                          rows="3">{{ $feedBack['comment'] }}
                                                </textarea>
                                                <div class="d-flex justify-content-between">
                                                    @if($feedBack['reply'])
                                                        <p class="text-capitalize my-1">
                                                            <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                                                            {{ $feedBack->admin->name }} đã phản hồi lúc {{ $feedBack['reply_at'] }}
                                                        </p>
                                                    @else
                                                        <p class="my-1">
                                                            <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                                                            Phản hồi
                                                        </p>
                                                    @endif

                                                    <span class="text-danger" id="error-{{ $feedBack['id'] }}"></span>

                                                    <button class="reply btn btn-link" data-id="{{ $feedBack['id'] }}"> Lưu </button>
                                                </div>
                                                <textarea class="form-control" id="reply-{{ $feedBack['id'] }}" rows="3">{{ $feedBack['reply'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('.reply').click(function () {
                const id = $(this).data('id');
                const reply = $('#reply-' + id).val().trim();
                if(reply === '')
                {
                    $('#error-' + id).text('Vui lòng nhập nội dung phản hồi.')
                }else{
                    $.ajax({
                        url: '{{ route("admin.feedback.reply", ':id') }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            reply: reply,
                        },
                        success: function (response) {
                            console.log(response)
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                            })
                        },
                        error: function (response) {
                            console.log(response);
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
    </script>
@endpush
