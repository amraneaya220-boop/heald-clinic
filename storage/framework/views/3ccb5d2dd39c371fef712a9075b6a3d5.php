

<?php $__env->startSection('title', 'Manage Appointments'); ?>
<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<div class="header-section">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">📅 Manage Appointments</h1>
        <p class="text-slate-500 text-sm mt-1">Schedule, manage, and track all patient appointments</p>
    </div>
    <div class="relative cursor-pointer" id="bellIcon">
        <span class="text-2xl">🔔</span>
        <span class="absolute -top-1 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center" id="bellCount">0</span>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card"><h3>Total Appointments</h3><div class="stat-number" id="totalAppointments">0</div></div>
    <div class="stat-card pending"><h3>Pending</h3><div class="stat-number" id="pendingCount">0</div></div>
    <div class="stat-card accepted"><h3>Accepted</h3><div class="stat-number" id="acceptedCount">0</div></div>
    <div class="stat-card rejected"><h3>Rejected</h3><div class="stat-number" id="rejectedCount">0</div></div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by patient or doctor...">
    <select class="filter-select" id="statusFilter">
        <option value="all">All Status</option>
        <option value="Pending">Pending</option>
        <option value="Accepted">Accepted</option>
        <option value="Rejected">Rejected</option>
    </select>
    <input type="date" class="date-filter" id="dateFilter">
    <button class="btn-add" onclick="toggleAddForm()">+ New Appointment</button>
</div>

<!-- Add Form -->
<div class="add-form" id="addForm" style="display: none;">
    <h3 class="text-lg font-semibold text-slate-800 mb-4">➕ Schedule New Appointment</h3>
    <div class="form-grid">
        <div class="input-group"><label>Patient Name</label><input type="text" id="patientName" placeholder="Full name"></div>
        <div class="input-group"><label>Doctor Name</label><select id="doctorId" class="w-full p-2 border rounded-xl"><option value="">Select Doctor</option></select></div>
        <div class="input-group"><label>Specialty</label><input type="text" id="specialty" placeholder="e.g., Cardiology"></div>
        <div class="input-group"><label>Date</label><input type="date" id="apptDate"></div>
        <div class="input-group"><label>Time</label><input type="time" id="apptTime"></div>
        <div class="input-group"><label>Notes</label><input type="text" id="notes" placeholder="Additional notes"></div>
    </div>
    <div class="flex gap-3 mt-4">
        <button class="btn-save" onclick="addAppointment()">Save Appointment</button>
        <button class="btn-cancel" onclick="toggleAddForm()">Cancel</button>
    </div>
</div>

<!-- Appointments Table -->
<div class="table-container">
    <h2 class="table-title">📋 Appointments List</h2>
    <div style="overflow-x: auto;">
        <table class="appointments-table">
            <thead>
                <tr><th>Patient</th><th>Doctor</th><th>Specialty</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody id="appointmentsBody"></tbody>
        </table>
    </div>
    <div id="noResults" class="no-results" style="display: none;">📭 No appointments found matching your filters</div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h3 class="text-xl font-bold text-slate-800 mb-4">✏️ Edit Appointment</h3>
        <input type="text" id="editPatient" placeholder="Patient Name" class="modal-input">
        <input type="text" id="editDoctor" placeholder="Doctor Name" class="modal-input">
        <input type="text" id="editSpecialty" placeholder="Specialty" class="modal-input">
        <input type="date" id="editDate" class="modal-input">
        <input type="time" id="editTime" class="modal-input">
        <input type="text" id="editNotes" placeholder="Notes" class="modal-input">
        <div class="modal-buttons">
            <button class="btn-save" onclick="saveEdit()">Save</button>
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="toast-container"></div>

