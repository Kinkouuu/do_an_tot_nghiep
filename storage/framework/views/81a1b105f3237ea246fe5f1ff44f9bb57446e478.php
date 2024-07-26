<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center p-0">
            <h4 class=" px-0 m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-9 d-flex">
            <div class="col-md-6 d-flex justify-content-around align-items-center" method="GET">
                <span class="mr-2">Sắp xếp theo: <?php echo e(( request()->input('by') === 'country') ? 'selected' : ''); ?></span>
                <select class="form-control w-25" name="by">
                    <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                    <option value="email" <?php echo e((request()->input('by') == 'email') ? 'selected' : ''); ?>>Email</option>
                    <option value="phone" <?php echo e((request()->input('by') == 'phone') ? 'selected' : ''); ?>>SDT</option>
                    <option value="status" <?php echo e((request()->input('by') == 'status') ? 'selected' : ''); ?>>Trạng Thái
                    </option>
                </select>
                <select class="form-control w-25" name="sort">
                    <option value="DESC" <?php echo e((request()->input('sort') == 'DESC') ? 'selected' : ''); ?>> Giảm dần</option>
                    <option value="ASC" <?php echo e((request()->input('sort') == 'ASC') ? 'selected' : ''); ?>>Tăng dần</option>
                </select>

            </div>
            <div class="col-md-6 d-flex justify-content-around align-items-center">
                <div class="d-flex">
                    <span class="mr-2">Trạng thái: </span>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="<?php echo e(\App\Enums\UserStatus::Cancelled); ?>" id="defaultCheck1"
                            <?php echo e((request()->get('status') != null) && in_array(\App\Enums\UserStatus::Cancelled,request()->get('status')) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="defaultCheck1">
                            Cancelled
                        </label>
                    </div>
                    <div class="form-check ">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="<?php echo e(\App\Enums\UserStatus::Active); ?>" id="defaultCheck2"
                            <?php echo e((request()->get('status') != null) && in_array(\App\Enums\UserStatus::Active,request()->get('status')) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="defaultCheck2">
                            Active
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status[]"
                               value="<?php echo e(\App\Enums\UserStatus::Banned); ?>" id="defaultCheck3"
                            <?php echo e((request()->get('status') != null) && in_array(\App\Enums\UserStatus::Banned,request()->get('status')) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="defaultCheck3">
                            Banned
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-info">
                    <i class="fa-solid fa-filter"></i>
                    Lọc
                </button>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">Tên</th>
            <th scope="col">Quốc tịch</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">CCCD/CMT/Visa</th>
            <th scope="col">Trạng thái tài khoản</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($user->id); ?></th>
                <td><?php echo e($user->email); ?></td>
                <td class="text-capitalize"><?php echo e($user->phone); ?></td>
                <td class="text-capitalize"><?php echo e($user->customer?->name); ?></td>
                <td class="text-capitalize"><?php echo e($user->customer?->country); ?></td>
                <td class="text-capitalize"><?php echo e($user->customer?->address); ?></td>
                <td><?php echo e($user->customer?->citizen_id); ?></td>

                <td style="min-width: 180px">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('status.change-status', ['item' => $user])->html();
} elseif ($_instance->childHasBeenRendered('pHfBt0Z')) {
    $componentId = $_instance->getRenderedChildComponentId('pHfBt0Z');
    $componentTag = $_instance->getRenderedChildComponentTagName('pHfBt0Z');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pHfBt0Z');
} else {
    $response = \Livewire\Livewire::mount('status.change-status', ['item' => $user]);
    $html = $response->html();
    $_instance->logRenderedChild('pHfBt0Z', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </td>
                <td>
                    <a type="button" class="btn btn-primary mb-1" href="<?php echo e(route('admin.users.edit', $user)); ?>">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo $users->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/users/index.blade.php ENDPATH**/ ?>