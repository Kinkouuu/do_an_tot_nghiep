<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
            <span class="mr-2">Sắp xếp theo: </span>
            <select class="form-control w-25" name="by">
                <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                <option value="name" <?php echo e((request()->input('by') == 'name') ? 'selected' : ''); ?>>Tên</option>
                <option value="status" <?php echo e((request()->input('by') == 'status') ? 'selected' : ''); ?>>Trạng thái</option>
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
        <thead class="thead-dark text-center">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên loại phòng</th>
            <th scope="col">Ảnh đại diện</th>

            <?php $__currentLoopData = \App\Enums\Room\PriceType::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <th><?php echo e($priceType['text']); ?></th>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th scope="col">Trạng thái</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($roomType['id']); ?></th>
                <td class="text-capitalize"><?php echo e($roomType['name']); ?></td>
                <td class="w-20">
                    <img class="w-100" src="<?php echo e(asset($roomType['thumb_link'])); ?>">
                </td>
                <?php $__currentLoopData = \App\Enums\Room\PriceType::getRoomPriceType(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$priceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><?php echo e(number_format($roomType['prices'][$key])); ?> VND</td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td class="text-capitalize"><?php echo e($roomType['status'] ? 'Đang hoạt động' : 'Đang tạm dừng'); ?></td>
                <td>
                    <div class="row">
                        <?php if (\Illuminate\Support\Facades\Blade::check('isAdmin')): ?>
                        <a type="button" class="col-5 btn btn-primary m-1" href="<?php echo e(route('admin.room-type.edit', ['typeRoom' => $roomType['id']])); ?>">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <?php endif; ?>
                        <a type="button" class="col-5 btn btn-success m-1" href="<?php echo e(route('admin.room-type.images', ['code' =>  $roomType['id']])); ?>">
                            <i class="fa-regular fa-image"></i>
                        </a>
                        <a type="button" class="col-5 btn btn-info m-1" href="<?php echo e(route('admin.room-type.services', ['code' =>  $roomType['id']])); ?>">
                            <i class="fa-solid fa-bell-concierge"></i>
                        </a>
                        <a type="button" class="col-5 btn btn-warning m-1 text-white" href="<?php echo e(route('admin.room-type.feedbacks', ['code' =>  $roomType['id']])); ?>">
                            <i class="fa-regular fa-star"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/index.blade.php ENDPATH**/ ?>