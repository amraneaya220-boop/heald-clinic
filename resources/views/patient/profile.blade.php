@extends('patient.layouts.patient')

@section('title', 'Profile & Settings')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-user-edit"></i> ✏️ Personal Information</h3>
    <form method="POST" action="{{ route('patient.profile.update') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>📝 Full Name</label>
            <input type="text" name="name" value="{{ old('name', $patient->name) }}" required>
        </div>
        <div class="form-group">
            <label>📞 Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}" required>
        </div>
        <div class="form-group">
            <label>✉️ Email</label>
            <input type="email" name="email" value="{{ old('email', $patient->email) }}" required>
        </div>
        <div class="form-group">
            <label>📍 Address</label>
            <input type="text" name="address" value="{{ old('address', $patient->address) }}">
        </div>
        <button type="submit" class="btn-sm">💾 Save Changes</button>
    </form>
</div>

<div class="card-white">
    <h3><i class="fas fa-bell"></i> 🔔 Notification Settings</h3>
    <form method="POST" action="{{ route('patient.profile.notifications') }}">
        @csrf
        @method('PUT')
        <div class="switch">
            <label>📧 Email Notifications</label>
            <input type="checkbox" name="email_notifications" {{ $patient->email_notifications ? 'checked' : '' }}>
        </div>
        <div class="switch">
            <label>📱 SMS Notifications</label>
            <input type="checkbox" name="sms_notifications" {{ $patient->sms_notifications ? 'checked' : '' }}>
        </div>
        <div class="switch">
            <label>⏰ Appointment Reminders</label>
            <input type="checkbox" name="appointment_reminders" {{ $patient->appointment_reminders ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn-sm">💾 Save Settings</button>
    </form>
</div>

<div class="card-white">
    <h3><i class="fas fa-key"></i> 🔒 Change Password</h3>
    <form method="POST" action="{{ route('patient.profile.password') }}">
        @csrf
        @method('PUT')
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
@endsection