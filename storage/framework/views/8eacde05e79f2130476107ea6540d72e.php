

<?php $__env->startSection('title', 'Bookings'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3><i class="fas fa-receipt"></i> Booking & Commission List</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Clinic</th>
                    <th>Amount (DZD)</th>
                    <th>Commission (DZD)</th>
                    <th>Rate %</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($booking->appointment_date); ?></td>
                    <td><?php echo e($booking->patient_name); ?></td>
                    <td><?php echo e($booking->clinic->name ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($booking->amount, 2)); ?></td>
                    <td><?php echo e(number_format($booking->commission, 2)); ?></td>
                    <td><?php echo e($booking->clinic->commission_rate ?? 0); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/bookings.blade.php ENDPATH**/ ?>