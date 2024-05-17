<script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery-migrate-3.0.1.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/owl.carousel.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.stellar.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.countdown.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/jquery.magnific-popup.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/aos.js')); ?>"></script>


<script src="<?php echo e(asset('js/mediaelement-and-player.min.js')); ?>"></script>
<!-- Select Option Live Search -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo e(asset('js/main.js')); ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mediaElements = document.querySelectorAll('video, audio'), total = mediaElements.length;

        for (var i = 0; i < total; i++) {
            new MediaElementPlayer(mediaElements[i], {
                pluginPath: 'https://cdn.jsdelivr.net/npm/mediaelement@4.2.7/build/',
                shimScriptAccess: 'always',
                success: function () {
                    var target = document.body.querySelectorAll('.player'), targetTotal = target.length;
                    for (var j = 0; j < targetTotal; j++) {
                        target[j].style.visibility = 'visible';
                    }
                }
            });
        }
    });
</script>

    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo \Livewire\Livewire::scripts(); ?>

</body>
</html>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/layouts/footer.blade.php ENDPATH**/ ?>