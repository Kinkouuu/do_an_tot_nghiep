<div class="pl-2">
    <div class="d-flex">
        <strong class="pr-1">Phòng: </strong>
        <a href="{{ route('admin.room.edit', $room['id']) }}"> {{ $room['name'] }}</a>
   @if($checkin_at && !$checkout_at)
        <p class="text-info pl-2 m-0"> Đã nhận phòng </p>
    </div>
    <p class="text-capitalize m-0">{{ $checkin_at }}</p>
    <p class="m-0">({{ $early }} so với giờ checkin)</p>
    @elseif($checkout_at)
        <p class="text-success pl-2 m-0">Đã trả phòng </p>
    </div>
    <p class="text-capitalize m-0">{{ $checkout_at }}</p>
    <p class="m-0">({{ $lately }} so với giờ checkout)</p>
    @else
        <a type="button" class="text-primary pl-2" style="text-decoration: underline" data-toggle="modal" data-target="#respective-room-{{ $room['id'] }}">
            <i class="fa-solid fa-rotate"></i>Đổi phòng
        </a>
    </div>
        <!-- Modal -->
        <form wire:ignore.self class="modal fade" id="respective-room-{{ $room['id'] }}"
              tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="changeRoom">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase" id="exampleModalLabel">Đổi phòng tương ứng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if($respectiveRooms->isEmpty())
                            <h5>Hiện không còn phòng tương ứng nào còn trống</h5>
                            <img src="{{ asset('images/empty-cart.webp') }}" class="w-100" alt="Not respective rooms available">
                        @else
                            @foreach($respectiveRooms as $respectiveRoom )
                                <div class="form-check form-check-inline mb-2">
                                    <input class="form-check-input" type="radio" wire:model="roomChangeId" name="roomChangeId" id="inlineRadio1" value="{{ $respectiveRoom['id'] }}">
                                    <label class="form-check-label" for="inlineRadio1">Phòng {{ $respectiveRoom['name'] }}</label>
                                </div>
                            @endforeach
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary">Đổi</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
   @endif
</div>
