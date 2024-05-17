<h3 class="footer-heading mb-4 text-white">Chi nhánh</h3>
<ul class="list-unstyled">
    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li> <?php echo e($branch->name); ?>:
            <br><?php echo e($branch->address); ?> - <?php echo e($branch->city); ?>

            <br>Hotline: <a href="tel:<?php echo e($branch->phone); ?>"><?php echo e($branch->phone); ?></a>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <li>
        <a class="" href="#">
            Xem thêm <?php echo e($branchesNumber); ?> chi nhánh khác...
        </a>
    </li>
</ul>
<?php /**PATH E:\DATN\VVCBooking\resources\views/components/branches.blade.php ENDPATH**/ ?>