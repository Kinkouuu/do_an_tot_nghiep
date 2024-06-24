<?php
    use App\Enums\Booking\BookingFilterColumns;
    use App\Enums\User\UserGender;
    use App\Enums\Booking\BookingStatus;
    use Carbon\Carbon;
?>


<?php $__env->startSection('content'); ?>
    <div class="container-fluid d-flex py-3 col-md-12">
        <div class="col-md-4 d-flex align-items-center">
            <h4 class="text-right m-0 text-bold text-uppercase"><?php echo e($title); ?></h4>
        </div>
        <form class="col-md-5 d-flex justify-content-around align-items-center" method="GET">
            <span class="mr-2">Sắp xếp theo: </span>
            <select class="form-control w-25" name="by">
                <?php $__currentLoopData = BookingFilterColumns::asArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookingFilter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($bookingFilter['key']); ?>" <?php echo e((request()->input('by') == $bookingFilter['key']) ? 'selected' : ''); ?>><?php echo e($bookingFilter['value']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    <div class="table-responsive" style="min-height: 75vh">
        <table class="table table-bordered table-striped mx-1" style="width: max-content">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Chi nhánh</th>
                <th scope="col">Người đặt</th>
                <th scope="col">Họ tên</th>
                <th scope="col">SDT</th>
                <th scope="col">Quốc tịch</th>
                <th scope="col">Loại</th>
                <th scope="col">Thời gian</th>
                <th scope="col">Tổng</th>
                <th scope="col">PT Thanh toán</th>
                <th scope="col">Cần thanh toán</th>
                <th scope="col">Ngày đặt</th>
                <th scope="col">Trạng thái</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <th scope="row">
                        <?php echo e($booking['booking_id']); ?>

                        <br>
                        <span style="font-weight: lighter">(<?php echo e(base64_encode($booking['booking_id'])); ?>)</span>
                    </th>
                    <td class="text-capitalize"><?php echo e($booking['branch_name']); ?></td>
                    <?php if(isset($booking['user']['customer'])): ?>
                        <td class="text-capitalize">
                            <a style="text-decoration: underline" class="text-info" href="<?php echo e(route('admin.users.edit', $booking['user']['id'])); ?>"><?php echo e($booking['user']['customer']['name']); ?></a>
                        </td>
                    <?php else: ?>
                        <td class="text-black">Khách vãng lai</td>
                    <?php endif; ?>
                    <td class="text-capitalize"><?php echo e($booking['gender'] == UserGender::Male ? 'Anh' : 'Chị'); ?>: <?php echo e($booking['name']); ?></td>
                    <td><?php echo e($booking['phone']); ?></td>
                    <td class="text-capitalize"><?php echo e($booking['country']); ?></td>
                    <td class="text-capitalize"><?php echo e($booking['type']); ?></td>
                    <td class="text-capitalize">
                        check-in: <?php echo e(Carbon::parse($booking['booking_checkin'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?>

                        <br>
                        check-out: <?php echo e(Carbon::parse($booking['booking_checkout'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?>

                    </td>
                    <td class="text-capitalize">
                        Thời gian: <span class="text-info"><?php echo e($booking['total_time']); ?></span>
                        <br>
                        Số phòng: <span class="text-info"><?php echo e($booking['total_room']); ?> phòng</span>
                        <br>
                        Chi phí: <span class="text-info"><?php echo e(number_format($booking['total_price'], 0, ',', '.')); ?> VND</span>
                    </td>
                    <td class="text-capitalize">
                        <span class="text-info"><?php echo e($booking['payment_type']); ?></span>
                        <br>
                        <span class="text-danger"> - <?php echo e(number_format($booking['deposit'], 0, ',', '.')); ?> VND</span>
                    </td>
                    <td>
                        <span class="text-warning"><?php echo e(number_format($booking['total_price'] - $booking['deposit'], 0, ',', '.')); ?> VND</span>
                    </td>
                    <td>
                        <span class="text-capitalize"> <?php echo e(Carbon::parse($booking['created_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                    </td>
                    <td>
                        <?php
                            foreach (BookingStatus::asArray() as $bookingStatus) {
                                if($booking['status'] == $bookingStatus['key']) {
                                     $status = $bookingStatus['value'];
                                    break;
                                } else {
                                    $status = null;
                                }
                            }
                        ?>
                        <span>
                            <?php echo e($status); ?>

                        </span>
                    </td>
                    <td>
                        <a type="button" class="btn btn-primary mb-1" href="<?php echo e(route('admin.booking.edit', $booking['booking_id'])); ?>">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <?php if($booking['status'] = BookingStatus::Completed['key']): ?>
                            <a type="button" class="btn btn-info mb-1" href="<?php echo e(route('admin.booking.show', $booking['booking_id'])); ?>">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </a>
                            <a type="button" class="btn btn-success mb-1" href="<?php echo e(route('admin.feedback.feed-back', $booking['booking_id'])); ?>">
                                <i class="fa-regular fa-star-half-stroke"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php echo $bookings->links('pagination::bootstrap-4'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/index.blade.php ENDPATH**/ ?>