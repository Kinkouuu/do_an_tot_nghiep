<?php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
    use App\Enums\Room\PriceType;
?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="col-md-12 pt-5">
            <div class="row">
                <div class="d-flex justify-content-between mt-3 mb-5">
                    <div class="col-3 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.booking.edit', $booking)); ?>">
                            <i class="fa-solid fa-file-pen"></i>
                            Chi tiết đơn đặt
                        </a>
                    </div>
                    <h1 class="col-6 my-auto text-center"><?php echo e($title); ?></h1>
                    <div class="col-3 my-auto text-center">
                        <a class="btn btn-outline-success" href="<?php echo e(route('admin.booking.show', $booking)); ?>">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                            Chi tiết hóa đơn
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
                                            <div class="col-md-12 text-center">
                                                <h2 class="mb-3 text-uppercase text-secondary"
                                                    style="text-decoration: underline">Phòng
                                                    <span
                                                        class="ms-5 m-md-0"><?php echo e($feedBack['roomType']['name']); ?></span>
                                                </h2>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="<?php echo e($feedBack->roomType->roomImages->first()->path); ?>"
                                                     alt="Ảnh phòng" class="w-100" oading="lazy">
                                            </div>
                                            <div class="col-md-8">
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

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/feed-back.blade.php ENDPATH**/ ?>