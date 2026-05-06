@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="card">
    <h3><i class="fas fa-user-shield"></i> Admin Profile</h3>
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" id="adminName" value="{{ $settings->admin_name }}">
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" id="adminEmail" value="{{ $settings->admin_email }}">
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
        <input type="number" id="defaultCommission" value="{{ $settings->default_commission }}" step="0.5">
    </div>
    <div class="form-group">
        <label>Currency</label>
        <select id="currency">
            <option value="DZD" {{ $settings->currency == 'DZD' ? 'selected' : '' }}>DZD - Algerian Dinar</option>
            <option value="USD" {{ $settings->currency == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
            <option value="EUR" {{ $settings->currency == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
        </select>
    </div>
    <button class="btn-sm" id="saveSystemBtn">Save System Settings</button>
</div>

<div class="card">
    <h3><i class="fas fa-bell"></i> Notification Preferences</h3>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            Email Notifications for New Bookings
            <input type="checkbox" id="emailNotifications" {{ $settings->email_notifications ? 'checked' : '' }}>
        </label>
    </div>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            SMS Notifications
            <input type="checkbox" id="smsNotifications" {{ $settings->sms_notifications ? 'checked' : '' }}>
        </label>
    </div>
    <div class="form-group">
        <label style="display: flex; justify-content: space-between;">
            Appointment Reminders
            <input type="checkbox" id="appointmentReminders" {{ $settings->appointment_reminders ? 'checked' : '' }}>
        </label>
    </div>
    <button class="btn-sm" id="saveNotifBtn">Save Notification Settings</button>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('saveProfileBtn').onclick = () => {
        const name = document.getElementById('adminName').value;
        const email = document.getElementById('adminEmail').value;
        const password = document.getElementById('adminPassword').value;

        fetch('{{ route("admin.settings.profile") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

        fetch('{{ route("admin.settings.system") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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

        fetch('{{ route("admin.settings.notifications") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email_notifications: emailNotifications, sms_notifications: smsNotifications, appointment_reminders: appointmentReminders })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('Notification settings saved!');
        });
    };
</script>
@endsection