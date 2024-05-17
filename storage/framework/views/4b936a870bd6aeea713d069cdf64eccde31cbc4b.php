<div class="position-relative">
<!-- Carousel -->
    <div class="slide-one-item home-slider owl-carousel" >
        <div class="site-blocks-cover overlay" style="background-image: url('<?php echo e(asset('images/hero_1.jpg')); ?>') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2"><?php echo e($page_title); ?></h1>
                        <h2 class="caption"><?php echo e($page_description); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-blocks-cover overlay" style="background-image: url('<?php echo e(asset('images/hero_2.jpg')); ?>') "
             data-aos="fade" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center justify-content-center h-50">
                    <div class="col-md-7 text-center" data-aos="fade">
                        <h1 class="mb-2"><?php echo e($page_title); ?></h1>
                        <h2 class="caption"><?php echo e($page_description); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Search form -->
    <?php if (isset($component)) { $__componentOriginal388c211f7710f1d87d652d21a88b5c50f16ce562 = $component; } ?>
<?php $component = App\View\Components\RoomSearch::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('room-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\RoomSearch::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal388c211f7710f1d87d652d21a88b5c50f16ce562)): ?>
<?php $component = $__componentOriginal388c211f7710f1d87d652d21a88b5c50f16ce562; ?>
<?php unset($__componentOriginal388c211f7710f1d87d652d21a88b5c50f16ce562); ?>
<?php endif; ?>

</div>
<?php /**PATH E:\DATN\VVCBooking\resources\views/user/layouts/slide.blade.php ENDPATH**/ ?>