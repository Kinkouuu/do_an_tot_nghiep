<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="<?php echo e(route('admin.room-type.edit' , ['typeRoom' => $type_room['id']])); ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                    <h1 class="col-8 my-auto text-center"><?php echo e($title); ?>

                        <br>
                        <strong class="text-secondary text-uppercase">[ <?php echo e($type_room['name']); ?> ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success"
                           href="<?php echo e(route('admin.room-type.images', ['code' =>  $type_room['id']])); ?>">
                            <i class="fa-solid fa-panorama"></i>
                            Ảnh chi tiết
                        </a>
                    </div>
                </div>
                <form class="col-md-6 border-secondary border-end"
                      action="<?php echo e(route('admin.room-type.services.add', $type_room)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <h3>Danh sách dịch vụ chưa có sẵn</h3>
                            <button class="btn btn-primary" type="submit">
                                <i class="fa-regular fa-square-plus"></i>
                                Thêm
                            </button>
                        </div>
                        <?php $__currentLoopData = $services['un_provided_service']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($typeService['services'])): ?>
                                <div class="col-md-12 bg-gradient-info">
                                    <h5>
                                        <i class="<?php echo e($typeService['type_service_icon']); ?>"></i>
                                        <?php echo e($typeService['type_service_name']); ?>

                                    </h5>
                                </div>
                                <?php $__currentLoopData = $typeService['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12 d-flex justify-content-between my-2">
                                        <div class="col-md-6 px-0">
                                            <?php echo e($service['name']); ?>

                                        </div>
                                        <div class="col-md-5 px-0">
                                            <?php echo e(number_format($service['price'])); ?> VND/người/vé
                                        </div>
                                        <div class="col-md-1 px-0">
                                            <input type="checkbox" value="<?php echo e($service['id']); ?>" name="add_services[]">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </form>

                <form class="col-md-6" action="<?php echo e(route('admin.room-type.services.remove', $type_room)); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-between mb-3">
                            <button class="btn btn-danger">
                                <i class="fa-regular fa-square-minus"></i>
                                Xóa
                            </button>
                            <h3>Danh sách dịch vụ có sẵn</h3>
                        </div>
                        <?php $__currentLoopData = $services['provided_service']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($typeService['services'])): ?>
                                <div class="col-md-12 bg-gradient-info">
                                    <h5>
                                        <i class="<?php echo e($typeService['type_service_icon']); ?>"></i>
                                        <?php echo e($typeService['type_service_name']); ?>

                                    </h5>
                                </div>
                                <?php $__currentLoopData = $typeService['services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div
                                        class="col-md-12 d-flex justify-content-between my-2 align-items-center <?php echo e($service['status'] == \App\Enums\Service\ServiceStatus::DeActive ? 'bg-warning' : ''); ?>">
                                        <div class="col-md-1 px-0">
                                            <input type="checkbox" value="<?php echo e($service['id']); ?>"
                                                   name="remove_services[]">
                                        </div>
                                        <div class="col-md-4 px-0">
                                            <?php echo e($service['name']); ?>

                                        </div>
                                        <div class="col-md-4 px-0">
                                            <?php echo e(number_format($service['price'])); ?> VND/người/vé
                                        </div>
                                        <div class="col-md-3 px-0 d-flex align-items-center">
                                            <?php if (\Illuminate\Support\Facades\Blade::check('isManager')): ?>
                                                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room-service.change-discount', [
                                                'roomType' => $type_room,
                                                'service' => $service,
                                                'discount' => $service['discount']
                                                ])->html();
} elseif ($_instance->childHasBeenRendered('WbN4wcN')) {
    $componentId = $_instance->getRenderedChildComponentId('WbN4wcN');
    $componentTag = $_instance->getRenderedChildComponentTagName('WbN4wcN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('WbN4wcN');
} else {
    $response = \Livewire\Livewire::mount('room-service.change-discount', [
                                                'roomType' => $type_room,
                                                'service' => $service,
                                                'discount' => $service['discount']
                                                ]);
    $html = $response->html();
    $_instance->logRenderedChild('WbN4wcN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                                            <?php else: ?>
                                                <div class="w-100">
                                                    <div class="d-flex">
                                                        Giảm: <?php echo e($service['discount']); ?>%/vé
                                                    </div>
                                                </div>

                                                <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </form>
                </div>
            </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/services.blade.php ENDPATH**/ ?>