@extends('patient.layouts.patient')

@section('title', 'Medical Diagnoses')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-notes-medical"></i> 📋 Medical Diagnoses & Prescriptions</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr><th>📅 Date</th><th>👨‍⚕️ Doctor</th><th>🏥 Clinic</th><th>🩺 Diagnosis</th><th>💊 Prescription</th></tr>
            </thead>
            <tbody>
                @forelse($diagnoses as $diag)
                <tr>
                    <td>{{ $diag->date }}</td>
                    <td>{{ $diag->doctor->name ?? 'N/A' }}</td>
                    <td>{{ $diag->doctor->clinic->name ?? 'N/A' }}</td>
                    <td>{{ $diag->diagnosis }}</td>
                    <td>{{ $diag->prescription }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;">No medical records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection