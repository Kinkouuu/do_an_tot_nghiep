@php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
    use App\Enums\Room\PriceType;
@endphp
@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="col-md-12 pt-5">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-3 my-auto text-center">
                        <a class="btn btn-outline-success" href="{{ route('admin.booking.edit', $booking) }}">
                            <i class="fa-solid fa-file-pen"></i>
                            Chi tiết đơn đặt
                        </a>
                    </div>
                    <h1 class="col-6 my-auto text-center">{{$title}}</h1>
                    <div class="col-3 my-auto text-center">
                        <a class="btn btn-outline-success" href="{{ route('admin.booking.show', $booking) }}">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            Chi tiết hóa đơn
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
                                            <div class="col-md-12 text-center">
                                                <h2 class="mb-3 text-uppercase text-secondary"
                                                    style="text-decoration: underline">Phòng
                                                    <span
                                                        class="ms-5 m-md-0">{{ $feedBack['roomType']['name'] }}</span>
                                                </h2>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="{{ $feedBack->roomType->roomImages->first()->path }}"
                                                     alt="Ảnh phòng" class="w-100" oading="lazy">
                                            </div>
                                            <div class="col-md-8">
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
