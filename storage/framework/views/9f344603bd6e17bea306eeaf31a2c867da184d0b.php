
    <div class="m-auto col-md-5 d-flex justify-content-center">
        <span><?php echo e($title); ?></span>
        <?php if($showButton): ?>
            <button id="re-send" class="btn-link border border-0" type="button" style="text-decoration: underline; color: blue" wire:click="reSend">
                <span>Gửi lại</span>
                <span id="icon-re-send">
                    <i class="fas fa-rotate"></i>
                </span>
            </button>
        <?php else: ?>
            <div wire:poll.180s="showButton" />
        <?php endif; ?>
    </div>


<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/verify/reSendCode.blade.php ENDPATH**/ ?>