<style>
    /* Reset & Base */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background: #f0f4f8; }
    
    /* Header Section */
    .header-section {
        background: white;
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    /* Stats Cards */
    .stats-grid {
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
    .stat-card h3 { color: #64748b; font-size: 12px; margin-bottom: 6px; }
    .stat-number { font-size: 28px; font-weight: bold; color: #2563eb; }
    .stat-card.pending .stat-number { color: #f59e0b; }
    .stat-card.accepted .stat-number { color: #16a34a; }
    .stat-card.rejected .stat-number { color: #dc2626; }
    
    /* Filter Bar */
    .filter-bar {
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
        min-width: 180px;
    }
    .search-input:focus { border-color: #2563eb; }
    .filter-select, .date-filter {
        padding: 8px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        background: white;
        font-size: 13px;
        cursor: pointer;
    }
    .btn-add {
        background: #2563eb;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 500;
        font-size: 13px;
    }
    .btn-add:hover { background: #1e40af; }
    
    /* Add Form */
    .add-form {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
    }
    .input-group { display: flex; flex-direction: column; gap: 5px; }
    .input-group label { font-weight: 600; color: #1e293b; font-size: 12px; }
    .input-group input, .input-group select {
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 13px;
        outline: none;
    }
    .input-group input:focus, .input-group select:focus { border-color: #2563eb; }
    .btn-save {
        background: #16a34a;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 500;
    }
    .btn-save:hover { background: #15803d; }
    .btn-cancel {
        background: #64748b;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 500;
    }
    .btn-cancel:hover { background: #475569; }
    
    /* Table */
    .table-container {
        background: white;
        border-radius: 20px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow-x: auto;
    }
    .table-title {
        color: #0f2b5c;
        font-size: 18px;
        margin-bottom: 15px;
        padding-left: 10px;
        border-left: 4px solid #f59e0b;
    }
    .appointments-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .appointments-table th, .appointments-table td {
        padding: 10px 8px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }
    .appointments-table th {
        background: #f8fafc;
        color: #1e3a8a;
        font-weight: 600;
        font-size: 12px;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-pending { background: #fef3c7; color: #f59e0b; }
    .status-accepted { background: #dcfce7; color: #16a34a; }
    .status-rejected { background: #fee2e2; color: #dc2626; }
    
    /* Action Buttons */
    .action-buttons { display: flex; gap: 5px; flex-wrap: wrap; }
    .btn-icon {
        padding: 4px 10px;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-accept { background: #16a34a; color: white; }
    .btn-accept:hover { background: #15803d; }
    .btn-reject { background: #dc2626; color: white; }
    .btn-reject:hover { background: #b91c1c; }
    .btn-edit { background: #2563eb; color: white; }
    .btn-edit:hover { background: #1e40af; }
    .btn-delete { background: #ef4444; color: white; }
    .btn-delete:hover { background: #dc2626; }
    
    /* Modal */
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
        width: 450px;
        padding: 25px;
        border-radius: 24px;
        animation: modalPop 0.3s ease;
    }
    .modal-input {
        width: 100%;
        padding: 10px 14px;
        margin-bottom: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
    }
    .modal-input:focus { border-color: #2563eb; }
    .modal-buttons { display: flex; gap: 10px; margin-top: 10px; }
    .modal-buttons button { flex: 1; padding: 10px; border: none; border-radius: 30px; cursor: pointer; font-weight: 600; }
    
    /* Toast */
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
    }
    .toast {
        background: #0f2b5c;
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        margin-top: 10px;
        animation: slideIn 0.3s ease;
        font-size: 13px;
    }
    .no-results { text-align: center; padding: 30px; color: #94a3b8; font-size: 14px; }
    
    @keyframes modalPop { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    
    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; align-items: stretch; }
        .form-grid { grid-template-columns: 1fr; }
        .modal-content { width: 90%; margin: 20px; }
    }
</style>

<script>
    // ========== المتغيرات العامة ==========
    let currentEditId = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const baseUrl = '<?php echo e(url("clinic")); ?>';

    // ========== دوال الإشعارات ==========
    function addNotification(notificationText) {
        try {
            let notifications = JSON.parse(localStorage.getItem("clinic_notifications_v3")) || [];
            notifications.unshift({ id: Date.now(), text: notificationText, read: false, timestamp: new Date().toISOString() });
            if (notifications.length > 50) notifications.pop();
            localStorage.setItem("clinic_notifications_v3", JSON.stringify(notifications));
            updateBellCount();
            showToast(notificationText);
        } catch(e) { showToast(notificationText); }
    }

    function updateBellCount() {
        try {
            const notifications = JSON.parse(localStorage.getItem("clinic_notifications_v3")) || [];
            const unread = notifications.filter(n => !n.read).length;
            const bellCount = document.getElementById("bellCount");
            if (bellCount) bellCount.innerText = unread;
        } catch(e) { console.log("Bell count error:", e); }
    }

    function showToast(message) {
        const container = document.getElementById("toastContainer");
        if (!container) return;
        const toast = document.createElement("div");
        toast.className = "toast";
        toast.innerText = message;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    function goToNotifications() {
        window.location.href = "<?php echo e(route('clinic.notifications.index')); ?>";
    }

    // ========== جلب البيانات من قاعدة البيانات ==========
    async function fetchAppointments() {
        const search = document.getElementById('searchInput')?.value || '';
        const status = document.getElementById('statusFilter')?.value || 'all';
        const date = document.getElementById('dateFilter')?.value || '';
        
        const tbody = document.getElementById('appointmentsBody');
        if (tbody) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">⏳ Loading appointments...</td></tr>';
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
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-red-500">❌ Error loading appointments. Please refresh the page.</td></tr>';
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
                        <button class="btn-icon btn-accept" onclick="updateStatus(${app.id},'Accepted')">✓ Accept</button>
                        <button class="btn-icon btn-reject" onclick="updateStatus(${app.id},'Rejected')">✗ Reject</button>
                        <button class="btn-icon btn-edit" onclick="openEditModal(${app.id})">✏️ Edit</button>
                        <button class="btn-icon btn-delete" onclick="deleteAppointment(${app.id})">🗑️ Delete</button>
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

    // ========== تعديل الموعد ==========
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

    // ========== Event Listeners & Init ==========
    document.addEventListener('DOMContentLoaded', () => {
        const bellIcon = document.getElementById('bellIcon');
        if (bellIcon) bellIcon.addEventListener('click', goToNotifications);
        
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
        setInterval(updateBellCount, 1000);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/appointments/index.blade.php ENDPATH**/ ?>