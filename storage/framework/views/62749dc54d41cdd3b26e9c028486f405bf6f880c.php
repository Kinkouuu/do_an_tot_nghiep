<?php echo $__env->make('user.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="text-center" style="margin-top: 200px">

    <h3 class="text-black"> Mã xác thực <span class="text-lowercase"><?php echo e($response['title_page']); ?></span> đã được gửi đến địa chỉ email:</h3>
    <h5 class="text-secondary"> <?php echo e($response['email']); ?></h5>

    <form class="" action="" method="POST">
        <?php echo csrf_field(); ?>
        <div class="m-3">
            <input class="form-control col-md-5 m-auto" id="code" name="code" type="text" placeholder="Nhập mã xác thực">
            <input type="hidden" name="type" value="<?php echo e($response['type']); ?>">
            <span class="text-danger"></span>
        </div>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('verify.re-send-code', [])->html();
} elseif ($_instance->childHasBeenRendered('4n5qhcw')) {
    $componentId = $_instance->getRenderedChildComponentId('4n5qhcw');
    $componentTag = $_instance->getRenderedChildComponentTagName('4n5qhcw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('4n5qhcw');
} else {
    $response = \Livewire\Livewire::mount('verify.re-send-code', []);
    $html = $response->html();
    $_instance->logRenderedChild('4n5qhcw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <button id="verify" type="submit" class="btn btn-success mt-3 " disabled>Xác nhận</button>
    </form>

</section>

<?php $__env->startPush('script'); ?>
    <script>
        // validation input verify-code input
        $(document).ready(function () {
            let typingTimer;
            const doneTypingInterval = 100;

            $(document).on("input", "#code", function () {
                clearTimeout(typingTimer);

                typingTimer = setTimeout(function () {
                    const input = $("#code").val();
                    if (input && input.length >= 6) {
                        $("#verify").removeAttr("disabled");
                    } else {
                        $("#verify").attr("disabled", true);
                    }
                }, doneTypingInterval);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/authentication/verify-code.blade.php ENDPATH**/ ?>