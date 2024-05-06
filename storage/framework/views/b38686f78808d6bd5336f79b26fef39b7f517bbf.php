<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
                <span class="mr-2">Sắp xếp theo: <?php echo e(( request()->input('by') === 'country') ? 'selected' : ''); ?></span>
                <select class="form-control w-25" name="by">
                    <option value="id" <?php echo e((request()->input('by') == 'id') ? 'selected' : ''); ?>>ID</option>
                    <option value="country" <?php echo e((request()->input('by') == 'country') ? 'selected' : ''); ?>>Quốc tịch</option>
                    <option value="name" <?php echo e((request()->input('by') == 'name') ? 'selected' : ''); ?>>Họ tên</option>
                    <option value="created_by" <?php echo e((request()->input('by') == 'created_by') ? 'selected' : ''); ?>>Người tạo</option>
                </select>
                <select class="form-control w-25" name="sort">
                    <option value="DESC" <?php echo e((request()->input('sort') == 'DESC') ? 'selected' : ''); ?>> Giảm dần</option>
                    <option value="ASC" <?php echo e((request()->input('sort') == 'ASC') ? 'selected' : ''); ?>>Tăng dần</option>
                </select>
                <button type="submit" class="btn btn-info">
                    <i class="fa-solid fa-filter"></i>
                </button>
        </form>
        <div class="col-md-3 d-flex justify-content-around">
            <div class="d-flex ">
                <div class="border bg-light text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">No account</span>
                </div>
                <div class="bg-secondary text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Cancel</span>
                </div>
                <div class="bg-success text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Active</span>
                </div>
                <div class="bg-warning text-center mx-2" style="width: 60px; height: 60px;">
                    <span class="text-center">Banned</span>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-striped mx-1">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Quốc tịch</th>
            <th scope="col">Giới tính</th>
            <th scope="col">CCCD/CMT/Visa</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>

            <th scope="col">Người tạo</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
       <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <tr id="customer-<?php echo e($customer->id); ?>"
               class="<?php echo e(isset($customer->user->status)
                      ? match ($customer->user->status) {
                        \App\Enums\UserStatus::Cancelled => 'bg-secondary',
                        \App\Enums\UserStatus::Active => 'bg-success',
                        \App\Enums\UserStatus::Banned => 'bg-warning',
                       }
                    : null); ?>"
           >
               <th scope="row"><?php echo e($customer->id); ?></th>
               <td class="text-capitalize"><?php echo e($customer->name); ?></td>
               <td class="text-capitalize"><?php echo e($customer->country); ?></td>
               <td><?php echo e($customer->gender == \App\Enums\User\UserGender::Female ? 'Nữ' : 'Nam'); ?></td>
               <td><?php echo e($customer->citizen_id); ?></td>
               <td><?php echo e($customer->user->email ?? null); ?></td>
               <td><?php echo e($customer->user->phone ?? null); ?></td>








               <td class="text-capitalize"><?php echo e($customer->created_by); ?></td>
               <td>
                   <a type="button" class="btn btn-primary mb-1" href="<?php echo e(route('admin.customers.edit', $customer)); ?>">
                       <i class="fa-regular fa-pen-to-square"></i>
                   </a>
                   <button type="button" class="btn btn-danger delete-btn" value="<?php echo e($customer->id); ?>">
                       <i class="fa-solid fa-trash"></i>
                   </button>
               </td>
           </tr>
       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php echo $customers->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                const id = $(this).val();
                const url = '<?php echo e(route("admin.customers.destroy", ':id')); ?>'.replace(':id', id);
                Swal.fire({
                    title: 'Bạn chắc chắn muốn xóa?',
                    text: "Bạn sẽ không thể hoàn tác lại hành động này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                        },
                        success: function (response) {
                            $('#customer-' + id).remove();
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                                })
                        },
                        error: function (response) {
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                            })
                        }
                    });
                }
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/customers/index.blade.php ENDPATH**/ ?>