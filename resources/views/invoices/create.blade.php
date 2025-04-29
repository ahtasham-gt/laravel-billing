@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0 text-primary">Create Invoice</h2>
                    <p class="text-muted">Add a new invoice with items and details</p>
                </div>
                <a href="{{ route('invoices.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Invoices
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                        @csrf

                        <div class="row g-4">
                            <!-- Customer Selection -->
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="customer_id" id="customer_id" class="form-select" required>
                                        <option value="">Select a customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }} {{ $customer->gstin ? '(' . $customer->gstin . ')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="customer_id">Customer</label>
                                </div>
                            </div>

                            <!-- Invoice Number -->
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ old('invoice_no') }}" required>
                                    <label for="invoice_no">Invoice No</label>
                                </div>
                            </div>

                            <!-- Invoice Date -->
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                                    <label for="invoice_date">Invoice Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Items Section -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Items</h5>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addItem()">
                                    <i class="fas fa-plus me-2"></i>Add Item
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 35%">Item Name</th>
                                            <th style="width: 15%">Quantity</th>
                                            <th style="width: 15%">Rate</th>
                                            <th style="width: 15%">Amount</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="items[0][item_name]" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]" class="form-control quantity" required onchange="calculateAmount(this)">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" name="items[0][rate]" class="form-control rate" required onchange="calculateAmount(this)">
                                            </td>
                                            <td>
                                                <input type="number" step="0.01" name="items[0][amount]" class="form-control amount" readonly>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Totals Section -->
                        <div class="row g-4 mt-4">
                            <div class="col-md-6 offset-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label">Subtotal</label>
                                                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" readonly>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label">GST (12%)</label>
                                                <input type="number" step="0.01" name="gst_amount" id="gst_amount" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-floating > .form-control,
.form-floating > .form-select {
    height: calc(3.5rem + 2px);
    line-height: 1.25;
}

.form-floating > label {
    padding: 1rem 0.75rem;
}

.table > :not(caption) > * > * {
    padding: 0.75rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-outline-primary {
    border-width: 2px;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.bg-light {
    background-color: #f8f9fa !important;
}
</style>

<script>
let itemIndex = 1;

function calculateAmount(input) {
    const row = input.closest('tr');
    const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
    const rate = parseFloat(row.querySelector('.rate').value) || 0;
    const amount = quantity * rate;
    row.querySelector('.amount').value = amount.toFixed(2);
    calculateTotals();
}

function calculateTotals() {
    let totalAmount = 0;
    document.querySelectorAll('.amount').forEach(input => {
        totalAmount += parseFloat(input.value) || 0;
    });
    
    const gstAmount = totalAmount * 0.12;
    
    document.getElementById('total_amount').value = totalAmount.toFixed(2);
    document.getElementById('gst_amount').value = gstAmount.toFixed(2);
}

function addItem() {
    const tbody = document.querySelector('#itemsTable tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <input type="text" name="items[${itemIndex}][item_name]" class="form-control" required>
        </td>
        <td>
            <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" required onchange="calculateAmount(this)">
        </td>
        <td>
            <input type="number" step="0.01" name="items[${itemIndex}][rate]" class="form-control rate" required onchange="calculateAmount(this)">
        </td>
        <td>
            <input type="number" step="0.01" name="items[${itemIndex}][amount]" class="form-control amount" readonly>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(this)">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(newRow);
    itemIndex++;
}

function removeItem(button) {
    const row = button.closest('tr');
    if (document.querySelectorAll('#itemsTable tbody tr').length > 1) {
        row.remove();
        calculateTotals();
    }
}
</script>
@endsection
