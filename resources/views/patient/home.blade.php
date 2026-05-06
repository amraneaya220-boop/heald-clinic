@extends('patient.layouts.patient')

@section('title', 'Patient Dashboard')

@section('content')
<div class="card-white">
    <div class="profile-card" style="display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
        <div class="profile-avatar-lg" style="width:80px; height:80px; background:#1e3a5f; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:36px; color:#4fc3f7; border:2px solid #4fc3f7;">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-info">
            <h3 id="patientName">{{ $patient->name }}</h3>
            <p><i class="fas fa-phone-alt"></i> <span id="patientPhone">{{ $patient->phone }}</span></p>
            <p><i class="fas fa-envelope"></i> <span id="patientEmail">{{ $patient->email }}</span></p>
            <p><i class="fas fa-map-marker-alt"></i> <span id="patientAddress">{{ $patient->address }}</span></p>
        </div>
    </div>
</div>

<div class="card-white">
    <h3><i class="fas fa-calendar-check"></i> <span id="upcoming_appointments">Upcoming Appointments</span></h3>
    <div style="overflow-x: auto;">
        <table id="upcomingTable">
            <thead>
                <tr><th id="date">Date</th><th id="time">Time</th><th id="clinic">Clinic</th><th id="doctor">Doctor</th><th id="status">Status</th><th id="actions">Actions</th></tr>
            </thead>
            <tbody id="upcomingBody">
                @forelse($upcomingAppointments as $app)
                <tr>
                    <td>{{ $app->appointment_date }}</td>
                    <td>{{ $app->appointment_time }}</td>
                    <td>{{ $app->clinic->name ?? 'N/A' }}</td>
                    <td>{{ $app->doctor->name ?? 'N/A' }}</td>
                    <td><span class="status upcoming">{{ $app->status }}</span></td>
                    <td>
                        <button class="btn-reminder" style="background:#ff9800; color:white; border:none; padding:6px 12px; border-radius:30px; margin-right:5px;" onclick="setReminder({{ $app->id }}, '{{ $app->doctor->name }}', '{{ $app->appointment_date }}', '{{ $app->appointment_time }}')">Remind</button>
                        <button class="btn-outline" style="background:transparent; border:1px solid #0288d1; color:#4fc3f7; padding:6px 12px; border-radius:30px;" onclick="cancelAppointment({{ $app->id }})">Cancel</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;">No upcoming appointments</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card-white">
    <h3><i class="fas fa-history"></i> <span id="past_appointments">Past Appointments</span></h3>
    <div style="overflow-x: auto;">
        <table id="pastTable">
            <thead>
                <tr><th id="date2">Date</th><th id="time2">Time</th><th id="clinic2">Clinic</th><th id="doctor2">Doctor</th><th id="status2">Status</th><th id="actions2">Actions</th></tr>
            </thead>
            <tbody id="pastBody">
                @forelse($pastAppointments as $app)
                <tr>
                    <td>{{ $app->appointment_date }}</td>
                    <td>{{ $app->appointment_time }}</td>
                    <td>{{ $app->clinic->name ?? 'N/A' }}</td>
                    <td>{{ $app->doctor->name ?? 'N/A' }}</td>
                    <td><span class="status {{ strtolower($app->status) }}">{{ $app->status }}</span></td>
                    <td><button class="btn-sm" onclick="viewDetails({{ $app->id }})">Details</button></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;">No past appointments</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function viewDetails(id) {
        window.location.href = "{{ url('patient/appointment') }}/" + id;
    }

    function cancelAppointment(id) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            fetch(`{{ url('patient/appointment') }}/${id}/cancel`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
                else alert('Cancellation failed');
            });
        }
    }

    function setReminder(id, doctor, date, time) {
        let notif = {
            id: Date.now(),
            type: 'reminder',
            params: { doctor: doctor, date: date, time: time },
            time: new Date().toISOString(),
            read: false
        };
        let notifications = JSON.parse(localStorage.getItem('cliniclick_patient_notifications') || '[]');
        notifications.unshift(notif);
        localStorage.setItem('cliniclick_patient_notifications', JSON.stringify(notifications));
        alert('Reminder set ✅');
    }
</script>
@endpush
@endsection