@extends('layouts.admin')

@section('title', 'Clinics')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <h3><i class="fas fa-list"></i> Clinic List</h3>
        <button class="btn-sm" id="openAddClinicModal" style="padding: 10px 20px;"><i class="fas fa-plus"></i> Add Clinic</button>
    </div>
    <div style="overflow-x: auto;">
        <table id="clinicsTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subscription</th>
                    <th>Paid Until</th>
                    <th>Commission %</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clinics as $clinic)
                <tr>
                    <td>{{ $clinic->name }}</td>
                    <td>{{ ucfirst($clinic->subscription) }}</td>
                    <td>{{ $clinic->paid_until ?? 'N/A' }}</td>
                    <td>{{ $clinic->commission_rate }}%</td>
                    <td><span style="color: #4fc3f7;">{{ ucfirst($clinic->status) }}</span></td>
                    <td>
                        <button class="btn-sm" onclick="renewClinic({{ $clinic->id }}, '{{ $clinic->name }}', {{ $clinic->commission_rate }})">Renew</button>
                        <button class="btn-sm btn-danger" onclick="deleteClinic({{ $clinic->id }})">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="addClinicModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Register New Clinic</h3>
        <div class="form-group">
            <label>Clinic Name</label>
            <input type="text" id="clinicName">
        </div>
        <div class="form-group">
            <label>Subscription Plan</label>
            <select id="subscriptionPlan">
                <option value="monthly">Monthly (5000 DZD)</option>
                <option value="yearly">Yearly (50000 DZD)</option>
            </select>
        </div>
        <div class="form-group">
            <label>Commission Rate (%)</label>
            <input type="number" id="commissionRate" value="5" step="0.5">
        </div>
        <button class="btn-sm" id="saveClinicBtn">Save</button>
    </div>
</div>

<div id="renewModal" class="modal">
    <div class="modal-content">
        <span class="close-renew">&times;</span>
        <h3>Renew Subscription</h3>
        <div class="form-group">
            <label>Clinic</label>
            <input type="text" id="renewClinicName" readonly disabled style="background:#0f2b3d;">
        </div>
        <div class="form-group">
            <label>New Commission Rate (%)</label>
            <input type="number" id="renewCommissionRate" step="0.5">
        </div>
        <button class="btn-sm" id="confirmRenewBtn">Confirm Renewal</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentClinicId = null;

    const addModal = document.getElementById('addClinicModal');
    const renewModal = document.getElementById('renewModal');
    
    document.getElementById('openAddClinicModal').onclick = () => addModal.style.display = 'flex';
    document.querySelector('#addClinicModal .close').onclick = () => addModal.style.display = 'none';
    document.querySelector('#renewModal .close-renew').onclick = () => renewModal.style.display = 'none';

    document.getElementById('saveClinicBtn').onclick = () => {
        const name = document.getElementById('clinicName').value;
        const subscription = document.getElementById('subscriptionPlan').value;
        const commissionRate = document.getElementById('commissionRate').value;
        
        if (name && commissionRate) {
            fetch('{{ route("admin.clinics.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, subscription, commission_rate: commissionRate })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    };

    function renewClinic(id, name, rate) {
        currentClinicId = id;
        document.getElementById('renewClinicName').value = name;
        document.getElementById('renewCommissionRate').value = rate;
        renewModal.style.display = 'flex';
    }

    document.getElementById('confirmRenewBtn').onclick = () => {
        const newRate = document.getElementById('renewCommissionRate').value;
        fetch(`{{ url('admin/clinics') }}/${currentClinicId}/renew`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ commission_rate: newRate })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    };

    function deleteClinic(id) {
        if (confirm('Delete this clinic?')) {
            fetch(`{{ url('admin/clinics') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    window.onclick = (e) => {
        if (e.target === addModal) addModal.style.display = 'none';
        if (e.target === renewModal) renewModal.style.display = 'none';
    };
</script>
@endsection