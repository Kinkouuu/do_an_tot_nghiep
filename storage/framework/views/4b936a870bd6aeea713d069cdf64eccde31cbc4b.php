<div class="position-relative">
<!-- Carousel -->
    <div class="slide-one-item home-slider owl-carousel" >
        <div class="site-blocks-cover overlay" style="background-image: url('<?php echo e(asset('images/hero_1.jpg')); ?>') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2 text-uppercase"><?php echo e(__($page_title)); ?></h1>
                        <h2 class="caption"><?php echo e($page_description ?? null); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-blocks-cover overlay" style="background-image: url('<?php echo e(asset('images/hero_2.jpg')); ?>') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2 text-uppercase"><?php echo e(__($page_title)); ?></h1>
                        <h2 class="caption"><?php echo e($page_description ?? null); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Search form -->
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room.form-search')->html();
} elseif ($_instance->childHasBeenRendered('LnTFnhC')) {
    $componentId = $_instance->getRenderedChildComponentId('LnTFnhC');
    $componentTag = $_instance->getRenderedChildComponentTagName('LnTFnhC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('LnTFnhC');
} else {
    $response = \Livewire\Livewire::mount('room.form-search');
    $html = $response->html();
    $_instance->logRenderedChild('LnTFnhC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/layouts/slide.blade.php ENDPATH**/ ?>