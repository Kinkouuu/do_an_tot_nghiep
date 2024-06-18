<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center">
            <h4 class="text-left m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-9 d-flex justify-content-around align-items-center" method="GET">
            <div class="col-md-12 p-0">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <span class="mr-2">Sắp xếp theo: </span>
                        <select class="form-control w-25" name="by">
                            <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                            <option value="name" <?php echo e((request()->input('by') == 'name') ? 'selected' : ''); ?>>Tên</option>
                            <option
                                value="room_type" <?php echo e((request()->input('by') == 'room_type') ? 'selected' : ''); ?>>
                                Loại phòng
                            </option>
                            <option value="branch" <?php echo e((request()->input('by') == 'branch') ? 'selected' : ''); ?>>
                                Chi nhánh
                            </option>
                            <option value="city" <?php echo e((request()->input('by') == 'city') ? 'selected' : ''); ?>>
                               Thành phố
                            </option>
                        </select>
                        <select class="form-control w-25" name="sort">
                            <option value="0" <?php echo e((request()->input('sort') == '0') ? 'selected' : ''); ?>>Tăng dần
                            </option>
                            <option value="1" <?php echo e((request()->input('sort') == '1') ? 'selected' : ''); ?>> Giảm dần
                            </option>
                        </select>
                        <button type="submit" class="btn btn-info">
                            <i class="fa-solid fa-filter"></i>
                            Lọc
                        </button>
                    </div>

                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <span class="mr-2">Trạng thái: </span>
                            <?php $__currentLoopData = \App\Enums\Room\RoomStatus::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="status[]"
                                           value="<?php echo e($status['key']); ?>" id="defaultCheck<?php echo e($key); ?>"
                                        <?php echo e(request()->get('status') === null || in_array($status['key'], request()->get('status')) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="defaultCheck<?php echo e($key); ?>">
                                        <?php echo e($status['value']); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark text-center">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên phòng</th>
            <th scope="col">Phân loại phòng</th>
            <th scope="col">Chi nhánh</th>
            <th scope="col">Trạng thái</th>
            <th>
                <a class="btn btn-primary" href="<?php echo e(route('admin.room.create')); ?>">
                    <i class="fa-solid fa-square-plus"></i>
                    Thêm phòng
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($room['id']); ?></th>
                <td class="text-capitalize"><?php echo e($room['name']); ?></td>
                <td class="text-capitalize"><?php echo e($room['room_type']); ?></td>
                <td class="text-capitalize"><?php echo e($room['branch'] . ' - ' . $room['city']); ?></td>

                <td class="text-capitalize">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('room.room-status', ['roomId' => $room['id']])->html();
} elseif ($_instance->childHasBeenRendered('NVO7sMW')) {
    $componentId = $_instance->getRenderedChildComponentId('NVO7sMW');
    $componentTag = $_instance->getRenderedChildComponentTagName('NVO7sMW');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('NVO7sMW');
} else {
    $response = \Livewire\Livewire::mount('room.room-status', ['roomId' => $room['id']]);
    $html = $response->html();
    $_instance->logRenderedChild('NVO7sMW', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </td>
                <td>
                    <a type="button" class="btn btn-success mb-1" href="<?php echo e(route('admin.room.edit', $room['id'])); ?>">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <a type="button" class="btn btn-info mb-1" href="<?php echo e(route('admin.room.devices', $room['id'])); ?>">
                        <i class="fa-regular fa-hard-drive"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo $rooms->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/rooms/index.blade.php ENDPATH**/ ?>