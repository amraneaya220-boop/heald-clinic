@extends('clinic.layouts.clinic')

@section('title', 'Manage Doctors')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="header">
    <h1>👨‍⚕️ Manage Doctors</h1>
    <p>Add, edit, and manage all clinic doctors + weekly work schedule for each doctor</p>
</div>
<div class="stats-cards">
    <div class="stat-card"><h3>Total Doctors</h3><div class="number" id="totalDoctors">0</div></div>
    <div class="stat-card"><h3>Active Doctors</h3><div class="number" id="activeDoctors">0</div></div>
    <div class="stat-card"><h3>On Leave</h3><div class="number" id="onLeaveDoctors">0</div></div>
    <div class="stat-card"><h3>Specialties</h3><div class="number" id="totalSpecialties">0</div></div>
</div>
<div class="search-bar">
    <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by name, speciality, or email...">
    <select class="filter-select" id="statusFilter">
        <option value="all">All Status</option>
        <option value="active">Active</option>
        <option value="onleave">On Leave</option>
        <option value="blocked">Blocked</option>
    </select>
</div>
<div class="add-doctor-card">
    <h2>➕ Add New Doctor</h2>
    <div class="form-grid">
        <div class="input-group"><label>Full Name</label><input type="text" id="docName" placeholder="Dr. John Smith"></div>
        <div class="input-group"><label>speciality</label><input type="text" id="docSpecialty" placeholder="Cardiology"></div>
        <div class="input-group"><label>Email</label><input type="email" id="docEmail" placeholder="doctor@heald.com"></div>
        <div class="input-group"><label>Phone</label><input type="tel" id="docPhone" placeholder="+213 XX XXX XXXX"></div>
        <div class="input-group"><label>Working Days</label><input type="text" id="docDays" placeholder="Mon, Tue, Wed, Thu"></div>
        <div class="input-group"><label>Status</label><select id="docStatus"><option value="active">🟢 Active</option><option value="onleave">🟡 On Leave</option><option value="blocked">🔴 Blocked</option></select></div>
    </div>
    <button class="btn-add" onclick="addDoctor()">+ Add Doctor</button>
</div>
<div class="doctors-table-container">
    <h2>📋 Doctors List</h2>
    <div style="overflow-x: auto;"><table id="doctorsTable"><thead><tr><th>Avatar</th><th>Name</th><th>speciality</th><th>Email</th><th>Phone</th><th>Working Days</th><th>Status</th><th>Actions</th></tr></thead><tbody id="doctorsTableBody"></tbody></table></div>
    <div id="noResults" class="no-results" style="display:none;">📭 No doctors found matching your search</div>
</div>
<div id="scheduleModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:1000; justify-content:center; align-items:center;">
    <div class="modal-content" style="background:white; border-radius:25px; width:90%; max-width:1300px; max-height:90vh; overflow-y:auto; padding:25px;">
        <div class="modal-header"><h2><i class="fas fa-calendar-week"></i> <span id="modalDoctorName">Doctor Name</span> - Weekly Work Schedule</h2><button class="close-modal" onclick="closeScheduleModal()">&times;</button></div>
        <div class="schedule-container" style="overflow-x:auto;"><table class="schedule-table" id="weeklyScheduleTable" style="width:100%; border-collapse:collapse; min-width:700px;"><thead id="scheduleHeader"></thead><tbody id="scheduleBody"></tbody></table></div>
        <div><button class="btn-sm" id="addTimeSlotBtn"><i class="fas fa-plus"></i> Add Time Slot</button><button class="btn-sm" id="resetDefaultBtn" style="background:#6C8DA3;"><i class="fas fa-undo"></i> Reset to Default</button></div>
    </div>
