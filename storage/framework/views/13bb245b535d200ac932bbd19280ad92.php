<?php $__env->startSection('title', 'Medical Diagnoses'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-white">
    <h3><i class="fas fa-notes-medical"></i> 📋 Medical Diagnoses & Prescriptions</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr><th>📅 Date</th><th>👨‍⚕️ Doctor</th><th>🏥 Clinic</th><th>🩺 Diagnosis</th><th>💊 Prescription</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $diagnoses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($diag->date); ?></td>
                    <td><?php echo e($diag->doctor->name ?? 'N/A'); ?></td>
                    <td><?php echo e($diag->doctor->clinic->name ?? 'N/A'); ?></td>
                    <td><?php echo e($diag->diagnosis); ?></td>
                    <td><?php echo e($diag->prescription); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" style="text-align:center;">No medical records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('patient.layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/patient/diagnoses.blade.php ENDPATH**/ ?>