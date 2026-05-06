@extends('doctor.layouts.doctor')

@section('title', 'My Patients')

@section('content')
<div class="card-white">
    <div class="filter-bar" style="display: flex; gap: 20px; flex-wrap: wrap; align-items: center; margin-bottom: 20px;">
        <h3 style="color: #1e3a8a; margin: 0;">📋 My Patients</h3>
        <input type="text" id="searchInput" placeholder="🔍 Search by patient name..." style="padding: 8px 16px; border-radius: 10px; border: 1px solid #cbd5e1; width: 250px;">
    </div>
</div>

<div class="card-white">
    <div style="overflow-x: auto;">
        <table id="patientsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>👤 Name</th>
                    <th>📞 Phone</th>
                    <th>✉️ Email</th>
                    <th>📍 Address</th>
                    <th>⚙️ Actions</th>
                </tr>
            </thead>
            <tbody id="patientsTableBody">
                @forelse($patients as $patient)
                <tr data-name="{{ $patient->name }}">
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->phone ?? 'N/A' }}</td>
                    <td>{{ $patient->email ?? 'N/A' }}</td>
                    <td>{{ $patient->address ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn-sm" style="background: #1e3a8a; color: white; text-decoration: none; padding: 5px 12px; border-radius: 8px;">View Details</a>
                    </td>
                 </tr>
                @empty
                 <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        No patients found
                    </td>
                 </tr>
                @endforelse
            </tbody>
         </table>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#patientsTableBody tr');

    function filterTable() {
        const search = searchInput?.value.toLowerCase() || '';
        
        rows.forEach(row => {
            if (row.querySelector('td[colspan]')) return;
            
            const patientName = row.getAttribute('data-name')?.toLowerCase() || '';
            
            let matchesSearch = !search || patientName.includes(search);
            row.style.display = matchesSearch ? '' : 'none';
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    
    // Initial filter
    filterTable();
</script>
@endpush
@endsection