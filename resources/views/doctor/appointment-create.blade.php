@extends('doctor.layouts.doctor')

@section('title', 'Create New Appointment')

@section('content')
<div class="card-white">
    <h3 style="color: #1e3a8a; margin-bottom: 20px;">📅 Create New Appointment</h3>
    
    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('doctor.appointments.store') }}">
        @csrf
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">👤 Select Patient <span style="color: red;">*</span></label>
            <select name="patient_id" class="form-control" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                <option value="">-- Select Patient --</option>
                @foreach($allPatients ?? [] as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} - {{ $patient->phone ?? 'No phone' }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">📅 Date <span style="color: red;">*</span></label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
            </div>
            
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">⏰ Time <span style="color: red;">*</span></label>
                <select name="appointment_time" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                    <option value="">-- Select Time --</option>
                    <option value="09:00" {{ old('appointment_time') == '09:00' ? 'selected' : '' }}>09:00 AM</option>
                    <option value="09:30" {{ old('appointment_time') == '09:30' ? 'selected' : '' }}>09:30 AM</option>
                    <option value="10:00" {{ old('appointment_time') == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                    <option value="10:30" {{ old('appointment_time') == '10:30' ? 'selected' : '' }}>10:30 AM</option>
                    <option value="11:00" {{ old('appointment_time') == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                    <option value="11:30" {{ old('appointment_time') == '11:30' ? 'selected' : '' }}>11:30 AM</option>
                    <option value="12:00" {{ old('appointment_time') == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                    <option value="14:00" {{ old('appointment_time') == '14:00' ? 'selected' : '' }}>02:00 PM</option>
                    <option value="14:30" {{ old('appointment_time') == '14:30' ? 'selected' : '' }}>02:30 PM</option>
                    <option value="15:00" {{ old('appointment_time') == '15:00' ? 'selected' : '' }}>03:00 PM</option>
                    <option value="15:30" {{ old('appointment_time') == '15:30' ? 'selected' : '' }}>03:30 PM</option>
                    <option value="16:00" {{ old('appointment_time') == '16:00' ? 'selected' : '' }}>04:00 PM</option>
                    <option value="16:30" {{ old('appointment_time') == '16:30' ? 'selected' : '' }}>04:30 PM</option>
                </select>
            </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">📝 Notes (Optional)</label>
            <textarea name="notes" rows="3" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; resize: vertical;">{{ old('notes') }}</textarea>
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <button type="submit" style="background: #22c55e; color: white; border: none; padding: 12px 24px; border-radius: 10px; cursor: pointer; font-size: 16px;">
                ✅ Create Appointment
            </button>
            <a href="{{ route('doctor.appointments.index') }}" style="background: transparent; border: 1px solid #1e3a8a; color: #1e3a8a; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
                ❌ Cancel
            </a>
        </div>
    </form>
</div>
@endsection