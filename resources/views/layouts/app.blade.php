<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HealD Clinic - @yield('title')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: #f0f4f8;
        }
        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #0f2b5c, #1a3a6e);
            color: white;
            position: fixed;
            padding: 25px 20px;
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
            overflow-y: auto;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 35px;
            font-size: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar ul li {
            margin: 6px 0;
        }
        .sidebar ul li a {
            color: #e2e8f0;
            text-decoration: none;
            display: block;
            padding: 10px 14px;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 14px;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: #2563eb;
            color: white;
            transform: translateX(5px);
        }
        .main-content {
            margin-left: 260px;
            padding: 25px 35px;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 100;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
        @yield('styles')
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>🏥 MediEase Clinic</h2>
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">📊 Dashboard</a></li>
            <li><a href="{{ route('doctors.index') }}" class="{{ request()->routeIs('doctors.*') ? 'active' : '' }}">👨‍⚕️ Manage Doctors</a></li>
            <li><a href="{{ route('patients.index') }}" class="{{ request()->routeIs('patients.*') ? 'active' : '' }}">👥 Manage Patients</a></li>
            <li><a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}">📅 Manage Appointments</a></li>
            <li><a href="{{ route('invoices.index') }}">📄 Patient Invoices</a></li>
            <li><a href="{{ route('statistics.index') }}">📈 Statistics</a></li>
            <li><a href="{{ route('reports.index') }}">📋 Reports</a></li>
            <li><a href="{{ route('settings.index') }}">⚙️ System Settings</a></li>
            <li><a href="{{ route('announcements.index') }}">📢 Announcements</a></li>
            <li><a href="{{ route('notifications.index') }}">🔔 Notifications</a></li>
        </ul>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <script>
        window.Laravel = { csrfToken: '{{ csrf_token() }}' };
    </script>
    @yield('scripts')
</body>
</html>