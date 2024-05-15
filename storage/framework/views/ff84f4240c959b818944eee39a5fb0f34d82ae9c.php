<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.room-type.services', ['code' =>  $type_room['id']])); ?>">
                            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                            Chi tiết dịch vụ
                        </a>
                    </div>

                    <h1 class="col-8 my-auto text-center"><?php echo e($title); ?>

                        <br>
                        <strong class="text-secondary text-uppercase">[ <?php echo e($type_room['name']); ?> ]</strong>
                    </h1>
                    <div class="col-2 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.room-type.edit', ['typeRoom' => $type_room['id']])); ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Thông tin chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__errorArgs = ['fileUpload'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="error mt-3"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <div class="col-md-11 mt-5 mx-auto">

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <h3 class="text-uppercase text-center">Ảnh đại diện</h3>
                    <div class="row mx-auto mt-5">
                        <?php if($thumbnail): ?>
                            <form id="thumb-form" enctype="multipart/form-data" class="position-relative w-100 p-0"
                                  action="<?php echo e(route('admin.room-type.images.thumb', ['typeRoom' => $type_room])); ?>"
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <img class="mx-auto mb-2 w-100" src="<?php echo e(asset($thumbnail->path)); ?>"
                                     alt="Click nút bên trên để đổi ảnh">
                                <input id="thumb-upload" type="file" name="fileUpload" accept="image/*" hidden/>
                                <label for="thumb-upload">
                                    <span id="update-thumb" class="image-delete-btn w-100">Thay Ảnh Mới</span>
                                </label>
                            </form>
                        <?php else: ?>
                            <form id="thumb-form" class="w-100 d-flex image-area"
                                  action="<?php echo e(route('admin.room-type.images.thumb', ['typeRoom' => $type_room])); ?>"
                                  method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input id="thumb-upload" type="file" name="fileUpload" accept="image/*" hidden=""/>
                                <label for="thumb-upload" id="file-drag"
                                       class="w-100 d-flex align-items-center justify-content-center">
                            <span id="file-upload-btn" class="btn btn-primary">
                                <i class="fa-sharp fa-solid fa-image"></i>
                                 Chọn 1 file ảnh
                            </span>
                                </label>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="col-md-7">
                    <h3 class="text-uppercase text-center">Ảnh chi tiết</h3>
                    <div class="col-md-12 mt-5">
                        <div class="row">
                            <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <form class="position-relative col-md-5 p-0 mx-auto" method="POST"
                                      action="<?php echo e(route('admin.room-type.images.delete', $image)); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <img class="mx-auto mb-1 w-100" style="height: 150px" src="<?php echo e(asset( $image->path )); ?>" alt="Click nút bên dưới để xóa ảnh">
                                    <label>
                                        <button type="submit" class="image-delete-btn w-100">Xóa</button>
                                    </label>
                                </form>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($details) < config('constants.max_room_img')): ?>
                                <form class="col-md-5 d-flex image-area mx-auto" style="height: 150px" method="POST"
                                      id="detail-form" enctype="multipart/form-data" action="<?php echo e(route('admin.room-type.images.detail', $type_room)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input id="detail-upload" type="file" name="fileUpload" accept="image/*" hidden=""/>
                                    <label for="detail-upload" id="file-drag"
                                           class="w-100 d-flex align-items-center justify-content-center">
                                    <span id="file-upload-btn" class="btn btn-primary">
                                        <i class="fa-sharp fa-solid fa-image"></i>
                                        Chọn 1 file ảnh
                                    </span>
                                    </label>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function () {
            $('#thumb-upload').change(function () {
                $('#thumb-form').submit();
            });
        });

        $(document).ready(function () {
            $('#detail-upload').change(function () {
                $('#detail-form').submit();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/images.blade.php ENDPATH**/ ?>