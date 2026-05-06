<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Patient Dashboard') - MediEase</title>

    <!-- Google Fonts & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* ========== GLOBAL STYLES ========== */
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
        .container { max-width: 1300px; margin: auto; }

        /* Modern Header */
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
            text-shadow: 0 0 12px rgba(79, 195, 247, 0.5);
        }
        .logo span { color: #0288d1; text-shadow: 0 0 8px #0288d1; }
        .lang-dropdown {
            background: #0f2b3d;
            border: 1px solid #2a6f8f;
            border-radius: 40px;
            padding: 0.6rem 1.2rem;
            font-weight: 500;
            color: #b3e5fc;
            cursor: pointer;
            background-color: rgba(15, 43, 61, 0.8);
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
        }
        .nav-links a.active {
            background: #0288d1;
            color: white;
        }
        /* Notification Dropdown */
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
        .mark-read { font-size: 12px; color: #0288d1; cursor: pointer; margin-top: 5px; display: inline-block; }

        /* Common Card Styles */
        .card-white {
            background: #0f2b3d;
            border-radius: 25px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid #1e4a76;
        }
        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #4fc3f7;
            margin-bottom: 15px;
            border-left: 4px solid #4fc3f7;
            padding-left: 12px;
        }
        body.rtl .section-title {
            border-left: none;
            border-right: 4px solid #4fc3f7;
            padding-left: 0;
            padding-right: 12px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            gap: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #4fc3f7;
            min-width: 100px;
        }
        .info-value {
            color: #e0f2fe;
        }
        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status.upcoming { background: #e3f2fd; color: #1976d2; }
        .status.completed { background: #e0f7e8; color: #2e7d32; }
        .status.cancelled { background: #ffebee; color: #c62828; }
        .readonly-box {
            background: #1e3a5f;
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #1e4a76;
            color: #e0f2fe;
        }
        .btn-invoice, .btn-sm {
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
            background: #ff9800;
            color: white;
        }
        .btn-sm { background: #0288d1; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #1e4a76; }
        th { color: #4fc3f7; }
        .status-paid { background: #e0f7e8; color: #2e7d32; padding: 4px 12px; border-radius: 20px; display: inline-block; }
        .status-unpaid { background: #ffebee; color: #c62828; padding: 4px 12px; border-radius: 20px; display: inline-block; }
        .form-group { margin-bottom: 20px; }
        label { font-weight: 600; display: block; margin-bottom: 8px; color: #4fc3f7; }
        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 16px;
            border: 1px solid #1e4a76;
            background: #1e3a5f;
            color: white;
            font-family: inherit;
        }
        .switch {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .switch label { margin-bottom: 0; cursor: pointer; color: #e0f2fe; }

        @media (max-width: 750px) {
            .logo { font-size: 1.4rem; }
            .profile-avatar { width: 40px; height: 40px; font-size: 1.4rem; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body class="ltr">
<div class="container">
    <header class="modern-header">
        <div class="header-container">
            <div class="logo">Medi<span>Ease</span></div>
            <select id="langSelect" class="lang-dropdown">
                <option value="en">🇬🇧 EN</option>
                <option value="fr">🇫🇷 FR</option>
                <option value="ar">🇸🇦 AR</option>
            </select>
            <div class="right-area">
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
        <a href="{{ route('patient.index') }}" class="{{ request()->routeIs('patient.index') ? 'active' : '' }}">
            <i class="fas fa-home"></i> <span id="nav_home">Home</span>
        </a>
        <a href="{{ route('patient.diagnoses') }}" class="{{ request()->routeIs('patient.diagnoses') ? 'active' : '' }}">
            <i class="fas fa-stethoscope"></i> <span id="nav_diagnosis">Diagnoses</span>
        </a>
        <a href="{{ route('patient.invoices') }}" class="{{ request()->routeIs('patient.invoices') ? 'active' : '' }}">
            <i class="fas fa-file-invoice-dollar"></i> <span id="nav_invoices">Invoices</span>
        </a>
        <a href="{{ route('patient.profile') }}" class="{{ request()->routeIs('patient.profile') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i> <span id="nav_profile">Profile</span>
        </a>
    </div>

    @yield('content')
</div>

<script>
    // -------------------- TRANSLATIONS --------------------
    const translations = {
        ar: {
            nav_home: "الرئيسية", nav_diagnosis: "التشخيصات", nav_invoices: "الفواتير", nav_profile: "الملف الشخصي",
            notifications_header: "📢 الإشعارات", mark_as_read: "✔️ وضع كمقروء", no_notifications: "✨ لا توجد إشعارات",
            notif_reminder: "تذكير بموعد", notif_reminder_msg: "لديك موعد مع {doctor} في {date} الساعة {time}",
            notif_cancelled: "إلغاء موعد", notif_cancelled_msg: "تم إلغاء موعدك مع {doctor} بتاريخ {date}"
        },
        fr: {
            nav_home: "Accueil", nav_diagnosis: "Diagnostics", nav_invoices: "Factures", nav_profile: "Profil",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Marquer comme lu", no_notifications: "✨ Aucune notification",
            notif_reminder: "Rappel de rendez-vous", notif_reminder_msg: "Rendez-vous avec {doctor} le {date} à {time}",
            notif_cancelled: "Annulation de rendez-vous", notif_cancelled_msg: "Votre rendez-vous avec {doctor} du {date} a été annulé"
        },
        en: {
            nav_home: "Home", nav_diagnosis: "Diagnoses", nav_invoices: "Invoices", nav_profile: "Profile",
            notifications_header: "📢 Notifications", mark_as_read: "✔️ Mark as read", no_notifications: "✨ No notifications",
            notif_reminder: "Appointment reminder", notif_reminder_msg: "Appointment with {doctor} on {date} at {time}",
            notif_cancelled: "Appointment cancelled", notif_cancelled_msg: "Your appointment with {doctor} on {date} has been cancelled"
        }
    };

    let currentLang = localStorage.getItem('cliniclick_patient_lang') || 'en';
    let notifications = [];

    function loadNotifications() {
        const stored = localStorage.getItem('cliniclick_patient_notifications');
        if (stored) notifications = JSON.parse(stored);
        else {
            notifications = [];
            saveNotifications();
        }
        renderNotificationBadge();
        renderNotificationList();
    }

    function saveNotifications() {
        localStorage.setItem('cliniclick_patient_notifications', JSON.stringify(notifications));
    }

    function renderNotificationBadge() {
        const unreadCount = notifications.filter(n => !n.read).length;
        const badge = document.getElementById('notificationBadge');
        if (unreadCount > 0) {
            badge.style.display = 'inline-block';
            badge.innerText = unreadCount > 9 ? '9+' : unreadCount;
        } else badge.style.display = 'none';
    }

    function translateNotification(notif, lang) {
        const t = translations[lang];
        const typeKey = `notif_${notif.type}`;
        const msgKey = `notif_${notif.type}_msg`;
        let title = t[typeKey] || notif.type;
        let message = t[msgKey] || '';
        if (notif.params) {
            Object.keys(notif.params).forEach(key => {
                message = message.replace(`{${key}}`, notif.params[key]);
                title = title.replace(`{${key}}`, notif.params[key]);
            });
        }
        return { title, message };
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
            const { title, message } = translateNotification(notif, currentLang);
            let iconClass = 'fa-bell';
            if (notif.type === 'reminder') iconClass = 'fa-bell';
            else if (notif.type === 'cancelled') iconClass = 'fa-calendar-times';
            const div = document.createElement('div');
            div.className = `notification-item ${!notif.read ? 'unread' : ''}`;
            div.innerHTML = `
                <div class="notification-icon"><i class="fas ${iconClass}"></i></div>
                <div class="notification-content">
                    <div class="notification-title">${escapeHtml(title)}</div>
                    <div class="notification-message">${escapeHtml(message)}</div>
                    <div class="notification-time">${new Date(notif.time).toLocaleString()}</div>
                    <div class="mark-read" data-id="${notif.id}">${!notif.read ? translations[currentLang].mark_as_read : ''}</div>
                </div>
            `;
            container.appendChild(div);
        });
        document.querySelectorAll('.mark-read').forEach(el => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(el.getAttribute('data-id'));
                const note = notifications.find(n => n.id === id);
                if (note && !note.read) {
                    note.read = true;
                    saveNotifications();
                    renderNotificationBadge();
                    renderNotificationList();
                }
            });
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[m] || m));
    }

    function setLanguage(lang) {
        currentLang = lang;
        document.body.classList.remove('ltr', 'rtl');
        document.body.classList.add(lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
        document.documentElement.setAttribute('lang', lang);
        localStorage.setItem('cliniclick_patient_lang', lang);
        document.getElementById("langSelect").value = lang;
        document.getElementById('nav_home').innerText = translations[lang].nav_home;
        document.getElementById('nav_diagnosis').innerText = translations[lang].nav_diagnosis;
        document.getElementById('nav_invoices').innerText = translations[lang].nav_invoices;
        document.getElementById('nav_profile').innerText = translations[lang].nav_profile;
        document.getElementById('notificationsHeader').innerHTML = translations[lang].notifications_header;
        renderNotificationList();
    }

    document.getElementById('langSelect').addEventListener('change', e => setLanguage(e.target.value));
    document.getElementById('profileAvatar').addEventListener('click', () => window.location.href = "{{ route('patient.profile') }}");

    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    bell.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });
    document.addEventListener('click', (e) => {
        if (!bell.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.remove('show');
    });

    loadNotifications();
    setLanguage(currentLang);
</script>
@stack('scripts')
</body>
</html>