@extends('clinic.layouts.clinic')

@section('title', 'Medical Invoice | Smart Receipt')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .invoice-wrapper {
        font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 24px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Main Invoice Card */
    .invoice-card {
        max-width: 1100px;
        width: 100%;
        background: #ffffff;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .invoice-card:hover {
        transform: translateY(-5px);
    }

    /* Clinic Header - Premium Design */
    .clinic-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 32px 40px;
        color: white;
        position: relative;
    }

    .clinic-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.1;
    }

    .clinic-edit-area {
        position: relative;
        z-index: 1;
    }

    .clinic-name-input-group {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 12px 24px;
        border-radius: 60px;
        margin-bottom: 20px;
    }

    .clinic-name-input-group label {
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 1px;
        color: #FFE699;
    }

    .clinic-name-input-group input {
        background: white;
        border: none;
        padding: 12px 24px;
        border-radius: 40px;
        font-size: 18px;
        font-weight: 700;
        width: 320px;
        color: #1e3c72;
        transition: all 0.3s;
    }

    .clinic-name-input-group input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 230, 153, 0.5);
    }

    .contact-editable {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        background: rgba(255, 255, 255, 0.1);
        padding: 16px 20px;
        border-radius: 28px;
    }

    .contact-editable div {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(0, 0, 0, 0.2);
        padding: 8px 16px;
        border-radius: 40px;
    }

    .contact-editable span {
        font-size: 18px;
    }

    .contact-editable input {
        background: #fef9ef;
        border: none;
        padding: 8px 12px;
        border-radius: 30px;
        font-size: 13px;
        width: 100%;
        color: #1e3c72;
        font-weight: 500;
        transition: all 0.3s;
    }

    .contact-editable input:focus {
        outline: none;
        background: white;
        box-shadow: 0 0 0 2px #FFE699;
    }

    /* Invoice Body */
    .invoice-body {
        padding: 36px 40px;
        background: #ffffff;
    }

    /* Invoice Header */
    .invoice-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eef2f8;
    }

    .invoice-number {
        font-size: 20px;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 10px 24px;
        border-radius: 50px;
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .invoice-date {
        color: #6c7a89;
        font-size: 14px;
        font-weight: 500;
    }

    /* Section Titles */
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e3c72;
        border-left: 5px solid #667eea;
        padding-left: 16px;
        margin: 28px 0 20px 0;
    }

    .section-title:first-of-type {
        margin-top: 0;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        background: linear-gradient(135deg, #f8f9fc 0%, #f0f4fa 100%);
        padding: 24px 28px;
        border-radius: 24px;
        margin-bottom: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-item label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 800;
        color: #667eea;
    }

    .info-item input,
    .info-item select {
        background: white;
        border: 2px solid #e2edf2;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 500;
        color: #2d3e50;
        transition: all 0.3s;
        width: 100%;
    }

    .info-item input:focus,
    .info-item select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Appointment Row */
    .appointment-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        background: linear-gradient(135deg, #fff8f0 0%, #fff0e6 100%);
        padding: 24px 28px;
        border-radius: 24px;
        margin-bottom: 24px;
    }

    .appointment-field label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #e67e22;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .appointment-field input,
    .appointment-field select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #f0e0cc;
        border-radius: 16px;
        font-size: 14px;
        background: white;
        transition: all 0.3s;
    }

    .appointment-field input:focus,
    .appointment-field select:focus {
        outline: none;
        border-color: #e67e22;
        box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
    }

    /* Services Table */
    .services-table {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .service-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 20px 28px;
        border-bottom: 1px solid #eef2f8;
        transition: background 0.3s;
    }

    .service-row:hover {
        background: #f8fafc;
    }

    .service-row:last-child {
        border-bottom: none;
    }

    .service-name {
        font-weight: 700;
        font-size: 16px;
        color: #2d3e50;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .service-price {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .service-price input {
        width: 160px;
        padding: 10px 16px;
        border-radius: 40px;
        border: 2px solid #e2edf2;
        text-align: right;
        font-weight: 600;
        font-size: 15px;
        background: white;
        transition: all 0.3s;
    }

    .service-price input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .service-price span {
        font-weight: 700;
        color: #27ae60;
        font-size: 14px;
    }

    /* Total Section */
    .total-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 24px 32px;
        margin: 24px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        color: white;
    }

    .total-label {
        font-size: 22px;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .total-amount {
        font-size: 36px;
        font-weight: 800;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 12px 32px;
        border-radius: 60px;
        letter-spacing: 2px;
    }

    /* Payment Method */
    .payment-method-simple {
        background: #f0f4fa;
        padding: 16px 24px;
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin: 20px 0;
    }

    .payment-method-simple label {
        font-weight: 700;
        color: #2d3e50;
    }

    .payment-method-simple select {
        padding: 10px 20px;
        border-radius: 40px;
        border: 2px solid #dce5ef;
        background: white;
        font-weight: 500;
        cursor: pointer;
    }

    /* Button Group */
    .button-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #eef2f9;
        border: 2px solid #cbdde9;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 600;
        color: #2c5a6e;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-print {
        background: #27ae60;
        border: none;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 700;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-print:hover {
        background: #219a52;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: #f9f5f0;
        border: 2px solid #d4c5b2;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-outline:hover {
        background: #ede5d8;
        transform: translateY(-2px);
    }

    /* Receipt Preview */
    .receipt-preview {
        margin-top: 28px;
        background: linear-gradient(135deg, #fef9ef 0%, #fff6e8 100%);
        border-radius: 24px;
        padding: 24px;
        border-left: 6px solid #667eea;
        display: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .receipt-preview.show {
        display: block;
        animation: slideUp 0.4s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .receipt-preview pre {
        font-family: 'Courier New', monospace;
        white-space: pre-wrap;
        background: white;
        padding: 20px;
        border-radius: 16px;
        font-size: 13px;
        line-height: 1.6;
        margin: 0;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
    }

    /* Print Styles */
    @media print {
        .invoice-wrapper {
            background: white;
            padding: 0;
        }
        .invoice-card {
            box-shadow: none;
            border-radius: 0;
        }
        .button-group,
        .btn-outline,
        .btn-secondary,
        .btn-primary,
        .btn-print,
        .payment-method-simple select,
        .contact-editable input,
        .clinic-name-input-group input,
        .info-item input,
        .info-item select,
        .appointment-field input,
        .appointment-field select,
        .service-price input {
            display: none !important;
        }
        .receipt-preview {
            display: block !important;
            background: white;
            border: 2px solid #ddd;
            box-shadow: none;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .invoice-wrapper {
            padding: 20px 16px;
        }
        .invoice-body {
            padding: 24px 20px;
        }
        .clinic-header {
            padding: 24px 20px;
        }
        .clinic-name-input-group {
            flex-direction: column;
            align-items: stretch;
        }
        .clinic-name-input-group input {
            width: 100%;
        }
        .contact-editable {
            grid-template-columns: 1fr;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .appointment-row {
            grid-template-columns: 1fr;
        }
        .service-row {
            flex-direction: column;
            gap: 12px;
            text-align: center;
        }
        .total-section {
            flex-direction: column;
            text-align: center;
        }
        .total-amount {
            font-size: 28px;
        }
        .button-group {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="invoice-wrapper">
    <div class="invoice-card">
        <!-- Clinic Header -->
        <div class="clinic-header">
            <div class="clinic-edit-area">
                <div class="clinic-name-input-group">
                    <label>🏥 CLINIC NAME</label>
                    <input type="text" id="clinicNameEdit" value="Mediease Premium " placeholder="Clinic Name">
                </div>
                <div class="contact-editable">
                    <div><span>📍</span> <input type="text" id="clinicAddressEdit" value="15 Medical District, Downtown, City Central" placeholder="Address"></div>
                    <div><span>📞</span> <input type="text" id="clinicPhoneEdit" value="+213 550 12 34 56" placeholder="Phone"></div>
                    <div><span>✉️</span> <input type="text" id="clinicEmailEdit" value="contact@healdclinic.com" placeholder="Email"></div>
                    <div><span>🕒</span> <input type="text" id="clinicHoursEdit" value="Mon - Sat: 8:30 AM – 7:00 PM" placeholder="Hours"></div>
                </div>
            </div>
        </div>

        <div class="invoice-body">
            <!-- Invoice Header -->
            <div class="invoice-header-row">
                <div class="invoice-number">
                    🧾 INVOICE # <span id="invoiceNumberDisplay">INV-0001</span>
                </div>
                <div class="invoice-date">
                    📅 {{ date('F d, Y') }}
                </div>
            </div>

            <!-- Patient & Doctor Details -->
            <div class="section-title">📋 PATIENT & DOCTOR DETAILS</div>
            <div class="info-grid">
                <div class="info-item">
                    <label>FULL NAME (PATIENT)</label>
                    <input type="text" id="fullName" placeholder="Enter patient name">
                </div>
                <div class="info-item">
                    <label>PHONE NUMBER</label>
                    <input type="tel" id="phoneNumber" placeholder="+213 XX XXX XXXX">
                </div>
                <div class="info-item">
                    <label>👨‍⚕️ DOCTOR NAME</label>
                    <select id="doctorName">
                        <option value="Dr. Nadia Benali - General Medicine">Dr. Nadia Benali - General Medicine</option>
                        <option value="Dr. Karim Mansouri - Cardiology">Dr. Karim Mansouri - Cardiology</option>
                        <option value="Dr. Leila Hamdi - Pediatrics">Dr. Leila Hamdi - Pediatrics</option>
                        <option value="Dr. Samir Khelifa - Dermatology">Dr. Samir Khelifa - Dermatology</option>
                    </select>
                </div>
                <div class="info-item">
                    <label>🆔 PATIENT ID</label>
                    <input type="text" id="patientId" placeholder="Reference / ID">
                </div>
            </div>

            <!-- Appointment Slot -->
            <div class="section-title">📅 APPOINTMENT SLOT</div>
            <div class="appointment-row">
                <div class="appointment-field">
                    <label>📆 DATE</label>
                    <input type="date" id="appointmentDate" value="{{ date('Y-m-d') }}">
                </div>
                <div class="appointment-field">
                    <label>⏰ TIME</label>
                    <select id="appointmentTime">
                        <option value="09:00 AM">09:00 AM</option>
                        <option value="10:30 AM" selected>10:30 AM</option>
                        <option value="01:00 PM">01:00 PM</option>
                        <option value="03:15 PM">03:15 PM</option>
                        <option value="05:00 PM">05:00 PM</option>
                    </select>
                </div>
                <div class="appointment-field">
                    <label>🏷️ CONSULTATION TYPE</label>
                    <input type="text" id="consultType" value="Specialized Consultation" placeholder="Consultation type">
                </div>
            </div>

            <!-- Services & Fees -->
            <div class="section-title">💰 SERVICES & FEES</div>
            <div class="services-table">
                <div class="service-row">
                    <div class="service-name">🩺 Consultation Fee</div>
                    <div class="service-price">
                        <input type="number" id="examFee" value="2500" step="100"> <span>DZD</span>
                    </div>
                </div>
                <div class="service-row">
                    <div class="service-name">🧪 Laboratory Tests</div>
                    <div class="service-price">
                        <input type="number" id="labFee" value="1800" step="100"> <span>DZD</span>
                    </div>
                </div>
                <div class="service-row">
                    <div class="service-name">💊 Additional Services</div>
                    <div class="service-price">
                        <input type="number" id="extraFee" value="0" step="100"> <span>DZD</span>
                    </div>
                </div>
            </div>

            <!-- Total Section -->
            <div class="total-section">
                <div class="total-label">
                    💵 TOTAL AMOUNT DUE
                </div>
                <div class="total-amount" id="totalDueDisplay">0 DZD</div>
            </div>

            <!-- Payment Method -->
            <div class="payment-method-simple">
                <label>💳 PAYMENT METHOD</label>
                <select id="paymentSelect">
                    <option value="Cash">💵 Cash</option>
                    <option value="Baridi Mob">📱 Baridi Mob</option>
                    <option value="Eddahabia Card">💳 Carte Eddahabia</option>
                    <option value="Visa/Mastercard">🌐 Credit Card</option>
                </select>
                <span style="font-size: 12px; color: #27ae60;">✓ Secure Transaction</span>
            </div>

            <!-- Buttons -->
            <div class="button-group">
                <button class="btn-primary" id="confirmInvoiceBtn">
                    ✅ CONFIRM INVOICE
                </button>
                <button class="btn-print" id="printInvoiceBtn">
                    🖨️ PRINT INVOICE
                </button>
                <button class="btn-secondary" id="resetBtn">
                    ⟳ RESET FIELDS
                </button>
                <button class="btn-outline" id="backToClinicBtn">
                    ← BACK TO DASHBOARD
                </button>
            </div>

            <!-- Receipt Preview -->
            <div id="receiptPreview" class="receipt-preview"></div>
        </div>
    </div>
</div>

<script>
    // تعريف المتغيرات الأساسية - بدون localStorage
    let currentInvoiceId = null;

    // تحديث رقم الفاتورة (من قاعدة البيانات)
    async function fetchInvoiceNumber() {
        try {
            const response = await fetch('{{ route("clinic.invoices.generate-number") }}');
            const data = await response.json();
            if (data.success) {
                document.getElementById("invoiceNumberDisplay").innerText = data.invoice_number;
                return data.invoice_number;
            }
        } catch (error) {
            console.error('Error fetching invoice number:', error);
        }
        // Fallback
        return 'INV-' + new Date().getTime();
    }

    // حساب المجموع
    function computeTotal() {
        let exam = parseFloat(document.getElementById('examFee').value) || 0;
        let lab = parseFloat(document.getElementById('labFee').value) || 0;
        let extra = parseFloat(document.getElementById('extraFee').value) || 0;
        let total = exam + lab + extra;
        document.getElementById("totalDueDisplay").innerText = total.toLocaleString() + " DZD";
        return total;
    }

    // جلب بيانات العيادة
    function getClinicData() {
        return {
            name: document.getElementById("clinicNameEdit").value.trim() || "HealD Clinic",
            address: document.getElementById("clinicAddressEdit").value.trim() || "Medical District",
            phone: document.getElementById("clinicPhoneEdit").value.trim() || "+213 550 00 00",
            email: document.getElementById("clinicEmailEdit").value.trim() || "contact@clinic.com",
            hours: document.getElementById("clinicHoursEdit").value.trim() || "Mon-Sat"
        };
    }

    // حفظ الفاتورة في قاعدة البيانات
    async function saveInvoiceToDatabase() {
        const clinic = getClinicData();
        const invoiceNum = document.getElementById("invoiceNumberDisplay").innerText;
        const patientName = document.getElementById("fullName").value.trim();
        const patientPhone = document.getElementById("phoneNumber").value.trim();
        const doctor = document.getElementById("doctorName").value;
        const patientId = document.getElementById("patientId").value.trim();
        const appointDate = document.getElementById("appointmentDate").value;
        const appointTime = document.getElementById("appointmentTime").value;
        const consultType = document.getElementById("consultType").value.trim();
        const examFee = parseFloat(document.getElementById('examFee').value) || 0;
        const labFee = parseFloat(document.getElementById('labFee').value) || 0;
        const extraFee = parseFloat(document.getElementById('extraFee').value) || 0;
        const totalDue = examFee + labFee + extraFee;
        const paymentMethod = document.getElementById("paymentSelect").value;

        const data = {
            invoice_number: invoiceNum,
            patient_name: patientName,
            patient_phone: patientPhone,
            patient_id_ref: patientId,
            doctor_name: doctor,
            appointment_date: appointDate,
            appointment_time: appointTime,
            consultation_type: consultType,
            consultation_fee: examFee,
            lab_fee: labFee,
            extra_fee: extraFee,
            total_amount: totalDue,
            payment_method: paymentMethod,
            payment_status: 'pending',
            clinic_name: clinic.name,
            clinic_address: clinic.address,
            clinic_phone: clinic.phone,
            clinic_email: clinic.email
        };

        try {
            const response = await fetch('{{ route("clinic.invoices.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.success) {
                currentInvoiceId = result.data.id;
                return true;
            } else {
                console.error('Validation errors:', result.errors);
                return false;
            }
        } catch (error) {
            console.error('Error saving invoice:', error);
            return false;
        }
    }

    // إنشاء نص الفاتورة
    function generateInvoiceText() {
        const clinic = getClinicData();
        const invoiceNum = document.getElementById("invoiceNumberDisplay").innerText;
        const patientName = document.getElementById("fullName").value.trim() || "Anonymous";
        const patientPhone = document.getElementById("phoneNumber").value.trim() || "—";
        const doctor = document.getElementById("doctorName").options[document.getElementById("doctorName").selectedIndex]?.text || "General Physician";
        const patientRef = document.getElementById("patientId").value.trim() || "—";
        const appointDate = document.getElementById("appointmentDate").value;
        const appointTime = document.getElementById("appointmentTime").value;
        const consultType = document.getElementById("consultType").value.trim() || "Standard";
        const examFee = parseFloat(document.getElementById('examFee').value) || 0;
        const labFee = parseFloat(document.getElementById('labFee').value) || 0;
        const extraFee = parseFloat(document.getElementById('extraFee').value) || 0;
        const totalDue = examFee + labFee + extraFee;
        const payment = document.getElementById("paymentSelect").options[document.getElementById("paymentSelect").selectedIndex]?.text || "Cash";

        let formattedDate = appointDate;
        if (appointDate) {
            const d = new Date(appointDate);
            if (!isNaN(d.getTime())) formattedDate = d.toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        const currentDate = new Date().toLocaleDateString('en-GB', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });

        return `═══════════════════════════════════════════════════════════
                    🏥 MEDICAL INVOICE
═══════════════════════════════════════════════════════════

🏥 ${clinic.name}
📍 ${clinic.address}
📞 ${clinic.phone}  ✉️ ${clinic.email}
🕒 ${clinic.hours}

───────────────────────────────────────────────────────────
🧾 INVOICE NUMBER    : ${invoiceNum}
📅 ISSUE DATE        : ${currentDate}
───────────────────────────────────────────────────────────

👤 PATIENT INFORMATION:
   • Name        : ${patientName}
   • ID/Ref      : ${patientRef}
   • Phone       : ${patientPhone}

👨‍⚕️ DOCTOR INFORMATION:
   • Doctor      : ${doctor}
   • Date        : ${formattedDate}
   • Time        : ${appointTime}
   • Type        : ${consultType}

───────────────────────────────────────────────────────────
💰 CHARGES BREAKDOWN:
───────────────────────────────────────────────────────────
   🩺 Consultation Fee     : ${examFee.toLocaleString()} DZD
   🧪 Laboratory Tests     : ${labFee.toLocaleString()} DZD
   💊 Extra Services       : ${extraFee.toLocaleString()} DZD
───────────────────────────────────────────────────────────
   💵 TOTAL AMOUNT         : ${totalDue.toLocaleString()} DZD
───────────────────────────────────────────────────────────

💳 PAYMENT METHOD        : ${payment}
✅ PAYMENT STATUS        : Pending

═══════════════════════════════════════════════════════════
   Thank you for choosing ${clinic.name}
   This is a computer-generated invoice.
═══════════════════════════════════════════════════════════`;
    }

    // عرض الفاتورة
    async function displayInvoicePreview() {
        const invoiceText = generateInvoiceText();
        const previewDiv = document.getElementById("receiptPreview");
        previewDiv.innerHTML = `<pre style="font-family: 'Courier New', monospace; white-space: pre-wrap; background: white; padding: 24px; border-radius: 16px; font-size: 13px; line-height: 1.6; margin:0; box-shadow: inset 0 0 10px rgba(0,0,0,0.05);">${invoiceText}</pre>
        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 16px;">
            <button id="closeReceiptBtn" style="background: #e74c3c; border: none; padding: 10px 24px; border-radius: 40px; color: white; font-weight: 700; cursor: pointer;">✖ CLOSE</button>
            <button id="printPreviewBtn" style="background: #27ae60; border: none; padding: 10px 24px; border-radius: 40px; color: white; font-weight: 700; cursor: pointer;">🖨️ PRINT</button>
        </div>`;
        previewDiv.classList.add("show");
        
        document.getElementById("closeReceiptBtn").onclick = () => {
            previewDiv.classList.remove("show");
        };
        
        document.getElementById("printPreviewBtn").onclick = () => {
            printInvoiceDirectly();
        };
    }

    // طباعة الفاتورة
    function printInvoiceDirectly() {
        const invoiceText = generateInvoiceText();
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Medical Invoice</title>
                <style>
                    body {
                        font-family: 'Courier New', monospace;
                        padding: 40px;
                        max-width: 800px;
                        margin: 0 auto;
                    }
                    pre {
                        font-family: 'Courier New', monospace;
                        white-space: pre-wrap;
                        font-size: 13px;
                        line-height: 1.6;
                    }
                </style>
            </head>
            <body>
                <pre>${invoiceText}</pre>
                <script>window.print();<\/script>
            </body>
            </html>
        `);
        printWindow.document.close();
    }

    // تأكيد وحفظ الفاتورة
    async function confirmAndShowInvoice() {
        const name = document.getElementById("fullName").value.trim();
        const phone = document.getElementById("phoneNumber").value.trim();
        const date = document.getElementById("appointmentDate").value;
        
        if (!name) {
            showToast("❌ Please enter patient name", "error");
            return;
        }
        if (!phone) {
            showToast("❌ Please enter phone number", "error");
            return;
        }
        if (!date) {
            showToast("❌ Please select appointment date", "error");
            return;
        }
        
        const total = computeTotal();
        if (total === 0 && !confirm("⚠️ Total due is 0 DZD. Continue?")) return;
        
        showToast("⏳ Saving invoice...", "info");
        
        const saved = await saveInvoiceToDatabase();
        if (saved) {
            await displayInvoicePreview();
            await fetchInvoiceNumber();
            showToast("✅ Invoice saved successfully!", "success");
        } else {
            showToast("⚠️ Warning: Could not save invoice to database", "error");
            displayInvoicePreview();
        }
    }

    // إعادة تعيين الحقول
    function resetAllFields() {
        document.getElementById("fullName").value = "";
        document.getElementById("phoneNumber").value = "";
        document.getElementById("patientId").value = "";
        document.getElementById("doctorName").selectedIndex = 0;
        document.getElementById("appointmentDate").value = "{{ date('Y-m-d') }}";
        document.getElementById("appointmentTime").selectedIndex = 1;
        document.getElementById("consultType").value = "General Consultation";
        document.getElementById("examFee").value = "2500";
        document.getElementById("labFee").value = "1800";
        document.getElementById("extraFee").value = "0";
        document.getElementById("paymentSelect").selectedIndex = 0;
        computeTotal();
        document.getElementById("receiptPreview").classList.remove("show");
        showToast("⟳ Form reset successfully", "info");
    }

    // عرض إشعار
    function showToast(message, type = "info") {
        const toast = document.createElement("div");
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${type === "success" ? "#27ae60" : type === "error" ? "#e74c3c" : "#3498db"};
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            z-index: 9999;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            animation: slideIn 0.3s ease;
        `;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // العودة إلى لوحة التحكم
    function goBackToClinic() {
        window.location.href = "{{ route('clinic.dashboard') }}";
    }

    // إضافة أنماط للـ toast
    const style = document.createElement('style');
    style.textContent = `
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
    `;
    document.head.appendChild(style);

    // تهيئة الصفحة
    document.addEventListener('DOMContentLoaded', async () => {
        await fetchInvoiceNumber();
        computeTotal();
        
        document.getElementById('examFee').addEventListener('input', computeTotal);
        document.getElementById('labFee').addEventListener('input', computeTotal);
        document.getElementById('extraFee').addEventListener('input', computeTotal);
        document.getElementById('confirmInvoiceBtn').addEventListener('click', confirmAndShowInvoice);
        document.getElementById('printInvoiceBtn').addEventListener('click', () => {
            if (document.getElementById("fullName").value.trim() === "") {
                showToast("❌ Please fill patient details first", "error");
            } else {
                printInvoiceDirectly();
            }
        });
        document.getElementById('resetBtn').addEventListener('click', resetAllFields);
        document.getElementById('backToClinicBtn').addEventListener('click', goBackToClinic);
    });
</script>
@endsection