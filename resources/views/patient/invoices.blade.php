@extends('patient.layouts.patient')

@section('title', 'Invoices')

@section('content')
<div class="card-white">
    <h3><i class="fas fa-receipt"></i> 🧾 Invoices List</h3>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr><th>📄 Invoice #</th><th>📅 Date</th><th>🏥 Clinic</th><th>💰 Amount (DZD)</th><th>📌 Status</th><th>⚙️ Actions</th></tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                <tr>
                    <td>{{ $inv->invoice_number }}</td>
                    <td>{{ $inv->date }}</td>
                    <td>{{ $inv->clinic->name ?? 'N/A' }}</td>
                    <td>{{ number_format($inv->amount) }}</td>
                    <td><span class="status-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span></td>
                    <td><button class="btn-sm" onclick="viewInvoice({{ $inv->id }})">View</button></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;">No invoices found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function viewInvoice(id) {
        alert('Invoice details will be shown here.');
    }
</script>
@endpush
@endsection