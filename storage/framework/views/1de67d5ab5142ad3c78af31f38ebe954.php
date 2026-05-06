

<?php $__env->startSection('title', 'Clinic Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* خلفية بنفس النمط الأصلي */
.dashboard-container {
    background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBkPSJNMjAgMjBhMTAgMTAgMCAwIDEgMjAgMCAxMCAxMCAwIDAgMS0yMCAweiIgZmlsbD0icmdiYSgxMDAsMTUwLDIwMCwwLjA1KSIvPjxwYXRoIGQ9Ik0wIDIwYTEwIDEwIDAgMCAxIDIwIDAgMTAgMTAgMCAwIDEtMjAgMHoiIGZpbGw9InJnYmEoMTAwLDE1MCwyMDAsMC4wNSkiLz48cGF0aCBkPSJNMzAgMTBhMTAgMTAgMCAwIDEgMjAgMCAxMCAxMCAwIDAgMS0yMCAweiIgZmlsbD0icmdiYSgxMDAsMTUwLDIwMCwwLjA1KSIvPjwvc3ZnPg==');
    background-color: #0a1e3d;
    background-repeat: repeat;
    background-size: 40px;
    position: relative;
    min-height: 100vh;
    padding: 20px 30px;
}

.dashboard-container::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(10, 30, 61, 0.85), rgba(18, 43, 82, 0.9));
    backdrop-filter: blur(2px);
    z-index: 0;
    pointer-events: none;
}

/* محتوى رئيسي فوق الطبقة */
.main-content {
    position: relative;
    z-index: 2;
}

