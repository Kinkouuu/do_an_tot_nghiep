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
               value="<?php echo e(request()->get('from') ?? null); ?>" min="<?php echo e($maxFrom); ?>">
    </div>
    <div class="col-md-3">
        <label>Đến ngày</label>
        <input type="date" name="to" class="col-md-10 form-control find-input"
               value="<?php echo e(request()->get('to') ?? null); ?>" max="<?php echo e(\Carbon\Carbon::today()->toString()); ?>" onchange="setMaxFrom($event.target.value)">
    </div>
    <div class="col-2 mb-0 mt-auto p-0">
        <button class="btn btn-success">
            <i class="fa-solid fa-chart-pie"></i>
            Thống kê
        </button>
    </div>
</form>
<?php /**PATH E:\DATN\VVCBooking\resources\views/livewire/statistic/filter.blade.php ENDPATH**/ ?>