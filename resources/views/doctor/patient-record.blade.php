@extends('doctor.layouts.doctor')

@section('title', 'Patient Record')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-user-circle"></i> 🧑‍⚕️ {{ $patient->name }}</h3>
    <div class="info-grid">
        <div><strong>Age:</strong> {{ $patient->age ?? 'N/A' }}</div>
        <div><strong>Gender:</strong> {{ $patient->gender ?? 'N/A' }}</div>
        <div><strong>Blood type:</strong> {{ $patient->blood_type ?? 'N/A' }}</div>
        <div><strong>Phone:</strong> {{ $patient->phone }}</div>
        <div><strong>Email:</strong> {{ $patient->email }}</div>
        <div><strong>Address:</strong> {{ $patient->address }}</div>
    </div>
    <h4><i class="fas fa-history"></i> 📋 Medical History</h4>
    <div style="overflow-x: auto;">
        <table>
            <thead><tr><th>📅 Date</th><th>🩺 Diagnosis</th><th>💊 Prescription</th></tr></thead>
            <tbody>
                @forelse($medicalRecords as $record)
                <tr>
                    <td>{{ $record->date ?? $record->created_at->format('Y-m-d') }}</td>
                    <td>{{ $record->diagnosis }}</td>
                    <td>{{ $record->prescription }}</td>
                </tr>
                @empty
                <tr><td colspan="3">No medical records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        <button class="btn-sm" id="newAppointmentBtn">📅 New appointment</button>
        <button class="btn-outline" id="printBtn">🖨️ Print report</button>
    </div>
</div>

<div id="appointmentModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); justify-content:center; align-items:center;">
    <div class="modal-content" style="background:#0f2b3d; padding:25px; border-radius:30px; width:90%; max-width:400px;">
        <h3>📅 Set Next Appointment</h3>
        <input type="date" id="appointmentDate" class="form-control" style="margin:10px 0;">
        <input type="time" id="appointmentTime" class="form-control">
        <button class="btn-sm" id="confirmAppointmentBtn">Confirm</button>
        <button class="btn-outline" id="cancelModalBtn">Cancel</button>
    </div>
</div>

@push('scripts')
<script>
    const patientId = {{ $patient->id }};
    const modal = document.getElementById('appointmentModal');
    document.getElementById('newAppointmentBtn').addEventListener('click', () => {
        modal.style.display = 'flex';
    });
    document.getElementById('cancelModalBtn').addEventListener('click', () => {
        modal.style.display = 'none';
    });
    document.getElementById('confirmAppointmentBtn').addEventListener('click', () => {
        const date = document.getElementById('appointmentDate').value;
        const time = document.getElementById('appointmentTime').value;
        if (!date || !time) { alert('Please fill date and time'); return; }
        fetch('{{ route("doctor.patients.add-appointment", $patient->id) }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ date, time })
        }).then(res => res.json()).then(data => {
            if (data.success) {
                alert('Appointment added');
                modal.style.display = 'none';
                location.reload();
            } else alert('Error');
        });
    });
    document.getElementById('printBtn').addEventListener('click', () => {
        alert('Print feature will be implemented');
    });
</script>
@endpush
@endsection