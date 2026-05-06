

<?php $__env->startSection('title', 'Manage Patients'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="header">
    <h1>👥 Manage Patients</h1>
    <p>Add, edit, and manage all registered patients</p>
</div>

<!-- STATS CARDS -->
<div class="stats-cards">
    <div class="stat-card"><h3>Total Patients</h3><div class="number" id="totalPatients">0</div></div>
    <div class="stat-card"><h3>Active Patients</h3><div class="number" id="activePatients">0</div></div>
    <div class="stat-card"><h3>New This Month</h3><div class="number" id="newPatients">0</div></div>
    <div class="stat-card"><h3>Appointments</h3><div class="number" id="totalAppointments">0</div></div>
</div>

<!-- SEARCH & FILTER -->
<div class="search-bar">
    <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by name, email, or phone...">
    <select class="filter-select" id="statusFilter">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

<!-- ADD PATIENT FORM -->
<div class="add-patient-card">
    <h2>➕ Add New Patient</h2>
    <div class="form-grid">
        <div class="input-group">
            <label>Full Name</label>
            <input type="text" id="patientName" placeholder="Full name">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" id="patientEmail" placeholder="email@example.com">
        </div>
        <div class="input-group">
            <label>Phone</label>
            <input type="tel" id="patientPhone" placeholder="+213 XX XXX XXXX">
        </div>
        <div class="input-group">
            <label>Date of Birth</label>
            <input type="date" id="patientDob">
        </div>
        <div class="input-group">
            <label>Gender</label>
            <select id="patientGender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="input-group">
            <label>Address</label>
            <input type="text" id="patientAddress" placeholder="City, Address">
        </div>
    </div>
    <button class="btn-add" onclick="addPatient()">+ Add Patient</button>
</div>

<!-- PATIENTS TABLE -->
<div class="patients-table-container">
    <h2>📋 Patients List</h2>
    <div style="overflow-x: auto;">
        <table id="patientsTable">
            <thead>
                <tr><th>Avatar</th><th>Name</th><th>Email</th><th>Phone</th><th>Date of Birth</th><th>Gender</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody id="patientsTableBody"></tbody>
        </table>
    </div>
    <div id="noResults" class="no-results" style="display: none;">📭 No patients found matching your search</div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3>✏️ Edit Patient</h3>
        <input type="text" id="editName" placeholder="Full Name">
        <input type="email" id="editEmail" placeholder="Email">
        <input type="tel" id="editPhone" placeholder="Phone">
        <input type="date" id="editDob">
        <select id="editGender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <input type="text" id="editAddress" placeholder="Address">
        <div class="modal-buttons">
            <button class="btn-save" onclick="saveEdit()">Save</button>
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .header {
        background: white;
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    .header h1 {
        color: #0f2b5c;
        font-size: 24px;
        margin-bottom: 5px;
    }
    .header p {
        color: #64748b;
        font-size: 13px;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        padding: 15px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
    }
    .stat-card h3 {
        color: #64748b;
        font-size: 12px;
        margin-bottom: 6px;
    }
    .stat-card .number {
        font-size: 28px;
        font-weight: bold;
        color: #2563eb;
    }

    .search-bar {
        background: white;
        padding: 12px 18px;
        border-radius: 18px;
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .search-input {
        flex: 1;
        padding: 8px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        font-size: 13px;
        outline: none;
        transition: all 0.2s;
    }
    .search-input:focus {
        border-color: #2563eb;
    }
    .filter-select {
        padding: 8px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        background: white;
        font-size: 13px;
        cursor: pointer;
    }

    .add-patient-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    .add-patient-card h2 {
        color: #0f2b5c;
        font-size: 18px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e2e8f0;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 12px;
    }
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .input-group label {
        font-weight: 600;
        color: #1e293b;
        font-size: 12px;
    }
    .input-group input,
    .input-group select {
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        outline: none;
    }
    .input-group input:focus,
    .input-group select:focus {
        border-color: #2563eb;
    }
    .btn-add {
        background: #16a34a;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 15px;
        width: 100%;
        font-size: 14px;
    }
    .btn-add:hover {
        background: #15803d;
    }

    .patients-table-container {
        background: white;
        border-radius: 20px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow-x: auto;
    }
    .patients-table-container h2 {
        color: #0f2b5c;
        font-size: 18px;
        margin-bottom: 15px;
        padding-left: 10px;
        border-left: 4px solid #f59e0b;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    th, td {
        padding: 10px 8px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    th {
        background: #f8fafc;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 12px;
    }
    .patient-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: #16a34a;
        color: white;
        font-weight: bold;
    }
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-active {
        background: #dcfce7;
        color: #16a34a;
    }
    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }
    .btn-icon {
        padding: 4px 10px;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-edit {
        background: #2563eb;
        color: white;
    }
    .btn-edit:hover {
        background: #1e40af;
    }
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    .btn-delete:hover {
        background: #dc2626;
    }
    .btn-status {
        background: #f59e0b;
        color: white;
    }
    .btn-status:hover {
        background: #d97706;
    }
    .no-results {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
        font-size: 14px;
    }

    /* MODAL */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background: white;
        width: 400px;
        padding: 25px;
        border-radius: 24px;
        position: relative;
        animation: modalPop 0.3s ease;
    }
    .modal-content h3 {
        color: #0f2b5c;
        margin-bottom: 20px;
        font-size: 20px;
    }
    .modal-content input, .modal-content select {
        width: 100%;
        padding: 10px 14px;
        margin-bottom: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
    }
    .modal-content input:focus, .modal-content select:focus {
        border-color: #2563eb;
    }
    .modal-buttons {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }
    .modal-buttons button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-save {
        background: #16a34a;
        color: white;
    }
    .btn-cancel {
        background: #64748b;
        color: white;
    }
    @keyframes modalPop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>

<script>
    let allPatients = [];

    // ========== FETCH PATIENTS FROM DATABASE ==========
    async function fetchPatients() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        const url = `/clinic/patients/data?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`;
        
        try {
            const res = await fetch(url);
            const result = await res.json();
            
            if (result.success) {
                allPatients = result.data;
                renderPatients(allPatients);
                const stats = calculateStats(allPatients);
                updateStats(stats);
            } else {
                console.error('API error:', result);
                renderPatients([]);
                updateStats({ total: 0, active: 0, new: 0, appointments: 0 });
            }
        } catch (err) {
            console.error('Fetch error:', err);
            renderPatients([]);
            updateStats({ total: 0, active: 0, new: 0, appointments: 0 });
        }
    }

    // ========== CALCULATE STATISTICS ==========
    function calculateStats(patients) {
        const total = patients.length;
        const active = patients.filter(p => p.status === 'active').length;
        const now = new Date();
        const newThisMonth = patients.filter(p => {
            if (!p.created_at) return false;
            const created = new Date(p.created_at);
            return created.getMonth() === now.getMonth() && created.getFullYear() === now.getFullYear();
        }).length;
        const appointments = Math.floor(total * 2.5);
        return { total, active, new: newThisMonth, appointments };
    }

    // ========== UPDATE STATS DISPLAY ==========
    function updateStats(stats) {
        document.getElementById('totalPatients').innerText = stats.total;
        document.getElementById('activePatients').innerText = stats.active;
        document.getElementById('newPatients').innerText = stats.new;
        document.getElementById('totalAppointments').innerText = stats.appointments;
    }

    // ========== RENDER PATIENTS TABLE ==========
    function renderPatients(patients) {
        const tbody = document.getElementById('patientsTableBody');
        const noResults = document.getElementById('noResults');
        
        if (patients.length === 0) {
            tbody.innerHTML = '';
            noResults.style.display = 'block';
            return;
        }
        
        noResults.style.display = 'none';
        tbody.innerHTML = '';
        
        patients.forEach(patient => {
            let statusClass = patient.status === 'active' ? 'status-active' : 'status-inactive';
            let statusText = patient.status === 'active' ? '🟢 Active' : '🔴 Inactive';
            let dobFormatted = patient.dob ? new Date(patient.dob).toLocaleDateString() : '—';
            
            tbody.innerHTML += `
                <tr>
                    <td><div class="patient-avatar">👤</div></td>
                    <td><strong>${escapeHtml(patient.name)}</strong></td>
                    <td>${escapeHtml(patient.email)}</td>
                    <td>${escapeHtml(patient.phone)}</td>
                    <td>${dobFormatted}</td>
                    <td>${patient.gender || '—'}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="openEditModal(${patient.id})">✏️ Edit</button>
                        <button class="btn-icon btn-delete" onclick="deletePatient(${patient.id})">🗑️ Delete</button>
                        <button class="btn-icon btn-status" onclick="togglePatientStatus(${patient.id})">🔄 Status</button>
                    </td>
                <table>
            `;
        });
    }

    // ========== ADD PATIENT TO DATABASE ==========
    async function addPatient() {
        const name = document.getElementById('patientName').value.trim();
        const email = document.getElementById('patientEmail').value.trim();
        const phone = document.getElementById('patientPhone').value.trim();
        const dob = document.getElementById('patientDob').value;
        const gender = document.getElementById('patientGender').value;
        const address = document.getElementById('patientAddress').value.trim();
        
        if (!name || !email || !phone) {
            alert('❌ Please fill at least Name, Email, and Phone');
            return;
        }
        
        const data = { name, email, phone, dob, gender, address };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        try {
            const res = await fetch('/clinic/patients', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            
            if (res.ok) {
                // Clear form
                document.getElementById('patientName').value = '';
                document.getElementById('patientEmail').value = '';
                document.getElementById('patientPhone').value = '';
                document.getElementById('patientDob').value = '';
                document.getElementById('patientGender').value = 'Male';
                document.getElementById('patientAddress').value = '';
                
                // Refresh the list
                await fetchPatients();
                alert(`✅ Patient "${name}" added successfully!`);
            } else {
                const error = await res.json();
                alert('Error: ' + (error.message || 'Could not add patient'));
            }
        } catch (err) {
            console.error(err);
            alert('Network error');
        }
    }

    // ========== DELETE PATIENT FROM DATABASE ==========
    async function deletePatient(id) {
        const patient = allPatients.find(p => p.id === id);
        if (confirm(`Are you sure you want to delete ${patient?.name}?`)) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const res = await fetch(`/clinic/patients/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                if (res.ok) {
                    await fetchPatients();
                    alert(`✅ Patient deleted successfully.`);
                } else {
                    alert('Error deleting patient');
                }
            } catch (err) {
                console.error(err);
                alert('Network error');
            }
        }
    }

    // ========== OPEN EDIT MODAL ==========
    let currentEditId = null;
    
    function openEditModal(id) {
        const patient = allPatients.find(p => p.id === id);
        if (patient) {
            currentEditId = id;
            document.getElementById('editName').value = patient.name;
            document.getElementById('editEmail').value = patient.email;
            document.getElementById('editPhone').value = patient.phone;
            document.getElementById('editDob').value = patient.dob || '';
            document.getElementById('editGender').value = patient.gender || 'Male';
            document.getElementById('editAddress').value = patient.address || '';
            document.getElementById('editModal').style.display = 'flex';
        }
    }

    // ========== SAVE EDIT TO DATABASE ==========
    async function saveEdit() {
        const data = {
            name: document.getElementById('editName').value.trim(),
            email: document.getElementById('editEmail').value.trim(),
            phone: document.getElementById('editPhone').value.trim(),
            dob: document.getElementById('editDob').value,
            gender: document.getElementById('editGender').value,
            address: document.getElementById('editAddress').value.trim()
        };
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        try {
            const res = await fetch(`/clinic/patients/${currentEditId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            });
            if (res.ok) {
                closeModal();
                await fetchPatients();
                alert(`✅ Patient updated successfully!`);
            } else {
                alert('Error updating patient');
            }
        } catch (err) {
            console.error(err);
            alert('Network error');
        }
    }

    // ========== TOGGLE PATIENT STATUS ==========
    async function togglePatientStatus(id) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        try {
            const res = await fetch(`/clinic/patients/${id}/toggle-status`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                await fetchPatients();
            } else {
                alert('Error toggling status');
            }
        } catch (err) {
            console.error(err);
            alert('Network error');
        }
    }

    // ========== CLOSE MODAL ==========
    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
        currentEditId = null;
    }

    // ========== HELPER FUNCTIONS ==========
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ========== EVENT LISTENERS ==========
    document.getElementById('searchInput').addEventListener('keyup', fetchPatients);
    document.getElementById('statusFilter').addEventListener('change', fetchPatients);

    // Close modal when clicking outside
    window.onclick = function(e) {
        const modal = document.getElementById('editModal');
        if (e.target === modal) {
            closeModal();
        }
    }

    // ========== INITIAL LOAD ==========
    fetchPatients();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/patients/index.blade.php ENDPATH**/ ?>