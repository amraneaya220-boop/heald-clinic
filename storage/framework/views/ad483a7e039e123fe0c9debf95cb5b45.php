

<?php $__env->startSection('title', 'Pending Clinics'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-clock"></i> Pending Clinic Approvals</h3>
                    <p>Review and approve new clinic registrations</p>
                </div>
                <div class="card-body">
                    <!-- Stats Cards -->
                    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                        <div class="stat-card" style="background: #fef3c7; border-radius: 20px; padding: 20px; text-align: center;">
                            <i class="fas fa-clock" style="font-size: 40px; color: #f59e0b;"></i>
                            <h3 style="font-size: 32px; margin: 10px 0;"><?php echo e($pendingCount ?? 0); ?></h3>
                            <p style="color: #64748b;">Pending Approval</p>
                        </div>
                        <div class="stat-card" style="background: #dcfce7; border-radius: 20px; padding: 20px; text-align: center;">
                            <i class="fas fa-check-circle" style="font-size: 40px; color: #16a34a;"></i>
                            <h3 style="font-size: 32px; margin: 10px 0;"><?php echo e($approvedCount ?? 0); ?></h3>
                            <p style="color: #64748b;">Approved Clinics</p>
                        </div>
                        <div class="stat-card" style="background: #dbeafe; border-radius: 20px; padding: 20px; text-align: center;">
                            <i class="fas fa-hospital" style="font-size: 40px; color: #2563eb;"></i>
                            <h3 style="font-size: 32px; margin: 10px 0;"><?php echo e($totalCount ?? 0); ?></h3>
                            <p style="color: #64748b;">Total Clinics</p>
                        </div>
                    </div>
                    
                    <?php if(count($pendingClinics) > 0): ?>
                    <div style="overflow-x: auto;">
                        <table class="table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">ID</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Clinic Name</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Email</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Phone</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Location</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Registered Date</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $pendingClinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo e($clinic->id); ?></td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                                        <strong><?php echo e($clinic->name); ?></strong>
                                    </td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo e($clinic->user->email ?? 'N/A'); ?></td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo e($clinic->phone ?? 'N/A'); ?></td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo e($clinic->location ?? 'N/A'); ?></td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;"><?php echo e($clinic->created_at->format('Y-m-d')); ?></td>
                                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                                        <button class="btn-approve" onclick="approveClinic(<?php echo e($clinic->id); ?>)" style="background: #10b981; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; margin-right: 8px;">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                        <button class="btn-reject" onclick="rejectClinic(<?php echo e($clinic->id); ?>)" style="background: #ef4444; color: white; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer;">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div style="text-align: center; padding: 60px;">
                        <i class="fas fa-check-circle" style="font-size: 60px; color: #10b981;"></i>
                        <h3 style="margin-top: 20px;">No Pending Clinics</h3>
                        <p style="color: #64748b;">All clinics have been reviewed and approved.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .card-header h3 {
        margin: 0;
        color: #1e293b;
    }
    .card-header p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 14px;
    }
    .card-body {
        padding: 25px;
    }
    .table {
        width: 100%;
    }
    .table th {
        background: #f8fafc;
        font-weight: 600;
    }
    .btn-approve:hover {
        background: #059669 !important;
        transform: translateY(-1px);
    }
    .btn-reject:hover {
        background: #dc2626 !important;
        transform: translateY(-1px);
    }
</style>

<script>
    function approveClinic(id) {
        if (confirm('Approve this clinic? They will get 2 free trials.')) {
            fetch(`/admin/clinics/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Clinic approved successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error: ' + error));
        }
    }
    
    function rejectClinic(id) {
        if (confirm('Reject this clinic? This action cannot be undone.')) {
            fetch(`/admin/clinics/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Clinic rejected and removed!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error: ' + error));
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/clinics_pending.blade.php ENDPATH**/ ?>