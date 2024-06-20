<?php
    use App\Enums\User\UserGender;
    use Carbon\Carbon;
    use App\Enums\Booking\PaymentType;
    use App\Enums\Booking\BookingStatus;
?>
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h1> Invoice </h1>
    <div class="col-md-11 mt-4 border mx-auto bg-white" id="invoice"  style="font-family: 'DejaVu Sans'">
        <div class="col-md-8 mx-auto my-3 text-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>">
            <h3 class="text-uppercase my-5" > Công ty TNHH thương mại và Dịch vụ VVC</h3>
            <strong class="text-capitalize mt-5">Hóa đơn thanh toán dịch vụ đặt phòng</strong>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <p>
                        <strong><?php echo e($booking['booking']['gender'] ==  UserGender::Male ? 'Anh' : 'Chị'); ?>: </strong>
                        <?php echo e($booking['booking']['name']); ?>

                    </p>
                    <p>
                        <strong>Địa chỉ: <?php echo e($booking['branch']['name']); ?></strong>
                        - <?php echo e($booking['branch']['address'] . ', ' . $booking['branch']['city']); ?>

                    </p>
                    <p>
                        <strong>Hotline: </strong>
                        <?php echo e($booking['branch']['phone']); ?>

                    </p>
                    <p>
                        <strong>Nhân viên thu ngân: </strong>
                        <span class="text-capitalize"> <?php echo e(auth()->guard('admins')->user()->name); ?></span>
                    </p>
                </div>
                <div class="col-md-5">
                    <p>
                        <strong>Mã đơn hàng:</strong>
                        <?php echo e(base64_encode($booking['booking']['id'])); ?>

                    </p>
                    <p>
                        <strong>Ngày nhận phòng: </strong>
                        <span class="text-capitalize"> <?php echo e(Carbon::parse($booking['booking']['booking_checkin'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                    </p>
                    <p>
                        <strong>Ngày trả phòng: </strong>
                        <span class="text-capitalize"> <?php echo e(Carbon::parse($booking['booking']['booking_checkout'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                    </p>
                    <p>
                        <strong>Ngày tạo đơn: </strong>
                        <span class="text-capitalize"> <?php echo e($booking['booking']['created_at']->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                    </p>
                </div>
                <div class="col-md-12 table-responsive" >
                    <table class="table table-hover table-light" style="width: max-content; min-width: 100%;">
                        <thead>
                        <tr class="bg-danger">
                            <th scope="col">#</th>
                            <th scope="col">Phòng</th>
                            <th scope="col">Loại phòng</th>
                            <th scope="col">Giá phòng</th>
                            <th scope="col">Phụ phí</th>
                            <th scope="col">Nhận|Trả phòng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $booking['rooms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th scope="row"><?php echo e($key+1); ?></th>
                                <td class="text-capitalize">
                                    <?php echo e($room['room_name']); ?>

                                </td>
                                <td class="text-uppercase">
                                    <?php echo e($room['room_type']); ?>

                                </td>
                                <td class="text-uppercase">
                                    <?php echo e(number_format($room['price'], 0, ',' , '.')); ?> VND
                                </td>
                                <td>
                                    <ul class="p-1">
                                        <li class="text-<?php echo e($room['early_time'] > 0 ? 'danger' : 'primary'); ?>">
                                            <strong>Checkin sớm(<?php echo e($room['early_time']); ?> giờ): </strong> <br>
                                            <?php echo e(number_format($room['early_fee'], 0, ',' , '.')); ?> VND
                                        </li>
                                        <li class="text-<?php echo e($room['lately_time'] > 0 ? 'danger' : 'primary'); ?>">
                                            <strong>Checkout muộn(<?php echo e($room['lately_time']); ?> giờ):  </strong> <br>
                                            <?php echo e(number_format($room['lately_fee'], 0, ',' , '.')); ?> VND
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="p-1">
                                        <li>
                                            <strong>Checkin: </strong><br>
                                            <span class="text-capitalize"><?php echo e(Carbon::parse( $room['checkin_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                                        </li>
                                        <li>
                                            <strong>Checkout: </strong><br>
                                            <span class="text-capitalize"><?php echo e(Carbon::parse( $room['checkout_at'])->isoFormat('dddd, HH:mm DD/MM/YYYY')); ?></span>
                                        </li>
                                    </ul>
                                </td>
                                <td class="text-info">
                                    <strong><?php echo e(number_format($room['price'] + $room['early_fee'] + $room['lately_fee'], 0, ',', '.')); ?> VND</strong>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row">TỔNG </th>
                            <td colspan="4" class="text-capitalize text-right">
                                <strong>Thời gian thuê phòng:</strong>
                                <?php echo e($booking['duration']); ?>

                            </td>
                            <td>
                                <strong>Số lượng phòng:</strong>
                                <?php echo e(count($booking['rooms'])); ?>

                            </td>
                            <td class="text-success">
                                <strong><?php echo e(number_format($booking['total'], 0 , ',', '.')); ?> VND</strong>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="5" scope="row">Phương thức thanh toán: </th>
                            <td class="text-capitalize">
                                <strong
                                    class="text-danger"><?php echo e(PaymentType::getValue($booking['booking']['payment_type'])); ?></strong>
                            </td>
                            <td class="text-danger">
                                <strong>-<?php echo e(number_format($booking['booking']['deposit'], 0 , ',', '.')); ?> VND</strong>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="6" scope="row">Cần thanh toán: </th>
                            <td class="text-warning">
                                <strong><?php echo e(number_format($booking['total'] - $booking['booking']['deposit'], 0 , ',', '.')); ?> VND</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">

                </div>
            </div>
        </div>
    </div>
</div>
<h2>asdas</h2>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</html>
<?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/bookings/tesr.blade.php ENDPATH**/ ?>