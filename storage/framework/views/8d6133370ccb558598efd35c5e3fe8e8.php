

<?php $__env->startSection('title', 'Manage Patients'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    
    .stat-info h4 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }
    
    .stat-info .number {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-icon i {
        font-size: 24px;
        color: white;
    }
    
    /* Search Bar */
    .search-bar {
        background: white;
        padding: 15px 20px;
        border-radius: 20px;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .search-input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
        min-width: 200px;
    }
    
    .search-input:focus {
        border-color: #6366f1;
    }
    
    .filter-select {
        padding: 12px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        background: white;
        font-size: 14px;
        cursor: pointer;
        outline: none;
    }
    
    .filter-select:focus {
        border-color: #6366f1;
    }
    
    /* Add Patient Card */
    .add-patient-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .add-patient-card h2 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
    }
    
    .add-patient-card h2 i {
        color: #6366f1;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .input-group label {
        font-weight: 600;
        color: #1e293b;
        font-size: 13px;
    }
    
    .input-group input,
    .input-group select {
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }
    
    .input-group input:focus,
    .input-group select:focus {
        border-color: #6366f1;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        width: 100%;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
    /* Patients Table */
    .patients-table-container {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .patients-table-container h2 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .patients-table-container h2 i {
        color: #6366f1;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
    }
    
    th, td {
        padding: 14px 12px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }
    
    th {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 600;
        font-size: 12px;
    }
    
    .patient-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        font-weight: bold;
        font-size: 16px;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
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
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .btn-icon {
        padding: 6px 14px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-edit {
        background: #6366f1;
        color: white;
    }
    
    .btn-edit:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }
    
    .btn-status {
        background: #f59e0b;
        color: white;
    }
    
    .btn-status:hover {
        background: #d97706;
        transform: translateY(-1px);
    }
    
    .no-results {
        text-align: center;
        padding: 50px;
        color: #94a3b8;
        font-size: 14px;
    }
    
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    
    .modal-content {
        background: white;
        width: 450px;
        max-width: 90%;
        padding: 30px;
        border-radius: 28px;
        position: relative;
        animation: modalPop 0.3s ease;
    }
    
    .modal-content h3 {
        color: #1e293b;
        margin-bottom: 20px;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-content h3 i {
        color: #6366f1;
    }
    
    .modal-content input,
    .modal-content select {
        width: 100%;
        padding: 12px 16px;
        margin-bottom: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }
    
    .modal-content input:focus,
    .modal-content select:focus {
        border-color: #6366f1;
    }
    
    .modal-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    .modal-buttons button {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
    }
    
    @keyframes modalPop {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    
    /* RTL Support */
    body.rtl th, body.rtl td {
        text-align: right;
    }
    
    body.rtl .stat-info {
        text-align: right;
    }
    
    body.rtl .action-buttons {
        justify-content: flex-start;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        th, td {
            padding: 10px 8px;
            font-size: 12px;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }
        
        .btn-icon {
            text-align: center;
        }
    }
</style>

<div class="main-content-wrapper">
    <!-- STATS CARDS -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Patients</h4>
                <div class="number" id="totalPatients">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>Active Patients</h4>
                <div class="number" id="activePatients">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>New This Month</h4>
                <div class="number" id="newPatients">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Appointments</h4>
                <div class="number" id="totalAppointments">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
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
        <h2><i class="fas fa-user-plus"></i> Add New Patient</h2>
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
        <button class="btn-add" onclick="addPatient()">
            <i class="fas fa-plus"></i> Add Patient
        </button>
    </div>
    
    <!-- PATIENTS TABLE -->
    <div class="patients-table-container">
        <h2><i class="fas fa-list"></i> Patients List</h2>
        <div style="overflow-x: auto;">
            <table id="patientsTable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="patientsTableBody"></tbody>
            </table>
        </div>
        <div id="noResults" class="no-results" style="display: none;">
            <i class="fas fa-inbox"></i> No patients found matching your search
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Patient</h3>
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
            <button class="btn-save" onclick="saveEdit()"><i class="fas fa-save"></i> Save</button>
            <button class="btn-cancel" onclick="closeModal()"><i class="fas fa-times"></i> Cancel</button>
        </div>
    </div>
</div>

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
            let avatarLetter = patient.name ? patient.name.charAt(0).toUpperCase() : '👤';
            
            tbody.innerHTML += `
                <tr>
                    <td><div class="patient-avatar">${escapeHtml(avatarLetter)}</div></td>
                    <td><strong>${escapeHtml(patient.name)}</strong></td>
                    <td>${escapeHtml(patient.email)}</td>
                    <td>${escapeHtml(patient.phone)}</td>
                    <td>${dobFormatted}</td>
                    <td>${patient.gender || '—'}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="openEditModal(${patient.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="deletePatient(${patient.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="btn-icon btn-status" onclick="togglePatientStatus(${patient.id})">
                            <i class="fas fa-sync-alt"></i> Status
                        </button>
                    </td>
                </tr>
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
                document.getElementById('patientName').value = '';
                document.getElementById('patientEmail').value = '';
                document.getElementById('patientPhone').value = '';
                document.getElementById('patientDob').value = '';
                document.getElementById('patientGender').value = 'Male';
                document.getElementById('patientAddress').value = '';
                
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
                alert('✅ Patient status updated!');
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

    // Listen for language changes from layout
    window.addEventListener('languageChanged', function(e) {
        // Refresh table to update status text if needed
        renderPatients(allPatients);
    });

    // ========== INITIAL LOAD ==========
    fetchPatients();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/patients/index.blade.php ENDPATH**/ ?>