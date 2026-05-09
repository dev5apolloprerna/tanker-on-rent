<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Customer Report</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style>
@if(!empty($gujaratiFontPath) && file_exists($gujaratiFontPath))
@font-face {
    font-family: 'NotoSansGujarati';
    font-style: normal;
    font-weight: normal;
    src: url("{{ 'file://' . str_replace('\\', '/', $gujaratiFontPath) }}") format("truetype");
}
@endif

* {
    font-family: 'NotoSansGujarati', freeserif, DejaVu Sans, sans-serif !important;
}

body {
    font-size: 12px;
    color: #111;
}

h2, h4 {
    margin: 0;
    text-align: center;
    font-family: 'NotoSansGujarati', freeserif, DejaVu Sans, sans-serif !important;
}
.h4
{
    margin: 0;
    text-align: center;
    font-family: 'NotoSansGujarati', freeserif, DejaVu Sans, sans-serif !important;
}
.meta {
    margin: 8px 0 12px;
    text-align: right;
    font-size: 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #333;
    padding: 6px;
    vertical-align: top;
}

th {
    background: #f1f1f1;
}

.text-right { text-align: right; }
.small { font-size: 10px; }
.summary { margin-top: 14px; width: 45%; margin-left: auto; }
.summary td { border: 1px solid #333; padding: 5px; }
.section-gap td { border: none; padding: 8px 0; }
</style>
</head>
<body>
    @php
        $firstOrder = $reportRows[0]['order'] ?? null;
        $customerName = $firstOrder->customer->customer_name ?? 'All Customers';
        $customerMobile = $firstOrder->customer->customer_mobile ?? '';
    @endphp
    <h2>Suvidha Water Suppliers</h2>
    <p class="h4">{{ $customerName }}{{ $customerMobile ? ' (MO. ' . $customerMobile . ')' : '' }}</p>
    <div class="meta">Generated: {{ $generatedAt->format('d-m-Y h:i A') }}</div>

    <table>
        <thead>
            <tr>
                <th style="width:11%">Tanker</th>
                <th style="width:28%">Customer Name / Dates</th>
                <th style="width:14%">Tanker No</th>
                <th style="width:7%">Months</th>
                <th style="width:10%">Rent</th>
                <th style="width:10%">Total Rent</th>
                <th style="width:10%">Paid</th>
                <th style="width:10%">Unpaid</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportRows as $i => $row)
                @php
                    $order = $row['order'];
                    $snap = $row['snap'];
                    $schedule = $row['schedule'];
                @endphp
                <tr>
                    <td>Tanker.{{ $i + 1 }}</td>
                    <td>{{ $order->customer->customer_name ?? '-' }}<br><span class="small">{{ $schedule[0] ?? '-' }}</span></td>
                    <td>{{ $order->tanker->tanker_code ?? '-' }}</td>
                    <td class="text-right">{{ $snap['months'] }}</td>
                    <td class="text-right">{{ number_format($snap['base']) }}</td>
                    <td class="text-right">{{ number_format($snap['total_due']) }}</td>
                    <td class="text-right">{{ number_format($snap['paid_sum']) }}</td>
                    <td class="text-right">{{ number_format($snap['unpaid']) }}</td>
                </tr>
                @foreach(array_slice($schedule, 1) as $date)
                    <tr>
                        <td></td>
                        <td class="small">{{ $date }}</td>
                        <td></td><td></td><td></td><td></td><td></td><td></td>
                    </tr>
                @endforeach
                <tr class="section-gap"><td colspan="8"></td></tr>
            @empty
                <tr><td colspan="8" style="text-align:center">No monthly orders found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="summary">
        <tr><td><strong>Total Amount</strong></td><td class="text-right"><strong>{{ number_format($grandTotal) }}</strong></td></tr>
        <tr><td><strong>Paid Amount</strong></td><td class="text-right"><strong>{{ number_format($grandPaid) }}</strong></td></tr>
        <tr><td><strong>Unpaid Amount</strong></td><td class="text-right"><strong>{{ number_format($grandUnpaid) }}</strong></td></tr>
    </table>
</body>
</html>
