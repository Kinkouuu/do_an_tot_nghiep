    <select class="form-select change-status" wire:change="changeStatus($event.target.value)">
        @foreach(\App\Enums\Room\RoomStatus::asArray() as $status)
            <option value="{{ $status['key'] }}" {{ $room->status == $status['key'] ? 'selected' : '' }}>
                {{ $status['value'] }}
            </option>
        @endforeach
    </select>

