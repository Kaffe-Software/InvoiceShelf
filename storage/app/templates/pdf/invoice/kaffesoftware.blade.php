<!DOCTYPE html>
<html>

<head>
    <title>@lang('pdf_invoice_label') - {{ $invoice->invoice_number }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        /* -- Base & Typography -- */
        body {
            font-family: "DejaVu Sans", sans-serif; /* DejaVu Sans is good for UTF-8 in PDFs */
            font-size: 10pt;
            color: #333;
            margin: 0;
            padding: 0;
        }

        html {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            font-weight: bold;
        }

        p {
            margin: 0 0 5px 0;
            line-height: 1.4;
        }

        /* -- Page Layout -- */
        .page-container {
            padding: 30px 40px; /* Generous padding around the content */
            position: relative;
        }

        /* -- Header -- */
        .header {
            padding-bottom: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid #7675ff; /* Accent color border */
        }

        .header-left {
            width: 50%;
            vertical-align: top;
        }

        .header-logo img {
            max-height: 60px; /* Adjust as needed */
            max-width: 200px; /* Adjust as needed */
            width: auto;
            height: auto;
        }

        .header-company-name {
            font-size: 16pt;
            color: #7675ff; /* Accent color */
            margin-top: 10px;
        }

        .header-right {
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .invoice-title {
            font-size: 24pt;
            color: #333;
            margin-bottom: 5px;
        }

        .invoice-meta p {
            font-size: 10pt;
            color: #555;
            line-height: 1.4;
            margin: 0;
        }

        /* -- Address Section -- */
        .address-section {
            margin-bottom: 30px;
            /* Using table for robust PDF layout */
        }

        .address-section td {
            vertical-align: top;
            padding-right: 20px;
            font-size: 10pt;
            line-height: 1.5;
        }

        .address-section .label {
            font-weight: bold;
            color: #555;
            font-size: 9pt;
            margin-bottom: 5px;
            display: block; /* Make label appear above address */
        }

        .address-section h4 { /* Company Name / Customer Name */
            font-size: 11pt;
            margin-bottom: 5px;
            color: #000;
        }

        .address-block {
            color: #444;
            word-wrap: break-word;
        }

        .company-address-col {
            width: 35%;
        }
        .billing-address-col {
            width: 30%;
        }
        .shipping-address-col {
            width: 35%;
        }


        /* -- Items Table -- */
        .items-table {
            margin-bottom: 20px;
            page-break-inside: auto; /* Allow table rows to break across pages */
        }

        .items-table thead th {
            background-color: #f0f0f0; /* Light gray background for header */
            color: #333;
            font-weight: bold;
            font-size: 9pt;
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid #ccc;
            text-transform: uppercase; /* Optional: Makes headers stand out */
        }

        .items-table tbody td {
            padding: 10px 8px;
            vertical-align: top;
            border-bottom: 1px solid #eee; /* Subtle row separator */
            font-size: 10pt;
        }

        /* Give specific alignment to columns */
        .items-table .col-description { text-align: left; width: 45%; }
        .items-table .col-quantity { text-align: center; }
        .items-table .col-price { text-align: right; }
        .items-table .col-discount { text-align: right; }
        .items-table .col-tax { text-align: right; }
        .items-table .col-total { text-align: right; font-weight: bold; }

        .items-table .item-description-notes {
            font-size: 8pt;
            color: #666;
            margin-top: 3px;
        }

        /* Zebra striping (optional, might not render perfectly in all PDF engines) */
        /* .items-table tbody tr:nth-child(even) td {
            background-color: #f9f9f9;
        } */


        /* -- Totals Section -- */
        .totals-section {
            page-break-inside: avoid; /* Keep totals block together */
            margin-top: 20px;
        }

        .totals-table {
            width: 40%; /* Adjust width as needed */
            float: right; /* Align to the right */
            color: #333;
        }

        .totals-table td {
            padding: 6px 10px;
            font-size: 10pt;
        }

        .totals-table tr td:first-child {
            text-align: right;
            font-weight: normal;
            color: #555;
        }

        .totals-table tr td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .totals-table tr.grand-total td {
            font-size: 12pt;
            font-weight: bold;
            color: #000;
            border-top: 2px solid #7675ff; /* Accent color border */
            padding-top: 10px;
        }


        /* -- Notes Section -- */
        .notes-section {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #eee; /* Separator line */
            clear: both; /* Clear floats from totals table */
            page-break-inside: avoid;
        }

        .notes-label {
            font-weight: bold;
            font-size: 10pt;
            color: #333;
            margin-bottom: 5px;
        }

        .notes-content {
            font-size: 9pt;
            color: #555;
            line-height: 1.5;
            /* Optional: Prevent extremely long words from breaking layout */
            word-wrap: break-word;
        }

        /* -- Footer -- */
        .footer {
            position: fixed; /* Fixed position for footer */
            bottom: -10px; /* Adjust position relative to bottom */
            left: 0px;
            right: 0px;
            height: 40px; /* Footer height */

            /* Styling */
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
            font-size: 8pt;
            color: #888;
        }

        /* -- Helpers -- */
        .text-primary { color: #7675ff; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .w-auto { width: auto; }
        .clear { clear: both; }

    </style>

    {{-- Include locale-specific CSS if needed --}}
    @if (App::isLocale('th'))
        @include('app.pdf.locale.th')
    @endif
</head>

<body>
{{-- Optional: Add a footer element that PDF generators can place --}}
<div class="footer">
    Thank you for your business! | {{ $invoice->customer->company->name ?? 'Your Company Name' }}
    {{-- You can add more footer info like page numbers if your PDF generator supports it --}}
</div>

<div class="page-container">
    {{-- Header Section --}}
    <table class="header">
        <tr>
            <td class="header-left">
                @if ($logo)
                    <div class="header-logo">
                        <img src="{{ \App\Space\ImageUtils::toBase64Src($logo) }}" alt="Company Logo">
                    </div>
                @elseif ($invoice->customer->company)
                    <h1 class="header-company-name">
                        {{ $invoice->customer->company->name }}
                    </h1>
                @endif
                {{-- Company Name from Address Block can also go here if needed --}}
            </td>
            <td class="header-right">
                <h1 class="invoice-title">@lang('pdf_invoice_label')</h1>
                <div class="invoice-meta">
                    <p><strong>@lang('pdf_invoice_number'):</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong>@lang('pdf_invoice_date'):</strong> {{ $invoice->formattedInvoiceDate }}</p>
                    @if ($invoice->due_date)
                        <p><strong>@lang('pdf_due_date'):</strong> {{ $invoice->formattedDueDate }}</p>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    {{-- Address Section --}}
    <table class="address-section">
        <tr>
            <td class="company-address-col">
                {{-- Displaying company info from $company_address --}}
                {{-- Assume $company_address includes name and full address formatted --}}
                <div class="address-block">
                    {!! $company_address !!}
                </div>
            </td>
            <td class="billing-address-col">
                @if ($billing_address)
                    <span class="label">@lang('pdf_bill_to')</span>
                    <div class="address-block">
                        {!! $billing_address !!}
                    </div>
                @endif
            </td>
            <td class="shipping-address-col">
                @if ($shipping_address && trim(strip_tags($shipping_address)) !== '')
                    <span class="label">@lang('pdf_ship_to')</span>
                    <div class="address-block">
                        {!! $shipping_address !!}
                    </div>
                @endif
            </td>
        </tr>
    </table>


    {{-- Items Table --}}
    {{-- Ensure the partial 'app.pdf.invoice.partials.table' uses the new classes --}}
    {{-- You might need to update the partial to add classes like: --}}
    {{-- <table class="items-table"> --}}
    {{--  <thead><tr><th class="col-description">...</th><th class="col-quantity">... --}}
    {{--  <tbody><tr><td class="col-description">... {!! $item->product->description !!} <div class="item-description-notes">Notes...</div> --}}
    @include('app.pdf.invoice.partials.table')


    {{-- Totals Section --}}
    {{-- Ensure the partial 'app.pdf.invoice.partials.table' outputs totals separately or adjust here --}}
    {{-- Assuming the totals are calculated and available in variables passed to the view --}}
    {{-- You'll likely have these totals within the partial, but if not, structure them like this: --}}
    <div class="totals-section">
        <table class="totals-table">
            <tbody>
            <tr>
                <td>@lang('pdf_subtotal')</td>
                <td>{{ $invoice->sub_total }}</td> {{-- Adjust variable names as needed --}}
            </tr>
            @if($invoice->discount_total > 0)
                <tr>
                    <td>@lang('pdf_discount')</td>
                    <td>{{ $invoice->discount_total }}</td> {{-- Adjust variable names --}}
                </tr>
            @endif
            @foreach($invoice->taxes as $tax) {{-- Example tax loop --}}
            <tr>
                <td>{{ $tax->name }} ({{ $tax->percent }}%)</td>
                <td>{{ $tax->amount }}</td> {{-- Adjust variable names --}}
            </tr>
            @endforeach
            {{-- Add other totals like shipping if applicable --}}
            <tr class="grand-total">
                <td>@lang('pdf_total')</td>
                <td>{{ $invoice->total }}</td> {{-- Adjust variable names --}}
            </tr>
            </tbody>
        </table>
        <div class="clear"></div>
    </div>


    {{-- Notes Section --}}
    @if ($notes && trim(strip_tags($notes)) !== '')
        <div class="notes-section">
            <div class="notes-label">
                @lang('pdf_notes')
            </div>
            <div class="notes-content">
                {!! $notes !!}
            </div>
        </div>
    @endif

</div> {{-- End Page Container --}}
</body>

</html>