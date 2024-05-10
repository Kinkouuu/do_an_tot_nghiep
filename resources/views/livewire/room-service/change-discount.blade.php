<div class="w-100">
    <div class="d-flex">
        Giảm:
        <input type="number" class="discount w-50 mx-1" value="{{ $discount }}"
               {{ $service['status'] == \App\Enums\Service\ServiceStatus::DeActive ? 'readonly' : ''}}
               min="0" max="100" wire:change="update($event.target.value)"
        > %/vé
    </div>
    <span class="text-danger text-sm">{{ $error }}</span>
</div>
