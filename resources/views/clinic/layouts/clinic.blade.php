<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clinic Dashboard') - MediEase Clinic</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Tajawal', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
        }
        
        body.rtl {
            direction: rtl;
            font-family: 'Tajawal', 'Inter', sans-serif;
        }
        
        /* ==================== TOP BAR ==================== */
        .top-bar {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            z-index: 99;
        }
        
        body.rtl .top-bar {
            left: 0;
            right: 280px;
        }
        
        @media (max-width: 992px) {
            .top-bar {
                left: 0;
            }
            body.rtl .top-bar {
                right: 0;
            }
        }
        
        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .menu-toggle {
            display: none;
            background: #f1f5f9;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #64748b;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            transition: all 0.2s;
        }
        
        .menu-toggle:hover {
            background: #e2e8f0;
        }
        
        @media (max-width: 992px) {
            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }
        
        .search-box {
            display: flex;
            align-items: center;
            background: #f1f5f9;
            border-radius: 50px;
            padding: 10px 20px;
            gap: 10px;
            width: 300px;
        }
        
        .search-box i {
            color: #94a3b8;
        }
        
        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 14px;
        }
        
        .language-selector {
            display: flex;
            gap: 5px;
            background: #f1f5f9;
            padding: 5px;
            border-radius: 50px;
        }
        
        .lang-btn {
            background: transparent;
            border: none;
            padding: 6px 16px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.2s;
        }
        
        .lang-btn.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-icon {
            position: relative;
            cursor: pointer;
            background: #f1f5f9;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .notification-icon:hover {
            background: #e2e8f0;
        }
        
        .notification-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 50%;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
        }
        
        .user-details h4 {
            font-size: 14px;
            color: #1e293b;
            margin-bottom: 2px;
        }
        
        .user-details p {
            font-size: 11px;
            color: #94a3b8;
        }
        
        /* ==================== SIDEBAR ==================== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 20px rgba(0,0,0,0.05);
            padding: 30px 0;
            transition: all 0.3s;
            z-index: 100;
            overflow-y: auto;
        }
        
        body.rtl .sidebar {
            left: auto;
            right: 0;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                left: -280px;
            }
            body.rtl .sidebar {
                right: -280px;
                left: auto;
            }
            .sidebar.open {
                left: 0;
            }
            body.rtl .sidebar.open {
                right: 0;
                left: auto;
            }
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.4);
            z-index: 99;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px 20px;
            border-bottom: 1px solid #eef2ff;
        }
        
        .logo-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        
        .logo-icon i {
            font-size: 28px;
            color: white;
        }
        
        .sidebar-header h2 {
            font-size: 18px;
            color: #1e293b;
            margin-bottom: 4px;
        }
        
        .sidebar-header p {
            font-size: 11px;
            color: #94a3b8;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .sidebar-menu li {
            margin: 5px 0;
        }
        
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .sidebar-menu li a i {
            width: 22px;
            font-size: 16px;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
        }
        
        .sidebar-menu .logout-item {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eef2ff;
        }
        
        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: 280px;
            padding: 85px 30px 30px;
            min-height: 100vh;
        }
        
        body.rtl .main-content {
            margin-left: 0;
            margin-right: 280px;
        }
        
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }
            body.rtl .main-content {
                margin-right: 0;
            }
        }
        
        /* ==================== ALERTS ==================== */
        .alert-success {
            background: #10b981;
            color: white;
            padding: 14px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-error, .alert-danger {
            background: #ef4444;
            color: white;
            padding: 14px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-warning {
            background: #f59e0b;
            color: white;
            padding: 14px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-info {
            background: #3b82f6;
            color: white;
            padding: 14px 20px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .main-content {
                padding: 75px 15px 15px;
            }
            .top-bar {
                padding: 12px 15px;
            }
            .search-box {
                width: 180px;
            }
            .user-details {
                display: none;
            }
        }
        
        @media (max-width: 576px) {
            .search-box {
                display: none;
            }
            .language-selector .lang-btn {
                padding: 4px 10px;
                font-size: 10px;
            }
        }
        
        /* ==================== RTL SPECIFIC ==================== */
        body.rtl .sidebar-menu li a {
            flex-direction: row-reverse;
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">
            <i class="fas fa-stethoscope"></i>
        </div>
        <h2>MediEase Clinic</h2>
        <p>Healthcare Management</p>
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{ route('clinic.dashboard') }}" id="menuDashboard" class="{{ request()->routeIs('clinic.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{ route('clinic.doctors.index') }}" id="menuDoctors" class="{{ request()->routeIs('clinic.doctors*') ? 'active' : '' }}"><i class="fas fa-user-md"></i> Doctors</a></li>
        <li><a href="{{ route('clinic.patients.index') }}" id="menuPatients" class="{{ request()->routeIs('clinic.patients*') ? 'active' : '' }}"><i class="fas fa-users"></i> Patients</a></li>
        <li><a href="{{ route('clinic.appointments.index') }}" id="menuAppointments" class="{{ request()->routeIs('clinic.appointments*') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i> Appointments</a></li>
        <li><a href="{{ route('clinic.invoices.index') }}" id="menuInvoices" class="{{ request()->routeIs('clinic.invoices*') ? 'active' : '' }}"><i class="fas fa-file-invoice"></i> Invoices</a></li>
        <li><a href="{{ route('clinic.statistics.index') }}" id="menuStats" class="{{ request()->routeIs('clinic.statistics*') ? 'active' : '' }}"><i class="fas fa-chart-line"></i> Statistics</a></li>
        <li><a href="{{ route('clinic.reports.index') }}" id="menuReports" class="{{ request()->routeIs('clinic.reports*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Reports</a></li>
        <li><a href="{{ route('clinic.announcements.index') }}" id="menuAnnouncements" class="{{ request()->routeIs('clinic.announcements*') ? 'active' : '' }}"><i class="fas fa-bullhorn"></i> Announcements</a></li>
        <li><a href="{{ route('clinic.settings.index') }}" id="menuSettings" class="{{ request()->routeIs('clinic.settings*') ? 'active' : '' }}"><i class="fas fa-cog"></i> Settings</a></li>
        <li><a href="{{ route('clinic.subscription.plans') }}" id="menuSubscription" class="{{ request()->routeIs('clinic.subscription*') ? 'active' : '' }}"><i class="fas fa-credit-card"></i> Subscription</a></li>
        <li class="logout-item">
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- TOP BAR -->
<div class="top-bar">
    <div class="top-bar-left">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="globalSearch" placeholder="Search...">
        </div>
        <div class="language-selector">
            <button class="lang-btn" data-lang="en" onclick="setLanguage('en')">EN</button>
            <button class="lang-btn" data-lang="ar" onclick="setLanguage('ar')">AR</button>
            <button class="lang-btn" data-lang="fr" onclick="setLanguage('fr')">FR</button>
        </div>
    </div>
    <div class="top-bar-right">
        <div class="notification-icon" onclick="window.location.href='{{ route('clinic.notifications.index') }}'">
            <i class="fas fa-bell"></i>
            <span class="badge" id="notifBadge">0</span>
        </div>
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-details">
                <h4 id="userName">Hello, {{ Auth::user()->name ?? 'Admin' }}</h4>
                <p id="userRole">Clinic Admin</p>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert-warning">
            <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert-info">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
    @endif
    @yield('content')
</div>

<script>
    // Add Font Awesome if missing
    if (!document.querySelector('link[href*="font-awesome"]')) {
        var faLink = document.createElement('link');
        faLink.rel = 'stylesheet';
        faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(faLink);
    }
    
    // Translations
    const translations = {
        en: {
            menuDashboard: "Dashboard",
            menuDoctors: "Doctors",
            menuPatients: "Patients",
            menuAppointments: "Appointments",
            menuInvoices: "Invoices",
            menuStats: "Statistics",
            menuReports: "Reports",
            menuAnnouncements: "Announcements",
            menuSettings: "Settings",
            menuSubscription: "Subscription"
        },
        ar: {
            menuDashboard: "لوحة التحكم",
            menuDoctors: "الأطباء",
            menuPatients: "المرضى",
            menuAppointments: "المواعيد",
            menuInvoices: "الفواتير",
            menuStats: "الإحصائيات",
            menuReports: "التقارير",
            menuAnnouncements: "الإعلانات",
            menuSettings: "الإعدادات",
            menuSubscription: "الاشتراك"
        },
        fr: {
            menuDashboard: "Tableau de bord",
            menuDoctors: "Médecins",
            menuPatients: "Patients",
            menuAppointments: "Rendez-vous",
            menuInvoices: "Factures",
            menuStats: "Statistiques",
            menuReports: "Rapports",
            menuAnnouncements: "Annonces",
            menuSettings: "Paramètres",
            menuSubscription: "Abonnement"
        }
    };
    
    let currentLang = localStorage.getItem('clinicLanguage') || 'en';
    
    function setLanguage(lang) {
        currentLang = lang;
        const t = translations[lang];
        
        document.getElementById('menuDashboard').innerHTML = '<i class="fas fa-tachometer-alt"></i> ' + t.menuDashboard;
        document.getElementById('menuDoctors').innerHTML = '<i class="fas fa-user-md"></i> ' + t.menuDoctors;
        document.getElementById('menuPatients').innerHTML = '<i class="fas fa-users"></i> ' + t.menuPatients;
        document.getElementById('menuAppointments').innerHTML = '<i class="fas fa-calendar-check"></i> ' + t.menuAppointments;
        document.getElementById('menuInvoices').innerHTML = '<i class="fas fa-file-invoice"></i> ' + t.menuInvoices;
        document.getElementById('menuStats').innerHTML = '<i class="fas fa-chart-line"></i> ' + t.menuStats;
        document.getElementById('menuReports').innerHTML = '<i class="fas fa-chart-bar"></i> ' + t.menuReports;
        document.getElementById('menuAnnouncements').innerHTML = '<i class="fas fa-bullhorn"></i> ' + t.menuAnnouncements;
        document.getElementById('menuSettings').innerHTML = '<i class="fas fa-cog"></i> ' + t.menuSettings;
        document.getElementById('menuSubscription').innerHTML = '<i class="fas fa-credit-card"></i> ' + t.menuSubscription;
        
        document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector(`.lang-btn[data-lang="${lang}"]`).classList.add('active');
        
        if (lang === 'ar') {
            document.body.classList.add('rtl');
        } else {
            document.body.classList.remove('rtl');
        }
        
        localStorage.setItem('clinicLanguage', lang);
        
        // Trigger language change event for child components
        window.dispatchEvent(new CustomEvent('languageChanged', { detail: { lang: lang } }));
    }
    
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
    }
    
    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
    
    // Update notification badge
    function updateNotificationBadge(count) {
        const badge = document.getElementById('notifBadge');
        if (badge) {
            badge.innerText = count || 0;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }
    }
    
    // Close sidebar when clicking overlay
    document.getElementById('sidebarOverlay')?.addEventListener('click', closeSidebar);
    
    // Initialize language
    setLanguage(currentLang);
    
    // Global search functionality
    document.getElementById('globalSearch')?.addEventListener('keyup', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        window.dispatchEvent(new CustomEvent('globalSearch', { detail: { search: searchTerm } }));
    });
</script>
@stack('scripts')
</body>
</html>