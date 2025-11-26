@extends('layouts.app')
@section('title','Daily Orders')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
          
               {{-- Alert Messages --}}
            @include('common.alert')
        <div class="card"> 
          <div class="card-header">
            <h5> Customer Listing
            </h5>
          </div>
            <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('customer.index') }}" class="d-flex">
                        <input type="text" name="customer_name" class="form-control me-2" placeholder="Customer Name" value="{{ request('customer_name') }}">
                        <input type="text" name="customer_mobile" class="form-control me-2" placeholder="Mobile Number" value="{{ request('customer_mobile') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('daily-orders.index') }}" class="btn btn-light">Reset</a>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('daily-orders.create') }}" class="btn btn-sm btn-primary">
                        <i class="far fa-plus"></i> Add New
                    </a>
                </div>
            </div>

        {{-- RIGHT: Listing --}}
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><h5 class="mb-0">Recent Orders</h5></div>
            <div class="card-body table-responsive">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Mobile</th>
                    <th>Received</th>
                    <th class="text-end">Extra Rent</th>
                    <th class="text-center">Days</th>
                    <th class="text-end">Total</th>  {{-- total_amount from DB --}}
                    <!-- <th class="text-end">Grand</th>   {{-- Stored + Extra --}} -->
                    <th class="text-end">Paid</th>
                    <th class="text-end">Due</th>

                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($rows as $r)
                  @php
                      $paid = (float)($r->paid_sum ?? 0);
                      $due  = max(0, (float)$r->total_amount - $paid);
                    @endphp
                    <tr>
                      <td>{{ $r->daily_order_id }}</td>
                      <td>{{ \Carbon\Carbon::parse($r->rent_date)->format('d-m-Y') }}</td>
                      <td>
                      @if((int)$r->customer_id === 0)
                      {{ $r->customer_name }}
                        <span class="badge bg-info ms-1">Retail</span>
                      @else
                      <button
                        type="button"
                        class="btn btn-link p-0 js-order-payments"
                        title="View Payments"
                        data-order-id="{{ $r->daily_order_id }}"
                        data-customer-name="{{ $r->customer_name }}"
                      >
                        {{ $r->customer_name }}
                      </button>
                        <span class="badge bg-secondary ms-1">Recurring</span>
                      @endif
                    </td>

                      <td>{{ $r->mobile }}</td>
                     <td>
                        @if($r->received_at)
                          {{ \Carbon\Carbon::parse($r->received_at)->format('d-M-Y') }}
                        @else
                          <span class="badge bg-warning text-dark">Not Received</span>
                        @endif
                      </td>

                        <td class="text-end">₹{{ number_format($r->calc_extra, 2) }}</td>
                       <td class="text-center small text-muted">({{ $r->calc_days }} days)</td>
                        <!-- <td class="text-end">₹{{ number_format($r->calc_stored, 2) }}</td> -->
                        <td class="text-end fw-semibold">₹{{ number_format($r->calc_grand, 2) }}</td>
                        <td class="text-end">₹{{ number_format($r->calc_paid, 2) }}</td>
                        <td class="text-end">₹{{ number_format($r->calc_due, 2) }}</td>
                        <td>
                      @php
                          $placedDate = date('Y-m-d',strtotime($r->rent_date)); // fallback to rent_date
                      @endphp
                      @if(empty($r->received_at))
                          {{-- Not received → open modal --}}
                          <button type="button"
                                  class="btn btn-sm btn-success btn-open-receive"
                                  data-id="{{ $r->daily_order_id }}"
                                  data-placed="{{ $placedDate }}"
                                  data-rate="200"
                                  data-customer="{{ $r->customer_name }}">
                            Mark Received
                          </button>
                        @else
                          {{-- Already received → allow undo --}}
                          <form method="POST" action="{{ route('daily-orders.unreceive', $r->daily_order_id) }}" class="d-inline">
                            @csrf @method('PUT')
                            <button class="btn btn-sm btn-warning">Mark Not Received</button>
                          </form>
                        @endif
                       <a href="{{ route('daily-orders.edit', $r->daily_order_id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>

                        <form action="{{ route('daily-orders.destroy', $r->daily_order_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
                          @csrf @method('DELETE')
                          <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                        </form>
                        @if(!empty($r->received_at))
                        <button
                            type="button" title="Pay"
                            class="btn btn-sm btn-success btnPay"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            data-order-id="{{ $r->daily_order_id }}"
                            data-customer-id="{{ $r->customer_id }}"
                            data-customer-name="{{ $r->customer_name }}"
                            data-total-amount="{{ $r->calc_grand }}"
                            data-paid="{{ $r->calc_paid }}"
                            data-due="{{ $r->calc_due }}"

                            data-order-date="{{ \Carbon\Carbon::parse($r->rent_date)->format('Y-m-d') }}"
                          ><i class="fas fa-inr"></i></button>
                          @endif

                      </td>
                      


                    </tr>
                  @empty
                    <tr><td colspan="8" class="text-center text-muted">No records</td></tr>
                  @endforelse
                </tbody>
                    @if($rows->count())
                    <tfoot>
                      <tr class="fw-semibold">
                        <td colspan="5" class="text-end">Totals:</td>
                        <td class="text-center">{{ $totals['days'] }}</td>
                        <td class="text-end">₹{{ number_format($totals['extra'], 2) }}</td>
                        <!-- <td class="text-end">₹{{ number_format($totals['stored'], 2) }}</td> -->
                        <td class="text-end">₹{{ number_format($totals['grand'], 2) }}</td>
                        <td class="text-end">₹{{ number_format($totals['paid'], 2) }}</td>
                        <td class="text-end">₹{{ number_format($totals['due'], 2) }}</td>
                        <td></td>
                      </tr>
                    </tfoot>
                    @endif


              </table>

              <div class="mt-2">{{ $rows->links() }}</div>
            </div>
          </div>
        </div>

      </div>{{-- row --}}
    </div>
  </div>
