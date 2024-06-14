<div class="justify-content-around">
    <a href="{{ route('admin.room.edit', $room['id']) }}"> {{ $room['name'] }}</a>
    <!-- Button trigger modal -->
    <a type="button" class="text-success" style="text-decoration: underline" data-toggle="modal" data-target="#respective-room-{{ $room['id'] }}">
        <i class="fa-solid fa-rotate"></i>Đổi phòng
    </a>

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
</div>
