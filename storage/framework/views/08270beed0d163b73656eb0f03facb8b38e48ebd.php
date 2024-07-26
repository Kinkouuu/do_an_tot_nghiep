

<?php $__env->startSection('content'); ?>
        <div class="container-fluid">
            <div class="row">
               <?php if(count($roomBranches) > 0): ?>
                    <h1 class="m-auto p-5 text-capitalize"><?php echo e(__('Lựa chọn tốt nhất cho kì nghỉ của bạn')); ?>!</h1>
                    <?php $__currentLoopData = $roomBranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomBranch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room.booking-form', [
                        'roomBranch' => $roomBranch,
                         'time' => $time,
                         'condition' => $condition
                         ])->html();
} elseif ($_instance->childHasBeenRendered('ytjGeGC')) {
    $componentId = $_instance->getRenderedChildComponentId('ytjGeGC');
    $componentTag = $_instance->getRenderedChildComponentTagName('ytjGeGC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ytjGeGC');
} else {
    $response = \Livewire\Livewire::mount('room.booking-form', [
                        'roomBranch' => $roomBranch,
                         'time' => $time,
                         'condition' => $condition
                         ]);
    $html = $response->html();
    $_instance->logRenderedChild('ytjGeGC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                   <h1 class="m-auto p-5"><?php echo e(__('Hiện không đủ phòng trống. Bạn thử đặt ngày khác nha')); ?>!</h1>
                <?php endif; ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/user/pages/rooms/response-search-list.blade.php ENDPATH**/ ?>