<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clinic Dashboard') - MediEase Clinic</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI4MCIgaGVpZ2h0PSI4MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBkPSJNMjAgMjBhMTAgMTAgMCAwIDEgMjAgMCAxMCAxMCAwIDAgMS0yMCAweiIgZmlsbD0icmdiYSgxMDAsMTUwLDIwMCwwLjA1KSIvPjxwYXRoIGQ9Ik0wIDIwYTEwIDEwIDAgMCAxIDIwIDAgMTAgMTAgMCAwIDEtMjAgMHoiIGZpbGw9InJnYmEoMTAwLDE1MCwyMDAsMC4wNSkiLz48cGF0aCBkPSJNMzAgMTBhMTAgMTAgMCAwIDEgMjAgMCAxMCAxMCAwIDAgMS0yMCAweiIgZmlsbD0icmdiYSgxMDAsMTUwLDIwMCwwLjA1KSIvPjwvc3ZnPg==');
            background-color: #0a1e3d;
            background-repeat: repeat;
            background-size: 40px;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(10,30,61,0.85), rgba(18,43,82,0.9));
            backdrop-filter: blur(2px);
            z-index: -1;
        }
        body.rtl { direction: rtl; }
        body.rtl .sidebar { left: auto; right: -300px; }
        body.rtl .sidebar.open { left: auto; right: 0; }
        body.rtl .table-container h2,
        body.rtl .reviews-header h2,
        body.rtl .notifications h2 { border-left: none; border-right: 5px solid #f59e0b; padding-left: 0; padding-right: 12px; }
        body.rtl .notif-item { border-left: none; border-right: 4px solid #2563eb; }
        body.rtl .action-group { display: flex; flex-direction: row-reverse; gap: 5px; }
        body.rtl th, body.rtl td { text-align: right; }

        .top-bar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }
        .top-bar-left { display: flex; align-items: center; gap: 15px; }
        .top-bar-right { display: flex; align-items: center; gap: 18px; }
        .language-selector { display: flex; gap: 8px; background: rgba(255,255,255,0.5); padding: 4px; border-radius: 50px; backdrop-filter: blur(4px); }
        .lang-btn { background: transparent; border: none; padding: 8px 18px; border-radius: 40px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.3s; color: #1e3a8a; }
        .lang-btn.active { background: linear-gradient(135deg,#2563eb,#1e40af); color: white; box-shadow: 0 4px 12px rgba(37,99,235,0.4); transform: scale(1.02); }
        .lang-btn:hover:not(.active) { background: rgba(37,99,235,0.15); transform: translateY(-2px); }
        .home-icon { background: linear-gradient(135deg,#f59e0b,#e67e22); border: none; font-size: 14px; font-weight: 600; cursor: pointer; color: white; padding: 10px 24px; border-radius: 40px; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(245,158,11,0.3); }
        .home-icon:hover { background: linear-gradient(135deg,#e67e22,#d35400); transform: translateY(-2px); }
        .login-icon { background: linear-gradient(135deg,#e74c3c,#c0392b); border: none; font-size: 14px; font-weight: 600; cursor: pointer; color: white; padding: 10px 24px; border-radius: 40px; display: flex; align-items: center; gap: 8px; }
        .login-icon:hover { background: linear-gradient(135deg,#c0392b,#a93226); transform: translateY(-2px); }
        .menu-toggle { background: #f8fafc; border: none; font-size: 26px; cursor: pointer; color: #1e3a8a; width: 44px; height: 44px; border-radius: 30px; }
        .menu-toggle:hover { background: #2563eb; color: white; }
        .page-title { font-size: 24px; font-weight: 700; background: white; color: #1e3a8a; padding: 8px 28px; border-radius: 50px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); letter-spacing: -0.3px; text-align: center; border: 1px solid rgba(37,99,235,0.2); }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(3px); z-index: 200; display: none; }
        .sidebar-overlay.active { display: block; }
        .sidebar { position: fixed; top: 0; left: -300px; width: 300px; height: 100vh; background: linear-gradient(145deg,#0a1e3d,#122b52); color: white; padding: 80px 20px 25px; transition: left 0.3s; z-index: 201; overflow-y: auto; }
        .sidebar.open { left: 0; }
        .sidebar h2 { text-align: center; margin-bottom: 35px; font-size: 24px; background: linear-gradient(135deg,#fff,#bfdbfe); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .sidebar ul li { list-style: none; margin: 8px 0; }
        .sidebar ul li a { color: #e2e8f0; text-decoration: none; display: block; padding: 12px 18px; border-radius: 14px; transition: all 0.3s; font-weight: 500; }
        .sidebar ul li a:hover, .sidebar ul li a.active { background: #2563eb; color: white; }
        .main-content { margin-top: 70px; padding: 25px 35px; }
        .header { background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 25px 30px; border-radius: 28px; margin-bottom: 30px; }
        .header h1 { color: #0f2b5c; font-size: 28px; margin-bottom: 6px; }
        .header p { color: #64748b; font-size: 14px; }
        .notification-area { margin-top: 18px; display: flex; align-items: center; flex-wrap: wrap; gap: 10px; }
        .bell-icon { background: linear-gradient(135deg,#f1f5f9,#fff); padding: 10px 24px; border-radius: 50px; font-weight: 600; color: #1e3a8a; }
        .badge { background: #ef4444; color: white; border-radius: 40px; padding: 2px 10px; font-size: 12px; margin-left: 10px; }
        .cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 22px; margin-bottom: 35px; }
        .card { background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); padding: 22px; border-radius: 24px; text-align: center; transition: all 0.3s; }
        .card:hover { transform: translateY(-5px); border-color: #2563eb; }
        .card h3 { color: #475569; font-size: 14px; margin-bottom: 12px; }
        .number { font-size: 36px; font-weight: 800; background: linear-gradient(135deg,#2563eb,#1e3a8a); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .table-container, .reviews-section, .notifications { background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border-radius: 24px; padding: 20px; margin-bottom: 35px; overflow-x: auto; }
        .table-container h2, .reviews-header h2, .notifications h2 { color: #0f2b5c; margin-bottom: 18px; font-size: 20px; padding-left: 12px; border-left: 5px solid #f59e0b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 10px; text-align: left; border-bottom: 1px solid #eef2ff; font-size: 13px; }
        th { background: #fafcff; color: #1e3a8a; font-weight: 700; }
        .status-pending { color: #f59e0b; background: #fffbeb; padding: 4px 12px; border-radius: 30px; display: inline-block; }
        .status-accepted { color: #16a34a; background: #f0fdf4; padding: 4px 12px; border-radius: 30px; display: inline-block; }
        .status-rejected { color: #dc2626; background: #fef2f2; padding: 4px 12px; border-radius: 30px; display: inline-block; }
        .action-btn { padding: 5px 14px; border: none; border-radius: 30px; cursor: pointer; font-size: 11px; font-weight: 600; margin: 0 3px; }
        .btn-accept { background: #16a34a; color: white; }
        .btn-reject { background: #dc2626; color: white; }
        .reviews-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
        .rating-summary { display: flex; gap: 15px; background: #f8fafc; padding: 10px 20px; border-radius: 60px; }
        .avg-rating { font-size: 28px; font-weight: 800; color: #f59e0b; }
        .review-card { background: #fafcff; border-radius: 20px; padding: 18px; margin-bottom: 14px; border: 1px solid #eef2ff; }
        .reviewer-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 8px; }
        .reviewer-name { font-weight: 700; color: #0f2b5c; }
        .review-stars { color: #f59e0b; letter-spacing: 2px; }
        .delete-review { background: #fee2e2; color: #dc2626; border: none; padding: 5px 14px; border-radius: 30px; cursor: pointer; }
        .notif-item { background: #fafcff; padding: 14px 16px; border-radius: 18px; margin-bottom: 10px; display: flex; gap: 12px; border-left: 4px solid #2563eb; }
        .clear-btn { background: linear-gradient(135deg,#ef4444,#dc2626); color: white; border: none; padding: 10px 22px; border-radius: 40px; cursor: pointer; margin-top: 15px; }
        @media (max-width:768px){ .cards{grid-template-columns:repeat(2,1fr);} .main-content{padding:15px;} .page-title{font-size:16px;padding:5px 16px;} .home-icon,.login-icon{padding:6px 16px;font-size:12px;} }
    </style>
    @stack('styles')
</head>
<body class="ltr">
<div class="top-bar">
    <div class="top-bar-left">
        <button class="menu-toggle" onclick="openSidebar()">☰</button>
        <div class="language-selector">
            <button class="lang-btn" data-lang="en" onclick="setLanguage('en')">🇬🇧 EN</button>
            <button class="lang-btn" data-lang="ar" onclick="setLanguage('ar')">🇸🇪 عربي</button>
            <button class="lang-btn" data-lang="fr" onclick="setLanguage('fr')">🇫🇷 FR</button>
        </div>
    </div>
    <div class="page-title" id="pageTitle">📋 Clinic Dashboard</div>
    <div class="top-bar-right">
        <button class="home-icon" onclick="goHome()" id="homeBtn">🏠 Home</button>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="login-icon" id="loginBtn">🚪 Logout</button>
        </form>
    </div>
</div>
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
<div class="sidebar" id="sidebar">
    <div style="text-align: center; margin-bottom: 25px;">
        <!-- استخدام أيقونة بدلاً من الصورة -->
        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #2563eb, #1e40af); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px auto;">
            <i class="fas fa-hospital-user" style="font-size: 35px; color: white;"></i>
        </div>
        <h2 style="font-size: 20px; margin-top: 5px; background: linear-gradient(135deg, #fff, #bfdbfe); -webkit-background-clip: text; background-clip: text; color: transparent;">MediEase Clinic</h2>
    </div>
    <ul>
     <li>
    <a href="{{ route('clinic.doctors.index') }}" class="{{ request()->routeIs('clinic.doctors*') ? 'active' : '' }}" id="menuDoctors">
        👨‍⚕️ Manage Doctors
    </a>
</li>
<li>
    <a href="{{ route('clinic.patients.index') }}">👥 Manage Patients</a>  <!-- Changed here -->
</li>
<li>
    <a href="{{ route('clinic.appointments.index') }}">📅 Manage Appointments</a>
</li>
<li>
    <a href="{{ route('clinic.invoices.index') }}">📄 Patient Invoices</a>
</li>
<li>
    <a href="{{ route('clinic.statistics.index') }}">📊 Statistics</a>
</li>

<li>
    <a href="{{ route('clinic.settings.index') }}">⚙️ Setting</a>
</li>
<li>
    <a href="{{ route('clinic.announcements.index') }}"> 📢Ad</a>
</li>
    </ul>
</div>
<div class="main-content">
    @yield('content')
</div>
<script>
    const translations = {
        en: {
            pageTitle: "📋 Clinic Dashboard", homeBtn: "🏠 Home", loginBtn: "🚪 Logout",
            notifLabel: "Notifications", welcomeTitle: "Welcome to Clinic Dashboard ✨",
            welcomeSub: "Clinic Management System Overview",
            cardDoctors: "👨‍⚕️ Total Doctors", cardPatients: "👥 Total Patients",
            cardAppointments: "📅 Total Appointments", cardPending: "⏳ Pending Appointments",
            appointmentsTitle: "📋 Recent Clinic Appointments",
            thPatient: "Patient", thDoctor: "Doctor", thSpecialty: "Specialty", thDay: "Day", thTime: "Time", thStatus: "Status", thAction: "Action",
            reviewsTitle: "⭐ Patient Reviews & Feedback", avgLabel: "Average Rating:",
            notificationsTitle: "🔔 Clinic Notifications", clearBtn: "🗑️ Clear All Notifications",
            statusPending: "Pending", statusAccepted: "Accepted", statusRejected: "Rejected",
            btnAccept: "Accept", btnReject: "Reject", deleteReview: "Delete",
            noReviews: "📭 No patient reviews yet.", noNotifications: "📭 No new notifications",
            menuDashboard: "📊 Dashboard", menuDoctors: "👨‍⚕️ Manage Doctors",
            menuPatients: "👥 Manage Patients", menuAppointments: "📅 Manage Appointments",
            menuInvoices: "📄 Patient Invoices", menuStats: "📈 Statistics",
            menuReports: "📋 Reports", menuSettings: "⚙️ System Settings"
        },
        ar: {
            pageTitle: "📋 لوحة تحكم العيادة", homeBtn: "🏠 الرئيسية", loginBtn: "🚪 تسجيل خروج",
            notifLabel: "الإشعارات", welcomeTitle: "مرحباً بك في لوحة التحكم ✨",
            welcomeSub: "نظرة عامة على نظام إدارة العيادة",
            cardDoctors: "👨‍⚕️ إجمالي الأطباء", cardPatients: "👥 إجمالي المرضى",
            cardAppointments: "📅 إجمالي المواعيد", cardPending: "⏳ المواعيد المعلقة",
            appointmentsTitle: "📋 أحدث مواعيد العيادة",
            thPatient: "المريض", thDoctor: "الطبيب", thSpecialty: "التخصص", thDay: "اليوم", thTime: "الوقت", thStatus: "الحالة", thAction: "إجراء",
            reviewsTitle: "⭐ تقييمات المرضى", avgLabel: "متوسط التقييم:",
            notificationsTitle: "🔔 إشعارات العيادة", clearBtn: "🗑️ مسح الكل",
            statusPending: "معلق", statusAccepted: "مقبول", statusRejected: "مرفوض",
            btnAccept: "قبول", btnReject: "رفض", deleteReview: "حذف",
            noReviews: "📭 لا توجد تقييمات", noNotifications: "📭 لا توجد إشعارات",
            menuDashboard: "📊 لوحة التحكم", menuDoctors: "👨‍⚕️ إدارة الأطباء",
            menuPatients: "👥 إدارة المرضى", menuAppointments: "📅 إدارة المواعيد",
            menuInvoices: "📄 فواتير المرضى", menuStats: "📈 الإحصائيات",
            menuReports: "📋 التقارير", menuSettings: "⚙️ الإعدادات"
        },
        fr: {
            pageTitle: "📋 Tableau de bord clinique", homeBtn: "🏠 Accueil", loginBtn: "🚪 Déconnexion",
            notifLabel: "Notifications", welcomeTitle: "Bienvenue au Tableau de Bord ✨",
            welcomeSub: "Aperçu du système de gestion",
            cardDoctors: "👨‍⚕️ Total Médecins", cardPatients: "👥 Total Patients",
            cardAppointments: "📅 Total Rendez-vous", cardPending: "⏳ En attente",
            appointmentsTitle: "📋 Derniers Rendez-vous",
            thPatient: "Patient", thDoctor: "Médecin", thSpecialty: "Spécialité", thDay: "Jour", thTime: "Heure", thStatus: "Statut", thAction: "Action",
            reviewsTitle: "⭐ Avis des Patients", avgLabel: "Note moyenne:",
            notificationsTitle: "🔔 Notifications", clearBtn: "🗑️ Effacer tout",
            statusPending: "En attente", statusAccepted: "Accepté", statusRejected: "Rejeté",
            btnAccept: "Accepter", btnReject: "Rejeter", deleteReview: "Supprimer",
            noReviews: "📭 Aucun avis", noNotifications: "📭 Aucune notification",
            menuDashboard: "📊 Tableau de bord", menuDoctors: "👨‍⚕️ Gérer médecins",
            menuPatients: "👥 Gérer patients", menuAppointments: "📅 Gérer rendez-vous",
            menuInvoices: "📄 Factures", menuStats: "📈 Statistiques",
            menuReports: "📋 Rapports", menuSettings: "⚙️ Paramètres"
        }
    };
    let currentLang = localStorage.getItem('clinicLanguage') || 'en';
    function setLanguage(lang) {
        currentLang = lang;
        const t = translations[lang];
        document.getElementById('pageTitle').innerText = t.pageTitle;
        document.getElementById('homeBtn').innerHTML = t.homeBtn;
        document.getElementById('loginBtn').innerHTML = t.loginBtn;
        document.getElementById('menuDashboard').innerHTML = t.menuDashboard;
        document.getElementById('menuDoctors').innerHTML = t.menuDoctors;
        document.getElementById('menuPatients').innerHTML = t.menuPatients;
        document.getElementById('menuAppointments').innerHTML = t.menuAppointments;
        document.getElementById('menuInvoices').innerHTML = t.menuInvoices;
        document.getElementById('menuStats').innerHTML = t.menuStats;
        document.getElementById('menuReports').innerHTML = t.menuReports;
        document.getElementById('menuSettings').innerHTML = t.menuSettings;
        document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`.lang-btn[data-lang="${lang}"]`).classList.add('active');
        if(lang === 'ar') document.body.classList.add('rtl');
        else document.body.classList.remove('rtl');
        localStorage.setItem('clinicLanguage', lang);
        window.dispatchEvent(new Event('languageChanged'));
    }
    function openSidebar() { document.getElementById('sidebar').classList.add('open'); document.getElementById('sidebarOverlay').classList.add('active'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebarOverlay').classList.remove('active'); }
    function goHome() { window.location.href = "{{ route('home') }}"; }
    setLanguage(currentLang);
</script>
@stack('scripts')
</body>
</html>