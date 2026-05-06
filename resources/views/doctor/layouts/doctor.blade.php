<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor Panel') - MediEase</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* ========== نفس الأنماط الموجودة في ملفات HTML الأصلية ========== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: #0a1a2f;
            color: #e0f2fe;
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s;
        }
        body.rtl { direction: rtl; text-align: right; }
        body.ltr { direction: ltr; text-align: left; }
        .container { max-width: 1400px; margin: auto; }
        .header {
            background: #0f2b3d;
            border-radius: 30px;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
            border: 1px solid #1e4a76;
            position: relative;
        }
        .logo h2 { color: #4fc3f7; font-weight: 800; }
        .logo span { color: #0288d1; }
        .lang-select {
            background: #1e3a5f;
            border: none;
            padding: 8px 16px;
            border-radius: 30px;
            color: white;
            cursor: pointer;
            font-weight: 500;
        }
        .doctor-info {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
        }
        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 24px;
            color: #b3e5fc;
            transition: 0.2s;
        }
        .notification-bell:hover { color: #4fc3f7; }
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: #f44336;
            color: white;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 20px;
            min-width: 18px;
            text-align: center;
        }
        .notification-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            width: 340px;
            background: #0f2b3d;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border: 1px solid #1e4a76;
            z-index: 100;
            display: none;
            max-height: 400px;
            overflow-y: auto;
        }
        body.rtl .notification-dropdown { right: auto; left: 0; }
        .notification-dropdown.show { display: block; }
        .notification-header {
            padding: 12px 15px;
            border-bottom: 1px solid #1e4a76;
            font-weight: 600;
            color: #4fc3f7;
        }
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #1e4a76;
            cursor: pointer;
            transition: 0.1s;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .notification-item:hover { background: #1e3a5f; }
        .notification-item.unread { background: #1a3a55; }
        .notification-icon { color: #4fc3f7; font-size: 18px; margin-top: 2px; }
        .notification-content { flex: 1; }
        .notification-title { font-weight: 500; margin-bottom: 3px; }
        .notification-message { font-size: 12px; color: #b3e5fc; margin-bottom: 3px; }
        .notification-time { font-size: 11px; color: #89b9d9; }
        .mark-read {
            font-size: 12px;
            color: #0288d1;
            cursor: pointer;
            margin-top: 5px;
            display: inline-block;
        }
        .avatar {
            width: 50px;
            height: 50px;
            background: #0288d1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
        }
        .nav-links {
            background: #0f2b3d;
            border-radius: 60px;
            padding: 10px 20px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            border: 1px solid #1e4a76;
        }
        .nav-links a {
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 40px;
            font-weight: 600;
            color: #b3e5fc;
            transition: 0.2s;
        }
        .nav-links a.active {
            background: #0288d1;
            color: white;
        }
        .nav-links a i { margin: 0 8px; }
        .card-white {
            background: #0f2b3d;
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #1e4a76;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            background: #1e3a5f;
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #1e4a76;
        }
        th { color: #4fc3f7; }
        .status { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block; }
        .status.completed { background: #e0f7e8; color: #2e7d32; }
        .status.ready { background: #fff3e0; color: #ed6c02; }
        .status.waiting { background: #e3f2fd; color: #1976d2; }
        .btn-sm, .btn-done, .btn-outline {
            border: none;
            padding: 8px 16px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            margin-right: 6px;
        }
        .btn-sm { background: #0288d1; color: white; }
        .btn-done { background: #2e7d32; color: white; }
        .btn-outline { background: transparent; border: 1px solid #0288d1; color: #4fc3f7; }
        .form-group { margin-bottom: 20px; }
        label { font-weight: 600; display: block; margin-bottom: 8px; color: #4fc3f7; }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 16px;
            border: 1px solid #1e4a76;
            background: #1e3a5f;
            color: white;
            font-family: inherit;
        }
        .row-2 { display: flex; gap: 20px; flex-wrap: wrap; }
        .row-2 > div { flex: 1; }
        .days-checkboxes { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 8px; }
        .days-checkboxes label { display: inline-flex; align-items: center; gap: 5px; cursor: pointer; }
        .schedule-table { width: 100%; border-collapse: collapse; min-width: 700px; }
        .schedule-table th, .schedule-table td { border: 1px solid #1e4a76; padding: 12px; text-align: center; vertical-align: middle; background-color: #0f2b3d; }
        .schedule-table th { background-color: #1a3a55; }
        .time-slot { font-weight: 600; background-color: #1e3a5f; }
        .work-type { cursor: pointer; display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; transition: 0.2s; }
        .work-type.surgery { background-color: #ffcdd2; color: #c62828; }
        .work-type.exam { background-color: #c8e6e9; color: #00695c; }
        .work-type.holiday { background-color: #e0e0e0; color: #555; }
        .btn-edit-time { background: none; border: none; color: #4fc3f7; cursor: pointer; margin-left: 8px; font-size: 0.8rem; }
        .btn-save-time { background: #0288d1; color: white; border: none; border-radius: 20px; padding: 4px 10px; cursor: pointer; margin-left: 5px; }
        .inline-input { width: 80px; padding: 4px; border-radius: 10px; border: 1px solid #1e4a76; background: #1e3a5f; color: white; }
        .modal { position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); justify-content:center; align-items:center; z-index:1000; }
        .modal-content { background:#0f2b3d; border-radius:30px; padding:25px; width:90%; max-width:400px; border:1px solid #1e4a76; }
        @media (max-width: 700px) { .info-grid { grid-template-columns: 1fr; } th, td { padding: 8px; } .work-type { font-size: 0.7rem; } }
    </style>
    @stack('styles')
</head>
<body class="ltr">
<div class="container">
    <header class="header">
        <div class="logo"><h2>Medi<span>Ease</span></h2></div>
        <select id="langSelect" class="lang-select">
            <option value="en">🇬🇧 English</option>
            <option value="fr">🇫🇷 Français</option>
            <option value="ar">🇸🇦 العربية</option>
        </select>
        <div class="doctor-info">
            <div class="notification-bell" id="notificationBell">
                <i class="fas fa-bell"></i>
                <span class="notification-badge" id="notificationBadge">0</span>
            </div>
            <div class="avatar">👨‍⚕️</div>
        </div>
    </header>

    <div class="notification-dropdown" id="notificationDropdown">
        <div class="notification-header" id="notificationsHeader">📢 Notifications</div>
        <div id="notificationList"></div>
    </div>

    <div class="nav-links">
        <a href="{{ route('doctor.dashboard') }}" class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> <span id="nav_dash">Dashboard</span></a>
        <a href="{{ route('doctor.appointments.index') }}" class="{{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i> <span id="nav_app">Appointments</span></a>
        <a href="{{ route('doctor.schedule') }}" class="{{ request()->routeIs('doctor.schedule') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> <span id="nav_schedule">Schedule</span></a>
        <a href="{{ route('doctor.patients.index') }}" class="{{ request()->routeIs('doctor.patients.*') ? 'active' : '' }}"><i class="fas fa-folder-open"></i> <span id="nav_record">Patients</span></a>
        <a href="{{ route('doctor.settings') }}" class="{{ request()->routeIs('doctor.settings') ? 'active' : '' }}"><i class="fas fa-cog"></i> <span id="nav_settings">Settings</span></a>
    </div>

    @yield('content')
</div>

{{-- تحديث جزء الـ script في doctor.blade.php --}}
@push('scripts')
<script>
    // Complete translations for layout
    const layoutTranslations = {
        ar: {
            nav_dash: "لوحة التحكم", nav_app: "المواعيد", nav_schedule: "جدول العمل", nav_record: "ملف المريض", nav_settings: "الإعدادات",
            notifications_header: "📢 الإشعارات", mark_as_read: "✔️ وضع كمقروء", no_notifications: "✨ لا توجد إشعارات"
        },
        fr: {
            nav_dash: "Tableau de bord", nav_app: "Rendez-vous", nav_schedule: "Planning", nav_record: "Dossier patient", nav_settings: "Paramètres",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Marquer comme lu", no_notifications: "✨ Aucune notification"
        },
        en: {
            nav_dash: "Dashboard", nav_app: "Appointments", nav_schedule: "Schedule", nav_record: "Patient Record", nav_settings: "Settings",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Mark as read", no_notifications: "✨ No notifications"
        }
    };
    
    let currentLang = localStorage.getItem('cliniclick_lang') || 'en';
    
    function setLanguage(lang) {
        currentLang = lang;
        document.body.classList.remove('ltr','rtl');
        document.body.classList.add(lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('lang', lang);
        localStorage.setItem('cliniclick_lang', lang);
        document.getElementById('langSelect').value = lang;
        
        const t = layoutTranslations[lang];
        document.getElementById('nav_dash').innerText = t.nav_dash;
        document.getElementById('nav_app').innerText = t.nav_app;
        document.getElementById('nav_schedule').innerText = t.nav_schedule;
        document.getElementById('nav_record').innerText = t.nav_record;
        document.getElementById('nav_settings').innerText = t.nav_settings;
        document.getElementById('notificationsHeader').innerHTML = t.notifications_header;
    }
    
    document.getElementById('langSelect').addEventListener('change', e => setLanguage(e.target.value));
    setLanguage(currentLang);
</script>
@endpush
@stack('scripts')
</body>
</html>