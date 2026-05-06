

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-hospital"></i>
        <h3><?php echo e($totalClinics); ?></h3>
        <p>Total Clinics</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-dollar-sign"></i>
        <h3><?php echo e(number_format($totalRevenue, 2)); ?> DZD</h3>
        <p>Total Commission</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-calendar-check"></i>
        <h3><?php echo e($totalBookings); ?></h3>
        <p>Total Bookings</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-ad"></i>
        <h3><?php echo e($activeAds); ?></h3>
        <p>Active Ads</p>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-chart-simple"></i> Recent Activity</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Clinic</th>
                    <th>Amount</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($booking->appointment_date); ?></td>
                    <td><?php echo e($booking->patient_name); ?></td>
                    <td><?php echo e($booking->clinic->name ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($booking->amount, 2)); ?> DZD</td>
                    <td><?php echo e(number_format($booking->commission, 2)); ?> DZD</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" style="text-align: center;">No recent bookings</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/dashboard.blade.php ENDPATH**/ ?>