</div>


{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Receive Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="paymentForm" method="POST" action="#">
        @csrf
        <div class="modal-body">
          <div class="mb-2">
            <div class="small text-muted" id="payCustomerInfo">Customer: —</div>
            <div class="small text-muted" id="payOrderInfo">Order: —</div>
          </div>

         <div class="mb-3">
          <label class="form-label">Amount (₹) <span class="text-danger">*</span></label>
          <input type="number" step="0.01" min="0.01" class="form-control" name="total_amount" id="payAmount" required>
          <div id="payAmountError" class="invalid-feedback d-block"></div>
        </div>


          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="entry_date" id="payDate" value="{{ now()->format('Y-m-d') }}">
          </div>

          <div class="mb-2">
            <label class="form-label">Comment</label>
            <input type="text" class="form-control" name="comment" id="payComment" placeholder="Payment received">
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Save Payment</button>
          <button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


{{-- Order Payments Modal --}}
<div class="modal fade" id="orderPaymentsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderPayTitle">Order Payments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderPayBody">
        <div class="p-5 text-center">
          <div class="spinner-border"></div>
          <div class="small text-muted mt-2">Loading…</div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- Receive Modal --}}
<div class="modal fade" id="receiveModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="receiveForm" class="modal-content">
      @csrf @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Mark Received</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {{-- Context --}}
        <div class="mb-2 small text-muted" id="receiveContext"></div>

        <div class="row g-2">
          <div class="col-md-6">
            <label class="form-label">Placed Date</label>
            <input type="date" class="form-control" id="placedDate" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Received Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="received_date" id="receivedDate" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Rate / Day (₹) <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="rate" id="ratePerDay" min="1" step="1" value="{{ $rate }}" readonly>
          </div>
          <div class="col-md-6">
            <label class="form-label">Days (auto)</label>
            <input type="text" class="form-control" id="calcDays" readonly>
          </div>

          <div class="col-12">
            <div class="alert alert-info py-2 mb-0" id="calcTotal">Total: ₹0.00</div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Save</button>
        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
(function(){ 
  const paymentModal = document.getElementById('paymentModal');
  const paymentForm  = document.getElementById('paymentForm');
  const payCustomerInfo = document.getElementById('payCustomerInfo');
  const payOrderInfo    = document.getElementById('payOrderInfo');
  const payAmount  = document.getElementById('payAmount');
  const payDate    = document.getElementById('payDate');
  const payComment = document.getElementById('payComment');

  document.querySelectorAll('.btnPay').forEach(btn => {
    btn.addEventListener('click', () => {
      const orderId   = btn.dataset.orderId;
      const custName  = btn.dataset.customerName || '—';
      const custId    = btn.dataset.customerId || '';
      const service   = btn.dataset.service || '';
      const orderDate = btn.dataset.orderDate || '';
      const total_amount = btn.dataset.totalAmount || '';
      // Set form action to /daily-orders/{id}/payment
      paymentForm.action = "{{ route('daily-orders.payment', ':id') }}".replace(':id', orderId);

      // Prefill UI
      payCustomerInfo.textContent = `Customer: ${custName} (ID: ${custId})`;
      payOrderInfo.textContent    = `Order #${orderId} • ${service} • ${orderDate}`;
      payAmount.value  = total_amount;
      payComment.value = `Payment received for Order #${orderId}`;
      if(!payDate.value) {
        const today = new Date().toISOString().slice(0,10);
        payDate.value = today;
      }
    });
  });
})();