</div>
<style>
    .stats-cards{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:15px;margin-bottom:25px;}
    .stat-card{background:white;padding:15px;border-radius:18px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.05);border:1px solid #e2e8f0;}
    .stat-card .number{font-size:28px;font-weight:bold;color:#2563eb;}
    .search-bar{background:white;padding:12px 18px;border-radius:18px;margin-bottom:20px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;}
    .search-input{flex:1;padding:8px 14px;border:2px solid #e2e8f0;border-radius:30px;}
    .filter-select{padding:8px 14px;border:2px solid #e2e8f0;border-radius:30px;}
    .add-doctor-card{background:white;border-radius:20px;padding:20px;margin-bottom:25px;}
    .add-doctor-card h2{color:#0f2b5c;font-size:18px;margin-bottom:15px;border-bottom:2px solid #e2e8f0;padding-bottom:8px;}
    .form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;}
    .input-group{display:flex;flex-direction:column;gap:4px;}
    .input-group label{font-weight:600;font-size:12px;}
    .input-group input,.input-group select{padding:8px 12px;border:2px solid #e2e8f0;border-radius:12px;}
    .btn-add{background:#16a34a;color:white;border:none;padding:10px;border-radius:30px;font-weight:600;cursor:pointer;margin-top:15px;width:100%;}
    .doctors-table-container{background:white;border-radius:20px;padding:18px;overflow-x:auto;}
    .doctors-table-container h2{color:#0f2b5c;font-size:18px;margin-bottom:15px;border-left:4px solid #f59e0b;padding-left:10px;}
    .doctor-avatar{width:35px;height:35px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#3b82f6;color:white;font-weight:bold;}
    .status-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:500;}
    .status-active{background:#dcfce7;color:#16a34a;}
    .status-onleave{background:#fef3c7;color:#f59e0b;}
    .status-blocked{background:#fee2e2;color:#dc2626;}
    .action-buttons{display:flex;gap:5px;}
    .btn-icon{padding:4px 10px;border:none;border-radius:16px;cursor:pointer;font-size:11px;}
    .btn-edit{background:#2563eb;color:white;}
    .btn-delete{background:#ef4444;color:white;}
    .btn-status{background:#f59e0b;color:white;}
    .btn-schedule{background:#8b5cf6;color:white;}
    .close-modal{background:#ef4444;color:white;border:none;width:35px;height:35px;border-radius:50%;font-size:20px;cursor:pointer;}
    .schedule-table th,.schedule-table td{border:1px solid #ddd;padding:12px;text-align:center;}
    .time-slot{font-weight:600;background:#f9f9f9;}
    .work-type{cursor:pointer;display:inline-block;padding:6px 12px;border-radius:20px;font-size:0.85rem;}
    .work-type.surgery{background:#ffcdd2;color:#c62828;}
    .work-type.exam{background:#c8e6e9;color:#00695c;}
    .work-type.holiday{background:#e0e0e0;color:#555;}
    .btn-edit-time{background:none;border:none;color:#1E8F8F;cursor:pointer;margin-left:8px;}
    .btn-save-time{background:#1E8F8F;color:white;border:none;border-radius:20px;padding:4px 10px;cursor:pointer;}
    .inline-input{width:80px;padding:4px;border-radius:10px;border:1px solid #ccc;}
    .btn-sm{background:#1E8F8F;color:white;border:none;padding:8px 16px;border-radius:30px;cursor:pointer;font-weight:600;margin-right:10px;margin-top:15px;}
</style>
<script>
    const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    const dayNames = { en: ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"], fr: ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"], ar: ["الأحد","الإثنين","الثلاثاء","الأربعاء","الخميس","الجمعة","السبت"] };
    const typeNames = { en: { surgery: "Surgery", exam: "Examination", holiday: "Holiday" }, fr: { surgery: "Chirurgie", exam: "Examen", holiday: "Congé" }, ar: { surgery: "جراحة", exam: "فحص", holiday: "عطلة" } };
    let currentDoctorId = null, currentWorkSchedule = {}, currentTimeSlots = [];
    async function fetchDoctors() {
        const search = document.getElementById('searchInput').value;
        const status = document.getElementById('statusFilter').value;
        const res = await fetch(`{{ route("clinic.doctors.data") }}?search=${search}&status=${status}`);
        const data = await res.json();
        if(data.success) {
            renderDoctors(data.data);
            updateStats(data.stats);
        }
    }
    // دالة لحماية النصوص من XSS
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// تحسين دالة fetchDoctors لمعالجة أي تنسيق للبيانات (مع paginator أو بدونه)
async function fetchDoctors() {
    const search = document.getElementById('searchInput').value;
    const status = document.getElementById('statusFilter').value;
    const url = `/clinic/doctors/data?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`;
    
    try {
        const res = await fetch(url);
        const result = await res.json();
        console.log('API Response:', result);
        
        if (result.success) {
            let doctorsArray = [];
            let stats = null;
            
            // حالة التنسيق الأول: getData (data مصفوفة + stats)
            if (Array.isArray(result.data)) {
                doctorsArray = result.data;
                stats = result.stats;
            }
            // حالة التنسيق الثاني: paginator (data.data مصفوفة)
            else if (result.data && Array.isArray(result.data.data)) {
                doctorsArray = result.data.data;
                // إذا لم تكن stats موجودة، نحسبها من الأطباء
                stats = result.stats || calculateStats(doctorsArray);
            }
            // حالة أخرى غير متوقعة
            else {
                console.warn('Unexpected data format', result);
                doctorsArray = [];
            }
            
            renderDoctors(doctorsArray);
            
            if (stats) {
                updateStats(stats);
            } else {
                // احتساب الإحصائيات من المصفوفة المعروضة
                const calculatedStats = calculateStats(doctorsArray);
                updateStats(calculatedStats);
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

// دالة مساعدة لحساب الإحصائيات من قائمة الأطباء
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
    tbody.innerHTML = '';
    doctors.forEach(doc => {
        let statusClass = `status-${doc.status}`;
        let statusText = doc.status === 'active' ? '🟢 Active' : (doc.status === 'onleave' ? '🟡 On Leave' : '🔴 Blocked');
        tbody.innerHTML += `<tr>
            <td><div class="doctor-avatar">👨‍⚕️</div></td>
            <td><strong>${escapeHtml(doc.name)}</strong></td>
            <td>${escapeHtml(doc.specialty)}</td>
            <td>${escapeHtml(doc.email)}</td>
            <td>${escapeHtml(doc.phone)}</td>
            <td>${escapeHtml(doc.working_days || '')}</td>
            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
            <td class="action-buttons">
                <button class="btn-icon btn-edit" onclick="editDoctor(${doc.id})">✏️ Edit</button>
                <button class="btn-icon btn-delete" onclick="deleteDoctor(${doc.id})">🗑️ Delete</button>
                <button class="btn-icon btn-status" onclick="toggleDoctorStatus(${doc.id})">🔄 Status</button>
                <button class="btn-icon btn-schedule" onclick="openScheduleModal(${doc.id})">📅 Schedule</button>
            </td>
        </tr>`;
    });
}
    function updateStats(stats) {
    console.log('Stats received:', stats);
    document.getElementById('totalDoctors').innerText = stats.total; document.getElementById('activeDoctors').innerText = stats.active; document.getElementById('onLeaveDoctors').innerText = stats.onleave; document.getElementById('totalSpecialties').innerText = stats.specialties; }
   async function addDoctor() {
    const data = {
    full_name: document.getElementById('docName').value,
    specialty: document.getElementById('docSpecialty').value,   // <-- يجب أن يكون specialty
    email: document.getElementById('docEmail').value,
    phone: document.getElementById('docPhone').value,
    working_days: document.getElementById('docDays').value,
    status: document.getElementById('docStatus').value
};
console.log('Working days value:', document.getElementById('docDays').value);
    
    // تحقق بسيط
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
            // إفراغ الحقول
            document.getElementById('docName').value = '';
            document.getElementById('docSpecialty').value = '';
            document.getElementById('docEmail').value = '';
            document.getElementById('docPhone').value = '';
            document.getElementById('docDays').value = '';
            document.getElementById('docStatus').value = 'active';
            // تحديث الجدول
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
    async function deleteDoctor(id) { if(confirm('Delete?')) { await fetch(`{{ url('clinic/doctors') }}/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); fetchDoctors(); } }
    async function editDoctor(id) { const newName = prompt('Enter new name:'); if(newName) { await fetch(`{{ url('clinic/doctors') }}/${id}`, { method: 'PUT', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ name: newName }) }); fetchDoctors(); } }
    async function toggleDoctorStatus(id) { await fetch(`{{ url('clinic/doctors') }}/${id}/toggle-status`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); fetchDoctors(); }
    async function openScheduleModal(doctorId) { currentDoctorId = doctorId; const res = await fetch(`{{ url('clinic/doctors') }}/${doctorId}/schedule`); const data = await res.json(); if(data.success) { currentWorkSchedule = data.data.workSchedule; currentTimeSlots = data.data.timeSlots; renderScheduleModal(); document.getElementById('scheduleModal').style.display = 'flex'; } }
    function closeScheduleModal() { document.getElementById('scheduleModal').style.display = 'none'; currentDoctorId = null; }
    function renderScheduleModal() { /* render schedule table similar to original JS */ }
    document.getElementById('searchInput').addEventListener('keyup', fetchDoctors);
    document.getElementById('statusFilter').addEventListener('change', fetchDoctors);
    fetchDoctors();
</script>
@endsection