


<?php $__env->startSection('title', 'Reports'); ?>

<?php $__env->startSection('content'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<style>
    /* ========== MAIN CONTENT ========== */
    .reports-wrapper {
        padding: 0;
    }
    
    /* ========== HEADER ========== */
    .header-section {
        background: white;
        padding: 20px 25px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
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
    
    .action-buttons {
        display: flex;
        gap: 12px;
    }
    
    .btn-print, .btn-pdf {
        padding: 10px 24px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-print {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }
    
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }
    
    .btn-pdf {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .btn-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
    }
    
    /* ========== CONTROL PANEL ========== */
    .control-panel {
        background: white;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    .control-panel h3 {
        color: #1e293b;
        font-size: 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 2px solid #eef2ff;
    }
    
    .control-panel h3 i {
        color: #6366f1;
    }
    
    .control-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .input-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .input-group label {
        font-weight: 600;
        color: #1e293b;
        font-size: 13px;
    }
    
    .input-group input {
        padding: 10px 14px;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        outline: none;
        transition: all 0.2s;
    }
    
    .input-group input:focus {
        border-color: #6366f1;
    }
    
    .btn-generate {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: 600;
        margin-top: 20px;
        width: 100%;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    }
    
    /* ========== REPORT CONTAINER ========== */
    .report-container {
        background: white;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #f1f5f9;
    }
    
    /* Report Styles */
    .report {
        background: white;
        font-family: 'Times New Roman', 'Inter', serif;
        color: #1e293b;
        line-height: 1.5;
    }
    
    .report-header {
        text-align: center;
        border-bottom: 3px solid #6366f1;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }
    
    .report-header h1 {
        font-size: 28px;
        color: #1e293b;
        margin: 5px 0;
    }
    
    .report-header h2 {
        font-size: 20px;
        color: #6366f1;
        margin: 5px 0;
    }
    
    .report-header p {
        font-size: 13px;
        color: #64748b;
    }
    
    .report-info {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 25px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 16px;
        font-size: 13px;
    }
    
    .report-info span {
        color: #1e293b;
    }
    
    .report-info strong {
        color: #6366f1;
    }
    
    .report-section {
        margin-top: 25px;
    }
    
    .report-section h3 {
        font-size: 18px;
        border-left: 4px solid #6366f1;
        padding-left: 12px;
        margin-bottom: 15px;
        color: #1e293b;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .stat-item {
        background: #f8fafc;
        padding: 15px;
        text-align: center;
        border-radius: 16px;
        transition: all 0.2s;
    }
    
    .stat-item:hover {
        background: #eef2ff;
        transform: translateY(-2px);
    }
    
    .stat-item .stat-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 5px;
    }
    
    .stat-item .stat-number {
        font-size: 24px;
        font-weight: 800;
        color: #6366f1;
    }
    
    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 13px;
    }
    
    .report-table th {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        padding: 12px;
        font-weight: 600;
    }
    
    .report-table td {
        border: 1px solid #e2e8f0;
        padding: 10px;
    }
    
    .report-table tr:nth-child(even) {
        background: #f8fafc;
    }
    
    .report-table tr:hover {
        background: #eef2ff;
    }
    
    .report-notes {
        margin-top: 25px;
        border: 1px solid #e2e8f0;
        padding: 15px;
        background: #f8fafc;
        border-radius: 16px;
        font-size: 13px;
    }
    
    .report-notes strong {
        color: #6366f1;
    }
    
    .report-footer {
        margin-top: 35px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .signature-box {
        text-align: center;
        margin-top: 20px;
    }
    
    .signature-box p {
        margin: 5px 0;
        font-size: 12px;
        color: #64748b;
    }
    
    .signature-line {
        width: 200px;
        border-top: 1px solid #1e293b;
        margin: 10px auto;
    }
    
    /* RTL Support */
    body.rtl .report-section h3 {
        border-left: none;
        border-right: 4px solid #6366f1;
        padding-left: 0;
        padding-right: 12px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .control-grid {
            grid-template-columns: 1fr;
        }
        
        .report-info {
            flex-direction: column;
        }
        
        .action-buttons {
            width: 100%;
            justify-content: center;
        }
        
        .report-footer {
            flex-direction: column;
            align-items: center;
        }
    }
    
    @media print {
        .header-section, .control-panel, .action-buttons, .btn-print, .btn-pdf {
            display: none !important;
        }
        .report-container {
            box-shadow: none;
            padding: 0;
            border: none;
        }
        .report {
            margin: 0;
            padding: 0;
        }
    }
</style>

<div class="reports-wrapper">
    <!-- HEADER SECTION -->
    <div class="header-section">
        <div>
            <h1><i class="fas fa-chart-bar"></i> Administrative Reports</h1>
            <p>Generate, print and export comprehensive clinic reports</p>
        </div>
        <div class="action-buttons">
            <button class="btn-print" onclick="printReport()">
                <i class="fas fa-print"></i> Print Report
            </button>
            <button class="btn-pdf" onclick="exportToPDF()">
                <i class="fas fa-file-pdf"></i> Export to PDF
            </button>
        </div>
    </div>

    <!-- CONTROL PANEL -->
    <div class="control-panel">
        <h3><i class="fas fa-sliders-h"></i> Report Configuration</h3>
        <div class="control-grid">
            <div class="input-group">
                <label>Clinic Name</label>
                <input type="text" id="clinicName" placeholder="Enter clinic name" value="<?php echo e($clinicName ?? ''); ?>">
            </div>
            <div class="input-group">
                <label>City / State</label>
                <input type="text" id="clinicLocation" placeholder="Enter location" value="<?php echo e($clinicLocation ?? ''); ?>">
            </div>
            <div class="input-group">
                <label>Report ID</label>
                <input type="text" id="reportId" placeholder="RPT-001" value="<?php echo e($reportId ?? ''); ?>">
            </div>
            <div class="input-group">
                <label>Date</label>
                <input type="date" id="reportDate" value="<?php echo e($reportDate ?? ''); ?>">
            </div>
            <div class="input-group">
                <label>Time</label>
                <input type="time" id="reportTime" value="<?php echo e($reportTime ?? ''); ?>">
            </div>
        </div>
        <button class="btn-generate" onclick="updateReport()">
            <i class="fas fa-sync-alt"></i> Generate Report
        </button>
    </div>

    <!-- REPORT CONTAINER -->
    <div class="report-container" id="reportContainer">
        <div class="report" id="reportContent">
            <!-- Report header -->
            <div class="report-header">
                <h1 id="displayClinicName"><?php echo e($clinicName ?? 'HEALD CLINIC'); ?></h1>
                <h2>Administrative Report</h2>
                <p id="displayLocation">📍 Address: <?php echo e($clinicLocation ?? '---'); ?></p>
            </div>

            <!-- Report info -->
            <div class="report-info">
                <span><strong>📄 Report ID:</strong> <span id="displayReportId"><?php echo e($reportId ?? '---'); ?></span></span>
                <span><strong>📅 Date:</strong> <span id="displayDate"><?php echo e($reportDate ?? '---'); ?></span></span>
                <span><strong>⏰ Time:</strong> <span id="displayTime"><?php echo e($reportTime ?? '---'); ?></span></span>
                <span><strong>👤 Generated By:</strong> System Admin</span>
            </div>

            <!-- General Statistics -->
            <div class="report-section">
                <h3>1. General Statistics</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-label">Total Doctors</div>
                        <div class="stat-number" id="statDoctors"><?php echo e($totalDoctors ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Active Doctors</div>
                        <div class="stat-number" id="statActiveDoctors"><?php echo e($activeDoctors ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Total Patients</div>
                        <div class="stat-number" id="statPatients"><?php echo e($totalPatients ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Active Patients</div>
                        <div class="stat-number" id="statActivePatients"><?php echo e($activePatients ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Total Appointments</div>
                        <div class="stat-number" id="statAppointments"><?php echo e($totalAppointments ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Pending</div>
                        <div class="stat-number" id="statPending"><?php echo e($pendingAppointments ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Accepted</div>
                        <div class="stat-number" id="statAccepted"><?php echo e($acceptedAppointments ?? 0); ?></div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-label">Total Revenue</div>
                        <div class="stat-number" id="statRevenue"><?php echo e($totalRevenue ?? '€0'); ?></div>
                    </div>
                </div>
            </div>

            <!-- Services Table -->
            <div class="report-section">
                <h3>2. Medical Services & Products</h3>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody id="servicesBody">
                        <?php if(isset($services) && count($services) > 0): ?>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($service['name']); ?></td>
                                <td><?php echo e($service['type']); ?></td>
                                <td><?php echo e($service['price']); ?></td>
                                <td><?php echo e($service['desc']); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center;">No services found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Recent Appointments -->
            <div class="report-section">
                <h3>3. Recent Appointments</h3>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentsBody">
                        <?php if(isset($recentAppointments) && count($recentAppointments) > 0): ?>
                            <?php $__currentLoopData = $recentAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($appointment['patient_name']); ?></td>
                                <td><?php echo e($appointment['doctor_name']); ?></td>
                                <td><?php echo e($appointment['appointment_date']); ?></td>
                                <td><?php echo e($appointment['appointment_time']); ?></td>
                                <td><?php echo e($appointment['status']); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center;">No appointments found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Daily Activity Log -->
            <div class="report-section">
                <h3>4. Daily Activity Log</h3>
                <table class="report-table">
                    <thead>
                        <table>
                            <th>Time</th>
                            <th>Activity</th>
                            <th>Details</th>
                        </tr>
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
                <strong><i class="fas fa-pencil-alt"></i> Notes & Observations:</strong>
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
        generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        generateBtn.disabled = true;
        
        try {
            const response = await fetch('<?php echo e(route("clinic.reports.generate")); ?>', {
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
                        servicesBody.innerHTML += `<tr>
                            <td>${escapeHtml(service.name)}</td>
                            <td>${escapeHtml(service.type)}</td>
                            <td>${escapeHtml(service.price)}</td>
                            <td>${escapeHtml(service.desc || service.description)}</td>
                        </tr>`;
                    });
                }
                
                const appointmentsBody = document.getElementById("appointmentsBody");
                appointmentsBody.innerHTML = "";
                if (data.recent_appointments && data.recent_appointments.length > 0) {
                    data.recent_appointments.forEach(app => {
                        appointmentsBody.innerHTML += `<tr>
                            <td>${escapeHtml(app.patient_name)}</td>
                            <td>${escapeHtml(app.doctor_name)}</td>
                            <td>${escapeHtml(app.date || app.appointment_date)}</td>
                            <td>${escapeHtml(app.time || app.appointment_time)}</td>
                            <td>${escapeHtml(app.status)}</td>
                        </tr>`;
                    });
                }
                
                if (data.notes) {
                    document.getElementById("reportNotes").innerHTML = data.notes;
                }
                
                showToast('Report generated successfully!');
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
        toast.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
        toastContainer.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function printReport() {
        window.print();
    }

    async function exportToPDF() {
        const element = document.getElementById("reportContainer");
        try {
            await html2pdf().set({ 
                margin: 0.5, 
                filename: `clinic_report_${new Date().toISOString().split('T')[0]}.pdf`, 
                image: { type: 'jpeg', quality: 0.98 }, 
                html2canvas: { scale: 2 }, 
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' } 
            }).from(element).save();
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('clinic.layouts.clinic', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heald-clinic\resources\views/clinic/reports/index.blade.php ENDPATH**/ ?>