(function(){ 
  const paymentForm  = document.getElementById('paymentForm');
  const payAmount    = document.getElementById('payAmount');
  const payErr       = document.getElementById('payAmountError');
  const saveBtn      = paymentForm.querySelector('.btn.btn-success');

  let currentDue = 0;

  function fmtINR(n){
    return '₹' + (Number(n)||0).toLocaleString('en-IN',{minimumFractionDigits:2, maximumFractionDigits:2});
  }

  function validatePay(){
    const val = parseFloat(payAmount.value || '0');
    if (currentDue <= 0.0001) {
      payAmount.classList.add('is-invalid');
      payErr.textContent = 'This order is already fully paid.';
      saveBtn.disabled = true;
      return false;
    }
    if (isNaN(val) || val <= 0) {
      payAmount.classList.add('is-invalid');
      payErr.textContent = 'Enter a valid amount greater than 0.';
      saveBtn.disabled = true;
      return false;
    }
    if (val - currentDue > 0.0001) {
      payAmount.classList.add('is-invalid');
      payErr.textContent = `Payment exceeds due amount (Due: ${fmtINR(currentDue)}).`;
      saveBtn.disabled = true;
      return false;
    }
    payAmount.classList.remove('is-invalid');
    payErr.textContent = '';
    saveBtn.disabled = false;
    return true;
  }

  // When Pay button opens the modal, prefill & validate
  document.querySelectorAll('.btnPay').forEach(btn => {
    btn.addEventListener('click', () => {
      const due  = parseFloat(btn.dataset.due || '0') || 0;
      currentDue = Math.max(0, due);

      // Prefill amount with the remaining due (you can change to empty if you prefer)
      payAmount.value = currentDue > 0 ? currentDue.toFixed(2) : '';
      validatePay();
    });
  });

  payAmount.addEventListener('input', validatePay);

  // Final guard on submit (prevents accidental submit)
  paymentForm.addEventListener('submit', (e) => {
    if (!validatePay()) e.preventDefault();
  });
})();


// ddetail view 


(function(){
  const modalEl = document.getElementById('orderPaymentsModal');
  const modal   = new bootstrap.Modal(modalEl);
  const titleEl = document.getElementById('orderPayTitle');
  const bodyEl  = document.getElementById('orderPayBody');

  document.querySelectorAll('.js-order-payments').forEach(btn => {
    btn.addEventListener('click', async () => {
      const orderId = btn.dataset.orderId;
      const cust    = btn.dataset.customerName || 'Customer';

      titleEl.textContent = `Order #${orderId} — Payments`;
      bodyEl.innerHTML = `
        <div class="p-5 text-center">
          <div class="spinner-border"></div>
          <div class="small text-muted mt-2">Loading…</div>
        </div>`;
      modal.show();

      const url = "{{ route('daily-orders.order-payments', ':id') }}"
        .replace(':id', encodeURIComponent(orderId));

      try {
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
        const html = await res.text();
        bodyEl.innerHTML = html;
      } catch (e) {
        bodyEl.innerHTML = `<div class="alert alert-danger mb-0">Failed to load payments.</div>`;
      }
    });
  });
})();

</script>
<script>
(function(){
  const modalEl   = document.getElementById('receiveModal');
  const formEl    = document.getElementById('receiveForm');
  const ctxEl     = document.getElementById('receiveContext');
  const placedEl  = document.getElementById('placedDate');
  const recvEl    = document.getElementById('receivedDate');
  const rateEl    = document.getElementById('ratePerDay');
  const daysEl    = document.getElementById('calcDays');
  const totalEl   = document.getElementById('calcTotal');

  const bsModal   = new bootstrap.Modal(modalEl);

  // Build action URL with id
  const receiveUrlTpl = @json(route('daily-orders.receive', ':id'));

  // Utilities
  function ymd(d){ return d.toISOString().slice(0,10); } // YYYY-MM-DD
  function parseYMD(s){
    // Parse YYYY-MM-DD as UTC midnight to avoid TZ off-by-one
    const [y,m,d] = (s||'').split('-').map(Number);
    if(!y||!m||!d) return null;
    return new Date(Date.UTC(y, m-1, d));
  }
  function diffDays(a,b){ // b - a, NOT inclusive (25->27 = 2)
    const ms = (b - a);
    return ms < 0 ? 0 : Math.floor(ms / 86400000);
  }
  function fmtCurrency(n){
    try { return '₹' + (Number(n)||0).toLocaleString('en-IN', {minimumFractionDigits:2, maximumFractionDigits:2}); }
    catch { return '₹' + (Number(n)||0).toFixed(2); }
  }
  function recompute(){
    const placed = parseYMD(placedEl.value);
    const recv   = parseYMD(recvEl.value);
    const rate   = Number(rateEl.value||0);
    if(!placed || !recv || !rate){ daysEl.value = ''; totalEl.textContent=''; return; }
    const days   = diffDays(placed, recv);      // NOT inclusive
    const total  = days * rate;
    daysEl.value = String(days);
    totalEl.textContent = `Total: ${fmtCurrency(total)} (Days: ${days} × Rate: ${fmtCurrency(rate)})`;
  }

  // Open modal on button click
  document.querySelectorAll('.btn-open-receive').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const id       = btn.dataset.id;
      const placed   = btn.dataset.placed || '';
      const rate     = Number(btn.dataset.rate || 200);
      const customer = btn.dataset.customer || '';

      // Fill fields
      placedEl.value = placed;
      recvEl.value   = @json(now()->toDateString());
      rateEl.value   = rate;
      ctxEl.textContent = customer ? `Customer: ${customer} (Order #${id})` : `Order #${id}`;

      // Update form action
      formEl.action = receiveUrlTpl.replace(':id', id);

      // Initial compute
      recompute();

      // Show modal
      bsModal.show();
    });
  });

  // Live recompute
  [recvEl, rateEl].forEach(el => el.addEventListener('input', recompute));
})();
</script>
@endsection


