{{-- resources/views/clinic/statistics/index.blade.php --}}
@extends('clinic.layouts.clinic')

@section('title', 'Statistics')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ========== MAIN CONTENT ========== */
    .stats-wrapper {
        padding: 0;
    }
    
    /* ========== HEADER ========== */
    .header-section {
        background: white;
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 25px;
        border: 1px solid #f1f5f9;
    }
    
    .header-section h1 {
        color: #1e293b;
        font-size: 24px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .header-section h1 i {
        color: #6366f1;
    }
    
    .header-section p {
        color: #64748b;
        font-size: 13px;
    }
    
    /* ========== STATS CARDS ========== */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    
    .stat-info h4 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 8px;
    }
    
    .stat-info .number {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
    }
    
    .stat-info .trend {
        font-size: 11px;
        color: #10b981;
        margin-top: 5px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .stat-icon i {
        font-size: 24px;
        color: white;
    }
    
    /* ========== CHARTS GRID ========== */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: white;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        transition: all 0.3s;
    }
    
    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    
    .chart-card h3 {
        color: #1e293b;
        font-size: 16px;
        margin-bottom: 15px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-card h3 i {
        color: #6366f1;
    }
    
    .chart-card canvas {
        max-height: 280px;
        width: 100%;
    }
    
    /* ========== TABLE SECTION ========== */
    .table-section {
        background: white;
        border-radius: 24px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
        margin-top: 10px;
    }
    
    .table-section h3 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-section h3 i {
        color: #6366f1;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    th, td {
        padding: 14px 12px;
        text-align: left;
        border-bottom: 1px solid #f1f5f9;
    }
    
    th {
        background: #f8fafc;
        color: #1e293b;
        font-weight: 600;
        font-size: 12px;
    }
    
    tr:hover td {
        background: #f8fafc;
    }
    
    .rank-cell {
        font-weight: bold;
        color: #6366f1;
        font-size: 16px;
    }
    
    /* ========== RTL SUPPORT ========== */
    body.rtl th, body.rtl td {
        text-align: right;
    }
    
    body.rtl .table-section h3 {
        border-left: none;
        border-right: 4px solid #f59e0b;
        padding-left: 0;
        padding-right: 10px;
    }
    
    body.rtl .stat-info {
        text-align: right;
    }
    
    /* ========== RESPONSIVE ========== */
    @media (max-width: 1000px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-info .number {
            font-size: 24px;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
        }
        
        .stat-icon i {
            font-size: 18px;
        }
        
        th, td {
            padding: 10px 8px;
            font-size: 12px;
        }
    }
    
    @media print {
        .header-section, .stats-cards, .charts-grid {
            display: none !important;
        }
        .table-section {
            box-shadow: none;
            border: none;
        }
    }
</style>

<div class="stats-wrapper">
    <!-- HEADER SECTION -->
    <div class="header-section">
        <h1><i class="fas fa-chart-line"></i> System Statistics</h1>
        <p>Real-time analytics and insights from your clinic data</p>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-cards" id="statsCards">
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Doctors</h4>
                <div class="number" id="totalDoctors">0</div>
                <div class="trend"><i class="fas fa-user-md"></i> Active staff</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-md"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Patients</h4>
                <div class="number" id="totalPatients">0</div>
                <div class="trend"><i class="fas fa-users"></i> Registered</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h4>Total Appointments</h4>
                <div class="number" id="totalAppointments">0</div>
                <div class="trend"><i class="fas fa-calendar-check"></i> All time</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h4>Pending</h4>
                <div class="number" id="pendingAppointments">0</div>
                <div class="trend"><i class="fas fa-clock"></i> Awaiting action</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h4>Completed</h4>
                <div class="number" id="completedAppointments">0</div>
                <div class="trend"><i class="fas fa-check-circle"></i> Finished</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-info">
                <h4>Revenue</h4>
                <div class="number" id="totalRevenue">€0</div>
                <div class="trend"><i class="fas fa-coins"></i> Total income</div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="charts-grid">
        <!-- Appointments Trend Chart -->
        <div class="chart-card">
            <h3><i class="fas fa-chart-line"></i> Appointments Trend (Weekly)</h3>
            <canvas id="appointmentsTrendChart"></canvas>
        </div>

        <!-- Doctors Activity Chart -->
        <div class="chart-card">
            <h3><i class="fas fa-chart-bar"></i> Doctors by Specialty</h3>
            <canvas id="doctorsSpecialtyChart"></canvas>
        </div>

        <!-- Patients Distribution Chart -->
        <div class="chart-card">
            <h3><i class="fas fa-chart-pie"></i> Patients Distribution</h3>
            <canvas id="patientsDistributionChart"></canvas>
        </div>

        <!-- Appointment Status Chart -->
        <div class="chart-card">
            <h3><i class="fas fa-chart-doughnut"></i> Appointment Status</h3>
            <canvas id="appointmentStatusChart"></canvas>
        </div>
    </div>

    <!-- TOP DOCTORS TABLE -->
    <div class="table-section">
        <h3><i class="fas fa-trophy"></i> Top Performing Doctors</h3>
        <div style="overflow-x: auto;">
            <table id="topDoctorsTable">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Doctor Name</th>
                        <th>Specialty</th>
                        <th>Appointments</th>
                        <th>Acceptance Rate</th>
                    </tr>
                </thead>
                <tbody id="topDoctorsBody">
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px;">
                            <i class="fas fa-spinner fa-spin"></i> Loading data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let appointmentsChart = null;
    let specialtyChart = null;
    let patientsChart = null;
    let statusChart = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ========== FETCH STATISTICS FROM DATABASE ==========
    async function fetchStats() {
        try {
            const response = await fetch('{{ route("clinic.statistics.stats") }}');
            const data = await response.json();
            if (data.success) {
                updateStatsCards(data.data);
                updateCharts(data.data);
                updateTopDoctors(data.top_doctors);
            } else {
                console.error('Failed to fetch statistics:', data.message);
            }
        } catch (error) {
            console.error('Error fetching statistics:', error);
        }
    }

    // ========== UPDATE STATS CARDS ==========
    function updateStatsCards(data) {
        document.getElementById('totalDoctors').innerText = data.total_doctors || 0;
        document.getElementById('totalPatients').innerText = data.total_patients || 0;
        document.getElementById('totalAppointments').innerText = data.total_appointments || 0;
        document.getElementById('pendingAppointments').innerText = data.pending_appointments || 0;
        document.getElementById('completedAppointments').innerText = data.accepted_appointments || 0;
        
        let revenue = data.revenue || 0;
        if (typeof revenue === 'number') {
            document.getElementById('totalRevenue').innerText = '€' + revenue.toLocaleString();
        } else {
            document.getElementById('totalRevenue').innerText = revenue;
        }
    }

    // ========== UPDATE CHARTS ==========
    function updateCharts(data) {
        // Appointments Trend Chart (Line)
        if (appointmentsChart) appointmentsChart.destroy();
        appointmentsChart = new Chart(document.getElementById('appointmentsTrendChart'), {
            type: 'line',
            data: {
                labels: data.weekly_labels || ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                datasets: [{
                    label: 'Appointments',
                    data: data.weekly_counts || [0, 0, 0, 0, 0, 0],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: 'white',
                    pointBorderWidth: 2,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Doctors by Specialty Chart (Bar)
        if (specialtyChart) specialtyChart.destroy();
        specialtyChart = new Chart(document.getElementById('doctorsSpecialtyChart'), {
            type: 'bar',
            data: {
                labels: data.specialty_labels || [],
                datasets: [{
                    label: 'Number of Doctors',
                    data: data.specialty_counts || [],
                    backgroundColor: 'linear-gradient(135deg, #6366f1, #8b5cf6)',
                    backgroundColor: '#6366f1',
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e2e8f0' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Patients Distribution Chart (Doughnut)
        if (patientsChart) patientsChart.destroy();
        patientsChart = new Chart(document.getElementById('patientsDistributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [data.male_patients || 0, data.female_patients || 0],
                    backgroundColor: ['#6366f1', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: (context) => `${context.label}: ${context.raw} patients` } }
                }
            }
        });

        // Appointment Status Chart (Pie)
        if (statusChart) statusChart.destroy();
        statusChart = new Chart(document.getElementById('appointmentStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Pending', 'Accepted', 'Rejected'],
                datasets: [{
                    data: [data.pending_appointments || 0, data.accepted_appointments || 0, data.rejected_appointments || 0],
                    backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: { callbacks: { label: (context) => `${context.label}: ${context.raw} appointments` } }
                }
            }
        });
    }

    // ========== UPDATE TOP DOCTORS TABLE ==========
    function updateTopDoctors(doctors) {
        const tbody = document.getElementById('topDoctorsBody');
        tbody.innerHTML = '';
        
        if (!doctors || doctors.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center; padding: 40px;"><i class="fas fa-inbox"></i> No data available</td></tr>';
            return;
        }
        
        doctors.slice(0, 10).forEach((doctor, index) => {
            const rankIcon = index === 0 ? '🥇' : (index === 1 ? '🥈' : (index === 2 ? '🥉' : `#${index + 1}`));
            tbody.innerHTML += `
                <tr>
                    <td class="rank-cell">${rankIcon}</td>
                    <td><strong>${escapeHtml(doctor.name)}</strong></td>
                    <td>${escapeHtml(doctor.specialty)}</td>
                    <td>${doctor.appointments || 0}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; background: #e2e8f0; border-radius: 10px; height: 6px; width: 80px;">
                                <div style="width: ${doctor.acceptance_rate || 0}%; background: #10b981; border-radius: 10px; height: 6px;"></div>
                            </div>
                            <span>${doctor.acceptance_rate || 0}%</span>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    // ========== HELPER FUNCTION ==========
    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    // ========== SHOW TOAST ==========
    function showToast(message) {
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 1000;';
            document.body.appendChild(toastContainer);
        }
        const toast = document.createElement('div');
        toast.style.cssText = 'background: #1e293b; color: white; padding: 12px 20px; border-radius: 50px; margin-top: 10px; font-size: 13px; animation: slideIn 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.1);';
        toast.innerHTML = `<i class="fas fa-chart-line"></i> ${message}`;
        toastContainer.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ========== INITIALIZE ==========
    document.addEventListener('DOMContentLoaded', function() {
        fetchStats();
        // Refresh data every 30 seconds
        const interval = setInterval(fetchStats, 30000);
        
        // Clean up interval on page unload
        window.addEventListener('beforeunload', () => clearInterval(interval));
    });
</script>

<style>
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endsection