{{-- resources/views/doctor/dashboard.blade.php --}}
@extends('doctor.layouts.doctor')

@section('title', 'Dashboard')

@section('content')
<!-- Stats -->
<div class="stats" id="statsContainer">
    <div class="stat-card">
        <i class="fas fa-calendar-check"></i>
        <h3>{{ $todayAppointmentsCount ?? 0 }}</h3>
        <p data-i18n="stat_today" id="stat_today">Today's Appointments</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-users"></i>
        <h3>{{ $newPatientsCount ?? 0 }}</h3>
        <p data-i18n="stat_new" id="stat_new">New Patients</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle"></i>
        <h3>{{ $completedAppointmentsCount ?? 0 }}</h3>
        <p data-i18n="stat_completed" id="stat_completed">Completed</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-hourglass-half"></i>
        <h3>{{ $pendingAppointmentsCount ?? 0 }}</h3>
        <p data-i18n="stat_pending" id="stat_pending">Pending</p>
    </div>
</div>

<!-- Today's Appointments Table -->
<div class="card-white">
    <h3><i class="fas fa-calendar-day"></i> 📅 <span id="todayTitle">Today's Appointments</span> – <span id="currentDate"></span></h3>
    <div style="overflow-x: auto;">
        <table id="appointmentsTable">
            <thead>
                <tr>
                    <th id="th_time">⏰ Time</th>
                    <th id="th_patient">🩺 Patient</th>
                    <th id="th_status">📌 Status</th>
                    <th id="th_action">⚙️ Action</th>
                </tr>
            </thead>
            <tbody id="appointmentsTableBody">
                @forelse($todayAppointments ?? [] as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                    <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                    <td>
                        @php
                            $statusClass = '';
                            $statusText = ucfirst($appointment->status);
                            if ($appointment->status == 'completed') $statusClass = 'completed';
                            elseif ($appointment->status == 'ready') $statusClass = 'ready';
                            elseif ($appointment->status == 'waiting') $statusClass = 'waiting';
                            elseif ($appointment->status == 'cancelled') $statusClass = 'cancelled';
                        @endphp
                        <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td>
                        {{-- IMPORTANT: Use data-appointment-id instead of data-patient-id --}}
                        <button class="btn-sm view-appointment-detail" data-appointment-id="{{ $appointment->id }}">
                            Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center;">No appointments for today</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Upcoming Appointments -->
<div class="card-white">
    <h3><i class="fas fa-calendar-week"></i> 📅 <span id="upcomingTitle">Upcoming Appointments</span></h3>
    <div id="upcomingText">
        @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)
            @foreach($upcomingAppointments->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->appointment_date)->format('Y-m-d');
            }) as $date => $appointments)
                <div>📅 {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}: {{ $appointments->count() }} appointment(s)</div>
            @endforeach
        @else
            <p>No upcoming appointments</p>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: #0f2b3d;
        padding: 25px;
        border-radius: 25px;
        text-align: center;
        border: 1px solid #1e4a76;
        transition: 0.2s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card i { font-size: 40px; color: #4fc3f7; margin-bottom: 15px; }
    .stat-card h3 { font-size: 32px; color: white; }
    .stat-card p { color: #89b9d9; font-weight: 500; }
    .status.cancelled { background: #ffebee; color: #c62828; }
    @media (max-width: 700px) { 
        .stats { grid-template-columns: 1fr 1fr; } 
    }
</style>
@endpush

@push('scripts')
<script>
// Complete translations
const fullTranslations = {
    ar: {
        nav_dash: "لوحة التحكم", nav_app: "المواعيد", nav_schedule: "جدول العمل", nav_record: "ملف المريض", nav_settings: "الإعدادات",
        stat_today: "مواعيد اليوم", stat_new: "مرضى جدد", stat_completed: "مكتملة", stat_pending: "معلقة",
        today_title: "مواعيد اليوم", th_time: "الوقت", th_patient: "المريض", th_status: "الحالة", th_action: "الإجراء",
        status_completed: "مكتمل", status_ready: "جاهز", status_upcoming: "قادم", status_cancelled: "ملغي",
        btn_details: "تفاصيل", btn_start: "بدء", btn_edit: "تعديل",
        upcoming_title: "المواعيد القادمة",
        notifications_header: "📢 الإشعارات", mark_as_read: "✔️ وضع كمقروء", no_notifications: "✨ لا توجد إشعارات"
    },
    fr: {
        nav_dash: "Tableau de bord", nav_app: "Rendez-vous", nav_schedule: "Planning", nav_record: "Dossier patient", nav_settings: "Paramètres",
        stat_today: "RDV aujourd'hui", stat_new: "Nouveaux patients", stat_completed: "Terminés", stat_pending: "En attente",
        today_title: "RDV aujourd'hui", th_time: "Heure", th_patient: "Patient", th_status: "Statut", th_action: "Action",
        status_completed: "Terminé", status_ready: "Prêt", status_upcoming: "À venir", status_cancelled: "Annulé",
        btn_details: "Détails", btn_start: "Démarrer", btn_edit: "Modifier",
        upcoming_title: "Prochains RDV",
        notifications_header: "📢 Notifications", mark_as_read: "✔️ Marquer comme lu", no_notifications: "✨ Aucune notification"
    },
    en: {
        nav_dash: "Dashboard", nav_app: "Appointments", nav_schedule: "Schedule", nav_record: "Patient Record", nav_settings: "Settings",
        stat_today: "Today's Appointments", stat_new: "New Patients", stat_completed: "Completed", stat_pending: "Pending",
        today_title: "Today's Appointments", th_time: "Time", th_patient: "Patient", th_status: "Status", th_action: "Action",
        status_completed: "Completed", status_ready: "Ready", status_upcoming: "Upcoming", status_cancelled: "Cancelled",
        btn_details: "Details", btn_start: "Start", btn_edit: "Edit",
        upcoming_title: "Upcoming Appointments",
        notifications_header: "📢 Notifications", mark_as_read: "✔️ Mark as read", no_notifications: "✨ No notifications"
    }
};

// Load notifications from database
let notifications = @json($notifications ?? []);
let currentLang = localStorage.getItem('cliniclick_lang') || 'en';

function renderNotificationBadge() { 
    const unreadCount = notifications.filter(n => !n.read).length;
    const badge = document.getElementById('notificationBadge');
    if (badge) {
        if (unreadCount > 0) {
            badge.style.display = 'inline-block';
            badge.innerText = unreadCount > 9 ? '9+' : unreadCount;
        } else badge.style.display = 'none';
    }
}

function renderNotificationList() {
    const container = document.getElementById('notificationList');
    if (!container) return;
    const t = fullTranslations[currentLang];
    
    if (notifications.length === 0) {
        container.innerHTML = `<div class="notification-item">✨ ${t.no_notifications}</div>`;
        return;
    }
    
    container.innerHTML = '';
    notifications.forEach(notif => {
        let iconClass = 'fa-bell';
        if (notif.type === 'completed') iconClass = 'fa-check-circle';
        else if (notif.type === 'diagnosis') iconClass = 'fa-notes-medical';
        else if (notif.type === 'cancelled') iconClass = 'fa-times-circle';
        
        const div = document.createElement('div');
        div.className = `notification-item ${!notif.read ? 'unread' : ''}`;
        div.innerHTML = `
            <div class="notification-icon"><i class="fas ${iconClass}"></i></div>
            <div class="notification-content">
                <div class="notification-title">${escapeHtml(notif.title)}</div>
                <div class="notification-message">${escapeHtml(notif.message)}</div>
                <div class="notification-time">${new Date(notif.created_at).toLocaleString()}</div>
                ${!notif.read ? `<div class="mark-read" data-id="${notif.id}">${t.mark_as_read}</div>` : ''}
            </div>
        `;
        container.appendChild(div);
    });
    
    document.querySelectorAll('.mark-read').forEach(el => {
        el.addEventListener('click', async (e) => {
            e.stopPropagation();
            const id = parseInt(el.getAttribute('data-id'));
            const note = notifications.find(n => n.id === id);
            if (note && !note.read) {
                try {
                    const response = await fetch(`/doctor/notifications/${id}/mark-read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (response.ok) {
                        note.read = true;
                        renderNotificationBadge();
                        renderNotificationList();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        });
    });
    
}

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m] || m));
}

function updateDashboardTexts() {
    const t = fullTranslations[currentLang];
    const elements = {
        stat_today: 'stat_today',
        stat_new: 'stat_new', 
        stat_completed: 'stat_completed',
        stat_pending: 'stat_pending',
        todayTitle: 'todayTitle',
        th_time: 'th_time',
        th_patient: 'th_patient',
        th_status: 'th_status',
        th_action: 'th_action',
        upcomingTitle: 'upcomingTitle'
    };
    
    for (const [id, elementId] of Object.entries(elements)) {
        const el = document.getElementById(elementId);
        if (el && t[id]) {
            if (elementId === 'todayTitle' || elementId === 'upcomingTitle') {
                el.innerHTML = `📅 ${t[id]}`;
            } else if (elementId.startsWith('th_')) {
                const icon = elementId === 'th_time' ? '⏰' : (elementId === 'th_patient' ? '🩺' : (elementId === 'th_status' ? '📌' : '⚙️'));
                el.innerHTML = `${icon} ${t[id]}`;
            } else {
                el.innerText = t[id];
            }
        }
    }
    
    // Update status texts in table
    document.querySelectorAll('#appointmentsTableBody tr').forEach(row => {
        const statusSpan = row.querySelector('.status');
        if (statusSpan) {
            const currentStatus = statusSpan.innerText.toLowerCase();
            if (currentStatus === 'completed') statusSpan.innerText = t.status_completed;
            else if (currentStatus === 'ready') statusSpan.innerText = t.status_ready;
            else if (currentStatus === 'waiting') statusSpan.innerText = t.status_upcoming;
            else if (currentStatus === 'cancelled') statusSpan.innerText = t.status_cancelled;
        }
        const btn = row.querySelector('.btn-sm');
        if (btn) btn.innerText = t.btn_details;
    });
}

function setCurrentDate() {
    const dateElement = document.getElementById('currentDate');
    if (dateElement) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        dateElement.innerText = new Date().toLocaleDateString(
            currentLang === 'ar' ? 'ar-EG' : (currentLang === 'fr' ? 'fr-FR' : 'en-US'),
            options
        );
    }
}

// ========== IMPORTANT FIX: View appointment details ==========
// This is the correct event handler for the Details button
document.querySelectorAll('.view-appointment-detail').forEach(btn => {
    btn.addEventListener('click', function() {
        const appointmentId = this.getAttribute('data-appointment-id');
        if (appointmentId) {
            window.location.href = `/doctor/appointments/${appointmentId}/detail`;
        }
    });
});

// Initialize
setCurrentDate();
renderNotificationBadge();
renderNotificationList();
updateDashboardTexts();

// Bell click handler
const bell = document.getElementById('notificationBell');
const dropdown = document.getElementById('notificationDropdown');
if (bell && dropdown) {
    bell.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });
    document.addEventListener('click', (e) => {
        if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
}
</script>
@endpush