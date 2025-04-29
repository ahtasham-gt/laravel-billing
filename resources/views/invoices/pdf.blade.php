<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .shop-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .shop-address {
            font-size: 14px;
            margin-bottom: 20px;
            color: #666;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f5f5f5;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px;
        }
        .totals .amount {
            text-align: right;
        }
        .currency {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="shop-name">SUMANA SAREEES</div>
        <div class="shop-address">
            Bhanugudi,<br>
            Kakinada - 533003<br>
            Andhra Pradesh, India
        </div>
        <h1>INVOICE</h1>
        <h2>Invoice No: {{ $invoice->invoice_no }}</h2>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ $invoice->invoice_date }}</td>
                <td><strong>Customer:</strong></td>
                <td>{{ $invoice->customer->name }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td colspan="3">{{ $invoice->customer->address }}</td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>GST</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs. {{ number_format($item->rate, 2) }}</td>
                <td>Rs. {{ number_format(($item->amount * 0.12), 2) }}</td>
                <td>Rs. {{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td class="amount">Rs. {{ number_format($invoice->total_amount - $invoice->gst_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>GST Amount:</strong></td>
                <td class="amount">Rs. {{ number_format($invoice->gst_amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Total Amount:</strong></td>
                <td class="amount">Rs. {{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html> 