@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-primary">Invoices</h2>
            <p class="text-muted">Manage your invoices and billing</p>
        </div>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Invoice
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Invoice No</th>
                            <th class="border-0">Customer</th>
                            <th class="border-0">Date</th>
                            <th class="border-0">Items</th>
                            <th class="border-0 text-end">Total Amount</th>
                            <th class="border-0 text-end">GST Amount</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td class="align-middle">
                                    <span class="fw-medium">{{ $invoice->invoice_no }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle bg-primary text-white me-2">
                                            {{ strtoupper(substr($invoice->customer->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $invoice->customer->name }}</div>
                                            <small class="text-muted">{{ $invoice->customer->gstin ?? 'No GSTIN' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        @foreach($invoice->items as $item)
                                            <span class="badge bg-light text-dark mb-1">
                                                {{ $item->item_name }} ({{ $item->quantity }})
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="align-middle text-end">
                                    <span class="fw-medium">₹{{ number_format($invoice->total_amount, 2) }}</span>
                                </td>
                                <td class="align-middle text-end">
                                    <span class="text-success">₹{{ number_format($invoice->gst_amount, 2) }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('invoices.download-pdf', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download me-1"></i>Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.table-hover tbody tr:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

.btn-outline-primary {
    border-width: 2px;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.table thead th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

.text-success {
    color: #198754 !important;
}

.fw-medium {
    font-weight: 500;
}
</style>
@endsection
