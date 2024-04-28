
    <div class="m-auto col-md-5 d-flex justify-content-center">
        <span>{{ $title }}</span>
        @if($showButton)
            <button id="re-send" class="btn-link border border-0" type="button" style="text-decoration: underline; color: blue" wire:click="reSend">
                <span>Gửi lại</span>
                <span id="icon-re-send">
                    <i class="fas fa-rotate"></i>
                </span>
            </button>
        @else
            <div wire:poll.180s="showButton" />
        @endif
    </div>


