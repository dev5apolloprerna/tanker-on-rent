<div class="mb-3">
    <div class="alert alert-info border">
        <div class="d-flex justify-content-between flex-wrap">
            <div>
                <strong>Customer Collection Summary</strong>
                <div class="small text-muted">Tanker-wise paid/unpaid details for this customer.</div>
            </div>

            <div class="text-end">
                <div>
                    <strong>Total Paid:</strong>
                    ₹{{ number_format($customerTotals['paid'] ?? 0) }}
                </div>

                <div class="{{ ($customerTotals['unpaid'] ?? 0) > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                    <strong>Total Amount to be Paid:</strong>
                    ₹{{ number_format($customerTotals['unpaid'] ?? 0) }}
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive card mb-3">
        <table class="table table-sm table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Tanker No</th>
                    <th>Tanker Name</th>
                    <th class="text-end">Paid</th>
                    <th class="text-end">Unpaid</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customerOrders as $co)
                    @php
                        $cs = $co->customer_snapshot ?? ['paid_sum' => 0, 'unpaid' => 0];
                    @endphp

                    <tr class="{{ (int) $co->order_id === (int) $order->order_id ? 'table-warning' : '' }}">
                        <td>{{ $co->order_id }}</td>

                        <td>{{ $co->tanker->tanker_code ?? '-' }}</td>

                        <td>{{ $co->tanker->tanker_name ?? '-' }}</td>

                        <td class="text-end text-success">
                            ₹{{ number_format($cs['paid_sum'] ?? 0) }}
                        </td>

                        <td class="text-end {{ ($cs['unpaid'] ?? 0) > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                            ₹{{ number_format($cs['unpaid'] ?? 0) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            No tanker records found for this customer.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @php
        $customerPaid = (float) ($customerTotals['paid'] ?? 0);
        $customerUnpaid = (float) ($customerTotals['unpaid'] ?? 0);
        $customerTotalDue = $customerPaid + $customerUnpaid;
        $lastPayment = $payments->last();
    @endphp

    <div class="alert alert-light border">
        <div class="d-flex justify-content-between flex-wrap">
            <div>
                <div>
                    <strong>Selected Order #:</strong>
                    {{ $order->order_id }}
                </div>

                <div>
                    <strong>Customer:</strong>
                    {{ $order->customer->customer_name ?? $order->customer_id }}
                </div>

                <div>
                    <strong>Last Payment Date:</strong>
                    {{ $lastPayment ? \Carbon\Carbon::parse($lastPayment->payment_date ?? $lastPayment->created_at)->format('d-M-Y') : '-' }}
                </div>

                <div>
                    <strong>Tanker Status:</strong>

                    @if($order->isReceive)
                        <span class="badge bg-warning">Not Received</span>
                    @else
                        <span class="badge bg-success">Received</span>
                    @endif
                </div>
            </div>

            <div class="text-end">
                <div>
                    <strong>Total Due (Customer):</strong>
                    ₹{{ number_format($customerTotalDue) }}
                </div>

                <div>
                    <strong>Total Paid (Customer):</strong>
                    ₹{{ number_format($customerPaid) }}
                </div>

                <div class="{{ $customerUnpaid > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                    <strong>Amount to be Paid (Customer):</strong>
                    ₹{{ number_format($customerUnpaid) }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive card">
    <table class="table table-sm table-bordered align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>When</th>
                <th>Total (Snapshot)</th>
                <th>Paid</th>
                <th>Unpaid (After Row)</th>
                <th>Payment Received By</th>
            </tr>
        </thead>

        <tbody>
            @forelse($payments as $p)
                <tr>
                    <td>{{ $p->payment_id }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($p->created_at)->format('d-M-Y H:i') }}
                    </td>

                    <td>
                        ₹{{ number_format((int) $p->total_amount) }}
                    </td>

                    <td class="text-success">
                        ₹{{ number_format((int) $p->paid_amount) }}
                    </td>

                    <td class="{{ (int) $p->unpaid_amount > 0 ? 'text-danger' : 'text-success' }}">
                        ₹{{ number_format((int) $p->unpaid_amount) }}
                    </td>

                    <td>
                        {{ $p->PaymentReceivedUser->name ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No payments yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>