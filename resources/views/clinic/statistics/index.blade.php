{{-- resources/views/clinic/statistics/index.blade.php --}}
@extends('clinic.layouts.clinic')

@section('title', 'Statistics')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.main-content {
    padding: 25px 35px;
}

/* ========== HEADER ========== */
.header {
    background: white;
    padding: 20px 25px;
    border-radius: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.header h1 {
    color: #0f2b5c;
    font-size: 24px;
    margin-bottom: 5px;
}

.header p {
    color: #64748b;
    font-size: 13px;
}

/* ========== STATS CARDS ========== */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 18px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 18px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-card h3 {
    color: #64748b;
    font-size: 13px;
    margin-bottom: 8px;
    font-weight: 500;
}

.stat-card .number {
    font-size: 32px;
    font-weight: bold;
    color: #2563eb;
}

.stat-card .trend {
    font-size: 11px;
    margin-top: 5px;
    color: #16a34a;
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
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
}

.chart-card h3 {
    color: #0f2b5c;
    font-size: 16px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.chart-card canvas {
    max-height: 280px;
    width: 100%;
}

/* ========== TABLE SECTION ========== */
.table-section {
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-top: 10px;
}

.table-section h3 {
    color: #0f2b5c;
    font-size: 16px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

th, td {
    padding: 12px 10px;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

th {
    background: #f8fafc;
    color: #1e3a8a;
    font-weight: 600;
    font-size: 12px;
}

tr:hover {
    background: #f8fafc;
}

.rank-cell {
    font-weight: bold;
    color: #2563eb;
}

/* ========== RESPONSIVE ========== */
@media (max-width: 900px) {
    .charts-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }
    .stats-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media print {
    .header, .stats-cards, .charts-grid, .table-section {
        display: none !important;
    }
}
</style>

<div class="main-content">
    <div class="header">
        <h1>📈 System Statistics</h1>
        <p>Real-time analytics and insights from your clinic data</p>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="stats-cards" id="statsCards">
        <div class="stat-card"><h3>Total Doctors</h3><div class="number" id="totalDoctors">0</div><div class="trend">👨‍⚕️ Active staff</div></div>
        <div class="stat-card"><h3>Total Patients</h3><div class="number" id="totalPatients">0</div><div class="trend">👥 Registered</div></div>
        <div class="stat-card"><h3>Total Appointments</h3><div class="number" id="totalAppointments">0</div><div class="trend">📅 All time</div></div>
        <div class="stat-card"><h3>Pending</h3><div class="number" id="pendingAppointments">0</div><div class="trend">⏳ Awaiting action</div></div>
        <div class="stat-card"><h3>Completed</h3><div class="number" id="completedAppointments">0</div><div class="trend">✅ Finished</div></div>
        <div class="stat-card"><h3>Revenue</h3><div class="number" id="totalRevenue">€0</div><div class="trend">💰 Total income</div></div>
    </div>

    <!-- CHARTS GRID -->
    <div class="charts-grid">
        <!-- Appointments Trend Chart -->
        <div class="chart-card">
            <h3>📅 Appointments Trend (Weekly)</h3>
            <canvas id="appointmentsTrendChart"></canvas>
        </div>

        <!-- Doctors Activity Chart -->
        <div class="chart-card">
            <h3>👨‍⚕️ Doctors by Specialty</h3>
            <canvas id="doctorsSpecialtyChart"></canvas>
        </div>

        <!-- Patients Distribution Chart -->
        <div class="chart-card">
            <h3>👥 Patients Distribution</h3>
            <canvas id="patientsDistributionChart"></canvas>
        </div>

        <!-- Appointment Status Chart -->
        <div class="chart-card">
            <h3>📊 Appointment Status</h3>
            <canvas id="appointmentStatusChart"></canvas>
        </div>
    </div>

    <!-- TOP DOCTORS TABLE -->
    <div class="table-section">
        <h3>🏆 Top Performing Doctors</h3>
        <div style="overflow-x: auto;">
            <table id="topDoctorsTable">
                <thead>
                    <tr><th>Rank</th><th>Doctor Name</th><th>Specialty</th><th>Appointments</th><th>Acceptance Rate</th></tr>
                </thead>
                <tbody id="topDoctorsBody"></tbody>
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
        document.getElementById('totalRevenue').innerText = data.revenue || '€0';
    }

    // ========== UPDATE CHARTS ==========
    function updateCharts(data) {
        // Appointments Trend Chart (Weekly)
        if (appointmentsChart) appointmentsChart.destroy();
        appointmentsChart = new Chart(document.getElementById('appointmentsTrendChart'), {
            type: 'line',
            data: {
                labels: data.weekly_labels || ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                datasets: [{
                    label: 'Appointments',
                    data: data.weekly_counts || [0, 0, 0, 0, 0, 0],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: 'white',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'top' } }
            }
        });

        // Doctors by Specialty Chart (Bar Chart)
        if (specialtyChart) specialtyChart.destroy();
        specialtyChart = new Chart(document.getElementById('doctorsSpecialtyChart'), {
            type: 'bar',
            data: {
                labels: data.specialty_labels || [],
                datasets: [{
                    label: 'Number of Doctors',
                    data: data.specialty_counts || [],
                    backgroundColor: '#2563eb',
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } }
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
                    backgroundColor: ['#2563eb', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
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
                    backgroundColor: ['#f59e0b', '#16a34a', '#dc2626'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // ========== UPDATE TOP DOCTORS TABLE ==========
    function updateTopDoctors(doctors) {
        const tbody = document.getElementById('topDoctorsBody');
        tbody.innerHTML = '';
        
        if (!doctors || doctors.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;">No data available</td></tr>';
            return;
        }
        
        doctors.slice(0, 5).forEach((doctor, index) => {
            tbody.innerHTML += `
                <tr>
                    <td class="rank-cell">#${index + 1}</td>
                    <td><strong>${escapeHtml(doctor.name)}</strong></td>
                    <td>${escapeHtml(doctor.specialty)}</td>
                    <td>${doctor.appointments || 0}</td>
                    <td>${doctor.acceptance_rate || 0}%</td>
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

    // ========== INITIALIZE ==========
    document.addEventListener('DOMContentLoaded', function() {
        fetchStats();
        // Refresh data every 30 seconds
        setInterval(fetchStats, 30000);
    });
</script>
@endsection