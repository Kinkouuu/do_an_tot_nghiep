<select class="form-select change-status" data-id="{{ $item->id }}" wire:change="changeStatus($event.target.value)">
    @foreach(\App\Enums\UserStatus::asArray() as $status)
        <option value="{{$status}}" {{ $item->status == $status ? 'selected' : '' }}>
            {{ match ($status) {
                   \App\Enums\UserStatus::Cancelled => 'Đã hủy',
                   \App\Enums\UserStatus::Active => 'Đang hoạt động',
                   \App\Enums\UserStatus::Banned => 'Bị cấm',
               }
            }}
        </option>
    @endforeach
</select>
