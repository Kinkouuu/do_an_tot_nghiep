
<div class="col-md-12">
    <form class="row" action="{{route('admin.booking.create')}}" method="">
        @csrf
        <div class="col-md-9 m-auto">
            <div class="row">
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3" wire:ignore>
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Chi nhánh</span>
                        </div>
                        <select class="selectpicker w-75" data-live-search="true"
                                data-style="bg-white border border-left-0" name="branch" required>
                            <option value=""> Chọn chi nhánh </option>
                            @foreach($branches as $branch)
                                <option class="text-capitalize" value="{{ $branch['id'] }}"
                                    {{ request()->get('branch') == $branch['id'] ? 'selected' : ''}}>
                                    {{ $branch['name'] }} - {{ $branch['city'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3" wire:ignore>
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Loại phòng</span>
                        </div>
                        <select class="selectpicker w-75" name="room_type" data-live-search="true"
                               data-style="bg-white border border-left-0">
                            <option value=""> Tất cả </option>
                            @foreach($roomTypes as $roomType)
                                <option class="text-capitalize" value={{ $roomType['id'] }}
                                    {{ request()->get('room_type') == $roomType['id'] ? 'selected' : ''}}>
                                    {{ $roomType['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Check in</span>
                        </div>
                        <input type="datetime-local" class="col-md-10 form-control find-input" min="{{ $minCheckin }}"
                               name="checkin" wire:change="setMinCheckOut($event.target.value)"
                               value="{{ request()->get('checkin') ?? null}}" required>
                    </div>
                </div>
                <div class="col-md-6 m-auto">
                    <div class="w-100 input-group input-group-sm mb-3">
                        <div class="w-25 input-group-prepend">
                            <span class="input-group-text w-100" id="inputGroup-sizing-sm">Check out</span>
                        </div>
                        <input type="datetime-local" class="col-md-10 form-control find-input" name="checkout"
                               value="{{ request()->get('checkout') ?? null}}" min="{{ $minCheckout }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 m-auto">
            <button type="submit" class="btn btn-warning text-white">
                <i class="fa-solid fa-magnifying-glass"></i>
                Tìm kiếm
            </button>
        </div>
    </form>
</div>
