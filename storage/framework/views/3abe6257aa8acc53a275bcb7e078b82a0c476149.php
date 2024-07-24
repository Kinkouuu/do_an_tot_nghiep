<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-11 mt-5 mx-auto">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room.option-form', [
           'branch' => $branch,
           'rooms' => $rooms,
           'condition' => $condition,
          ])->html();
} elseif ($_instance->childHasBeenRendered('N9cyvUr')) {
    $componentId = $_instance->getRenderedChildComponentId('N9cyvUr');
    $componentTag = $_instance->getRenderedChildComponentTagName('N9cyvUr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('N9cyvUr');
} else {
    $response = \Livewire\Livewire::mount('room.option-form', [
           'branch' => $branch,
           'rooms' => $rooms,
           'condition' => $condition,
          ]);
    $html = $response->html();
    $_instance->logRenderedChild('N9cyvUr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/rooms/search-more-option.blade.php ENDPATH**/ ?>