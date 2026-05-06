@extends('patient.layouts.patient')

@section('title', 'My Appointments')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-calendar-alt"></i> <span id="my_appointments">My Appointments</span></h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th id="th_date">Date</th>
                    <th id="th_time">Time</th>
                    <th id="th_clinic">Clinic</th>
                    <th id="th_doctor">Doctor</th>
                    <th id="th_status">Status</th>
                    <th id="th_actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $app)
                <tr>
                    <td>{{ $app->appointment_date }}</td>
                    <td>{{ $app->appointment_time }}</td>
                    <td>{{ $app->clinic->name ?? 'N/A' }}</td>
                    <td>{{ $app->doctor->name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusClass = match(strtolower($app->status)) {
                                'pending' => 'upcoming',
                                'accepted' => 'upcoming',
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                                default => 'upcoming'
                            };
                        @endphp
                        <span class="status {{ $statusClass }}">{{ $app->status }}</span>
                    </td>
                    <td>
                        <button class="btn-sm" onclick="viewDetails({{ $app->id }})" style="background:#0288d1; color:white; border:none; padding:6px 12px; border-radius:30px; margin-right:5px;">
                            <i class="fas fa-eye"></i> Details
                        </button>
                        @if(strtolower($app->status) !== 'cancelled' && strtolower($app->status) !== 'completed')
                        <button class="btn-outline" style="background:transparent; border:1px solid #f44336; color:#f44336; padding:6px 12px; border-radius:30px;" onclick="cancelAppointment({{ $app->id }})">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;">No appointments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $appointments->links() }}
    </div>
</div>

@push('scripts')
<script>
    function viewDetails(id) {
        window.location.href = "{{ url('patient/appointment') }}/" + id;
    }

    function cancelAppointment(id) {
        if (confirm('Are you sure you want to cancel this appointment?')) {
            fetch("{{ url('patient/appointment') }}/" + id + "/cancel", {
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
</script>
@endpush
@endsection