/* ===== RTL Support ===== */
body.rtl .action-group { display: flex; flex-direction: row-reverse; gap: 5px; }
body.rtl th, body.rtl td { text-align: right; }
body.rtl .table-container h2,
body.rtl .reviews-header h2,
body.rtl .notifications h2 { border-left: none; border-right: 5px solid #f59e0b; padding-left: 0; padding-right: 12px; }
body.rtl .notif-item { border-left: none; border-right: 4px solid #2563eb; }

/* ===== TOP BAR ===== */
.top-bar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 12px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    border-radius: 60px;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 12px;
}

.top-bar-left { display: flex; align-items: center; gap: 15px; flex-wrap: wrap; }
.top-bar-right { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }

/* Language Selector */
.language-selector {
    display: flex;
    gap: 8px;
    background: rgba(255,255,255,0.5);
    padding: 4px;
    border-radius: 50px;
    backdrop-filter: blur(4px);
}

.lang-btn {
    background: transparent;
    border: none;
    padding: 8px 18px;
    border-radius: 40px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    color: #1e3a8a;
}

.lang-btn.active {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    color: white;
    box-shadow: 0 4px 12px rgba(37,99,235,0.4);
    transform: scale(1.02);
}

.lang-btn:hover:not(.active) {
    background: rgba(37,99,235,0.15);
    transform: translateY(-2px);
}

/* Buttons */
.home-icon {
    background: linear-gradient(135deg, #f59e0b, #e67e22);
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    color: white;
    transition: all 0.3s ease;
    padding: 10px 24px;
    border-radius: 40px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.home-icon:hover {
    background: linear-gradient(135deg, #e67e22, #d35400);
    transform: translateY(-2px);
}

.login-icon {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border: none;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    color: white;
    transition: all 0.3s ease;
    padding: 10px 24px;
    border-radius: 40px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.login-icon:hover {
    background: linear-gradient(135deg, #c0392b, #a93226);
    transform: translateY(-2px);
}

/* Page Title */
.page-title {
    font-size: 24px;
    font-weight: 700;
    background: white;
    color: #1e3a8a;
    padding: 8px 28px;
    border-radius: 50px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    letter-spacing: -0.3px;
    text-align: center;
    border: 1px solid rgba(37,99,235,0.2);
}

/* Sidebar Toggle */
.menu-toggle {
    background: #f8fafc;
    border: none;
    font-size: 26px;
    cursor: pointer;
    color: #1e3a8a;
    width: 44px;
    height: 44px;
    border-radius: 30px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.menu-toggle:hover {
    background: #2563eb;
    color: white;
}

/* Sidebar */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(3px);
    z-index: 200;
    display: none;
}

.sidebar-overlay.active { display: block; }

.sidebar {
    position: fixed;
    top: 0;
    left: -300px;
    width: 300px;
    height: 100vh;
    background: linear-gradient(145deg, #0a1e3d, #122b52);
    color: white;
    padding: 80px 20px 25px;
    transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    z-index: 201;
    overflow-y: auto;
}

.sidebar.open { left: 0; }

.sidebar h2 {
    text-align: center;
    margin-bottom: 35px;
    font-size: 24px;
    background: linear-gradient(135deg, #fff, #bfdbfe);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.sidebar ul li {
    list-style: none;
    margin: 8px 0;
}

.sidebar ul li a {
    color: #e2e8f0;
    text-decoration: none;
    display: block;
    padding: 12px 18px;
    border-radius: 14px;
    transition: all 0.3s;
    font-weight: 500;
}

.sidebar ul li a:hover,
.sidebar ul li a.active {
    background: #2563eb;
    color: white;
}

/* Header Card */
.header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    padding: 25px 30px;
    border-radius: 28px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header h1 { color: #0f2b5c; font-size: 28px; margin-bottom: 6px; }
.header p { color: #64748b; font-size: 14px; }

.notification-area {
    position: relative;
}

.bell-icon {
    background: linear-gradient(135deg, #f1f5f9, #ffffff);
    padding: 10px 24px;
    border-radius: 50px;
    font-weight: 600;
    color: #1e3a8a;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}

.bell-icon:hover {
    background: #e2e8f0;
}

.badge {
    background: #ef4444;
    color: white;
    border-radius: 40px;
    padding: 2px 10px;
    font-size: 12px;
    margin-left: 10px;
}

/* Cards */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 22px;
    margin-bottom: 35px;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    padding: 22px;
    border-radius: 24px;
    text-align: center;
    transition: all 0.3s;
    border: 1px solid rgba(255,255,255,0.2);
}

.card:hover { transform: translateY(-5px); border-color: #2563eb; }

.card h3 { color: #475569; font-size: 14px; margin-bottom: 12px; }

.number {
    font-size: 36px;
    font-weight: 800;
    background: linear-gradient(135deg, #2563eb, #1e3a8a);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

/* Tables */
.table-container, .reviews-section, .notifications {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    border-radius: 24px;
    padding: 20px;
    margin-bottom: 35px;
    overflow-x: auto;
}

.table-container h2, .reviews-header h2, .notifications h2 {
    color: #0f2b5c;
    margin-bottom: 18px;
    font-size: 20px;
    padding-left: 12px;
    border-left: 5px solid #f59e0b;
}

table { width: 100%; border-collapse: collapse; }
th, td { padding: 14px 10px; text-align: left; border-bottom: 1px solid #eef2ff; font-size: 13px; }
th { background: #fafcff; color: #1e3a8a; font-weight: 700; }

.status-pending { color: #f59e0b; background: #fffbeb; padding: 4px 12px; border-radius: 30px; display: inline-block; }
.status-accepted { color: #16a34a; background: #f0fdf4; padding: 4px 12px; border-radius: 30px; display: inline-block; }
.status-rejected { color: #dc2626; background: #fef2f2; padding: 4px 12px; border-radius: 30px; display: inline-block; }

.action-btn {
    padding: 5px 14px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 600;
    margin: 0 3px;
    transition: all 0.2s;
}

.btn-accept { background: #16a34a; color: white; }
.btn-reject { background: #dc2626; color: white; }

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 15px;
}

.rating-summary {
    display: flex;
    gap: 15px;
    background: #f8fafc;
    padding: 10px 20px;
    border-radius: 60px;
    align-items: baseline;
}

.avg-rating {
    font-size: 28px;
    font-weight: 800;
    color: #f59e0b;
}

.review-card {
    background: #fafcff;
    border-radius: 20px;
    padding: 18px;
    margin-bottom: 14px;
    border: 1px solid #eef2ff;
}

.reviewer-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    flex-wrap: wrap;
    gap: 8px;
}

.reviewer-name { font-weight: 700; color: #0f2b5c; }
.review-stars { color: #f59e0b; letter-spacing: 2px; }
.delete-review {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    padding: 5px 14px;
    border-radius: 30px;
    cursor: pointer;
}

.notif-item {
    background: #fafcff;
    padding: 14px 16px;
    border-radius: 18px;
    margin-bottom: 10px;
    display: flex;
    gap: 12px;
    border-left: 4px solid #2563eb;
}

.clear-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 40px;
    cursor: pointer;
    margin-top: 15px;
}

@media (max-width: 768px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .dashboard-container { padding: 15px; }
    .page-title { font-size: 16px; padding: 5px 16px; }
    .home-icon, .login-icon { padding: 6px 16px; font-size: 12px; }
    .top-bar { flex-direction: column; align-items: stretch; }
    .top-bar-left, .top-bar-right { justify-content: center; }
}
</style>

<div class="dashboard-container">
    <div class="main-content">
       
        <!-- SIDEBAR -->
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
        <div class="sidebar" id="sidebar">
            <h2>⚕️ HealD Clinic</h2>
            <ul>
                <li><a href="#" class="active" id="menuDashboard">📊 Dashboard</a></li>
                <li><a href="<?php echo e(route('clinic.doctors.index')); ?>" id="menuDoctors">👨‍⚕️ Manage Doctors</a></li>
                <li><a href="<?php echo e(route('clinic.patients.index')); ?>" id="menuPatients">👥 Manage Patients</a></li>
                <li><a href="<?php echo e(route('clinic.appointments.index')); ?>" id="menuAppointments">📅 Manage Appointments</a></li>
                <li><a href="<?php echo e(route('clinic.invoices.index')); ?>" id="menuInvoices">📄 Patient Invoices</a></li>
                <li><a href="<?php echo e(route('clinic.statistics.index')); ?>" id="menuStats">📈 Statistics</a></li>
                <li><a href="<?php echo e(route('clinic.reports.index')); ?>" id="menuReports">📋 Reports</a></li>
                <li><a href="<?php echo e(route('clinic.announcements.index')); ?>" id="menuReports"> Ad</a></li>
                <li><a href="<?php echo e(route('clinic.settings.index')); ?>" id="menuSettings">⚙️ System Settings</a></li>
            </ul>
        </div>

        <!-- HEADER -->
        <div class="header">
            <div>
                <h1 id="welcomeTitle">Welcome to Admin Dashboard ✨</h1>
                <p id="welcomeSub">Clinic Management System Overview</p>
            </div>
            <div class="notification-area">
                <div class="bell-icon" onclick="window.location.href='<?php echo e(route('clinic.notifications.index')); ?>'">
                    🔔 <span id="notifLabel">Notifications</span> <span id="badge" class="badge">0</span>
                </div>
            </div>
        </div>

        <!-- CARDS -->
        <div class="cards">
            <div class="card"><h3 id="cardDoctors">👨‍⚕️ Total Doctors</h3><p class="number" id="totalDoctors">0</p></div>
            <div class="card"><h3 id="cardPatients">👥 Total Patients</h3><p class="number" id="totalPatients">0</p></div>
            <div class="card"><h3 id="cardAppointments">📅 Total Appointments</h3><p class="number" id="totalAppointments">0</p></div>
            <div class="card"><h3 id="cardPending">⏳ Pending Appointments</h3><p class="number" id="pendingCount">0</p></div>
        </div>

        <!-- APPOINTMENTS TABLE -->
        <div class="table-container">
            <h2 id="appointmentsTitle">📋 Recent Clinic Appointments</h2>
            <div style="overflow-x: auto;">
                <table id="appointmentsTable">
                    <thead>
                        <tr>
                            <th id="thPatient">Patient</th>
                            <th id="thDoctor">Doctor</th>
                            <th id="thSpecialty">Specialty</th>
                            <th id="thDay">Day</th>
                            <th id="thTime">Time</th>
                            <th id="thStatus">Status</th>
                            <th id="thAction">Action</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        <tr><td colspan="7" style="text-align:center; padding:40px;">Loading appointments...</td><tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- REVIEWS -->
        <div class="reviews-section">
            <div class="reviews-header">
                <h2 id="reviewsTitle">⭐ Patient Reviews & Feedback</h2>
                <div class="rating-summary">
                    <span id="avgLabel">Average Rating:</span>
                    <span class="avg-rating" id="avgRating">0</span>
                    <span>★</span>
                    <span id="totalReviewsText">(0 reviews)</span>
                </div>
            </div>
            <div id="reviewsList">
                <div class="no-reviews">Loading reviews...</div>
            </div>
        </div>

        <!-- NOTIFICATIONS -->
        <div class="notifications">
            <h2 id="notificationsTitle">🔔 Clinic Notifications</h2>
            <div id="notifList"></div>
            <button class="clear-btn" id="clearBtn" onclick="clearAllNotifications()">🗑️ Clear All Notifications</button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // ==================== TRANSLATIONS ====================
    const translations = {
        en: {
            pageTitle: "📋 Clinic Dashboard",
            homeBtn: "🏠 Home",
            loginBtn: "🚪 Logout",
            notifLabel: "Notifications",
            welcomeTitle: "Welcome to Admin Dashboard ✨",
            welcomeSub: "Clinic Management System Overview",
            cardDoctors: "👨‍⚕️ Total Doctors",
            cardPatients: "👥 Total Patients",
            cardAppointments: "📅 Total Appointments",
            cardPending: "⏳ Pending Appointments",
            appointmentsTitle: "📋 Recent Clinic Appointments",
            thPatient: "Patient",
            thDoctor: "Doctor",
            thSpecialty: "Specialty",
            thDay: "Day",
            thTime: "Time",
            thStatus: "Status",
            thAction: "Action",
            reviewsTitle: "⭐ Patient Reviews & Feedback",
            avgLabel: "Average Rating:",
            notificationsTitle: "🔔 Clinic Notifications",
            clearBtn: "🗑️ Clear All Notifications",
            statusPending: "Pending",
            statusAccepted: "Accepted",
            statusRejected: "Rejected",
            btnAccept: "Accept",
            btnReject: "Reject",
            deleteReview: "Delete",
            noReviews: "📭 No patient reviews yet.",
            noNotifications: "📭 No new notifications",
            menuDashboard: "📊 Dashboard",
            menuDoctors: "👨‍⚕️ Manage Doctors",
            menuPatients: "👥 Manage Patients",
            menuAppointments: "📅 Manage Appointments",
            menuInvoices: "📄 Patient Invoices",
            menuStats: "📈 Statistics",
            menuReports: "📋 Reports",
            menuSettings: "⚙️ System Settings"
        },
        ar: {
            pageTitle: "📋 لوحة تحكم العيادة",
            homeBtn: "🏠 الرئيسية",
            loginBtn: "🚪 تسجيل خروج",
            notifLabel: "الإشعارات",
            welcomeTitle: "مرحباً بك في لوحة التحكم ✨",
            welcomeSub: "نظرة عامة على نظام إدارة العيادة",
            cardDoctors: "👨‍⚕️ إجمالي الأطباء",
            cardPatients: "👥 إجمالي المرضى",
            cardAppointments: "📅 إجمالي المواعيد",
            cardPending: "⏳ المواعيد المعلقة",
            appointmentsTitle: "📋 أحدث مواعيد العيادة",
            thPatient: "المريض",
            thDoctor: "الطبيب",
            thSpecialty: "التخصص",
            thDay: "اليوم",
            thTime: "الوقت",
            thStatus: "الحالة",
            thAction: "إجراء",
            reviewsTitle: "⭐ تقييمات المرضى",
            avgLabel: "متوسط التقييم:",
            notificationsTitle: "🔔 إشعارات العيادة",
            clearBtn: "🗑️ مسح الكل",
            statusPending: "معلق",
            statusAccepted: "مقبول",
            statusRejected: "مرفوض",
            btnAccept: "قبول",
            btnReject: "رفض",
            deleteReview: "حذف",
            noReviews: "📭 لا توجد تقييمات بعد.",
            noNotifications: "📭 لا توجد إشعارات جديدة",
            menuDashboard: "📊 لوحة التحكم",
            menuDoctors: "👨‍⚕️ إدارة الأطباء",
            menuPatients: "👥 إدارة المرضى",
            menuAppointments: "📅 إدارة المواعيد",
            menuInvoices: "📄 فواتير المرضى",
            menuStats: "📈 الإحصائيات",
            menuReports: "📋 التقارير",
            menuSettings: "⚙️ الإعدادات"
        },
        fr: {
            pageTitle: "📋 Tableau de bord clinique",
            homeBtn: "🏠 Accueil",
            loginBtn: "🚪 Déconnexion",
            notifLabel: "Notifications",
            welcomeTitle: "Bienvenue au Tableau de Bord ✨",
            welcomeSub: "Aperçu du système de gestion",
            cardDoctors: "👨‍⚕️ Total Médecins",
            cardPatients: "👥 Total Patients",
            cardAppointments: "📅 Total Rendez-vous",
            cardPending: "⏳ En attente",
            appointmentsTitle: "📋 Derniers Rendez-vous",
            thPatient: "Patient",
            thDoctor: "Médecin",
            thSpecialty: "Spécialité",
            thDay: "Jour",
            thTime: "Heure",
            thStatus: "Statut",
            thAction: "Action",
            reviewsTitle: "⭐ Avis des Patients",
            avgLabel: "Note moyenne:",
            notificationsTitle: "🔔 Notifications",
            clearBtn: "🗑️ Effacer tout",
            statusPending: "En attente",
            statusAccepted: "Accepté",
            statusRejected: "Rejeté",
            btnAccept: "Accepter",
            btnReject: "Rejeter",
            deleteReview: "Supprimer",
            noReviews: "📭 Aucun avis patient pour le moment.",
            noNotifications: "📭 Aucune nouvelle notification",
            menuDashboard: "📊 Tableau de bord",
            menuDoctors: "👨‍⚕️ Gérer médecins",
            menuPatients: "👥 Gérer patients",
            menuAppointments: "📅 Gérer rendez-vous",
            menuInvoices: "📄 Factures",
            menuStats: "📈 Statistiques",
            menuReports: "📋 Rapports",
            menuSettings: "⚙️ Paramètres"
        }
    };

    let currentLang = localStorage.getItem('clinicLanguage') || 'en';
    let notificationsArray = [];

    // ==================== HELPER ====================
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ==================== NOTIFICATIONS ====================
    function addNotification(msg) {
        notificationsArray.unshift({ 
            msg: msg, 
            time: new Date().toLocaleTimeString(),
            date: new Date().toLocaleDateString()
        });
        if (notificationsArray.length > 15) notificationsArray.pop();
        renderNotifications();
    }

    function renderNotifications() {
        const container = document.getElementById('notifList');
        if (!container) return;
        
        if (notificationsArray.length === 0) {
            container.innerHTML = `<div class="notif-item">📭 ${translations[currentLang].noNotifications}</div>`;
            const badge = document.getElementById('badge');
            if (badge) badge.innerText = '0';
            return;
        }
        
        container.innerHTML = '';
        notificationsArray.forEach(n => {
            container.innerHTML += `
                <div class="notif-item">
                    <span>🔔</span>
                    <div>
                        <strong>${escapeHtml(n.msg)}</strong>
                        <div style="font-size:10px; color:#64748b;">${escapeHtml(n.date)} ${escapeHtml(n.time)}</div>
                    </div>
                </div>
            `;
        });
        const badge = document.getElementById('badge');
        if (badge) badge.innerText = notificationsArray.length;
    }

    function clearAllNotifications() { 
        notificationsArray = []; 
        renderNotifications();
        addNotification('All notifications cleared');
    }

    // ==================== FETCH STATS ====================
    async function fetchStats() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.stats")); ?>');
            const data = await res.json();
            if (data.success) {
                document.getElementById('totalDoctors').innerText = data.data.totalDoctors || 0;
                document.getElementById('totalPatients').innerText = data.data.totalPatients || 0;
                document.getElementById('totalAppointments').innerText = data.data.totalAppointments || 0;
                document.getElementById('pendingCount').innerText = data.data.pendingAppointments || 0;
            }
        } catch(e) { 
            console.error("Stats fetch error", e); 
        }
    }

    // ==================== FETCH RECENT APPOINTMENTS ====================
    async function fetchRecentAppointments() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.recent")); ?>');
            const data = await res.json();
            const tbody = document.getElementById('appointmentsBody');
            if (!tbody) return;
            
            if (data.success && data.appointments && data.appointments.length > 0) {
                tbody.innerHTML = '';
                data.appointments.forEach(app => {
                    let statusClass = app.status === 'Pending' ? 'status-pending' :
                                    (app.status === 'Accepted' ? 'status-accepted' : 'status-rejected');
                    let statusText = translations[currentLang][`status${app.status}`] || app.status;
                    tbody.innerHTML += `
                        <tr>
                            <td>${escapeHtml(app.patient_name || '—')}</td>
                            <td>${escapeHtml(app.doctor_name || '—')}</td>
                            <td>${escapeHtml(app.specialty || '—')}</td>
                            <td>${app.date || '—'}</td>
                            <td>${app.time || '—'}</td>
                            <td><span class="${statusClass}">${statusText}</span></td>
                            <td class="action-group">
                                <button class="action-btn btn-accept" onclick="updateStatus(${app.id}, 'Accepted')">${translations[currentLang].btnAccept}</button>
                                <button class="action-btn btn-reject" onclick="updateStatus(${app.id}, 'Rejected')">${translations[currentLang].btnReject}</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px;">No appointments found</td></tr>';
            }
        } catch(e) { 
            console.error("Recent appointments fetch error", e); 
            const tbody = document.getElementById('appointmentsBody');
            if (tbody) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:40px;">Error loading appointments</td></tr>';
            }
        }
    }

    // ==================== UPDATE APPOINTMENT STATUS ====================
    async function updateStatus(id, status) {
        try {
            const res = await fetch(`/clinic/appointments/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ status })
            });
            if (res.ok) {
                const result = await res.json();
                if (result.success) {
                    fetchStats();
                    fetchRecentAppointments();
                    addNotification(`✅ Appointment #${id} ${status.toLowerCase()}`);
                }
            } else {
                console.error("Status update failed");
                addNotification(`❌ Failed to update appointment #${id}`);
            }
        } catch(e) { 
            console.error("Update status error", e); 
        }
    }

    // ==================== FETCH REVIEWS ====================
    async function fetchReviews() {
        try {
            const res = await fetch('<?php echo e(route("clinic.dashboard.reviews")); ?>');
            const data = await res.json();
            if (data.success) {
                renderReviews(data.reviews, data.avgRating);
            }
        } catch(e) { 
            console.error("Reviews fetch error", e); 
        }
    }

    function renderReviews(reviews, avgRating) {
        const container = document.getElementById('reviewsList');
        if (!container) return;
        
        if (!reviews || reviews.length === 0) {
            container.innerHTML = `<div class="no-reviews">${translations[currentLang].noReviews}</div>`;
            document.getElementById('avgRating').innerText = '0';
            document.getElementById('totalReviewsText').innerText = '(0 reviews)';
            return;
        }
        
        let total = reviews.reduce((sum, r) => sum + r.rating, 0);
        let avg = (total / reviews.length).toFixed(1);
        document.getElementById('avgRating').innerText = avg;
        document.getElementById('totalReviewsText').innerText = `(${reviews.length} reviews)`;
        
        container.innerHTML = '';
        reviews.forEach(review => {
            let stars = '★'.repeat(review.rating) + '☆'.repeat(5 - review.rating);
            container.innerHTML += `
                <div class="review-card">
                    <div class="reviewer-info">
                        <span class="reviewer-name">👤 ${escapeHtml(review.patient_name)}</span>
                        <span class="review-stars">${stars}</span>
                        <span class="review-date">📅 ${review.date}</span>
                    </div>
                    <div class="review-text">"${escapeHtml(review.review)}"</div>
                    <button class="delete-review" onclick="deleteReview(${review.id})">🗑️ ${translations[currentLang].deleteReview}</button>
                </div>
            `;
        });
    }

    async function deleteReview(id) {
        if (confirm('Are you sure you want to delete this review?')) {
            try {
                const res = await fetch(`/clinic/reviews/${id}`, { 
                    method: 'DELETE', 
                    headers: { 
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Content-Type': 'application/json'
                    } 
                });
                if (res.ok) {
                    fetchReviews();
                    addNotification("✅ Review deleted successfully");
                }
            } catch(e) { 
                console.error("Delete review error", e); 
            }
        }
    }

    // ==================== LANGUAGE & UI ====================
    function setLanguage(lang) {
        currentLang = lang;
        localStorage.setItem('clinicLanguage', lang);
        updateUITexts();
        
        document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`.lang-btn[data-lang="${lang}"]`).classList.add('active');
        
        if (lang === 'ar') {
            document.body.classList.add('rtl');
        } else {
            document.body.classList.remove('rtl');
        }
        
        // Re-render dynamic content
        renderNotifications();
        fetchRecentAppointments();
        fetchReviews();
    }

    function updateUITexts() {
        const t = translations[currentLang];
        
        document.getElementById('pageTitle').innerText = t.pageTitle;
        document.getElementById('homeBtn').innerHTML = t.homeBtn;
        document.getElementById('loginBtn').innerHTML = t.loginBtn;
        document.getElementById('notifLabel').innerText = t.notifLabel;
        document.getElementById('welcomeTitle').innerHTML = t.welcomeTitle;
        document.getElementById('welcomeSub').innerHTML = t.welcomeSub;
        document.getElementById('cardDoctors').innerHTML = t.cardDoctors;
        document.getElementById('cardPatients').innerHTML = t.cardPatients;
        document.getElementById('cardAppointments').innerHTML = t.cardAppointments;
        document.getElementById('cardPending').innerHTML = t.cardPending;
        document.getElementById('appointmentsTitle').innerHTML = t.appointmentsTitle;
        document.getElementById('thPatient').innerText = t.thPatient;
        document.getElementById('thDoctor').innerText = t.thDoctor;
        document.getElementById('thSpecialty').innerText = t.thSpecialty;
        document.getElementById('thDay').innerText = t.thDay;
        document.getElementById('thTime').innerText = t.thTime;
        document.getElementById('thStatus').innerText = t.thStatus;
        document.getElementById('thAction').innerText = t.thAction;
        document.getElementById('reviewsTitle').innerHTML = t.reviewsTitle;
        document.getElementById('avgLabel').innerText = t.avgLabel;
        document.getElementById('notificationsTitle').innerHTML = t.notificationsTitle;
        document.getElementById('clearBtn').innerHTML = t.clearBtn;
        document.getElementById('menuDashboard').innerHTML = t.menuDashboard;
        document.getElementById('menuDoctors').innerHTML = t.menuDoctors;
        document.getElementById('menuPatients').innerHTML = t.menuPatients;
        document.getElementById('menuAppointments').innerHTML = t.menuAppointments;
        document.getElementById('menuInvoices').innerHTML = t.menuInvoices;
        document.getElementById('menuStats').innerHTML = t.menuStats;
        document.getElementById('menuReports').innerHTML = t.menuReports;
        document.getElementById('menuSettings').innerHTML = t.menuSettings;
    }

    // ==================== SIDEBAR FUNCTIONS ====================
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('active');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('active');
    }

    function goHome() {
        window.location.href = '<?php echo e(route("clinic.dashboard")); ?>';
    }

    function toggleLogin() {
        window.location.href = '<?php echo e(route("logout")); ?>';
    }

    // ==================== INIT ====================
    document.addEventListener('DOMContentLoaded', function() {
        const savedLang = localStorage.getItem('clinicLanguage') || 'en';
        setLanguage(savedLang);
        
        fetchStats();
        fetchRecentAppointments();
        fetchReviews();
        addNotification("Welcome to Clinic Dashboard");
        
        // Refresh data every 30 seconds
        setInterval(() => {
            fetchStats();
            fetchRecentAppointments();
        }, 30000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/dashboard.blade.php ENDPATH**/ ?>