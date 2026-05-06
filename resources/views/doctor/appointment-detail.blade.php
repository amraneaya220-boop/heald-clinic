@extends('doctor.layouts.doctor')

@section('title', 'Appointment Detail')

@section('content')
<div class="card-white">
    <div class="info-row"><div class="info-label">🩺 Patient:</div><div id="patientValue">{{ $appointment->patient->name }}</div></div>
    <div class="info-row"><div class="info-label">📅 Date:</div><div id="dateValue">{{ $appointment->appointment_date }} - {{ $appointment->appointment_time }}</div></div>
    <div class="info-row"><div class="info-label">📞 Phone:</div><div id="phoneValue">{{ $appointment->patient->phone }}</div></div>
    <div class="info-row"><div class="info-label">📌 Status:</div><div id="statusValue"><span class="status {{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span></div></div>
    <hr>
    <form id="medicalForm">
        @csrf
        <div class="form-group"><label>💬 Main complaint</label><textarea rows="2" id="complaintInput">{{ $appointment->medicalRecord->complaint ?? '' }}</textarea></div>
        <div class="form-group"><label>🩺 Diagnosis</label><textarea rows="2" id="diagnosisInput">{{ $appointment->medicalRecord->diagnosis ?? '' }}</textarea></div>
        <div class="form-group"><label>💊 Prescription / Treatment</label><textarea rows="2" id="prescriptionInput">{{ $appointment->medicalRecord->prescription ?? '' }}</textarea></div>
        <div class="form-group"><label>📝 Additional notes</label><textarea rows="2" id="notesInput">{{ $appointment->medicalRecord->notes ?? '' }}</textarea></div>
        <div>
            <button type="button" class="btn-sm" id="saveBtn">💾 Save diagnosis</button>
            <button type="button" class="btn-outline" id="cancelBtn">❌ Cancel appointment</button>
            <button type="button" class="btn-sm" id="finishBtn" style="background:#2e7d32;">🏁 Finish Examination</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const appointmentId = {{ $appointment->id }};
    document.getElementById('saveBtn').addEventListener('click', function() {
        const data = {
            complaint: document.getElementById('complaintInput').value,
            diagnosis: document.getElementById('diagnosisInput').value,
            prescription: document.getElementById('prescriptionInput').value,
            notes: document.getElementById('notesInput').value
        };
        fetch(`{{ route('doctor.appointments.medical-record', $appointment->id) }}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(data => {
            if (data.success) alert('Diagnosis saved');
            else alert('Error');
        });
    });

    document.getElementById('cancelBtn').addEventListener('click', function() {
        if (confirm('Cancel this appointment?')) {
            fetch(`{{ route('doctor.appointments.cancel', $appointment->id) }}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(res => res.json()).then(data => {
                if (data.success) window.location.href = '{{ route("doctor.appointments.index") }}';
                else alert('Cannot cancel');
            });
        }
    });

    document.getElementById('finishBtn').addEventListener('click', function() {
        if (confirm('Mark as completed?')) {
            fetch(`{{ route('doctor.appointments.update-status', $appointment->id) }}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ status: 'completed' })
            }).then(res => res.json()).then(data => {
                if (data.success) window.location.href = '{{ route("doctor.dashboard") }}';
                else alert('Error');
            });
        }
    });
</script>
@endpush
@endsection