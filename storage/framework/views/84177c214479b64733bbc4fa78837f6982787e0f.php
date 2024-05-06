

<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-3 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-9 d-flex">
            <div class="col-md-6 d-flex justify-content-around align-items-center" method="GET">
                <span class="mr-2">Sắp xếp theo: <?php echo e(( request()->input('by') === 'country') ? 'selected' : ''); ?></span>
                <select class="form-control w-25" name="by">
                    <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                    <option value="account_name" <?php echo e((request()->input('by') == 'account_name') ? 'selected' : ''); ?>>Tên tài khoản</option>
                    <option value="email" <?php echo e((request()->input('by') == 'email') ? 'selected' : ''); ?>>Email</option>
                    <option value="phone" <?php echo e((request()->input('by') == 'phone') ? 'selected' : ''); ?>>SDT</option>
                    <option value="status" <?php echo e((request()->input('by') == 'status') ? 'selected' : ''); ?>>Trạng Thái</option>
                    <option value="role" <?php echo e((request()->input('by') == 'role') ? 'selected' : ''); ?>>Chức vụ</option>
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
            <th scope="col">Tên</th>
            <th scope="col">Tài khoản</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">CCCD/CMT</th>
            <th scope="col">Ngày sinh</th>
            <th scope="col">Giới tính</th>
            <th scope="col">Trạng thái tài khoản</th>
            <th scope="col">Chức vụ</th>
            <th>
                <a type="button" class="btn btn-success" href="<?php echo e(route('admin.staffs.create')); ?>">
                    <i class="fa-solid fa-user-plus"></i>
                    Thêm
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $staffs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <th scope="row"><?php echo e($staff->id); ?></th>
                <td class="text-capitalize"><?php echo e($staff->name); ?></td>
                <td class="text-capitalize"><?php echo e($staff->account_name); ?></td>
                <td><?php echo e($staff->email); ?></td>
                <td><?php echo e($staff->phone); ?></td>
                <td><?php echo e($staff->citizen_id); ?></td>
                <td><?php echo e($staff->birth_day); ?></td>
                <td><?php echo e($staff->gender == \App\Enums\User\UserGender::Female ? 'Nữ' : 'Nam'); ?></td>
                <td style="min-width: 180px">
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('status.change-status', ['item' => $staff])->html();
} elseif ($_instance->childHasBeenRendered('tEer21f')) {
    $componentId = $_instance->getRenderedChildComponentId('tEer21f');
    $componentTag = $_instance->getRenderedChildComponentTagName('tEer21f');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('tEer21f');
} else {
    $response = \Livewire\Livewire::mount('status.change-status', ['item' => $staff]);
    $html = $response->html();
    $_instance->logRenderedChild('tEer21f', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                </td>
                <td class="text-capitalize"><?php echo e($staff->role); ?></td>

                <td>
                    <a type="button" class="btn btn-primary mb-1" href="<?php echo e(route('admin.staffs.edit', $staff)); ?>">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo e($staff->id); ?>">
                        <i class="fa-solid fa-arrow-down-up-lock text-light"></i>
                    </button>

                    <!-- Modal -->
                    <form action="<?php echo e(route('admin.staffs.reset-password', $staff)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal fade" id="exampleModal-<?php echo e($staff->id); ?>" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Cấp lại mật khẩu cho
                                            <span class="text-secondary text-bold"><?php echo e($staff->account_name); ?></span>
                                        </h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="password" class="form-control mb-3" placeholder="Mật khẩu mới"
                                               name="password">
                                        <input type="password" class="form-control mb-3" placeholder="Nhập lại mật khẩu mới"
                                               name="re-password">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy
                                        </button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Modal -->
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo $staffs->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/staffs/index.blade.php ENDPATH**/ ?>