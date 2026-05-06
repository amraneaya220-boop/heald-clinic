{{-- resources/views/clinic/reports/index.blade.php --}}
@extends('clinic.layouts.clinic')

@section('title', 'Reports')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ========== MAIN CONTENT STYLES (بدون sidebar مكررة) ========== */
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
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
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

.action-buttons {
    display: flex;
    gap: 10px;
}

.btn-print, .btn-pdf {
    padding: 10px 20px;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 500;
    font-size: 13px;
    transition: all 0.2s;
}

.btn-print {
    background: #2563eb;
    color: white;
}

.btn-print:hover {
    background: #1e40af;
}

.btn-pdf {
    background: #dc2626;
    color: white;
}

.btn-pdf:hover {
    background: #b91c1c;
}

/* ========== CONTROL PANEL ========== */
.control-panel {
    background: white;
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.control-panel h3 {
    color: #0f2b5c;
    font-size: 16px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.control-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.input-group label {
    font-weight: 600;
    color: #1e293b;
    font-size: 12px;
}

.input-group input {
    padding: 8px 12px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 13px;
    outline: none;
}

.input-group input:focus {
    border-color: #2563eb;
}

.btn-generate {
    background: #16a34a;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 30px;
    cursor: pointer;
    font-weight: 500;
    margin-top: 20px;
    width: 100%;
}

.btn-generate:hover {
    background: #15803d;
}

/* ========== REPORT CONTAINER (FOR PRINT/PDF) ========== */
.report-container {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

/* Report Styles */
.report {
    background: white;
    font-family: 'Times New Roman', serif;
    color: #000;
    line-height: 1.5;
}

.report-header {
    text-align: center;
    border-bottom: 3px solid #1e3a8a;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.report-header h1 {
    font-size: 24px;
    color: #1e3a8a;
    margin: 5px 0;
}

.report-header h2 {
    font-size: 18px;
    margin: 5px 0;
}

.report-header p {
    font-size: 13px;
    color: #475569;
}

.report-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 13px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 8px;
}

.report-section {
    margin-top: 20px;
}

.report-section h3 {
    font-size: 16px;
    border-left: 4px solid #1e3a8a;
    padding-left: 10px;
    margin-bottom: 10px;
    color: #1e3a8a;
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.report-table th {
    background: #1e3a8a;
    color: white;
    padding: 10px;
    font-size: 13px;
}

.report-table td {
    border: 1px solid #cbd5e1;
    padding: 8px;
    font-size: 12px;
}

.report-table tr:nth-child(even) {
    background: #f8fafc;
}

.report-notes {
    margin-top: 20px;
    border: 1px solid #1e3a8a;
    padding: 12px;
    background: #f0f4f8;
    border-radius: 8px;
    font-size: 13px;
}

.report-footer {
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
}

.signature-box {
    text-align: center;
    margin-top: 30px;
}

.signature-box p {
    margin: 5px 0;
}

.signature-line {
    width: 200px;
    border-top: 1px solid #000;
    margin: 10px auto;
}

/* Stats Cards inside report */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-bottom: 15px;
}

.stat-item {
    background: #f0f4f8;
    padding: 10px;
    text-align: center;
    border-radius: 8px;
}

.stat-item .stat-label {
    font-size: 11px;
    color: #64748b;
}

.stat-item .stat-number {
    font-size: 20px;
    font-weight: bold;
    color: #1e3a8a;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media print {
    .header, .control-panel, .action-buttons, .btn-print, .btn-pdf {
        display: none !important;
    }
    .report-container {
        box-shadow: none;
        padding: 0;
    }
}
</style>

<!-- MAIN CONTENT (بدون sidebar مكررة لأن القالب الرئيسي يحتوي عليها) -->
<div class="main-content">
    <div class="header">
        <div>
            <h1>📋 Administrative Reports</h1>
            <p>Generate, print and export clinic reports</p>
        </div>
        <div class="action-buttons">
            <button class="btn-print" onclick="printReport()">🖨️ Print Report</button>
            <button class="btn-pdf" onclick="exportToPDF()">📄 Export to PDF</button>
        </div>
    </div>

    <!-- CONTROL PANEL -->
    <div class="control-panel">
        <h3>⚙️ Report Configuration</h3>
        <div class="control-grid">
            <div class="input-group">
                <label>Clinic Name</label>
                <input type="text" id="clinicName" placeholder="Enter clinic name" value="{{ $clinicName ?? '' }}">
            </div>
            <div class="input-group">
                <label>City / State</label>
                <input type="text" id="clinicLocation" placeholder="Enter location" value="{{ $clinicLocation ?? '' }}">
            </div>
            <div class="input-group">
                <label>Report ID</label>
                <input type="text" id="reportId" placeholder="RPT-001" value="{{ $reportId ?? '' }}">
            </div>
            <div class="input-group">
                <label>Date</label>
                <input type="date" id="reportDate" value="{{ $reportDate ?? '' }}">
            </div>
            <div class="input-group">
                <label>Time</label>
                <input type="time" id="reportTime" value="{{ $reportTime ?? '' }}">
            </div>
        </div>
        <button class="btn-generate" onclick="updateReport()">📊 Generate Report</button>
    </div>

    <!-- REPORT CONTAINER -->
    <div class="report-container" id="reportContainer">
        <div class="report" id="reportContent">
            <!-- Report header -->
            <div class="report-header">
                <h1 id="displayClinicName">{{ $clinicName ?? 'HEALD CLINIC' }}</h1>
                <h2>Administrative Report</h2>
                <p id="displayLocation">📍 Address: {{ $clinicLocation ?? '---' }}</p>
            </div>

            <!-- Report info -->
            <div class="report-info">
                <span><strong>Report ID:</strong> <span id="displayReportId">{{ $reportId ?? '---' }}</span></span>
                <span><strong>Date:</strong> <span id="displayDate">{{ $reportDate ?? '---' }}</span></span>
                <span><strong>Time:</strong> <span id="displayTime">{{ $reportTime ?? '---' }}</span></span>
                <span><strong>Generated By:</strong> System Admin</span>
            </div>

            <!-- General Statistics -->
            <div class="report-section">
                <h3>1. General Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item"><div class="stat-label">Total Doctors</div><div class="stat-number" id="statDoctors">{{ $totalDoctors ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Active Doctors</div><div class="stat-number" id="statActiveDoctors">{{ $activeDoctors ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Total Patients</div><div class="stat-number" id="statPatients">{{ $totalPatients ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Active Patients</div><div class="stat-number" id="statActivePatients">{{ $activePatients ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Total Appointments</div><div class="stat-number" id="statAppointments">{{ $totalAppointments ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Pending</div><div class="stat-number" id="statPending">{{ $pendingAppointments ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Accepted</div><div class="stat-number" id="statAccepted">{{ $acceptedAppointments ?? 0 }}</div></div>
                    <div class="stat-item"><div class="stat-label">Total Revenue</div><div class="stat-number" id="statRevenue">{{ $totalRevenue ?? '€0' }}</div></div>
                </div>
            </div>

            <!-- Services Table -->
            <div class="report-section">
                <h3>2. Medical Services & Products</h3>
                <table class="report-table">
                    <thead>
                        <tr><th>Service Name</th><th>Type</th><th>Price</th><th>Description</th></tr>
                    </thead>
                    <tbody id="servicesBody">
                        @if(isset($services) && count($services) > 0)
                            @foreach($services as $service)
                            <tr>
                                <td>{{ $service['name'] }}</td>
                                <td>{{ $service['type'] }}</td>
                                <td>{{ $service['price'] }}</td>
                                <td>{{ $service['desc'] }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="4">No services found</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Recent Appointments -->
            <div class="report-section">
                <h3>3. Recent Appointments</h3>
                <table class="report-table">
                    <thead>
                        <tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Status</th></tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        @if(isset($recentAppointments) && count($recentAppointments) > 0)
                            @foreach($recentAppointments as $appointment)
                            <tr>
                                <td>{{ $appointment['patient_name'] }}</td>
                                <td>{{ $appointment['doctor_name'] }}</td>
                                <td>{{ $appointment['appointment_date'] }}</td>
                                <td>{{ $appointment['appointment_time'] }}</td>
                                <td>{{ $appointment['status'] }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5">No appointments found</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Daily Activity Log -->
            <div class="report-section">
                <h3>4. Daily Activity Log</h3>
                <table class="report-table">
                    <thead>
                        <tr><th>Time</th><th>Activity</th><th>Details</th></tr>
                    </thead>
                    <tbody id="activityBody">
                        <tr><td>09:00 AM</td><td>Clinic Opened</td><td>Daily operations started</td></tr>
                        <tr><td>10:30 AM</td><td>Patient Check-in</td><td>New patient registered</td></tr>
                        <tr><td>11:00 AM</td><td>Appointment</td><td>Consultation completed</td></tr>
                        <tr><td>02:00 PM</td><td>Report Generated</td><td>Daily administrative report</td></tr>
                        <tr><td>04:30 PM</td><td>Clinic Closing</td><td>End of daily operations</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Notes -->
            <div class="report-notes">
                <strong>📝 Notes & Observations:</strong>
                <p id="reportNotes">- Clinic activity is stable.<br>- Increase in consultation demand this month.<br>- All departments operating normally.</p>
            </div>

            <!-- Footer Signatures -->
            <div class="report-footer">
                <div class="signature-box">
                    <p>Administrator</p>
                    <div class="signature-line"></div>
                    <p>Signature & Date</p>
                </div>
                <div class="signature-box">
                    <p>Medical Director</p>
                    <div class="signature-line"></div>
                    <p>Signature & Date</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function updateReport() {
        const clinicName = document.getElementById("clinicName").value;
        const clinicLocation = document.getElementById("clinicLocation").value;
        const reportId = document.getElementById("reportId").value;
        const reportDate = document.getElementById("reportDate").value;
        const reportTime = document.getElementById("reportTime").value;
        
        const generateBtn = document.querySelector('.btn-generate');
        const originalText = generateBtn.innerHTML;
        generateBtn.innerHTML = '⏳ Loading...';
        generateBtn.disabled = true;
        
        try {
            const response = await fetch('{{ route("clinic.reports.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    clinic_name: clinicName,
                    clinic_location: clinicLocation,
                    report_id: reportId,
                    report_date: reportDate,
                    report_time: reportTime
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                const data = result.data;
                
                document.getElementById("displayClinicName").innerText = data.clinic_name || clinicName || "HEALD CLINIC";
                document.getElementById("displayLocation").innerHTML = `📍 Address: ${data.clinic_location || clinicLocation || "---"}`;
                document.getElementById("displayReportId").innerText = data.report_id || reportId || "RPT-" + new Date().getTime();
                document.getElementById("displayDate").innerText = data.report_date || reportDate || new Date().toLocaleDateString();
                document.getElementById("displayTime").innerText = data.report_time || reportTime || new Date().toLocaleTimeString();
                
                if (data.stats) {
                    document.getElementById("statDoctors").innerText = data.stats.total_doctors || 0;
                    document.getElementById("statActiveDoctors").innerText = data.stats.active_doctors || 0;
                    document.getElementById("statPatients").innerText = data.stats.total_patients || 0;
                    document.getElementById("statActivePatients").innerText = data.stats.active_patients || 0;
                    document.getElementById("statAppointments").innerText = data.stats.total_appointments || 0;
                    document.getElementById("statPending").innerText = data.stats.pending_appointments || 0;
                    document.getElementById("statAccepted").innerText = data.stats.accepted_appointments || 0;
                    document.getElementById("statRevenue").innerText = data.stats.total_revenue || '€0';
                }
                
                const servicesBody = document.getElementById("servicesBody");
                servicesBody.innerHTML = "";
                if (data.services && data.services.length > 0) {
                    data.services.forEach(service => {
                        servicesBody.innerHTML += `<tr><td>${escapeHtml(service.name)}</td><td>${escapeHtml(service.type)}</td><td>${escapeHtml(service.price)}</td><td>${escapeHtml(service.desc || service.description)}</td></tr>`;
                    });
                }
                
                const appointmentsBody = document.getElementById("appointmentsBody");
                appointmentsBody.innerHTML = "";
                if (data.recent_appointments && data.recent_appointments.length > 0) {
                    data.recent_appointments.forEach(app => {
                        appointmentsBody.innerHTML += `<tr><td>${escapeHtml(app.patient_name)}</td><td>${escapeHtml(app.doctor_name)}</td><td>${escapeHtml(app.date || app.appointment_date)}</td><td>${escapeHtml(app.time || app.appointment_time)}</td><td>${escapeHtml(app.status)}</td></tr>`;
                    });
                }
                
                if (data.notes) {
                    document.getElementById("reportNotes").innerHTML = data.notes;
                }
            } else {
                alert('Error: ' + (result.message || 'Could not generate report'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while generating the report');
        } finally {
            generateBtn.innerHTML = originalText;
            generateBtn.disabled = false;
        }
    }

    function printReport() {
        window.print();
    }

    async function exportToPDF() {
        const element = document.getElementById("reportContainer");
        try {
            await html2pdf().set({ margin: 0.5, filename: `clinic_report_${new Date().toISOString().split('T')[0]}.pdf`, image: { type: 'jpeg', quality: 0.98 }, html2canvas: { scale: 2 }, jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' } }).from(element).save();
        } catch (error) {
            alert("PDF generation failed. Trying print instead.");
            printReport();
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }

    function setDefaultDates() {
        const today = new Date().toISOString().split('T')[0];
        const now = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        if (!document.getElementById("reportDate").value) document.getElementById("reportDate").value = today;
        if (!document.getElementById("reportTime").value) document.getElementById("reportTime").value = now;
    }

    document.addEventListener('DOMContentLoaded', function() {
        setDefaultDates();
    });
</script>
@endsection