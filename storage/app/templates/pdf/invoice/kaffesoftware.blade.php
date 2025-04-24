<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        /* -- Base Styles -- */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        /* -- Layout -- */
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 30px;
            position: relative;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .mb-4 { margin-bottom: 16px; }
        .mb-5 { margin-bottom: 20px; }
        .mt-4 { margin-top: 16px; }
        .mt-5 { margin-top: 20px; }

        /* -- Header -- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 30px;
        }

        .header-logo {
            max-height: 70px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 700;
            color: #2563eb;
            margin-bottom: 5px;
        }

        /* -- Details -- */
        .details-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .company-details {
            width: 48%;
        }

        .invoice-details {
            width: 48%;
            text-align: right;
        }

        .detail-title {
            font-size: 16px;
            font-weight: 600;
            color: #111;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-content {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
            padding-right: 10px;
        }

        .detail-value {
            font-weight: 500;
            color: #333;
        }

        .detail-table {
            width: 100%;
        }

        .detail-table td {
            padding: 4px 0;
        }

        /* -- Client Details -- */
        .client-details-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .client-billing {
            width: 48%;
        }

        .client-shipping {
            width: 48%;
        }

        /* -- Items Table -- */
        .items-table-wrapper {
            margin-bottom: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #eaeaea;
        }

        .items-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eaeaea;
            vertical-align: top;
        }

        .items-table .item-description {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
        }

        /* -- Totals -- */
        .totals-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .totals-table {
            width: 350px;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 15px;
        }

        .totals-table .total-label {
            text-align: left;
            color: #555;
        }

        .totals-table .total-value {
            text-align: right;
            font-weight: 500;
        }

        .totals-table .grand-total {
            font-size: 16px;
            font-weight: 700;
            color: #2563eb;
            border-top: 2px solid #eaeaea;
            padding-top: 12px;
        }

        /* -- Notes -- */
        .notes-wrapper {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        .notes-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .notes-content {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        /* -- Footer -- */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <div>
            @if ($logo)
                <img class="header-logo" src="{{ \App\Space\ImageUtils::toBase64Src($logo) }}" alt="Company Logo">
            @else
                @if ($invoice->customer->company)
                    <h1 class="invoice-title">{{ $invoice->customer->company->name }}</h1>
                @endif
            @endif
        </div>
        <div class="text-right">
            <div class="invoice-title">INVOICE</div>
            <div class="detail-value">#{{ $invoice->invoice_number }}</div>
        </div>
    </div>

    <!-- Company & Invoice Details -->
    <div class="details-wrapper">
        <div class="company-details">
            <div class="detail-title">From</div>
            <div class="detail-content">
                {!! $company_address !!}
            </div>
        </div>

        <div class="invoice-details">
            <div class="detail-title">Invoice Details</div>
            <table class="detail-table">
                <tr>
                    <td class="detail-label text-right">Invoice Number:</td>
                    <td class="detail-value text-right">{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td class="detail-label text-right">Invoice Date:</td>
                    <td class="detail-value text-right">{{ $invoice->formattedInvoiceDate }}</td>
                </tr>
                <tr>
                    <td class="detail-label text-right">Due Date:</td>
                    <td class="detail-value text-right">{{ $invoice->formattedDueDate }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Client Details -->
    <div class="client-details-wrapper">
        <div class="client-billing">
            @if ($billing_address)
                <div class="detail-title">Bill To</div>
                <div class="detail-content">
                    {!! $billing_address !!}
                </div>
            @endif
        </div>

        <div class="client-shipping">
            @if ($shipping_address)
                <div class="detail-title">Ship To</div>
                <div class="detail-content">
                    {!! $shipping_address !!}
                </div>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div class="items-table-wrapper">
        <table class="items-table">
            <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>
                        <div>{{ $item->name }}</div>
                        @if($item->description)
                            <div class="item-description">{{ $item->description }}</div>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $company->currency->symbol }}{{ $item->price }}</td>
                    <td class="text-right">{{ $company->currency->symbol }}{{ $item->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="totals-wrapper">
        <table class="totals-table">
            <tr>
                <td class="total-label">Subtotal:</td>
                <td class="total-value">{{ $company->currency->symbol }}{{ $invoice->sub_total }}</td>
            </tr>
            @if($invoice->tax)
                <tr>
                    <td class="total-label">Tax ({{ $invoice->tax_rate }}%):</td>
                    <td class="total-value">{{ $company->currency->symbol }}{{ $invoice->tax }}</td>
                </tr>
            @endif
            @if($invoice->discount)
                <tr>
                    <td class="total-label">Discount:</td>
                    <td class="total-value">{{ $company->currency->symbol }}{{ $invoice->discount }}</td>
                </tr>
            @endif
            <tr>
                <td class="total-label grand-total">Total:</td>
                <td class="total-value grand-total">{{ $company->currency->symbol }}{{ $invoice->total }}</td>
            </tr>
        </table>
    </div>

    <!-- Notes -->
    @if ($notes)
        <div class="notes-wrapper">
            <div class="notes-title">Notes</div>
            <div class="notes-content">
                {!! $notes !!}
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</div>
</body>
</html>