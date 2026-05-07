<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MediEase - Admin Panel @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: #0a0f1a;
            color: #e0f2fe;
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
            box-shadow: 0 15px 35px rgba(0, 20, 50, 0.5);
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
        .logo span { color: #0288d1; }
        .lang-dropdown {
            background: #0f2b3d;
            border: 1px solid #2a6f8f;
            border-radius: 40px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            color: #b3e5fc;
            cursor: pointer;
        }
        .right-area {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.6rem;
            color: #b3e5fc;
        }
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
        .logout-btn {
            background: #c62828;
            border: none;
            padding: 8px 18px;
            border-radius: 40px;
            color: white;
            cursor: pointer;
            font-weight: 500;
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
        .card {
            background: #0f2b3d;
            border-radius: 25px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #1e4a76;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        .stat-card {
            background: #0f2b3d;
            padding: 25px;
            border-radius: 25px;
            text-align: center;
            border: 1px solid #1e4a76;
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card i { font-size: 40px; color: #4fc3f7; margin-bottom: 15px; }
        .stat-card h3 { font-size: 32px; color: white; }
        .stat-card p { color: #89b9d9; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #1e4a76; }
        body.rtl th, body.rtl td { text-align: right; }
        .btn-sm {
            background: #0288d1;
            border: none;
            padding: 6px 14px;
            border-radius: 30px;
            color: white;
            cursor: pointer;
            margin: 5px;
        }
        .btn-danger { background: #c62828; }
        .btn-success { background: #2e7d32; }
        .notification-dropdown {
            position: absolute;
            top: 80px;
            right: 20px;
            width: 340px;
            background: #0f2b3d;
            border-radius: 20px;
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
        }
        .notification-item:hover { background: #1e3a5f; }
        .notification-item.unread { background: #1a3a55; }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: #0f2b3d;
            border-radius: 30px;
            padding: 25px;
            max-width: 500px;
            width: 90%;
            border: 1px solid #1e4a76;
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #b3e5fc; }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border-radius: 20px;
            border: none;
            background: #1e3a5f;
            color: white;
        }
        .close { float: right; font-size: 24px; cursor: pointer; }
        @media (max-width: 750px) {
            .logo { font-size: 1.4rem; }
            .profile-avatar { width: 40px; height: 40px; font-size: 1.4rem; }
        }
    </style>
    @yield('styles')
</head>
<body class="ltr">
<div class="container">
    <header class="modern-header">
        <div class="header-container">
            <div class="logo">Medi<span>Ease</span> - Admin</div>
            <select id="langSelect" class="lang-dropdown">
                <option value="en">🇬🇧 English</option>
                <option value="fr">🇫🇷 Français</option>
                <option value="ar">🇸🇦 العربية</option>
            </select>
            <div class="right-area">
                <div class="notification-bell" id="notificationBell">
                    <i class="fas fa-bell"></i>
                    <span class="badge" id="notificationBadge">0</span>
                </div>
                <div class="profile-avatar" id="profileAvatar">
                    <i class="fas fa-user-cog"></i>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span id="logoutText">Logout</span></button>
                </form>
            </div>
        </div>
    </header>

    <div class="notification-dropdown" id="notificationDropdown">
        <div class="notification-header" id="notificationsHeader">📢 Notifications</div>
        <div id="notificationList"></div>
    </div>

    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> <span id="nav_dash">Dashboard</span>
        </a>
<a href="{{ route('admin.clinics.index') }}" class="{{ request()->routeIs('admin.clinics*') ? 'active' : '' }}">
    <i class="fas fa-hospital"></i> <span id="nav_clinics">Clinics</span>
</a>
<a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
    <i class="fas fa-calendar-check"></i> <span id="nav_bookings">Bookings</span>
</a>
<a href="{{ route('admin.ads.index') }}" class="{{ request()->routeIs('admin.ads*') ? 'active' : '' }}">
    <i class="fas fa-ad"></i> <span id="nav_ads">Ads</span>
</a>

<a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
    <i class="fas fa-credit-card"></i> <span id="nav_payments">Payments</span>
</a>
<a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
    <i class="fas fa-cog"></i> <span id="nav_settings">Settings</span>
</a>
<a href="{{ route('admin.clinics.pending') }}">
        <i class="fas fa-clock"></i>
        <span>Pending Approvals</span>
        @if($pendingCount ?? 0 > 0)
            <span class="badge">{{ $pendingCount }}</span>
        @endif
    </a>


</a>
    </div>

    <main>
        @yield('content')
    </main>
</div>

<script>
    let currentLang = localStorage.getItem('admin_lang') || 'en';
    let notifications = [];

    const translations = {
        ar: {
            nav_dash: "لوحة التحكم", nav_clinics: "العيادات", nav_bookings: "الحجوزات", nav_ads: "الإعلانات", nav_payments: "المدفوعات", nav_settings: "الإعدادات",
            notifications_header: "📢 الإشعارات", mark_as_read: "✔️ وضع كمقروء", no_notifications: "✨ لا توجد إشعارات", logout: "تسجيل الخروج"
        },
        fr: {
            nav_dash: "Tableau de bord", nav_clinics: "Cliniques", nav_bookings: "Réservations", nav_ads: "Annonces", nav_payments: "Paiements", nav_settings: "Paramètres",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Marquer comme lu", no_notifications: "✨ Aucune notification", logout: "Déconnexion"
        },
        en: {
            nav_dash: "Dashboard", nav_clinics: "Clinics", nav_bookings: "Bookings", nav_ads: "Ads", nav_payments: "Payments", nav_settings: "Settings",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Mark as read", no_notifications: "✨ No notifications", logout: "Logout"
        }
    };

    function setLanguage(lang) {
        currentLang = lang;
        document.body.classList.remove('ltr', 'rtl');
        document.body.classList.add(lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        localStorage.setItem('admin_lang', lang);
        document.getElementById('langSelect').value = lang;
        updateTexts();
    }

    function updateTexts() {
        const t = translations[currentLang];
        document.getElementById('nav_dash') && (document.getElementById('nav_dash').innerText = t.nav_dash);
        document.getElementById('nav_clinics') && (document.getElementById('nav_clinics').innerText = t.nav_clinics);
        document.getElementById('nav_bookings') && (document.getElementById('nav_bookings').innerText = t.nav_bookings);
        document.getElementById('nav_ads') && (document.getElementById('nav_ads').innerText = t.nav_ads);
        document.getElementById('nav_payments') && (document.getElementById('nav_payments').innerText = t.nav_payments);
        document.getElementById('nav_settings') && (document.getElementById('nav_settings').innerText = t.nav_settings);
        document.getElementById('notificationsHeader') && (document.getElementById('notificationsHeader').innerHTML = t.notifications_header);
        document.getElementById('logoutText') && (document.getElementById('logoutText').innerText = t.logout);
    }

    function loadNotifications() {
        fetch('{{ route("admin.notifications.index") }}', {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                notifications = data.data;
                renderNotificationBadge();
                renderNotificationList();
            }
        })
        .catch(err => console.error(err));
    }

    function renderNotificationBadge() {
        const unreadCount = notifications.filter(n => !n.is_read).length;
        const badge = document.getElementById('notificationBadge');
        if (unreadCount > 0) {
            badge.style.display = 'inline-block';
            badge.innerText = unreadCount > 9 ? '9+' : unreadCount;
        } else {
            badge.style.display = 'none';
        }
    }

    function renderNotificationList() {
        const container = document.getElementById('notificationList');
        if (!container) return;
        if (notifications.length === 0) {
            container.innerHTML = `<div class="notification-item">✨ ${translations[currentLang].no_notifications}</div>`;
            return;
        }
        container.innerHTML = '';
        notifications.forEach(notif => {
            const div = document.createElement('div');
            div.className = `notification-item ${!notif.is_read ? 'unread' : ''}`;
            let message = notif.params ? JSON.stringify(notif.params) : '';
            div.innerHTML = `
                <div class="notification-icon"><i class="fas fa-bell"></i></div>
                <div class="notification-content">
                    <div class="notification-title">${escapeHtml(notif.type)}</div>
                    <div class="notification-message">${escapeHtml(message)}</div>
                    <div class="notification-time">${new Date(notif.created_at).toLocaleString()}</div>
                    <div class="mark-read" data-id="${notif.id}">${!notif.is_read ? translations[currentLang].mark_as_read : ''}</div>
                </div>
            `;
            container.appendChild(div);
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m] || m));
    }

    document.getElementById('langSelect')?.addEventListener('change', (e) => setLanguage(e.target.value));
    
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    if (bell && dropdown) {
        bell.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('show');
            loadNotifications();
        });
        document.addEventListener('click', (e) => {
            if (!bell.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.remove('show');
        });
    }

    setLanguage(currentLang);
    loadNotifications();
    setInterval(loadNotifications, 30000);
</script>
@yield('scripts')
</body>
</html>