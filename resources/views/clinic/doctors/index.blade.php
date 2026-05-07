@extends('clinic.layouts.clinic')

@section('title', 'Manage Doctors')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
    
    /* Add Doctor Card */
    .add-doctor-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .add-doctor-card h2 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
    }
    
    .add-doctor-card h2 i {
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
    
    /* Doctors Table */
    .doctors-table-container {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .doctors-table-container h2 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .doctors-table-container h2 i {
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
    
    .doctor-avatar {
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
    
    .status-onleave {
        background: #fef3c7;
        color: #d97706;
    }
    
    .status-blocked {
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
    
    .btn-schedule {
        background: #8b5cf6;
        color: white;
    }
    
    .btn-schedule:hover {
        background: #7c3aed;
        transform: translateY(-1px);
    }
    
    .no-results {
        text-align: center;
        padding: 50px;
        color: #94a3b8;
        font-size: 14px;
    }
    
    /* Schedule Modal */
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
        width: 90%;
        max-width: 1300px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        border-radius: 28px;
        position: relative;
        animation: modalPop 0.3s ease;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #eef2ff;
    }
    
    .modal-header h2 {
        font-size: 22px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-header h2 i {
        color: #6366f1;
    }
    
    .close-modal {
        background: #ef4444;
        color: white;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .close-modal:hover {
        background: #dc2626;
        transform: scale(1.05);
    }
    
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    
    .schedule-table th,
    .schedule-table td {
        border: 1px solid #e2e8f0;
        padding: 12px;
        text-align: center;
        font-size: 13px;
    }
    
    .schedule-table th {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 600;
    }
    
    .schedule-table td {
        background: white;
    }
    
    .time-slot {
        font-weight: 600;
        background: #f8fafc;
    }
    
    .work-type {
        cursor: pointer;
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .work-type.surgery {
        background: #fef2f2;
        color: #dc2626;
    }
    
    .work-type.exam {
        background: #ecfdf5;
        color: #10b981;
    }
    
    .work-type.holiday {
        background: #fef3c7;
        color: #d97706;
    }
    
    .work-type:hover {
        transform: scale(1.05);
    }
    
    .btn-sm {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        margin-right: 10px;
    }
    
    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }
    
    .btn-edit-time {
        background: none;
        border: none;
        color: #6366f1;
        cursor: pointer;
        font-size: 14px;
        margin-left: 8px;
    }
    
    .btn-edit-time:hover {
        color: #4f46e5;
    }
    
    .btn-save-time {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 4px 12px;
        cursor: pointer;
        font-size: 11px;
    }
    
    .inline-input {
        width: 80px;
        padding: 4px 8px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
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
    
    body.rtl .doctors-table-container h2 {
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
                <h4>Total Doctors</h4>
                <div class="number" id="totalDoctors">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>Active Doctors</h4>
                <div class="number" id="activeDoctors">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>On Leave</h4>
                <div class="number" id="onLeaveDoctors">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h4>Specialties</h4>
                <div class="number" id="totalSpecialties">0</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-stethoscope"></i>
            </div>
        </div>
    </div>
    
    <!-- SEARCH & FILTER -->
    <div class="search-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by name, specialty, or email...">
        <select class="filter-select" id="statusFilter">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="onleave">On Leave</option>
            <option value="blocked">Blocked</option>
        </select>
    </div>
    
    <!-- ADD DOCTOR FORM -->
    <div class="add-doctor-card">
        <h2><i class="fas fa-user-plus"></i> Add New Doctor</h2>
        <div class="form-grid">
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" id="docName" placeholder="Dr. John Smith">
            </div>
            <div class="input-group">
                <label>Specialty</label>
                <input type="text" id="docSpecialty" placeholder="Cardiology">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" id="docEmail" placeholder="doctor@heald.com">
            </div>
            <div class="input-group">
                <label>Phone</label>
                <input type="tel" id="docPhone" placeholder="+213 XX XXX XXXX">
            </div>
            <div class="input-group">
                <label>Working Days</label>
                <input type="text" id="docDays" placeholder="Mon, Tue, Wed, Thu">
            </div>
            <div class="input-group">
                <label>Status</label>
                <select id="docStatus">
                    <option value="active">Active</option>
                    <option value="onleave">On Leave</option>
                    <option value="blocked">Blocked</option>
                </select>
            </div>
        </div>
        <button class="btn-add" onclick="addDoctor()">
            <i class="fas fa-plus"></i> Add Doctor
        </button>
    </div>
    
    <!-- DOCTORS TABLE -->
    <div class="doctors-table-container">
        <h2><i class="fas fa-list"></i> Doctors List</h2>
        <div style="overflow-x: auto;">
            <table id="doctorsTable">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Working Days</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="doctorsTableBody"></tbody>
            </table>
        </div>
        <div id="noResults" class="no-results" style="display: none;">
            <i class="fas fa-inbox"></i> No doctors found matching your search
        </div>
    </div>
</div>

<!-- SCHEDULE MODAL -->
<div id="scheduleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><i class="fas fa-calendar-week"></i> <span id="modalDoctorName">Doctor Name</span> - Weekly Work Schedule</h2>
            <button class="close-modal" onclick="closeScheduleModal()">&times;</button>
        </div>
        <div style="overflow-x: auto;">
            <table class="schedule-table" id="weeklyScheduleTable">
                <thead id="scheduleHeader"></thead>
                <tbody id="scheduleBody"></tbody>
            </table>
        </div>
        <div>
            <button class="btn-sm" id="addTimeSlotBtn" onclick="addTimeSlot()">
                <i class="fas fa-plus"></i> Add Time Slot
            </button>
            <button class="btn-sm" id="resetDefaultBtn" onclick="resetToDefault()">
                <i class="fas fa-undo"></i> Reset to Default
            </button>
        </div>
    </div>
</div>

<script>
    // Translation data
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const dayNames = {
        en: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        fr: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        ar: ["الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"]
    };
    const typeNames = {
        en: { surgery: "Surgery", exam: "Examination", holiday: "Holiday" },
        fr: { surgery: "Chirurgie", exam: "Examen", holiday: "Congé" },
        ar: { surgery: "جراحة", exam: "فحص", holiday: "عطلة" }
    };
    
    let currentDoctorId = null;
    let currentWorkSchedule = {};
    let currentTimeSlots = [];
    let currentLang = localStorage.getItem('clinicLanguage') || 'en';
    
    // Escape HTML
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    // Fetch doctors from database
    async function fetchDoctors() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        const url = `/clinic/doctors/data?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`;
        
        try {
            const res = await fetch(url);
            const result = await res.json();
            
            if (result.success) {
                let doctorsArray = [];
                let stats = null;
                
                if (Array.isArray(result.data)) {
                    doctorsArray = result.data;
                    stats = result.stats;
                } else if (result.data && Array.isArray(result.data.data)) {
                    doctorsArray = result.data.data;
                    stats = result.stats;
                } else {
                    doctorsArray = [];
                }
                
                renderDoctors(doctorsArray);
                
                if (stats) {
                    updateStats(stats);
                } else {
                    updateStats(calculateStats(doctorsArray));
                }
            } else {
                console.error('API error:', result);
                renderDoctors([]);
            }
        } catch (err) {
            console.error('Fetch error:', err);
            renderDoctors([]);
        }
    }
    
    function calculateStats(doctors) {
        if (!doctors || !doctors.length) {
            return { total: 0, active: 0, onleave: 0, specialties: 0 };
        }
        const total = doctors.length;
        const active = doctors.filter(d => d.status === 'active').length;
        const onleave = doctors.filter(d => d.status === 'onleave').length;
        const specialties = new Set(doctors.map(d => d.specialty).filter(s => s)).size;
        return { total, active, onleave, specialties };
    }
    
    function renderDoctors(doctors) {
        const tbody = document.getElementById('doctorsTableBody');
        const noResults = document.getElementById('noResults');
        
        if (!doctors || doctors.length === 0) {
            tbody.innerHTML = '';
            noResults.style.display = 'block';
            return;
        }
        
        noResults.style.display = 'none';
        tbody.innerHTML = '';
        
        doctors.forEach(doc => {
            let statusClass = `status-${doc.status}`;
            let statusText = doc.status === 'active' ? 'Active' : (doc.status === 'onleave' ? 'On Leave' : 'Blocked');
            let statusIcon = doc.status === 'active' ? '🟢' : (doc.status === 'onleave' ? '🟡' : '🔴');
            
            tbody.innerHTML += `
                <tr>
                    <td><div class="doctor-avatar">👨‍⚕️</div></td>
                    <td><strong>${escapeHtml(doc.name)}</strong></td>
                    <td>${escapeHtml(doc.specialty)}</td>
                    <td>${escapeHtml(doc.email)}</td>
                    <td>${escapeHtml(doc.phone)}</td>
                    <td>${escapeHtml(doc.working_days || '—')}</td>
                    <td><span class="status-badge ${statusClass}">${statusIcon} ${statusText}</span></td>
                    <td class="action-buttons">
                        <button class="btn-icon btn-edit" onclick="editDoctor(${doc.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-icon btn-delete" onclick="deleteDoctor(${doc.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                        <button class="btn-icon btn-status" onclick="toggleDoctorStatus(${doc.id})">
                            <i class="fas fa-sync-alt"></i> Status
                        </button>
                        <button class="btn-icon btn-schedule" onclick="openScheduleModal(${doc.id}, '${escapeHtml(doc.name)}')">
                            <i class="fas fa-calendar-week"></i> Schedule
                        </button>
                    </td>
                <table>
            `;
        });
    }
    
    function updateStats(stats) {
        document.getElementById('totalDoctors').innerText = stats.total || 0;
        document.getElementById('activeDoctors').innerText = stats.active || 0;
        document.getElementById('onLeaveDoctors').innerText = stats.onleave || 0;
        document.getElementById('totalSpecialties').innerText = stats.specialties || 0;
    }
    
    // Add doctor
    async function addDoctor() {
        const data = {
            full_name: document.getElementById('docName').value,
            specialty: document.getElementById('docSpecialty').value,
            email: document.getElementById('docEmail').value,
            phone: document.getElementById('docPhone').value,
            working_days: document.getElementById('docDays').value,
            status: document.getElementById('docStatus').value
        };
        
        if (!data.full_name || !data.email) {
            alert('❌ Name and Email are required');
            return;
        }
        
        try {
            const res = await fetch('/clinic/doctors', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            
            const result = await res.json();
            
            if (res.ok && result.success) {
                alert('✅ Doctor added successfully');
                document.getElementById('docName').value = '';
                document.getElementById('docSpecialty').value = '';
                document.getElementById('docEmail').value = '';
                document.getElementById('docPhone').value = '';
                document.getElementById('docDays').value = '';
                document.getElementById('docStatus').value = 'active';
                fetchDoctors();
            } else {
                let errorMsg = result.message || 'Unknown error';
                if (result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('\n');
                }
                alert('❌ Failed: ' + errorMsg);
            }
        } catch (err) {
            console.error(err);
            alert('❌ Network error or server problem');
        }
    }
    
    // Delete doctor
    async function deleteDoctor(id) {
        if (confirm('Are you sure you want to delete this doctor?')) {
            await fetch(`/clinic/doctors/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            fetchDoctors();
        }
    }
    
    // Edit doctor
    async function editDoctor(id) {
        const newName = prompt('Enter new name:');
        if (newName) {
            await fetch(`/clinic/doctors/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: newName })
            });
            fetchDoctors();
        }
    }
    
    // Toggle status
    async function toggleDoctorStatus(id) {
        await fetch(`/clinic/doctors/${id}/toggle-status`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        fetchDoctors();
    }
    
    // Schedule modal
    async function openScheduleModal(doctorId, doctorName) {
        currentDoctorId = doctorId;
        document.getElementById('modalDoctorName').innerText = doctorName;
        
        try {
            const res = await fetch(`/clinic/doctors/${doctorId}/schedule`);
            const data = await res.json();
            
            if (data.success) {
                currentWorkSchedule = data.data.workSchedule || {};
                currentTimeSlots = data.data.timeSlots || ['09:00', '11:00', '14:00', '16:00'];
                renderScheduleModal();
                document.getElementById('scheduleModal').style.display = 'flex';
            }
        } catch (err) {
            console.error(err);
            alert('Error loading schedule');
        }
    }
    
    function renderScheduleModal() {
        const headerRow = document.getElementById('scheduleHeader');
        const bodyRow = document.getElementById('scheduleBody');
        
        headerRow.innerHTML = '<th>Time / Day</th>' + days.map(day => `<th>${dayNames[currentLang][days.indexOf(day)]}</th>`).join('');
        
        bodyRow.innerHTML = '';
        currentTimeSlots.forEach(time => {
            let row = `<tr><td class="time-slot">${time}</td>`;
            days.forEach(day => {
                const key = `${day}|${time}`;
                const value = currentWorkSchedule[key] || { type: 'exam', text: '' };
                row += `<td class="work-cell" data-day="${day}" data-time="${time}">
                            <div class="work-type ${value.type}" onclick="editWorkType('${day}', '${time}')">
                                ${typeNames[currentLang][value.type] || 'Examination'}
                                ${value.text ? `<br><small>${escapeHtml(value.text)}</small>` : ''}
                            </div>
                         </td>`;
            });
            row += `</tr>`;
            bodyRow.innerHTML += row;
        });
    }
    
    function editWorkType(day, time) {
        const key = `${day}|${time}`;
        const current = currentWorkSchedule[key] || { type: 'exam', text: '' };
        const newType = prompt('Enter type (surgery/exam/holiday):', current.type);
        const newText = prompt('Enter description (optional):', current.text);
        
        if (newType && ['surgery', 'exam', 'holiday'].includes(newType)) {
            currentWorkSchedule[key] = { type: newType, text: newText || '' };
            saveSchedule();
        }
    }
    
    function addTimeSlot() {
        const newTime = prompt('Enter new time slot (e.g., 13:00):');
        if (newTime && !currentTimeSlots.includes(newTime)) {
            currentTimeSlots.push(newTime);
            currentTimeSlots.sort();
            saveSchedule();
        }
    }
    
    function resetToDefault() {
        if (confirm('Reset to default schedule?')) {
            currentWorkSchedule = {};
            currentTimeSlots = ['09:00', '11:00', '14:00', '16:00'];
            saveSchedule();
        }
    }
    
    async function saveSchedule() {
        try {
            await fetch(`/clinic/doctors/${currentDoctorId}/schedule`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    workSchedule: currentWorkSchedule,
                    timeSlots: currentTimeSlots
                })
            });
            renderScheduleModal();
        } catch (err) {
            console.error(err);
        }
    }
    
    function closeScheduleModal() {
        document.getElementById('scheduleModal').style.display = 'none';
        currentDoctorId = null;
    }
    
    // Listen for language changes
    window.addEventListener('languageChanged', function(e) {
        currentLang = e.detail?.lang || localStorage.getItem('clinicLanguage') || 'en';
        renderDoctors(allDoctors);
        if (currentDoctorId) {
            renderScheduleModal();
        }
    });
    
    // Event listeners
    document.getElementById('searchInput').addEventListener('keyup', fetchDoctors);
    document.getElementById('statusFilter').addEventListener('change', fetchDoctors);
    
    // Close modal on outside click
    window.onclick = function(e) {
        const modal = document.getElementById('scheduleModal');
        if (e.target === modal) {
            closeScheduleModal();
        }
    }
    
    // Initial load
    fetchDoctors();
</script>
@endsection