<?php
    use Carbon\Carbon;
?>


<?php $__env->startSection('content'); ?>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-8">
                        <form class="row">
                            <div class="col-md-4">
                                <label>Chi nhánh</label>
                                <select class="col-md-12 form-control selectpicker border" name="branch" data-live-search="true">
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option class="text-capitalize"
                                                <?php echo e(request()->get('branch') == $branch['id'] ? 'selected' : ''); ?>

                                                value="<?php echo e($branch['id']); ?>"><?php echo e($branch['name'] . ' - ' . $branch['city']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Từ ngày</label>
                                <input type="date" name="from" class="form-control find-input"
                                       value="<?php echo e(request()->get('from') ?? null); ?>">
                            </div>
                            <div class="col-md-3">
                                <label>Đến ngày</label>
                                <input type="date" name="to" class="col-md-10 form-control find-input"
                                       value="<?php echo e(request()->get('to') ?? null); ?>">
                            </div>
                            <div class="col-2 mb-0 mt-auto p-0">
                                <button class="btn btn-success">
                                    <i class="fa-solid fa-chart-pie"></i>
                                    Thống kê
                                </button>
                            </div>
                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><?php echo e($data['booking']['total']); ?></h3>

                                <p>Số đơn đặt</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#booking-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><?php echo e($data['revenue']['total']); ?></h3>

                                <p>Doanh thu ước tính</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#revenue-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><?php echo e($data['user']['total']); ?></h3>

                                <p>Người dùng mới</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a class="small-box-footer" data-toggle="collapse" href="#user-detail" role="button"
                               aria-expanded="false" aria-controls="collapseExample">
                                Chi tiết
                                <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                        <div class="col-12 collapse" id="booking-detail">
                            <div class="card card-body">
                               <div class="row">
                                   <h3 class="text-center">
                                       THỐNG KÊ ĐƠN ĐẶT PHÒNG
                                   </h3>
                                   <div class="col-md-4">
                                       <ul>
                                           <li>
                                               Tổng số đơn: <?php echo e($data['booking']['total']); ?>

                                           </li>
                                           <li>
                                               Số đơn đặt qua website: <?php echo e($data['booking']['on_web']); ?>

                                               ( <?php echo e($data['booking']['total'] >0 ? round($data['booking']['on_web'] / $data['booking']['total'], 4) * 100 :0); ?>) %
                                           </li>
                                           <li>
                                               Đang chờ: <?php echo e($data['booking']['awaiting']); ?> đơn
                                           </li>
                                           <li>
                                               Đã xác nhận:  <?php echo e($data['booking']['confirmed']); ?> đơn
                                           </li>
                                           <li>
                                               Đã hoàn thành:  <?php echo e($data['booking']['completed']); ?> đơn
                                           </li>
                                           <li>
                                               Đã hủy:  <?php echo e($data['booking']['canceled']); ?> đơn
                                           </li>
                                       </ul>
                                   </div>
                                   <div class="col-md-8">
                                       <!-- -->
                                   </div>
                               </div>
                            </div>
                        </div>
                    <div class="col-12 collapse" id="revenue-detail">
                        <div class="card card-body">
                            <div class="row">
                                <h3 class="text-center">
                                    THỐNG KÊ DOANH THU
                                </h3>
                                <div class="col-md-4">
                                    <ul>
                                        <li>
                                            Tổng doanh thu: <?php echo e(number_format($data['revenue']['revenue'], 0 ,',', '.')); ?> VND
                                        </li>
                                        <li>
                                            Tiền thuê phòng: <?php echo e(number_format($data['revenue']['price'], 0 , ',','.')); ?> VND
                                        </li>
                                        <li>
                                            Phí nhận phòng sớm: <?php echo e(number_format($data['revenue']['early_fee'], 0 , ',','.')); ?> VND
                                        </li>
                                        <li>
                                            Phí trả phòng muộn:  <?php echo e(number_format($data['revenue']['lately_fee'], 0 , ',','.')); ?> VND
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <!-- -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 collapse" id="user-detail">
                        <div class="card card-body">
                            <div class="row">
                                <h3 class="text-center">
                                    THỐNG KÊ KHÁCH HÀNG
                                </h3>
                                <div class="col-md-4">
                                    <ul>
                                        <li>
                                            Số người dùng mới: <?php echo e(number_format($data['user']['total'], 0 ,',', '.')); ?> tài khoản
                                        </li>
                                        <li>
                                            Số người dùng đã đặt phòng: <?php echo e(number_format($data['user']['users_has_booked'], 0 , ',','.')); ?> người
                                        </li>
                                        <li>
                                            Phí người dùng đã xác thực tài khoản: <?php echo e(number_format($data['user']['users_verified'], 0 , ',','.')); ?> người
                                        </li>
                                        <li>
                                            Lượng khách thực tế:  <?php echo e(number_format($data['user']['adults_customers'], 0 , ',','.')); ?> người lớn và
                                            <?php echo e(number_format($data['user']['children_customers'], 0 , ',','.')); ?> trẻ em
                                        </li>

                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <!-- -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- Main row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\DATN\VVCBooking\resources\views/admin/pages/dashboard.blade.php ENDPATH**/ ?>