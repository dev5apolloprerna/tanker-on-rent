<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Orders Report</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif !important;
        }
        body {
            font-size: 11px;
            color: #111;
        }
        h2 {
            margin: 0 0 2px;
            text-align: center;
        }
        .meta {
            margin: 4px 0 12px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px 6px;
            vertical-align: middle;
        }
        th {
            background: #f1f1f1;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        tfoot td {
            font-weight: bold;
            background: #f7f7f7;
        }
    </style>
</head>
<body>
    <h2>Daily Orders Report</h2>
    <div class="meta">
        Generated: {{ $generatedAt->format('d-m-Y H:i') }}
        @if(!empty($filters['customer_name'])) &nbsp;|&nbsp; Customer: {{ $filters['customer_name'] }} @endif
        @if(!empty($filters['customer_mobile'])) &nbsp;|&nbsp; Mobile: {{ $filters['customer_mobile'] }} @endif
        @if(!empty($filters['from_date']) || !empty($filters['to_date']))
            &nbsp;|&nbsp; Date: {{ $filters['from_date'] ?? '...' }} to {{ $filters['to_date'] ?? '...' }}
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Type</th>
                <th>Mobile</th>
                <th>Received</th>
                <th class="text-center">Days</th>
                <th class="text-end">Extra Rent</th>
                <th class="text-end">Total</th>
                <th class="text-end">Paid</th>
                <th class="text-end">Due</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr>
                    <td>{{ $r->daily_order_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->rent_date)->format('d-m-Y') }}</td>
                    <td>{{ $r->customer_name }}</td>
                    <td>{{ (int)$r->customer_id === 0 ? 'Retail' : 'Recurring' }}</td>
                    <td>{{ $r->mobile }}</td>
                    <td>{{ $r->received_at ? \Carbon\Carbon::parse($r->received_at)->format('d-m-Y') : 'Not Received' }}</td>
                    <td class="text-center">{{ $r->calc_days }}</td>
                    <td class="text-end">{{ number_format($r->calc_extra, 2) }}</td>
                    <td class="text-end">{{ number_format($r->calc_grand, 2) }}</td>
                    <td class="text-end">{{ number_format($r->calc_paid, 2) }}</td>
                    <td class="text-end">{{ number_format($r->calc_due, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="11" class="text-center">No records</td></tr>
            @endforelse
        </tbody>
        @if($rows->count())
        <tfoot>
            <tr>
                <td colspan="6" class="text-end">Totals:</td>
                <td class="text-center">{{ $totals['days'] }}</td>
                <td class="text-end">{{ number_format($totals['extra'], 2) }}</td>
                <td class="text-end">{{ number_format($totals['grand'], 2) }}</td>
                <td class="text-end">{{ number_format($totals['paid'], 2) }}</td>
                <td class="text-end">{{ number_format($totals['due'], 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
