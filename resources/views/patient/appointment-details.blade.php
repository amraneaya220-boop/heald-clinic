@extends('patient.layouts.patient')

@section('title', 'Appointment Details')

@section('content')
<!-- Patient Information -->
<div class="card-white">
    <div class="section-title">🩺 Patient Information</div>
    <div class="info-grid">
        <div class="info-item"><div class="info-label">Name:</div><div class="info-value">{{ $appointment->patient->name }}</div></div>
        <div class="info-item"><div class="info-label">Phone:</div><div class="info-value">{{ $appointment->patient->phone }}</div></div>
        <div class="info-item"><div class="info-label">Email:</div><div class="info-value">{{ $appointment->patient->email }}</div></div>
        <div class="info-item"><div class="info-label">Address:</div><div class="info-value">{{ $appointment->patient->address }}</div></div>
    </div>
</div>

<!-- Doctor & Clinic Information -->
<div class="card-white">
    <div class="section-title">👨‍⚕️ Doctor & Clinic</div>
    <div class="info-grid">
        <div class="info-item"><div class="info-label">Doctor:</div><div class="info-value">{{ $appointment->doctor->name ?? 'N/A' }}</div></div>
        <div class="info-item"><div class="info-label">Specialty:</div><div class="info-value">{{ $appointment->doctor->specialty ?? 'N/A' }}</div></div>
        <div class="info-item"><div class="info-label">Clinic:</div><div class="info-value">{{ $appointment->clinic->name ?? 'N/A' }}</div></div>
        <div class="info-item"><div class="info-label">Clinic Address:</div><div class="info-value">{{ $appointment->clinic->address ?? 'N/A' }}</div></div>
    </div>
</div>

<!-- Appointment Details -->
<div class="card-white">
    <div class="section-title">📅 Appointment Details</div>
    <div class="info-grid">
        <div class="info-item"><div class="info-label">Date:</div><div class="info-value">{{ $appointment->appointment_date }}</div></div>
        <div class="info-item"><div class="info-label">Time:</div><div class="info-value">{{ $appointment->appointment_time }}</div></div>
        <div class="info-item"><div class="info-label">Status:</div><div class="info-value"><span class="status {{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></div></div>
    </div>
</div>

<!-- Diagnosis & Medications (read-only) -->
<div class="card-white">
    <div class="section-title">📝 Diagnosis & Medications</div>
    <div class="readonly-box">
        <strong>💬 Main complaint:</strong><br>
        <span>{{ $appointment->medicalRecord->complaint ?? '—' }}</span>
    </div>
    <div class="readonly-box">
        <strong>🩺 Diagnosis:</strong><br>
        <span>{{ $appointment->medicalRecord->diagnosis ?? '—' }}</span>
    </div>
    <div class="readonly-box">
        <strong>💊 Medications / Prescription:</strong><br>
        <span>{{ $appointment->medicalRecord->prescription ?? '—' }}</span>
    </div>
    <div class="readonly-box">
        <strong>📝 Additional notes:</strong><br>
        <span>{{ $appointment->medicalRecord->notes ?? '—' }}</span>
    </div>
    <button class="btn-invoice" onclick="viewInvoice({{ $appointment->id }})">🧾 Invoice</button>
</div>

@push('scripts')
<script>
    function viewInvoice(appointmentId) {
        window.location.href = "{{ url('patient/invoice') }}/" + appointmentId;
    }
</script>
@endpush
@endsection