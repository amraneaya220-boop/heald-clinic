@extends('layouts.admin')

@section('title', 'Bookings')

@section('content')
<div class="card">
    <h3><i class="fas fa-receipt"></i> Booking & Commission List</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient</th>
                    <th>Clinic</th>
                    <th>Amount (DZD)</th>
                    <th>Commission (DZD)</th>
                    <th>Rate %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->appointment_date }}</td>
                    <td>{{ $booking->patient_name }}</td>
                    <td>{{ $booking->clinic->name ?? 'N/A' }}</td>
                    <td>{{ number_format($booking->amount, 2) }}</td>
                    <td>{{ number_format($booking->commission, 2) }}</td>
                    <td>{{ $booking->clinic->commission_rate ?? 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection