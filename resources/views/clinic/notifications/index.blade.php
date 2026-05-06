@extends('clinic.layouts.clinic')

@section('title', 'Notifications')
@section('content')
<div class="header"><h1>🔔 Notification Center</h1><p>Real-time appointment status updates</p><div class="notification-bell" style="cursor:pointer;" onclick="location.reload()">🔔 <span id="bellBadge" class="badge">0</span></div></div>
<div class="filter-bar" style="margin-bottom:20px;"><button class="filter-btn active" data-filter="all">All</button><button class="filter-btn" data-filter="unread">Unread</button><button class="filter-btn" onclick="markAllAsRead()">Mark all read</button></div>
<div class="notification-card" style="background:white; border-radius:20px; padding:20px;"><div id="notificationsList"></div><button class="clear-btn" onclick="clearAllNotifications()">🗑️ Clear All</button></div>
<style>
    .filter-btn{background:transparent;border:none;padding:6px 18px;border-radius:30px;cursor:pointer;}
    .filter-btn.active{background:#0a2540;color:white;}
    .notif-item{background:#f8fafc;padding:16px;margin-bottom:10px;border-radius:20px;border-left:4px solid #2563eb;}
    .notif-item.unread{background:#eef2ff;border-left-color:#f59e0b;}
    .notif-text{font-weight:500;}
    .notif-date{font-size:12px;color:#64748b;margin-top:8px;}
</style>
<script>
    let notifications = [], currentFilter = 'all';
    async function fetchNotifications() { const res = await fetch('{{ route("clinic.notifications.data") }}'); const data = await res.json(); if(data.success) { notifications = data.notifications; renderNotifications(); updateBadge(); } }
    function renderNotifications() { const filtered = currentFilter === 'all' ? notifications : notifications.filter(n => !n.read); const container = document.getElementById('notificationsList'); if(filtered.length === 0) { container.innerHTML = '<div class="empty-state">📭 No notifications</div>'; return; } container.innerHTML = ''; filtered.forEach(n => { container.innerHTML += `<div class="notif-item ${n.read ? '' : 'unread'}" onclick="markAsRead(${n.id})"><div class="notif-text">${escapeHtml(n.text)}</div><div class="notif-date">${new Date(n.created_at).toLocaleString()}</div></div>`; }); }
    async function markAsRead(id) { await fetch(`{{ url('clinic/notifications') }}/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); fetchNotifications(); }
    async function markAllAsRead() { await fetch('{{ route("clinic.notifications.mark-all-read") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); fetchNotifications(); }
    async function clearAllNotifications() { if(confirm('Clear all?')) { await fetch('{{ route("clinic.notifications.clear-all") }}', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }); fetchNotifications(); } }
    function updateBadge() { const unread = notifications.filter(n => !n.read).length; document.getElementById('bellBadge').innerText = unread; }
    document.querySelectorAll('.filter-btn').forEach(btn => btn.addEventListener('click', function() { document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active')); this.classList.add('active'); currentFilter = this.getAttribute('data-filter'); renderNotifications(); }));
    fetchNotifications();
    setInterval(fetchNotifications, 30000);
</script>
@endsection