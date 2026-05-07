@extends('clinic.layouts.clinic')

@section('title', 'Pending Approval')

@section('content')
<div class="pending-container">
    <div class="pending-card">
        <i class="fas fa-clock fa-4x" style="color: #f59e0b;"></i>
        <h2>Your Clinic is Pending Approval</h2>
        <p>Thank you for registering your clinic. Our admin team will review your application within 24-48 hours.</p>
        <p>You will receive an email notification once your clinic is approved.</p>
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            Once approved, you will get <strong>2 free trials</strong> before subscribing.
        </div>
    </div>
</div>

<style>
.pending-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.pending-card {
    background: white;
    border-radius: 30px;
    padding: 50px;
    text-align: center;
    max-width: 500px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}
.pending-card h2 {
    color: #1e293b;
    margin: 20px 0 10px;
}
.pending-card p {
    color: #64748b;
    margin-bottom: 15px;
}
.info-box {
    background: #fef3c7;
    border-radius: 15px;
    padding: 15px;
    margin-top: 20px;
    color: #92400e;
}
</style>
@endsection