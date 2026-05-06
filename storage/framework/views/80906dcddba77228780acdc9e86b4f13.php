

<?php $__env->startSection('title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <h3><i class="fas fa-credit-card"></i> Payment Requests</h3>
        <button class="btn-sm" id="openPaymentModal" style="padding: 10px 20px;"><i class="fas fa-plus"></i> New Payment Request</button>
    </div>
    
    <!-- Stats Summary -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 20px;">
        <div style="background: #f8fafc; padding: 15px; border-radius: 12px; text-align: center;">
            <h4 style="color: #1e293b;"><?php echo e($totalPayments ?? 0); ?></h4>
            <small style="color: #64748b;">Total Payments</small>
        </div>
        <div style="background: #f8fafc; padding: 15px; border-radius: 12px; text-align: center;">
            <h4 style="color: #16a34a;"><?php echo e(number_format($totalAmount ?? 0, 2)); ?> DZD</h4>
            <small style="color: #64748b;">Total Amount</small>
        </div>
        <div style="background: #fef3c7; padding: 15px; border-radius: 12px; text-align: center;">
            <h4 style="color: #d97706;"><?php echo e($pendingCount ?? 0); ?></h4>
            <small style="color: #64748b;">Pending</small>
        </div>
        <div style="background: #dcfce7; padding: 15px; border-radius: 12px; text-align: center;">
            <h4 style="color: #16a34a;"><?php echo e($paidCount ?? 0); ?></h4>
            <small style="color: #64748b;">Paid</small>
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table id="paymentsTable" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Type</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Entity</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Amount (DZD)</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Due Date</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Status</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(ucfirst($payment->type)); ?></td>
                    <td><?php echo e($payment->entity_name); ?></td>
                    <td><?php echo e(number_format($payment->amount, 2)); ?></td>
                    <td><?php echo e($payment->due_date); ?></td>
                    <td>
                        <span style="background: <?php echo e($payment->status == 'paid' ? '#16a34a' : '#f59e0b'); ?>; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                            <?php echo e(ucfirst($payment->status)); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($payment->status != 'paid'): ?>
                            <button class="btn-sm btn-success" onclick="markAsPaid(<?php echo e($payment->id); ?>)" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 8px; cursor: pointer; margin-right: 5px;">Mark Paid</button>
                        <?php endif; ?>
                        <button class="btn-sm btn-danger" onclick="deletePayment(<?php echo e($payment->id); ?>)" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 8px; cursor: pointer;">Delete</button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: #64748b;">No payment requests found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="paymentModal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-content" style="background: white; border-radius: 24px; padding: 30px; max-width: 500px; width: 90%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="color: #1e293b;">New Payment Request</h3>
            <span class="close" style="font-size: 28px; cursor: pointer;">&times;</span>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Payment Type</label>
            <select id="paymentType" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
                <option value="clinic">Clinic Subscription</option>
                <?php if(count($ads) > 0): ?>
                <option value="ad">Advertisement</option>
                <?php endif; ?>
            </select>
        </div>
        
        <div class="form-group" id="entityGroup" style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Select Clinic</label>
            <select id="entitySelect" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
                <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($clinic->id); ?>" data-name="<?php echo e($clinic->name); ?>"><?php echo e($clinic->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Amount (DZD)</label>
            <input type="number" id="amount" value="5000" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
        </div>
        
        <div class="form-group" style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Due Date</label>
            <input type="date" id="dueDate" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Description (optional)</label>
            <textarea id="description" rows="2" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;"></textarea>
        </div>
        
        <button class="btn-sm" id="savePaymentBtn" style="width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600;">Send Request</button>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    const modal = document.getElementById('paymentModal');
    const openBtn = document.getElementById('openPaymentModal');
    const closeBtn = document.querySelector('#paymentModal .close');
    
    openBtn.onclick = () => {
        document.getElementById('dueDate').value = new Date().toISOString().split('T')[0];
        modal.style.display = 'flex';
    };
    
    if (closeBtn) {
        closeBtn.onclick = () => modal.style.display = 'none';
    }
    
    //只有当有广告数据时才处理类型切换
    <?php if(count($ads) > 0): ?>
    document.getElementById('paymentType').addEventListener('change', function() {
        const type = this.value;
        const entityGroup = document.getElementById('entityGroup');
        const clinicsData = <?php echo json_encode($clinics, 15, 512) ?>;
        const adsData = <?php echo json_encode($ads, 15, 512) ?>;
        
        if (type === 'clinic') {
            let html = '<label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Select Clinic</label>';
            html += '<select id="entitySelect" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">';
            clinicsData.forEach(clinic => {
                html += `<option value="${clinic.id}" data-name="${clinic.name}">${clinic.name}</option>`;
            });
            html += '</select>';
            entityGroup.innerHTML = html;
        } else {
            let html = '<label style="display: block; margin-bottom: 8px; color: #1e293b; font-weight: 500;">Select Ad</label>';
            html += '<select id="entitySelect" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px;">';
            adsData.forEach(ad => {
                html += `<option value="${ad.id}" data-name="${ad.title}">${ad.title}</option>`;
            });
            html += '</select>';
            entityGroup.innerHTML = html;
        }
    });
    <?php endif; ?>

    document.getElementById('savePaymentBtn').onclick = () => {
        const type = document.getElementById('paymentType').value;
        const entitySelect = document.getElementById('entitySelect');
        const entityId = entitySelect.value;
        const entityName = entitySelect.options[entitySelect.selectedIndex]?.getAttribute('data-name') || '';
        const amount = document.getElementById('amount').value;
        const dueDate = document.getElementById('dueDate').value;
        const description = document.getElementById('description').value;

        fetch('<?php echo e(route("admin.payments.store")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ 
                type, 
                entity_id: entityId, 
                entity_name: entityName, 
                amount, 
                due_date: dueDate, 
                description 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    };

    function markAsPaid(id) {
        if (confirm('Mark this payment as paid?')) {
            fetch(`<?php echo e(url('admin/payments')); ?>/${id}/paid`, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }

    function deletePayment(id) {
        if (confirm('Delete this payment?')) {
            fetch(`<?php echo e(url('admin/payments')); ?>/${id}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    }

    window.onclick = (e) => { 
        if (e.target === modal) modal.style.display = 'none'; 
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/payments.blade.php ENDPATH**/ ?>