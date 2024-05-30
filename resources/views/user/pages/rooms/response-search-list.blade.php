@extends('user.layouts.main')

@section('content')
        <div class="container-fluid">
            <div class="row">
               @if(count($roomBranches) > 0)
                    <h1 class="m-auto p-5 text-capitalize">Lựa chọn tốt nhất cho kì nghỉ của bạn!</h1>
                    @foreach($roomBranches as $roomBranch)
                      @livewire('room.booking-form', [
                        'roomBranch' => $roomBranch,
                         'time' => $time,
                         'condition' => $condition
                         ])
                    @endforeach
                @else
                   <h1 class="m-auto p-5">Hiện không đủ phòng trống. Bạn thử đặt ngày khác nha!</h1>
                @endif
            </div>
        </div>
@endsection
