@extends('user.layouts.main')

@section('content')
    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="row">
                <h1 class="text-center text-uppercase">
                        Đánh giá chuyến đi
                </h1>

                <div class="col-md-10 col-12 my-4 mx-auto">
                    <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mb-3 text-white"
                                         style="background-image: url({{ asset($branch['avatar']) }}); background-repeat: no-repeat; background-size: cover">
                                        <h3 class="text-light"
                                            style="font-size: xxx-large; font-style: oblique">{{ $branch['name'] }}</h3>
                                        <div class="row">
                                            <div class="col-md-12 d-flex">
                                                <div class="col-md-6">
                                                    <p><i class="fa-solid fa-phone-volume"></i>
                                                        <strong>Hotline:</strong>
                                                        {{ $branch['phone'] }}
                                                    </p>
                                                    <p><i class="fa-solid fa-map-location-dot"></i>
                                                        <strong>Địa chỉ:</strong>
                                                        {{ $branch['address'] }}, {{ $branch['city'] }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <a class="btn btn-outline-success text-light" href="{{ route('booking.show', base64_encode($booking['id'])) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                        Chi tiết đơn hàng
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form class="col-md-12 pt-3" style="background-color: #f1e6b2" method="POST"
                                          action="{{ route('feedback.store', base64_encode($booking['id'])) }}">
                                        @csrf
                                        <div class="row align-items-center">
                                            @foreach($rooms as $key=>$room)
                                                <div class="col-md-4 p-2">
                                                    <img href="{{ $room['thumb_nail'] }}" src="{{ $room['thumb_nail'] }}"
                                                         alt="Ảnh phòng"
                                                         class="img-fluid image-popup img-opacity w-75" loading="lazy">
                                                    @foreach($room['detail_images'] as $detailImage)
                                                        <img href="{{ $detailImage }}" src="{{ $detailImage }}" alt="Ảnh chi tiết"
                                                             class="img-fluid detail-img-absolute image-popup img-opacity"
                                                             loading="lazy">
                                                    @endforeach

                                                </div>
                                                <div class="col-md-8">
                                                    <div class="section-heading text-left">
                                                        <h2 class="mb-5 text-uppercase">Phòng <span
                                                                class="ms-5 m-md-0">{{ $room['room_type'] }}</span>
                                                            <span
                                                                class="text-lowercase text-secondary">x{{ count($room['room_ids']) }}</span>
                                                        </h2>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="d-flex align-items-center">
                                                            @for($i=1; $i<=5; $i++)
                                                                <span onclick="rate({{$i}}, {{$key}})" class="star {{$key}}" >★</span>
                                                            @endfor
                                                            <span id="rating-{{$key}}">
                                                               0/5
                                                            </span>
                                                            <span class="ml-2" id="text-{{$key}}"></span>
                                                            @error('feedback.' . $room['room_type_id']  . '.point')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <input type="number" hidden name="feedback[{{ $room['room_type_id'] }}][point]" id="point-{{$key}}">
                                                        @error('feedback.' . $room['room_type_id']  . '.comment')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        <textarea name="feedback[{{ $room['room_type_id'] }}][comment]" class="form-control"
                                                                  maxlength="255" cols="1" rows="5" placeholder="Chia sẻ trải nghiêm của bạn...">
                                                        </textarea>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="mx-auto text-center mb-3">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="fa-regular fa-comment"></i>
                                                    Đánh giá
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
            // Cập nhật rating
            function rate(n, id) {
                let stars = document.getElementsByClassName("star " + id);
                let rating = document.getElementById("rating-" + id);
                let text = document.getElementById("text-" + id);
                removeRate(stars, id);
                for (let i = 0; i < n; i++) {
                    stars[i].classList.add("hovered");
                }
                rating.innerText = n + "/5";
                document.getElementById('point-' + id).value = n;
                text.innerText = getRateText(n);
            }

            // Xóa rating
            function removeRate(stars, id) {
                let i = 0;
                while (i < 5) {
                    stars[i].className = "star " + id;
                    i++;
                }
            }
            // Hiển thị mức đánh giá
            function getRateText(n)
            {
                if(n === 1) return 'Tệ';
                if(n === 2) return 'Khá thất vọng';
                if(n === 3) return 'Khá ổn';
                if(n === 4) return 'Tốt';
                if(n === 5) return 'Tuyệt vời';
            }
    </script>
@endpush
