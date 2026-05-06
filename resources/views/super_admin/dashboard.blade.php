@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-hospital"></i>
        <h3>{{ $totalClinics }}</h3>
        <p>Total Clinics</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-dollar-sign"></i>
        <h3>{{ number_format($totalRevenue, 2) }} DZD</h3>
        <p>Total Commission</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-calendar-check"></i>
        <h3>{{ $totalBookings }}</h3>
        <p>Total Bookings</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-ad"></i>
        <h3>{{ $activeAds }}</h3>
        <p>Active Ads</p>
    </div>
</div>

<div class="card">
    <h3><i class="fas fa-chart-simple"></i> Recent Activity</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Clinic</th>
                    <th>Amount</th>
                    <th>Commission</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->appointment_date }}</td>
                    <td>{{ $booking->patient_name }}</td>
                    <td>{{ $booking->clinic->name ?? 'N/A' }}</td>
                    <td>{{ number_format($booking->amount, 2) }} DZD</td>
                    <td>{{ number_format($booking->commission, 2) }} DZD</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">No recent bookings</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection