

<?php $__env->startSection('title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <h3><i class="fas fa-user-shield"></i> Admin Profile</h3>
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" id="adminName" value="<?php echo e($settings->admin_name); ?>">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" id="adminEmail" value="<?php echo e($settings->admin_email); ?>">
    </div>
    <div class="form-group">
        <label>New Password</label>
        <input type="password" id="adminPassword" placeholder="Leave blank to keep current">
    </div>
    <button class="btn-sm" id="saveProfileBtn">Save Profile</button>
</div>

<div class="card">
    <h3><i class="fas fa-globe"></i> System Settings</h3>
    <div class="form-group">
        <label>Default Commission Rate for New Clinics (%)</label>
        <input type="number" id="defaultCommission" value="<?php echo e($settings->default_commission); ?>" step="0.5">
    </div>
    <div class="form-group">
        <label>Currency</label>
        <select id="currency">
            <option value="DZD" <?php echo e($settings->currency == 'DZD' ? 'selected' : ''); ?>>DZD - Algerian Dinar</option>
            <option value="USD" <?php echo e($settings->currency == 'USD' ? 'selected' : ''); ?>>USD - US Dollar</option>
            <option value="EUR" <?php echo e($settings->currency == 'EUR' ? 'selected' : ''); ?>>EUR - Euro</option>
        </select>
    </div>
    <button class="btn-sm" id="saveSystemBtn">Save System Settings</button>
</div>

<div class="card">
    <h3><i class="fas fa-bell"></i> Notification Preferences</h3>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            Email Notifications for New Bookings
            <input type="checkbox" id="emailNotifications" <?php echo e($settings->email_notifications ? 'checked' : ''); ?>>
        </label>
    </div>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            SMS Notifications
            <input type="checkbox" id="smsNotifications" <?php echo e($settings->sms_notifications ? 'checked' : ''); ?>>
        </label>
    </div>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            Appointment Reminders
            <input type="checkbox" id="appointmentReminders" <?php echo e($settings->appointment_reminders ? 'checked' : ''); ?>>
        </label>
    </div>
    <button class="btn-sm" id="saveNotifBtn">Save Notification Settings</button>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.getElementById('saveProfileBtn').onclick = () => {
        const name = document.getElementById('adminName').value;
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;

        fetch('<?php echo e(route("admin.settings.profile")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ name, email, password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('Profile updated!');
        });
    };

    document.getElementById('saveSystemBtn').onclick = () => {
        const defaultCommission = document.getElementById('defaultCommission').value;
        const currency = document.getElementById('currency').value;

        fetch('<?php echo e(route("admin.settings.system")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ default_commission: defaultCommission, currency })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('System settings saved!');
        });
    };

    document.getElementById('saveNotifBtn').onclick = () => {
        const emailNotifications = document.getElementById('emailNotifications').checked;
        const smsNotifications = document.getElementById('smsNotifications').checked;
        const appointmentReminders = document.getElementById('appointmentReminders').checked;

        fetch('<?php echo e(route("admin.settings.notifications")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ email_notifications: emailNotifications, sms_notifications: smsNotifications, appointment_reminders: appointmentReminders })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('Notification settings saved!');
        });
    };
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/super_admin/settings.blade.php ENDPATH**/ ?>