<?php $__env->startSection('title', 'Profile & Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-white">
    <h3><i class="fas fa-user-edit"></i> ✏️ Personal Information</h3>
    <form method="POST" action="<?php echo e(route('patient.profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label>📝 Full Name</label>
            <input type="text" name="name" value="<?php echo e(old('name', $patient->name)); ?>" required>
        </div>
        <div class="form-group">
            <label>📞 Phone</label>
            <input type="text" name="phone" value="<?php echo e(old('phone', $patient->phone)); ?>" required>
        </div>
        <div class="form-group">
            <label>✉️ Email</label>
            <input type="email" name="email" value="<?php echo e(old('email', $patient->email)); ?>" required>
        </div>
        <div class="form-group">
            <label>📍 Address</label>
            <input type="text" name="address" value="<?php echo e(old('address', $patient->address)); ?>">
        </div>
        <button type="submit" class="btn-sm">💾 Save Changes</button>
    </form>
</div>

<div class="card-white">
    <h3><i class="fas fa-bell"></i> 🔔 Notification Settings</h3>
    <form method="POST" action="<?php echo e(route('patient.profile.notifications')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="switch">
            <label>📧 Email Notifications</label>
            <input type="checkbox" name="email_notifications" <?php echo e($patient->email_notifications ? 'checked' : ''); ?>>
        </div>
        <div class="switch">
            <label>📱 SMS Notifications</label>
            <input type="checkbox" name="sms_notifications" <?php echo e($patient->sms_notifications ? 'checked' : ''); ?>>
        </div>
        <div class="switch">
            <label>⏰ Appointment Reminders</label>
            <input type="checkbox" name="appointment_reminders" <?php echo e($patient->appointment_reminders ? 'checked' : ''); ?>>
        </div>
        <button type="submit" class="btn-sm">💾 Save Settings</button>
    </form>
</div>

<div class="card-white">
    <h3><i class="fas fa-key"></i> 🔒 Change Password</h3>
    <form method="POST" action="<?php echo e(route('patient.profile.password')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" required>
        </div>
        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn-sm">🔑 Update Password</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('patient.layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/patient/profile.blade.php ENDPATH**/ ?>