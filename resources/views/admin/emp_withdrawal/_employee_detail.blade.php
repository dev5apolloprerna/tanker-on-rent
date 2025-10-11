<div>
  <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
    <div>
      <h6 class="mb-1">{{ $employee->name ?? 'Employee' }}</h6>
      <small class="text-muted">Emp ID: {{ $employee->emp_id ?? '-' }}</small>
    </div>
    <div class="text-end">
      <div>Withdrawn: <strong>₹{{ number_format($withdrawTotal, 2) }}</strong></div>
      <div>Returned (salary deductions): <strong class="text-success">₹{{ number_format($returnTotal, 2) }}</strong></div>
      <div>Mobile Recharge (info): <strong>₹{{ number_format($rechargeTotal, 2) }}</strong></div>
      <div>Net Outstanding: <strong class="{{ $netOutstanding > 0 ? 'text-danger' : 'text-success' }}">₹{{ number_format($netOutstanding, 2) }}</strong></div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card border">
        <div class="card-header py-2"><strong>Withdrawals</strong></div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width:120px">Date</th>
                  <th class="text-end" style="width:120px">Amount (₹)</th>
                  <th style="width:110px">EMI (₹)</th>
                  <th style="width:130px">Remaining (₹)</th>
                  <th>Reason</th>
                </tr>
              </thead>
              <tbody>
                @forelse($withdrawals as $w)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($w->withdrawal_date)->format('d-m-Y') }}</td>
                    <td class="text-end">₹{{ number_format($w->amount, 2) }}</td>
                    <td>{{ $w->emi_amount !== null ? number_format($w->emi_amount, 2) : '-' }}</td>
                    <td>{{ $w->remaining_amount !== null ? number_format($w->remaining_amount, 2) : '-' }}</td>
                    <td>{{ $w->reason ?? '-' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-muted">No withdrawals</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card border">
        <div class="card-header py-2"><strong>Returns (Salary Deductions)</strong></div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width:120px">From</th>
                  <th style="width:120px">To</th>
                  <th class="text-end" style="width:130px">Deducted (₹)</th>
                  <th class="text-end" style="width:130px">Recharge (₹)</th>
                  <th class="text-end" style="width:130px">Salary (₹)</th>
                </tr>
              </thead>
              <tbody>
                @forelse($returns as $r)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($r->salary_date)->format('d-m-Y') }}</td>
                    <td>{{ $r->last_date ? \Carbon\Carbon::parse($r->last_date)->format('d-m-Y') : '-' }}</td>
                    <td class="text-end">₹{{ number_format($r->withdrawal_deducted ?? 0, 2) }}</td>
                    <td class="text-end">₹{{ number_format($r->mobile_recharge ?? 0, 2) }}</td>
                    <td class="text-end">₹{{ number_format($r->salary_amount ?? 0, 2) }}</td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-muted">No returns recorded</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
