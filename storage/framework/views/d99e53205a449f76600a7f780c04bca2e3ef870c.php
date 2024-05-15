<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
            <span class="mr-2">Sắp xếp theo: </span>
            <select class="form-control w-25" name="by">
                <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                <option value="type_device" <?php echo e((request()->input('by') == 'type_device') ? 'selected' : ''); ?>>Loại thiết bị</option>
                <option value="name" <?php echo e((request()->input('by') == 'name') ? 'selected' : ''); ?>>Tên</option>
                <option value="rental_price" <?php echo e((request()->input('by') == 'rental_price') ? 'selected' : ''); ?>>Giá</option>
                <option value="brand" <?php echo e((request()->input('by') == 'brand') ? 'selected' : ''); ?>>Nhãn hiệu</option>
                <option value="quantity" <?php echo e((request()->input('by') == 'quantity') ? 'selected' : ''); ?>>Số lượng</option>
            </select>
            <select class="form-control w-25" name="sort">
                <option value="0" <?php echo e((request()->input('sort') == '0') ? 'selected' : ''); ?>>Tăng dần</option>
                <option value="1" <?php echo e((request()->input('sort') == '1') ? 'selected' : ''); ?>> Giảm dần</option>
            </select>
            <button type="submit" class="btn btn-info">
                <i class="fa-solid fa-filter"></i>
            </button>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Loại thiết bị</th>
            <th scope="col">Tên thiết bị</th>
            <th scope="col">Nhãn hiệu</th>
            <th scope="col">Giá cho thuê</th>
            <th scope="col">Tổng số lượng</th>
            <th scope="col">Đang sử dụng</th>
            <th scope="col">Cho thuê thiết bị</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($device['id']); ?></th>
                <th class="text-capitalize"><?php echo e($device['type_device']); ?></th>
                <td class="text-capitalize"><?php echo e($device['name']); ?></td>
                <td class="text-capitalize"><?php echo e($device['brand']); ?></td>
                <td><?php echo e(number_format($device['rental_price'])); ?> VND/thiết bị/ngày</td>
                <td><?php echo e(number_format($device['quantity'])); ?> thiết bị</td>
                <td><?php echo e(number_format($device['equipping_quantity'])); ?> thiết bị</td>

                <td><?php echo e($device['for_rent']); ?></td>
                <td>
                    <a type="button" class="btn btn-primary mb-1" href="<?php echo e(route('admin.devices.edit', $device['id'])); ?>">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo $devices->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/devices/index.blade.php ENDPATH**/ ?>