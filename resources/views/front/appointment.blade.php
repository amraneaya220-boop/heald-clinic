@extends('layouts.front')

@section('title', 'Book Appointment')

@section('extra_styles')
<style>
    /* نفس الـ styles من appointment (7).html */
    .container{max-width:550px;margin:40px auto;padding:0 20px;}
    .appointment-card{background:rgba(255,255,255,0.1);backdrop-filter:blur(15px);border-radius:35px;padding:40px 30px;}
    .header{text-align:center;margin-bottom:30px;}
    .header h1{color:white;font-size:32px;}
    .info-box{background:rgba(255,255,255,0.08);border-radius:20px;padding:20px;margin-bottom:25px;}
    .info-row{display:flex;padding:10px 0;}
    .info-label{font-weight:600;width:100px;color:rgba(255,255,255,0.8);}
    .info-value{color:white;flex:1;}
    .input-group{margin-bottom:20px;}
    .input-group label{color:white;display:block;margin-bottom:8px;}
    .input-group input,.input-group select{width:100%;padding:14px;border:none;border-radius:15px;background:rgba(255,255,255,0.9);}
    .button-group{display:flex;gap:15px;margin-top:25px;}
    .btn-back,.btn-confirm{flex:1;padding:15px;border-radius:60px;font-weight:600;cursor:pointer;}
    .btn-back{background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.3);}
    .btn-confirm{background:#f59e0b;color:white;border:none;}
</style>
@endsection

@section('content')
<div class="container">
    <div class="appointment-card">
        <div class="header">
            <h1>📅 Book Appointment</h1>
            <p>Schedule your medical visit</p>
        </div>
        <div class="info-box">
            <h3>🏥 Appointment Details</h3>
            <div class="info-row"><div class="info-label">Doctor:</div><div class="info-value">{{ $doctor->name }}</div></div>
            <div class="info-row"><div class="info-label">Specialty:</div><div class="info-value">{{ $doctor->specialty }}</div></div>
            <div class="info-row"><div class="info-label">Clinic:</div><div class="info-value">{{ $doctor->clinic->name ?? '' }}</div></div>
            <div class="info-row"><div class="info-label">Fee:</div><div class="info-value">{{ $doctor->consultation_fee ?? '2500 DZD' }}</div></div>
        </div>
        <form method="POST" action="{{ route('appointment.store') }}">
            @csrf
            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
            <div class="input-group">
                <label>📅 Select Date</label>
                <input type="date" name="appointment_date" required>
            </div>
            <div class="input-group">
                <label>⏰ Select Time</label>
                <select name="appointment_time" required>
                    <option value="">Select time</option>
                    <option value="09:00 AM">09:00 AM</option>
                    <option value="10:00 AM">10:00 AM</option>
                    <option value="11:00 AM">11:00 AM</option>
                    <option value="02:00 PM">02:00 PM</option>
                    <option value="03:00 PM">03:00 PM</option>
                    <option value="04:00 PM">04:00 PM</option>
                </select>
            </div>
            <div class="input-group">
                <label>👤 Your Name</label>
                <input type="text" name="patient_name" required placeholder="Enter your full name">
            </div>
            <div class="input-group">
                <label>📞 Your Phone</label>
                <input type="tel" name="patient_phone" required placeholder="+213 XX XXX XXXX">
            </div>
            <div class="button-group">
                <button type="button" class="btn-back" onclick="history.back()">← Back</button>
                <button type="submit" class="btn-confirm">✅ Confirm</button>
            </div>
        </form>
    </div>
</div>
@endsection