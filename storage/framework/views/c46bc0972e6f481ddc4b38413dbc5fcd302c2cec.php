<?php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
?>


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
                <div class="col-md-10 col-12 my-4 mx-auto">
                    <div class="row">
                        <?php if($feedBacks->isEmpty()): ?>
                            <h3 class="text-center">Hiện chưa có đánh giá nào</h3>
                        <?php else: ?>
                            <div class="col-md-12 pb-3" style="background-color: #f1e6b2">
                                <?php $__currentLoopData = $feedBacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedBack): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12 p-2 mt-3">
                                        <div class="row">
                                            <div class="col-md-12 mb-3 border-bottom border-warning">
                                                <div class="d-flex justify-content-center align-items-center" style="color: orangered">
                                                    <strong class="mx-2" style="font-size: xx-large"><?php echo e($rating['avg']); ?></strong>
                                                    <i class="fa-solid fa-star fa-2xl"></i>
                                                    <strong class="ml-3"><?php echo e(array_sum($rating['number'])); ?> lượt đánh
                                                        giá</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-file-invoice"></i>
                                                        <a>Mã đơn hàng: <?php echo e(base64_encode($feedBack['booking']['id'])); ?></a>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-user"></i>
                                                        <span><?php echo e($feedBack['booking']['gender'] == UserGender::Male ? 'Anh' : 'Chị'); ?>: <?php echo e($feedBack['booking']['name']); ?></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                                        <span>Số điện thoại: <?php echo e($feedBack['booking']['phone']); ?></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        <span>Chi nhánh: Khách sạn
                                                            <?php echo e($feedBack['booking']['bookingRooms']->first()->branch['name']); ?>

                                                            - <?php echo e($feedBack['booking']['bookingRooms']->first()->branch['city']); ?>

                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-restroom"></i>
                                                        <span>Số người: <?php echo e($feedBack['booking']['number_of_adults']); ?> người lớn và <?php echo e($feedBack['booking']['number_of_children']); ?> trẻ em</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>
                                                        <i class="fa-solid fa-calendar-check"></i>
                                                        <span>Ngày đặt đơn: </span>
                                                        <span class="text-capitalize"><?php echo e(Carbon::parse($feedBack['booking']['created_at'])->isoFormat('dddd, HH:mm - DD/MM/YYYY')); ?> </span>
                                                    </label>

                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <a class="text-capitalize" href="<?php echo e(route('admin.booking.edit', $feedBack['booking']['id'])); ?>">
                                                        Xem chi tiết đơn hàng->
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-3">
                                                <div class="d-flex align-items-center">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <span
                                                            class="star <?php echo e($feedBack['rate_stars'] >= $i ? 'hovered' : ''); ?>">★</span>
                                                    <?php endfor; ?>
                                                    <span class="ml-2"> <?php echo e($feedBack['rate_stars']); ?> / 5 </span>
                                                    <span class="mr-0 ml-auto"><?php echo e($feedBack['created_at']); ?></span>
                                                </div>
                                                <textarea class="form-control" disabled maxlength="255" cols="1"
                                                          rows="3"><?php echo e($feedBack['comment']); ?>

                                                </textarea>
                                                <div class="d-flex justify-content-between">
                                                    <?php if($feedBack['reply']): ?>
                                                        <p class="text-capitalize my-1">
                                                            <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                                                            <?php echo e($feedBack->admin->name); ?> đã phản hồi lúc <?php echo e($feedBack['reply_at']); ?>

                                                        </p>
                                                    <?php else: ?>
                                                        <p class="my-1">
                                                            <i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>
                                                            Phản hồi
                                                        </p>
                                                    <?php endif; ?>

                                                    <span class="text-danger" id="error-<?php echo e($feedBack['id']); ?>"></span>

                                                    <button class="reply btn btn-link" data-id="<?php echo e($feedBack['id']); ?>"> Lưu </button>
                                                </div>
                                                <textarea class="form-control" id="reply-<?php echo e($feedBack['id']); ?>" rows="3"><?php echo e($feedBack['reply']); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('.reply').click(function () {
                const id = $(this).data('id');
                const reply = $('#reply-' + id).val().trim();
                if(reply === '')
                {
                    $('#error-' + id).text('Vui lòng nhập nội dung phản hồi.')
                }else{
                    $.ajax({
                        url: '<?php echo e(route("admin.feedback.reply", ':id')); ?>'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: "<?php echo e(csrf_token()); ?>",
                            reply: reply,
                        },
                        success: function (response) {
                            console.log(response)
                            Swal.fire({
                                title: response['title'],
                                text: response['message'],
                                icon: response['status']
                            })
                        },
                        error: function (response) {
                            console.log(response);
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/room-types/feedbacks.blade.php ENDPATH**/ ?>