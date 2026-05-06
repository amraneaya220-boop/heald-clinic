@extends('doctor.layouts.doctor')

@section('title', 'Edit Appointment')

@section('content')
<div class="card-white">
    <h3 style="color: #1e3a8a; margin-bottom: 20px;">✏️ Edit Appointment #{{ $appointment->id }}</h3>
    
    <form method="POST" action="{{ route('doctor.appointments.update', $appointment->id) }}" id="editAppointmentForm">
        @csrf
        @method('PUT')
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">👤 Patient</label>
            <input type="text" value="{{ $appointment->patient->name ?? 'N/A' }}" readonly style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; background: #f1f5f9;">
        </div>
        
        <div class="row-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">📅 Date <span style="color: red;">*</span></label>
                <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="{{ old('appointment_date', $appointment->appointment_date) }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                @error('appointment_date')
                    <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">⏰ Time <span style="color: red;">*</span></label>
                <select name="appointment_time" id="appointment_time" class="form-control" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                    <option value="09:00" {{ old('appointment_time', $appointment->appointment_time) == '09:00' ? 'selected' : '' }}>09:00 AM</option>
                    <option value="09:30" {{ old('appointment_time', $appointment->appointment_time) == '09:30' ? 'selected' : '' }}>09:30 AM</option>
                    <option value="10:00" {{ old('appointment_time', $appointment->appointment_time) == '10:00' ? 'selected' : '' }}>10:00 AM</option>
                    <option value="10:30" {{ old('appointment_time', $appointment->appointment_time) == '10:30' ? 'selected' : '' }}>10:30 AM</option>
                    <option value="11:00" {{ old('appointment_time', $appointment->appointment_time) == '11:00' ? 'selected' : '' }}>11:00 AM</option>
                    <option value="11:30" {{ old('appointment_time', $appointment->appointment_time) == '11:30' ? 'selected' : '' }}>11:30 AM</option>
                    <option value="12:00" {{ old('appointment_time', $appointment->appointment_time) == '12:00' ? 'selected' : '' }}>12:00 PM</option>
                    <option value="14:00" {{ old('appointment_time', $appointment->appointment_time) == '14:00' ? 'selected' : '' }}>02:00 PM</option>
                    <option value="14:30" {{ old('appointment_time', $appointment->appointment_time) == '14:30' ? 'selected' : '' }}>02:30 PM</option>
                    <option value="15:00" {{ old('appointment_time', $appointment->appointment_time) == '15:00' ? 'selected' : '' }}>03:00 PM</option>
                    <option value="15:30" {{ old('appointment_time', $appointment->appointment_time) == '15:30' ? 'selected' : '' }}>03:30 PM</option>
                    <option value="16:00" {{ old('appointment_time', $appointment->appointment_time) == '16:00' ? 'selected' : '' }}>04:00 PM</option>
                    <option value="16:30" {{ old('appointment_time', $appointment->appointment_time) == '16:30' ? 'selected' : '' }}>04:30 PM</option>
                </select>
                @error('appointment_time')
                    <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">📌 Status</label>
            <select name="status" id="status" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1;">
                <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ old('status', $appointment->status) == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: 600;">📝 Notes</label>
            <textarea name="notes" id="notes" rows="3" class="form-control" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; resize: vertical;">{{ old('notes', $appointment->notes) }}</textarea>
            @error('notes')
                <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <button type="submit" class="btn-sm" style="background: #eab308; color: white; border: none; padding: 12px 24px; border-radius: 10px; cursor: pointer; font-size: 16px;">
                💾 Update Appointment
            </button>
            <a href="{{ route('doctor.appointments.index') }}" class="btn-outline" style="background: transparent; border: 1px solid #1e3a8a; color: #1e3a8a; padding: 12px 24px; border-radius: 10px; text-decoration: none;">
                ❌ Cancel
            </a>
        </div>
    </form>
</div>
@endpush
@endsection