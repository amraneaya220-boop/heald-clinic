<?php $__env->startSection('title', 'Invoices'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-white">
    <h3><i class="fas fa-receipt"></i> 🧾 Invoices List</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr><th>📄 Invoice #</th><th>📅 Date</th><th>🏥 Clinic</th><th>💰 Amount (DZD)</th><th>📌 Status</th><th>⚙️ Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($inv->invoice_number); ?></td>
                    <td><?php echo e($inv->date); ?></td>
                    <td><?php echo e($inv->clinic->name ?? 'N/A'); ?></td>
                    <td><?php echo e(number_format($inv->amount)); ?></td>
                    <td><span class="status-<?php echo e($inv->status); ?>"><?php echo e(ucfirst($inv->status)); ?></span></td>
                    <td><button class="btn-sm" onclick="viewInvoice(<?php echo e($inv->id); ?>)">View</button></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" style="text-align:center;">No invoices found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function viewInvoice(id) {
        alert('Invoice details will be shown here.');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('patient.layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/patient/invoices.blade.php ENDPATH**/ ?>