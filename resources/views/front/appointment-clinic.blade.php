@extends('layouts.front')

@section('title', 'Book Clinic Appointment')

@section('extra_styles')
<style>
    /* نفس الـ styles من appointment-clinic (3).html */
    .card{max-width:550px;margin:40px auto;}
    .info-box{background:rgba(255,255,255,0.08);border-radius:20px;padding:20px;margin-bottom:25px;}
    .payment-methods{display:flex;gap:15px;margin-top:10px;flex-wrap:wrap;}
    .payment-option{flex:1;padding:15px;border:1px solid rgba(255,255,255,0.25);border-radius:15px;cursor:pointer;text-align:center;}
    .payment-option.selected{border-color:#f59e0b;background:rgba(245,158,11,0.2);}
    .payment-details{background:rgba(245,158,11,0.15);border-left:4px solid #f59e0b;border-radius:15px;padding:15px;margin-top:15px;display:none;}
    .btn-book{width:100%;padding:14px;background:#f59e0b;color:white;border-radius:60px;margin-top:20px;}
    .btn-back{width:100%;padding:12px;background:rgba(255,255,255,0.2);color:white;border-radius:60px;margin-top:10px;}
</style>
@endsection

@section('content')
<div class="card">
    <div class="header"><h1>📅 Book Clinic Appointment</h1><p>Schedule your visit</p></div>
    <div class="content">
        <div class="info-box">
            <h3>🏥 Clinic Information</h3>
            <div class="info-row"><div class="info-label">Clinic:</div><div class="info-value">{{ $clinic->name }}</div></div>
            <div class="info-row"><div class="info-label">Address:</div><div class="info-value">{{ $clinic->address }}</div></div>
            <div class="info-row"><div class="info-label">Phone:</div><div class="info-value">{{ $clinic->phone }}</div></div>
        </div>
        <form method="POST" action="{{ route('appointment.clinic.store') }}">
            @csrf
            <input type="hidden" name="clinic_name" value="{{ $clinic->name }}">
            <div class="input-group"><label>👤 Your Full Name</label><input type="text" name="patient_name" required placeholder="Enter your full name"></div>
            <div class="input-group"><label>📞 Your Phone Number</label><input type="tel" name="patient_phone" required placeholder="+213 XX XXX XXXX"></div>
            <div class="input-group"><label>📅 Select Date</label><input type="date" name="appointment_date" required></div>
            <div class="input-group"><label>⏰ Select Time</label>
                <select name="appointment_time" required>
                    <option value="">-- Select a time --</option>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="02:00 PM">02:00 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="04:00 PM">04:00 PM</option>
                </select>
            </div>
            <div class="input-group">
                <label>💳 Payment Method</label>
                <div class="payment-methods">
                    <div class="payment-option" data-payment="cash" onclick="selectPayment('cash')"><span class="icon">💵</span><span class="title">Cash</span></div>
                    <div class="payment-option" data-payment="baridimob" onclick="selectPayment('baridimob')"><span class="icon">📱</span><span class="title">Baridi Mob</span></div>
                    <div class="payment-option" data-payment="eddahabia" onclick="selectPayment('eddahabia')"><span class="icon">💳</span><span class="title">Carte Eddahabia</span></div>
                </div>
                <div id="paymentDetails" class="payment-details"></div>
                <input type="hidden" name="payment_method" id="paymentMethodInput">
            </div>
            <button type="submit" class="btn-book">✅ Confirm Appointment</button>
            <button type="button" class="btn-back" onclick="history.back()">← Back to Clinic</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectPayment(payment) {
        document.querySelectorAll(".payment-option").forEach(opt => opt.classList.remove("selected"));
        document.querySelector(`.payment-option[data-payment="${payment}"]`).classList.add("selected");
        document.getElementById("paymentMethodInput").value = payment;
        var details = document.getElementById("paymentDetails");
        if(payment === "cash") details.innerHTML = '<h4>💵 Cash Payment</h4><p>You will pay the consultation fee directly at the clinic reception.</p>';
        else if(payment === "baridimob") details.innerHTML = '<h4>📱 Baridi Mob Payment</h4><p>Transfer the consultation fee via Baridi Mob:</p><div class="account-info">📌 Account Number: <strong>007 12345678 90</strong><br>📌 Beneficiary: <strong>MediEase Clinic Services</strong></div><p>⚠️ After payment, send the SMS receipt to: <strong>0555 00 00 00</strong></p>';
        else if(payment === "eddahabia") details.innerHTML = '<h4>💳 Carte Eddahabia Payment</h4><p>Pay using your gold card at the clinic terminal:</p><div class="account-info">📌 Terminal ID: <strong>EDH-MEDIEASE-001</strong><br>📌 Merchant: <strong>MediEase Medical Services</strong></div>';
        details.style.display = "block";
    }
</script>
@endsection