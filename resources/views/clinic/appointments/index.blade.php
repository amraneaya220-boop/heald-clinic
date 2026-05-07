@extends('clinic.layouts.clinic')

@section('title', 'Manage Appointments')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Stats Cards */
    .stats-grid {
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
    
    .stat-card.pending .stat-info .number { color: #f59e0b; }
    .stat-card.accepted .stat-info .number { color: #10b981; }
    .stat-card.rejected .stat-info .number { color: #ef4444; }
    
    /* Filter Bar */
    .filter-bar {
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
    
    .filter-select, .date-filter {
        padding: 12px 18px;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        background: white;
        font-size: 14px;
        cursor: pointer;
        outline: none;
    }
    
    .filter-select:focus, .date-filter:focus {
        border-color: #6366f1;
    }
    
    .btn-add {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
    /* Add Form */
    .add-form {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .add-form h3 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
    }
    
    .add-form h3 i {
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
    
    .btn-save {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
    }
    
    /* Table Container */
    .table-container {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .table-title {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-title i {
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
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }
    
    .status-accepted {
        background: #dcfce7;
        color: #16a34a;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #dc2626;
    }
    
    /* Action Buttons */
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
    
    .btn-accept {
        background: #10b981;
        color: white;
    }
    
    .btn-accept:hover {
        background: #059669;
        transform: translateY(-1px);
    }
    
    .btn-reject {
        background: #ef4444;
        color: white;
    }
    
    .btn-reject:hover {
        background: #dc2626;
        transform: translateY(-1px);
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
    
    .modal-input {
        width: 100%;
        padding: 12px 16px;
        margin-bottom: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }
    
    .modal-input:focus {
        border-color: #6366f1;
    }
    
    .modal-buttons {
        display: flex;
        gap: 12px;
        margin-top: 10px;
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
    
    /* Toast */
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1001;
    }
    
    .toast {
        background: #1e293b;
        color: white;
        padding: 12px 20px;
        border-radius: 50px;
        margin-top: 10px;
        animation: slideIn 0.3s ease;
        font-size: 13px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    
    .no-results {
        text-align: center;
        padding: 50px;
        color: #94a3b8;
        font-size: 14px;
    }
    
    .flex {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
    
    /* RTL Support */
    body.rtl th, body.rtl td {
        text-align: right;
    }
    
    body.rtl .table-title {
        border-left: none;
        border-right: 4px solid #f59e0b;
        padding-left: 0;
        padding-right: 10px;
    }
    
    body.rtl .stat-info {
        text-align: right;
    }
    
    body.rtl .action-buttons {
        justify-content: flex-start;
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
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-content {
            width: 95%;
            padding: 20px;
        }
    }
</style>

<div class="main-content-wrapper">
    <!-- STATS CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Appointments</h4>
                <div class="number" id="totalAppointments">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        <div class="stat-card pending">
            <div class="stat-info">
                <h4>Pending</h4>
                <div class="number" id="pendingCount">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-card accepted">
            <div class="stat-info">
                <h4>Accepted</h4>
                <div class="number" id="acceptedCount">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-info">
                <h4>Rejected</h4>
                <div class="number" id="rejectedCount">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by patient or doctor...">
        <select class="filter-select" id="statusFilter">
            <option value="all">All Status</option>
            <option value="Pending">Pending</option>
            <option value="Accepted">Accepted</option>
            <option value="Rejected">Rejected</option>
        </select>
        <input type="date" class="date-filter" id="dateFilter">
        <button class="btn-add" onclick="toggleAddForm()">
            <i class="fas fa-plus"></i> New Appointment
        </button>
    </div>

    <!-- ADD FORM -->
    <div class="add-form" id="addForm" style="display: none;">
        <h3><i class="fas fa-calendar-plus"></i> Schedule New Appointment</h3>
        <div class="form-grid">
            <div class="input-group">
                <label>Patient Name</label>
                <input type="text" id="patientName" placeholder="Full name">
            </div>
            <div class="input-group">
                <label>Doctor Name</label>
                <select id="doctorId">
                    <option value="">-- Select Doctor --</option>
                </select>
            </div>
            <div class="input-group">
                <label>Specialty</label>
                <input type="text" id="specialty" placeholder="e.g., Cardiology">
            </div>
            <div class="input-group">
                <label>Date</label>
                <input type="date" id="apptDate">
            </div>
            <div class="input-group">
                <label>Time</label>
                <input type="time" id="apptTime">
            </div>
            <div class="input-group">
                <label>Notes</label>
                <input type="text" id="notes" placeholder="Additional notes">
            </div>
        </div>
        <div class="flex">
            <button class="btn-save" onclick="addAppointment()">
                <i class="fas fa-save"></i> Save Appointment
            </button>
            <button class="btn-cancel" onclick="toggleAddForm()">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </div>

    <!-- APPOINTMENTS TABLE -->
    <div class="table-container">
        <h3 class="table-title"><i class="fas fa-list"></i> Appointments List</h3>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appointmentsBody">
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            <i class="fas fa-spinner fa-spin"></i> Loading appointments...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="noResults" class="no-results" style="display: none;">
            <i class="fas fa-inbox"></i> No appointments found matching your filters
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3><i class="fas fa-edit"></i> Edit Appointment</h3>
        <input type="text" id="editPatient" placeholder="Patient Name" class="modal-input">
        <input type="text" id="editDoctor" placeholder="Doctor Name" class="modal-input">
        <input type="text" id="editSpecialty" placeholder="Specialty" class="modal-input">
        <input type="date" id="editDate" class="modal-input">
        <input type="time" id="editTime" class="modal-input">
        <input type="text" id="editNotes" placeholder="Notes" class="modal-input">
        <div class="modal-buttons">
            <button class="btn-save" onclick="saveEdit()">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <button class="btn-cancel" onclick="closeModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- TOAST CONTAINER -->
<div id="toastContainer" class="toast-container"></div>

<script>
    // ========== المتغيرات العامة ==========
    let currentEditId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const baseUrl = '{{ url("clinic") }}';

    // ========== دوال الإشعارات ==========
    function addNotification(notificationText) {
        try {
            let notifications = JSON.parse(localStorage.getItem("clinic_notifications_v3")) || [];
            notifications.unshift({ 
                id: Date.now(), 
                text: notificationText, 
                read: false, 
                timestamp: new Date().toISOString() 
            });
            if (notifications.length > 50) notifications.pop();
            localStorage.setItem("clinic_notifications_v3", JSON.stringify(notifications));
            updateBellCount();
            showToast(notificationText);
        } catch(e) { 
            showToast(notificationText); 
        }
    }

    function updateBellCount() {
        try {
            const notifications = JSON.parse(localStorage.getItem("clinic_notifications_v3")) || [];
            const unread = notifications.filter(n => !n.read).length;
            const bellCount = document.getElementById("notifBadge");
            if (bellCount) bellCount.innerText = unread;
        } catch(e) { 
            console.log("Bell count error:", e); 
        }
    }

    function showToast(message) {
        const container = document.getElementById("toastContainer");
        if (!container) return;
        const toast = document.createElement("div");
        toast.className = "toast";
        toast.innerHTML = `<i class="fas fa-info-circle"></i> ${escapeHtml(message)}`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    // ========== جلب البيانات ==========
    async function fetchAppointments() {
        const search = document.getElementById('searchInput')?.value || '';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const date = document.getElementById('dateFilter')?.value || '';
        
        const tbody = document.getElementById('appointmentsBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin"></i> Loading appointments...</td></tr>';
        }
        
        try {
            const res = await fetch(`${baseUrl}/appointments/get-data?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}&date=${encodeURIComponent(date)}`);
            const data = await res.json();
            
            if (data.success) {
                renderAppointments(data.data);
                updateStats(data.stats);
            } else {
                throw new Error(data.message || 'Failed to fetch data');
            }
        } catch(e) {
            console.error("Fetch error:", e);
            if (tbody) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 40px; color: #ef4444;"><i class="fas fa-exclamation-circle"></i> Error loading appointments</td></tr>';
            }
            showToast("Error loading appointments from database");
        }
    }

    function renderAppointments(apps) {
        const tbody = document.getElementById('appointmentsBody');
        const noResults = document.getElementById('noResults');
        
        if (!tbody) return;
        
        if (!apps || apps.length === 0) {
            tbody.innerHTML = '';
            if (noResults) noResults.style.display = 'block';
            return;
        }
        
        if (noResults) noResults.style.display = 'none';
        tbody.innerHTML = '';
        
        apps.forEach(app => {
            let statusClass = `status-${app.status.toLowerCase()}`;
            let formattedTime = formatTime(app.time);
            tbody.innerHTML += `
                <tr>
                    <td><strong>${escapeHtml(app.patient_name)}</strong></td>
                    <td>${escapeHtml(app.doctor_name)}</td>
                    <td>${escapeHtml(app.specialty)}</td>
                    <td>${app.date}</td>
                    <td>${formattedTime}</td>
                    <td><span class="status-badge ${statusClass}">${app.status}</span></td>
                    <td class="action-buttons">
                        <button class="btn-icon btn-accept" onclick="updateStatus(${app.id},'Accepted')">
                            <i class="fas fa-check"></i> Accept
                        </button>
                        <button class="btn-icon btn-reject" onclick="updateStatus(${app.id},'Rejected')">
                            <i class="fas fa-times"></i> Reject
                        </button>
                        <button class="btn-icon btn-edit" onclick="openEditModal(${app.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="deleteAppointment(${app.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
        });
    }

    function updateStats(stats) {
        const totalEl = document.getElementById('totalAppointments');
        const pendingEl = document.getElementById('pendingCount');
        const acceptedEl = document.getElementById('acceptedCount');
        const rejectedEl = document.getElementById('rejectedCount');
        
        if (totalEl) totalEl.innerText = stats.total || 0;
        if (pendingEl) pendingEl.innerText = stats.pending || 0;
        if (acceptedEl) acceptedEl.innerText = stats.accepted || 0;
        if (rejectedEl) rejectedEl.innerText = stats.rejected || 0;
    }

    function formatTime(time) {
        if (!time) return "—";
        let [hours, minutes] = time.split(":");
        let period = hours >= 12 ? "PM" : "AM";
        let hour12 = hours % 12 || 12;
        return `${hour12}:${minutes} ${period}`;
    }

    function escapeHtml(text) {
        if (!text) return "";
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ========== العمليات على قاعدة البيانات ==========
    async function updateStatus(id, status) {
        try {
            const res = await fetch(`${baseUrl}/appointments/${id}/update-status`, {
                method: 'PUT',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify({ status: status })
            });
            
            const data = await res.json();
            
            if (data.success) {
                await fetchAppointments();
                showToast(`✅ Appointment ${status.toLowerCase()} successfully`);
            } else {
                showToast('❌ Failed to update status: ' + (data.message || 'Unknown error'));
            }
        } catch(e) { 
            console.error("Update status error:", e);
            showToast("Error updating status"); 
        }
    }

    async function deleteAppointment(id) {
        if(!confirm('⚠️ Are you sure you want to delete this appointment? This action cannot be undone.')) return;
        
        try {
            const res = await fetch(`${baseUrl}/appointments/${id}/delete-appointment`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': csrfToken 
                }
            });
            
            const data = await res.json();
            
            if (data.success) {
                await fetchAppointments();
                addNotification(`🗑️ Appointment deleted from database`);
                showToast('✅ Appointment deleted successfully');
            } else {
                showToast('❌ Failed to delete appointment');
            }
        } catch(e) { 
            console.error("Delete error:", e);
            showToast("Error deleting appointment"); 
        }
    }

    async function loadDoctors() {
        try {
            const res = await fetch(`${baseUrl}/doctors/list-ajax`);
            const doctors = await res.json();
            const select = document.getElementById('doctorId');
            if (select) {
                select.innerHTML = '<option value="">-- Select Doctor --</option>';
                doctors.forEach(doctor => {
                    select.innerHTML += `<option value="${doctor.id}">${escapeHtml(doctor.name)}${doctor.specialty ? ' - ' + escapeHtml(doctor.specialty) : ''}</option>`;
                });
            }
        } catch(e) { 
            console.error("Doctor load error:", e);
            showToast("Error loading doctors list");
        }
    }

    async function addAppointment() {
        const patient = document.getElementById('patientName').value.trim();
        const doctorId = document.getElementById('doctorId').value;
        const specialty = document.getElementById('specialty').value.trim();
        const date = document.getElementById('apptDate').value;
        const time = document.getElementById('apptTime').value;
        const notes = document.getElementById('notes').value.trim();
        
        if(!patient || !doctorId || !date || !time) {
            alert("❌ Please fill Patient, Doctor, Date, and Time");
            return;
        }
        
        const data = {
            patient_name: patient,
            doctor_id: doctorId,
            specialty: specialty || "General",
            date: date,
            time: time,
            notes: notes
        };
        
        try {
            const res = await fetch(`${baseUrl}/appointments/store-appointment`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify(data)
            });
            
            const result = await res.json();
            
            if (result.success) {
                await fetchAppointments();
                toggleAddForm();
                
                document.getElementById('patientName').value = '';
                document.getElementById('specialty').value = '';
                document.getElementById('apptDate').value = '';
                document.getElementById('apptTime').value = '';
                document.getElementById('notes').value = '';
                document.getElementById('doctorId').value = '';
                
                addNotification(`📅 New appointment booked for ${patient}`);
                showToast('✅ Appointment added successfully!');
            } else {
                alert("Error: " + (result.message || "Could not save appointment"));
            }
        } catch(e) { 
            console.error("Add appointment error:", e);
            showToast("Error adding appointment"); 
        }
    }

    // ========== Edit Appointment ==========
    async function openEditModal(id) {
        try {
            const res = await fetch(`${baseUrl}/appointments/get-data`);
            const data = await res.json();
            const app = data.data.find(a => a.id === id);
            
            if(!app) {
                showToast("Appointment not found");
                return;
            }
            
            currentEditId = id;
            document.getElementById('editPatient').value = app.patient_name || '';
            document.getElementById('editDoctor').value = app.doctor_name || '';
            document.getElementById('editSpecialty').value = app.specialty || '';
            document.getElementById('editDate').value = app.date || '';
            document.getElementById('editTime').value = app.time || '';
            document.getElementById('editNotes').value = app.notes || '';
            document.getElementById('editModal').style.display = 'flex';
        } catch(e) {
            console.error("Open edit error:", e);
            showToast("Error loading appointment details");
        }
    }

    async function saveEdit() {
        const updatedData = {
            patient_name: document.getElementById('editPatient').value.trim(),
            doctor_name: document.getElementById('editDoctor').value.trim(),
            specialty: document.getElementById('editSpecialty').value.trim(),
            date: document.getElementById('editDate').value,
            time: document.getElementById('editTime').value,
            notes: document.getElementById('editNotes').value.trim()
        };
        
        if (!updatedData.patient_name || !updatedData.date || !updatedData.time) {
            showToast("Please fill all required fields");
            return;
        }
        
        try {
            const res = await fetch(`${baseUrl}/appointments/${currentEditId}/update-appointment`, {
                method: 'PUT',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': csrfToken 
                },
                body: JSON.stringify(updatedData)
            });
            
            const data = await res.json();
            
            if (data.success) {
                await fetchAppointments();
                closeModal();
                addNotification(`✏️ Appointment for ${updatedData.patient_name} has been updated`);
                showToast('✅ Appointment updated successfully');
            } else {
                showToast('❌ Failed to update appointment');
            }
        } catch(e) { 
            console.error("Save edit error:", e);
            showToast("Error updating appointment"); 
        }
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
        currentEditId = null;
    }

    function toggleAddForm() {
        const form = document.getElementById('addForm');
        if (form) {
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    }

    // ========== Event Listeners ==========
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.addEventListener('keyup', fetchAppointments);
        
        const statusFilter = document.getElementById('statusFilter');
        if (statusFilter) statusFilter.addEventListener('change', fetchAppointments);
        
        const dateFilter = document.getElementById('dateFilter');
        if (dateFilter) dateFilter.addEventListener('change', fetchAppointments);
        
        window.onclick = function(e) { 
            const modal = document.getElementById('editModal');
            if (e.target === modal) closeModal(); 
        };
        
        loadDoctors();
        fetchAppointments();
        updateBellCount();
        setInterval(updateBellCount, 30000);
    });
</script>
@endsection