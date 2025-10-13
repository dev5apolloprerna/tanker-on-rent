<div class="d-flex justify-content-between align-items-center mb-2">
  <div>
    <strong>{{ $customerName }}</strong>
    <span class="text-muted"> ({{ \Carbon\Carbon::parse($from)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($to)->format('d-m-Y') }})</span>
  </div>
  <div class="fw-semibold">Total Paid (in range): ₹{{ number_format($totalPaid, 2) }}</div>
</div>

<div class="table-responsive">
  <table class="table table-sm table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <!-- <th>#</th> -->
        <th>Pay Date</th>
        <!-- <th>Order#</th> -->
        <th>Order Date</th>
        <!-- <th>Service</th> -->
        <th class="text-end">Total Amount(₹)</th>
        <!-- <th class="text-end">Total Paid (₹)</th> -->
        <th class="text-end">Paid (₹)</th>
        <th class="text-end">Due (₹)</th>
        <th>Comment</th>
      </tr>
    </thead>
    <tbody>
      @forelse($rows as $r)
        @php
          $paidAll = (float) ($orderPaidAll[$r->daily_order_id] ?? 0);
          $due     = max(0, (float)$r->total_amount - $paidAll);
        @endphp
        <tr>
          <!-- <td>{{ $r->ledger_id }}</td> -->
          <td>{{ \Carbon\Carbon::parse($r->entry_date)->format('d-m-Y') }}</td>
          <!-- <td>{{ $r->daily_order_id }}</td> -->
          <td>{{ \Carbon\Carbon::parse($r->rent_date)->format('d-m-Y') }}</td>
          <!-- <td>{{ $r->service_type ?? '-' }}</td> -->
          <td class="text-end">₹{{ number_format($r->total_amount, 2) }}</td>
          <!-- <td class="text-end">₹{{ number_format($paidAll, 2) }}</td> -->
          <td class="text-end">₹{{ number_format($r->credit_bl, 2) }}</td>
          <td class="text-end {{ $due > 0 ? 'text-danger fw-semibold' : 'text-success' }}">
            ₹{{ number_format($due, 2) }}
          </td>
          <td>{{ $r->comment }}</td>
        </tr>
      @empty
        <tr><td colspan="10" class="text-center text-muted">No payments tied to orders in this range.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
