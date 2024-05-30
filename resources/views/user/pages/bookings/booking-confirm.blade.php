@extends('user.layouts.main')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
               <div class="col-12 m-auto py-4 rounded text-white" style="background-color:#a6a6a6">
                    <h5 class="text-center text-light mb-3"> Thông tin chuyến đi</h5>
                    <div class="col-md-12 mb-2">
                        <label>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Địa điểm: Khách sạn {{ $branch['name'] }} - {{ $branch['city'] }}</span>
                        </label>
                        <p> {{ $branch['address'] }}, {{ $branch['city'] }}</p>
                    </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-restroom"></i>
                           <span>Số người: {{ $condition['adults'] }} người lớn và {{ $condition['children'] }} trẻ em</span>
                       </label>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-person-walking-luggage"></i>
                           <span>Ngày nhận phòng: </span>
                       </label>
                       <p class="text-capitalize">{{ $condition['checkin']->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-person-walking-luggage fa-flip-horizontal"></i>
                           <span>Ngày trả phòng: </span>
                       </label>
                       <p class="text-capitalize">{{ $condition['checkout']->isoFormat('dddd, HH:mm - DD/MM/YYYY') }} </p>
                   </div>
                   <div class="col-md-12 mb-2">
                       <label>
                           <i class="fa-solid fa-clock"></i>
                           <span>
                               Chuyến đi {{ $condition['duration'] }} dành cho {{ $condition['adults'] + $condition['children'] }} người
                           </span>
                       </label>
                   </div>
               </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ $branch['avatar'] }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{--<form wire:ignore.self class="modal fade" id="confirmInfo" data-backdrop="static" data-keyboard="false" tabindex="-1"--}}
{{--      aria-labelledby="staticBackdropLabel" aria-hidden="true" >--}}
{{--    <div class="modal-dialog modal-dialog-centered modal-lg">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="confirmInfo">Thông tin người nhận phòng</h5>--}}
{{--                <div class="form-check form-switch">--}}
{{--                    <input class="form-check-input" type="checkbox" role="switch">--}}
{{--                    <span>Đặt cho người thân</span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-body pt-4 px-2">--}}
{{--                <div class="col-md-11 m-auto">--}}
{{--                        <p class="text-danger text-sm-left" style="font-size: 12px">--}}
{{--                            * Nếu người nhận phòng không phải bạn, hãy chọn chức năng đặt cho người thân--}}
{{--                        </p>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Email</span>--}}
{{--                                </div>--}}
{{--                                <div class="form-control col-md-7">--}}
{{--                                    <p class="m-auto">{{ $user->email }}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Số điện thoại</span>--}}
{{--                                </div>--}}
{{--                                <input type="text" class="form-control col-md-7" value="{{ $user->phone }}" wire:model.blur="user.phone"> {{ $user->phone }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Họ tên</span>--}}
{{--                                </div>--}}
{{--                                <input type="text" class="form-control col-md-7" value="{{ $user->customer?->name ?? old('data.name') }}" wire:model="data.name">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Quốc tịch</span>--}}
{{--                                </div>--}}
{{--                                <input type="text" class="form-control col-md-7" value="{{ $user->customer?->country ?? old('data.country') }}" wire:model="data.country">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Số CCCD</span>--}}
{{--                                </div>--}}
{{--                                <input type="text" class="form-control col-md-7" value="{{ $user->customer?->citizen_id ?? old('data.citizen_id') }}" wire:model="data.citizen_id">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 input-group mb-3">--}}
{{--                                <div class="input-group-prepend col-md-5 p-0">--}}
{{--                                    <span class="input-group-text w-100">Giới tính</span>--}}
{{--                                </div>--}}
{{--                                <select class="form-control" name="gender">--}}
{{--                                    @foreach(UserGender::asArray() as $gender)--}}
{{--                                        <option {{ $user->customer?->gender == $gender ? 'selected' : '' }} value={{ $gender }}>--}}
{{--                                            {{ $gender == UserGender::Male ? 'Nam' : 'Nữ' }}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>--}}
{{--                <button type="submit" class="btn btn-success">Đặt phòng</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}

