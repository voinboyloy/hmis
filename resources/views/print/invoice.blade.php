<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
            font-size: 28px;
            line-height: 1;
            font-weight: bold;
        }
        .header .logo {
            max-width: 150px;
        }
        .address-block {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }
        .address-block div {
            width: 48%;
        }
        .address-block h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
        }
        .address-block p {
            margin: 0;
            line-height: 1.6;
        }
        .invoice-details {
            margin-bottom: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .invoice-details div {
            width: 48%;
        }
        .invoice-details p {
            margin: 0;
            line-height: 1.6;
        }
        .invoice-details .label {
            font-weight: bold;
            color: #555;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th, .items-table td {
            border: 1px solid #eee;
            padding: 12px;
            text-align: left;
        }
        .items-table th {
            background-color: #f9f9f9;
            font-weight: bold;
            color: #555;
        }
        .items-table .total-row td {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 12px;
        }

        @media print {
            body {
                padding: 0;
            }
            .container {
                border: none;
                box-shadow: none;
            }
            .header, .address-block, .invoice-details, .items-table, .footer {
                margin-bottom: 15px;
            }
            .header {
                padding-bottom: 10px;
            }
            .invoice-details {
                padding-top: 10px;
            }
            .items-table th, .items-table td {
                padding: 8px;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p>#{{ $invoice->id }}</p>
            </div>
            <img src="{{ asset('images/hmis-logo.png') }}" alt="Logo" class="logo">
        </div>

        <div class="address-block">
            <div>
                <h3>Billed To:</h3>
                <p><strong>{{ $invoice->patient->full_name }}</strong></p>
                <p>{{ $invoice->patient->address }}</p>
                <p>{{ $invoice->patient->phone_number }}</p>
            </div>
            <div>
                <h3>From:</h3>
                <p><strong>HMIS Clinic</strong></p>
                <p>Phnom Penh Cambodia</p>
                <p>pagnavoin@hmis.com</p>
            </div>
        </div>

        <div class="invoice-details">
            <div>
                <p><span class="label">Invoice Date:</span> {{ $invoice->created_at->format('M d, Y') }}</p>
                <p><span class="label">Due Date:</span> {{ $invoice->created_at->addDays(30)->format('M d, Y') }}</p> {{-- Example: Due in 30 days --}}
            </div>
            <div class="text-right">
                <p><span class="label">Status:</span> {{ $invoice->status }}</p>
                <p><span class="label">Encounter ID:</span> {{ $invoice->encounter_id }}</p>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->service ? $item->service->name : ($item->medication ? $item->medication->name : 'N/A') }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" class="text-right">Subtotal</td>
                    <td class="text-right">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-right">Amount Paid</td>
                    <td class="text-right">${{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" class="text-right">Outstanding Balance</td>
                    <td class="text-right">${{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>HMIS Clinic | Phnom Penh Cambodia | info@hmis.com</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
