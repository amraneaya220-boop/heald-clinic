<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MediEase - @yield('title', 'Doctor Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: #0a0f1a;
            color: #e0f2fe;
            min-height: 100vh;
            padding: 20px;
            transition: all 0.3s;
        }
        body.rtl { direction: rtl; text-align: right; }
        body.ltr { direction: ltr; text-align: left; }
        .container { max-width: 1400px; margin: auto; }
        .modern-header {
            background: linear-gradient(145deg, #0a1a2f 0%, #0d2a3e 100%);
            border-radius: 60px;
            padding: 0.8rem 2rem;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 20, 50, 0.5), 0 0 12px rgba(0, 160, 255, 0.2);
            border: 1px solid rgba(0, 180, 255, 0.2);
        }
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(120deg, #4fc3f7, #0288d1);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .logo span { color: #0288d1; background: none; }
        .lang-dropdown {
            background: #0f2b3d;
            border: 1px solid #2a6f8f;
            border-radius: 40px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            font-size: 0.95rem;
            color: #b3e5fc;
            cursor: pointer;
            background-color: rgba(15, 43, 61, 0.8);
        }
        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.6rem;
            color: #b3e5fc;
        }
        .notification-bell:hover { color: #4fc3f7; }
        .badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: #f44336;
            color: white;
            font-size: 0.7rem;
            padding: 0.1rem 0.45rem;
            border-radius: 50px;
            min-width: 20px;
            text-align: center;
        }
        .profile-avatar {
            width: 48px;
            height: 48px;
            background: #1e3a5f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #4fc3f7;
            border: 2px solid #4fc3f7;
            cursor: pointer;
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
        .nav-links a.active, .nav-links a:hover {
            background: #0288d1;
            color: white;
        }
        .nav-links a i { margin: 0 8px; }
        .notification-dropdown {
            position: absolute;
            top: 80px;
            right: 20px;
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
        body.rtl .notification-dropdown { right: auto; left: 20px; }
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
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }
        .notification-item:hover { background: #1e3a5f; }
        .notification-item.unread { background: #1a3a55; }
        .notification-icon { color: #4fc3f7; font-size: 18px; }
        .notification-content { flex: 1; }
        .notification-title { font-weight: 500; margin-bottom: 3px; }
        .notification-message { font-size: 12px; color: #b3e5fc; margin-bottom: 3px; }
        .notification-time { font-size: 11px; color: #89b9d9; }
        .mark-read { font-size: 12px; color: #0288d1; cursor: pointer; margin-top: 5px; display: inline-block; }
        .card-white {
            background: #0f2b3d;
            border-radius: 25px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #1e4a76;
        }
        @media (max-width: 750px) {
            .modern-header { padding: 0.8rem 1.2rem; }
            .logo { font-size: 1.4rem; }
            .profile-avatar { width: 40px; height: 40px; font-size: 1.4rem; }
        }
    </style>
    @yield('extra_styles')
</head>
<body class="ltr">
<div class="container">
    <header class="modern-header">
        <div class="header-container">
            <div class="logo-area">
                <div class="logo">Medi<span>Ease</span></div>
            </div>
            <div class="language-area">
                <select id="langSelect" class="lang-dropdown">
                    <option value="en">🇬🇧 English</option>
                    <option value="fr">🇫🇷 Français</option>
                    <option value="ar">🇸🇦 العربية</option>
                </select>
            </div>
            <div class="right-area" style="display: flex; align-items: center; gap: 1.5rem;">
                <div class="notification-bell" id="notificationBell">
                    <i class="fas fa-bell"></i>
                    <span class="badge" id="notificationBadge">0</span>
                </div>
                <div class="profile-avatar" id="profileAvatar">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="notification-dropdown" id="notificationDropdown">
        <div class="notification-header" id="notificationsHeader">📢 Notifications</div>
        <div id="notificationList"></div>
    </div>

    <div class="nav-links">
        <a href="{{ route('doctor.dashboard') }}" class="{{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> <span id="nav_dash">Dashboard</span>
        </a>
        <a href="{{ route('doctor.appointments.index') }}" class="{{ request()->routeIs('doctor.appointments.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> <span id="nav_app">Appointments</span>
        </a>
        <a href="{{ route('doctor.schedule') }}" class="{{ request()->routeIs('doctor.schedule') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> <span id="nav_schedule">Schedule</span>
        </a>
        <a href="{{ route('doctor.patients.index') }}" class="{{ request()->routeIs('doctor.patients.*') ? 'active' : '' }}">
            <i class="fas fa-folder-open"></i> <span id="nav_patients">Patients</span>
        </a>
        <a href="{{ route('doctor.settings') }}" class="{{ request()->routeIs('doctor.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> <span id="nav_settings">Settings</span>
        </a>
    </div>

    <main>
        @yield('content')
    </main>
</div>

<script>
    let currentLang = localStorage.getItem('doctor_lang') || 'en';
    let notifications = [];

    function loadNotifications() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) return;

        fetch('/api/doctor/notifications', {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.data) {
                notifications = data.data;
                renderNotificationBadge();
                renderNotificationList();
            }
        })
        .catch(err => console.error('Error loading notifications:', err));
    }

    function renderNotificationBadge() {
        const unreadCount = notifications.filter(n => !n.is_read).length;
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            if (unreadCount > 0) {
                badge.style.display = 'inline-block';
                badge.innerText = unreadCount > 9 ? '9+' : unreadCount;
            } else {
                badge.style.display = 'none';
            }
        }
    }

    function renderNotificationList() {
        const container = document.getElementById('notificationList');
        if (!container) return;
        if (notifications.length === 0) {
            container.innerHTML = '<div class="notification-item">✨ No notifications</div>';
            return;
        }
        container.innerHTML = '';
        notifications.forEach(notif => {
            const div = document.createElement('div');
            div.className = `notification-item ${!notif.is_read ? 'unread' : ''}`;
            div.innerHTML = `
                <div class="notification-icon"><i class="fas fa-bell"></i></div>
                <div class="notification-content">
                    <div class="notification-title">${escapeHtml(notif.message || 'Notification')}</div>
                    <div class="notification-time">${new Date(notif.created_at).toLocaleString()}</div>
                    ${!notif.is_read ? `<div class="mark-read" data-id="${notif.id}">✔️ Mark as read</div>` : ''}
                </div>
            `;
            container.appendChild(div);
        });
        document.querySelectorAll('.mark-read').forEach(el => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(el.getAttribute('data-id'));
                fetch(`/api/doctor/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                    .then(() => loadNotifications());
            });
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '<', '>': '>' }[m] || m));
    }

    function setLanguage(lang) {
        currentLang = lang;
        document.body.classList.remove('ltr', 'rtl');
        document.body.classList.add(lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('lang', lang);
        localStorage.setItem('doctor_lang', lang);
        const langSelect = document.getElementById('langSelect');
        if (langSelect) langSelect.value = lang;

        const texts = {
            en: { dash: "Dashboard", app: "Appointments", schedule: "Schedule", patients: "Patients", settings: "Settings" },
            ar: { dash: "لوحة التحكم", app: "المواعيد", schedule: "الجدول", patients: "المرضى", settings: "الإعدادات" },
            fr: { dash: "Tableau de bord", app: "Rendez-vous", schedule: "Planning", patients: "Patients", settings: "Paramètres" }
        };
        const t = texts[lang] || texts.en;
        const navDash = document.getElementById('nav_dash');
        const navApp = document.getElementById('nav_app');
        const navSchedule = document.getElementById('nav_schedule');
        const navPatients = document.getElementById('nav_patients');
        const navSettings = document.getElementById('nav_settings');
        if (navDash) navDash.innerText = t.dash;
        if (navApp) navApp.innerText = t.app;
        if (navSchedule) navSchedule.innerText = t.schedule;
        if (navPatients) navPatients.innerText = t.patients;
        if (navSettings) navSettings.innerText = t.settings;
    }

    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    if (bell && dropdown) {
        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
            loadNotifications();
        });
        document.addEventListener('click', function(e) {
            if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    }

    const profileAvatar = document.getElementById('profileAvatar');
    if (profileAvatar) {
        profileAvatar.addEventListener('click', function() {
            window.location.href = '{{ route("doctor.settings") }}';
        });
    }

    const langSelect = document.getElementById('langSelect');
    if (langSelect) {
        langSelect.addEventListener('change', function(e) {
            setLanguage(e.target.value);
        });
    }

    setLanguage(currentLang);
    loadNotifications();
    setInterval(loadNotifications, 30000);
</script>
@yield('scripts')
</body>
</html>
