@extends('doctor.layouts.doctor')

@section('title', 'Appointments')

@section('content')
<div class="card-white">
    <div class="filter-bar" style="display: flex; gap: 20px; flex-wrap: wrap; align-items: center; margin-bottom: 20px;">
        <select id="filterSelect">
            <option value="all">All appointments</option>
            <option value="week">This week</option>
            <option value="month">This month</option>
        </select>
        <input type="text" id="searchInput" placeholder="🔍 Search by patient name...">
        <a href="{{ route('doctor.appointments.create') }}" class="btn-sm" style="background: #22c55e; color: white; text-decoration: none; padding: 8px 16px; border-radius: 10px;">+ New Appointment</a>
    </div>
</div>

<div class="card-white">
    <div style="overflow-x: auto;">
        <table id="appointmentsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>⏰ Time</th>
                    <th>🩺 Patient</th>
                    <th>📞 Phone</th>
                    <th>📌 Status</th>
                    <th>⚙️ Actions</th>
                </tr>
            </thead>
            <tbody id="appointmentsTableBody">
                @forelse($appointments as $app)
                <tr data-id="{{ $app->id }}" data-patient="{{ $app->patient->name ?? 'N/A' }}" data-phone="{{ $app->patient->phone ?? 'N/A' }}" data-status="{{ $app->status }}" data-date="{{ $app->appointment_date }}">
                    <td>{{ $app->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($app->appointment_time)->format('H:i') }}</td>
                    <td>{{ $app->patient->name ?? 'N/A' }}</td>
                    <td>{{ $app->patient->phone ?? 'N/A' }}</td>
                    <td>
                        <span class="status 
                            {{ $app->status === 'completed' ? 'completed' : '' }} 
                            {{ $app->status === 'cancelled' ? 'cancelled' : '' }} 
                            {{ $app->status === 'pending' ? 'pending' : '' }}
                            {{ $app->status === 'accepted' ? 'accepted' : '' }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </td>
                    <td style="display: flex; gap: 8px; flex-wrap: wrap;">
                        {{-- Details button - استخدام route parameter صحيح --}}
                        <a href="{{ route('doctor.patients.show', $app->patient->id ?? 0) }}" class="btn-sm">Details</a>
                        
                        {{-- Done button - فقط إذا لم يكن مكتملاً أو ملغى --}}
                        @if($app->status !== 'completed' && $app->status !== 'cancelled')
                            <button class="btn-done" onclick="markAsDone({{ $app->id }})" style="background: #22c55e; color: white; border: none; padding: 5px 12px; border-radius: 8px; cursor: pointer;">Done</button>
                        @endif
                        
                        {{-- Edit button - استخدام route parameter صحيح --}}
                        <a href="{{ route('doctor.appointments.edit', $app->id) }}" class="btn-sm" style="background: #eab308; color: white; text-decoration: none; padding: 5px 12px; border-radius: 8px;">Edit</a>
                        
                        {{-- Delete button - استخدام form مع POST + DELETE method بدلاً من GET --}}
                        <form action="{{ route('doctor.appointments.destroy', $app->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" style="background: #ef4444; color: white; border: none; padding: 5px 12px; border-radius: 8px; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        No appointments found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function markAsDone(id) {
        if (confirm('Mark this appointment as completed?')) {
            fetch(`/doctor/appointments/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: 'completed' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
        }
    }

    function confirmDelete(event, form) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this appointment? This action cannot be undone.')) {
            form.submit();
        }
        return false;
    }

    // Filter functionality
    const filterSelect = document.getElementById('filterSelect');
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#appointmentsTableBody tr');

    function isDateInThisWeek(dateStr) {
        const date = new Date(dateStr);
        const today = new Date();
        const startOfWeek = new Date(today);
        startOfWeek.setDate(today.getDate() - today.getDay());
        startOfWeek.setHours(0, 0, 0, 0);
        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        endOfWeek.setHours(23, 59, 59, 999);
        return date >= startOfWeek && date <= endOfWeek;
    }

    function isDateInThisMonth(dateStr) {
        const date = new Date(dateStr);
        const today = new Date();
        return date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear();
    }

    function filterTable() {
        const filter = filterSelect?.value || 'all';
        const search = searchInput?.value.toLowerCase() || '';
        
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            
            const patientName = row.getAttribute('data-patient')?.toLowerCase() || '';
            const appointmentDate = row.getAttribute('data-date') || '';
            
            let matchesSearch = !search || patientName.includes(search);
            let matchesFilter = true;
            
            if (filter === 'week' && appointmentDate) {
                matchesFilter = isDateInThisWeek(appointmentDate);
            } else if (filter === 'month' && appointmentDate) {
                matchesFilter = isDateInThisMonth(appointmentDate);
            }
            
            row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
        });
    }
    
    if (filterSelect) filterSelect.addEventListener('change', filterTable);
    if (searchInput) searchInput.addEventListener('input', filterTable);
    
    // Initial filter
    filterTable();
</script>
@endpush
@endsection