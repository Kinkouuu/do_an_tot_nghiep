<div class="position-relative">
<!-- Carousel -->
    <div class="slide-one-item home-slider owl-carousel" >
        <div class="site-blocks-cover overlay" style="background-image: url('<?php echo e(asset('images/hero_1.jpg')); ?>') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2 text-uppercase"><?php echo e($page_title); ?></h1>
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
                        <h1 class="mb-2 text-uppercase"><?php echo e($page_title); ?></h1>
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
} elseif ($_instance->childHasBeenRendered('KP4SoM9')) {
    $componentId = $_instance->getRenderedChildComponentId('KP4SoM9');
    $componentTag = $_instance->getRenderedChildComponentTagName('KP4SoM9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('KP4SoM9');
} else {
    $response = \Livewire\Livewire::mount('room.form-search');
    $html = $response->html();
    $_instance->logRenderedChild('KP4SoM9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/layouts/slide.blade.php ENDPATH**/ ?>