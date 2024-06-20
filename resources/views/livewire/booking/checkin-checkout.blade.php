<div class="row">
    @if(!$check_in_rooms->isEmpty())
        <div class="col-md-6 m-auto text-center">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#checkInModal">
                <i class="fa-solid fa-person-walking-arrow-right"></i>
                Check In
            </button>
        </div>

        <!-- Modal -->
        <form wire:ignore.self class="modal fade" id="checkInModal" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="checkin">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn phòng check-in</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ms-3 mb-2 form-check form-switch">
                            <input class="form-check-input" wire:click.prevent="quickCheckIn"
                                   type="checkbox" id="selectAll" {{ $selectAllInRooms ? 'checked' :'' }}>
                            <label class="form-check-label" for="selectAll">
                                Chọn tất cả
                            </label>
                        </div>
                        @foreach($check_in_rooms as $room)
                            <div class="form-check">
                                <input class="form-check-input" wire:model.sync="inRooms" type="checkbox"
                                       value="{{ $room['id'] }}" id="{{ $room['id'] }}" >
                                <label class="form-check-label" for="{{ $room['id'] }}">
                                    {{ $room['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </div>
            </div>
        </form>
    @endif
    @if(!$check_out_rooms->isEmpty())
            <div class="col-md-6 m-auto text-center">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#checkOutModal">
                    <i class="fa-solid fa-person-walking-arrow-right fa-flip-horizontal"></i>
                    Check Out
                </button>
            </div>

            <!-- Modal -->
            <form wire:ignore.self class="modal fade" id="checkOutModal" tabindex="-1" role="dialog"
                  aria-labelledby="exampleModalLabel" aria-hidden="true" wire:submit.prevent="checkout">
                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chọn phòng check-out</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="ms-3 mb-2 form-check form-switch">
                                <input class="form-check-input" wire:click.prevent="quickCheckOut"
                                       type="checkbox" id="selectAll" {{ $selectAllOutRooms ? 'checked' :'' }}>
                                <label class="form-check-label" for="selectAll">
                                    Chọn tất cả
                                </label>
                            </div>
                            @foreach($check_out_rooms as $room)
                                <div class="form-check">
                                    <input class="form-check-input" wire:model.sync="outRooms" type="checkbox"
                                           value="{{ $room['id'] }}" id="{{ $room['id'] }}" >
                                    <label class="form-check-label" for="{{ $room['id'] }}">
                                        {{ $room['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Xác nhận</button>
                        </div>
                    </div>
                </div>
            </form>
    @endif

    @if($check_in_rooms->isEmpty() && $check_out_rooms->isEmpty())
            <div class="col-md-6 m-auto text-center">
                <a class="btn btn-success text-white" href="{{ route('admin.booking.show', $booking) }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    In hóa đơn
                </a>
            </div>
    @endif
</div>
