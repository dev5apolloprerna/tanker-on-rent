@if(!$order)
  <div class="alert alert-danger mb-0">Order not found.</div>
@else
  <div class="mb-3">
    <div class="d-flex justify-content-between">
      <div>
        <div class="fw-semibold">Order #{{ $order->daily_order_id }}</div>
        <div class="text-muted small">
          {{ \Carbon\Carbon::parse($order->rent_date)->format('d-m-Y') }}
          · {{ $order->customer_name }} · {{ $order->mobile }}
          @if(!empty($order->service_type)) · {{ $order->service_type }} @endif
        </div>
      </div>
      <div class="text-end">
        <div>Order Total: <strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
        <div>Paid: <strong>₹{{ number_format($paid, 2) }}</strong></div>
        <div class="{{ $due > 0 ? 'text-danger fw-semibold' : 'text-success' }}">
          Due: ₹{{ number_format($due, 2) }}
        </div>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Payment Date</th>
          <th>Comment</th>
          <th class="text-end">Amount (₹)</th>
          <th class="text-end">Closing Bal (₹)</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rows as $r)
          <tr>
            <td>{{ $r->ledger_id }}</td>
            <td>{{ \Carbon\Carbon::parse($r->entry_date)->format('d-m-Y') }}</td>
            <td>{{ $r->comment }}</td>
            <td class="text-end">₹{{ number_format($r->credit_bl, 2) }}</td>
            <td class="text-end">₹{{ number_format($r->closing_bl, 2) }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted">No payments recorded for this order.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endif
