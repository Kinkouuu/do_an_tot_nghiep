<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.room.edit', $room['id'])); ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>

                    <h1 class="col-8 my-auto text-center"><?php echo e($title); ?>

                        <br>
                        <strong
                            class="text-secondary text-uppercase">[<?php echo e($room->name  . ' - ' . $room->branch->name . '/' .  $room->branch->city); ?>

                            ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 d-flex text-center p-0 bg-gradient-secondary">
                    <div class="col-1 p-0 border">Mã thiết bị</div>
                    <div class="col-2 p-0 border">Tên thiết bị</div>
                    <div class="col-2 p-0 border">Phân loại</div>
                    <div class="col-1 p-0 border">Nhãn hiệu</div>
                    <div class="col-2 p-0 border">Số lượng dự trữ</div>
                    <div class="col-2 p-0 border">Số lượng trang bị</div>
                    <div class="col-2 p-0 border">Ghi chú</div>
        </div>
            <?php $__currentLoopData = $room_devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room.room-device', ['room' => $room, 'room_device' => $room_device])->html();
} elseif ($_instance->childHasBeenRendered('ZKM6fh9')) {
    $componentId = $_instance->getRenderedChildComponentId('ZKM6fh9');
    $componentTag = $_instance->getRenderedChildComponentTagName('ZKM6fh9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ZKM6fh9');
} else {
    $response = \Livewire\Livewire::mount('room.room-device', ['room' => $room, 'room_device' => $room_device]);
    $html = $response->html();
    $_instance->logRenderedChild('ZKM6fh9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/rooms/devices.blade.php ENDPATH**/ ?>