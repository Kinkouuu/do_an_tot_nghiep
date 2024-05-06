@extends('user.layouts.main')

@section('content')
    <div class="site-section site-section-sm">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-8 mb-5">

                    <form action="" class="p-5 bg-white" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="fullname">Họ và tên</label>
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror
                                <input type="text" id="fullname" class="form-control" name="name"
                                       placeholder="Họ và tên"
                                       value="{{ $user['name'] ?? old('name') }}"
                                >
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="Địa chỉ email">Email</label>
                                @error('email')
                                <span class="error">{{ $message }}</span>
                                @enderror
                                <input type="email" id="email" class="form-control" name="email" placeholder="Email"
                                       value="{{ $user['email'] ?? old('email') }}"
                                >
                            </div>
                        </div>


                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="phone">Số điện thoại</label>
                                @error('phone')
                                <span class="error">{{ $message }}</span>
                                @enderror
                                <input type="text" id="phone" class="form-control" name="phone"
                                       placeholder="Số điện thoại"
                                       value="{{ $user['phone'] ?? old('phone') }}">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="message">Nội dung</label>
                                @error('message')
                                <span class="error">{{ $message }}</span>
                                @enderror
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                          maxlength="500">
                                    {{ old('message') }}
                                </textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <input type="submit" value="GÓP Ý" class="btn btn-primary pill px-4 py-2">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4">
                    <div class="p-4 mb-3 bg-white">
                        <h3 class="h5 text-black mb-3">Thông tin liên hệ</h3>
                        <p class="mb-0 font-weight-bold">Address</p>
                        <p class="mb-4">Tầng 4, Grandeur Palace, 138B Giảng Võ, Ba Đình, Hà Nội</p>

                        <p class="mb-0 font-weight-bold">Phone</p>
                        <p class="mb-4"> <a href="tel:+84397910001">+84 39 79 10001</a></p></p>

                        <p class="mb-0 font-weight-bold">Email Address</p>
                        <p class="mb-0"> <a href="mailto:contact@vietnamvacationclub.vn">contact@vietnamvacationclub.vn</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
