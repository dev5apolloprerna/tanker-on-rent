@extends('layouts.app')
@section('title', 'Attendance & Payment Report')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      @include('common.alert')

      <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
          <h5 class="mb-0">
            <i class="fa fa-calendar-check me-2 text-primary"></i> Attendance Report
          </h5>
          <form method="POST" class="d-flex gap-2 align-items-center">
            @csrf
            <label class="text-muted small">From</label>
            <input type="date" name="from_date" value="{{ $from }}" class="form-control form-control-sm">
            <label class="text-muted small">To</label>
            <input type="date" name="to_date" value="{{ $to }}" class="form-control form-control-sm">
            <button class="btn  btn-primary">Search</button>
            <a href="{{ route('admin.attendance-report.index') }}" class="btn btn-light border">
              Reset
            </a>
          </form>
        </div>

        <div class="card-body">
          <h6 class="text-secondary fw-semibold mb-3">Attendance Summary</h6>
          <div class="table-responsive mb-4">
            <table class="table table-striped align-middle table-bordered">
              <thead class="table-light">
                <tr>
                  <th>Employee</th>
                  <th>Daily Wages (₹)</th>
                  <th>Present Days</th>
                  <th>Absent</th>
                  <th>Payment (₹)</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($summary as $row)
                <tr>
                  <td>
                  <button type="button"
                          class="btn btn-link p-0 js-emp-detail"
                          data-employee-id="{{ $row->emp_id }}"
                          data-employee-name="{{ $row->employee_name }}">
                    {{ $row->employee_name }}
                  </button>
                </td>


                  <!-- <td>{{ $row->employee_name }}</td> -->
                  <td>{{ number_format($row->daily_wages, 2) }}</td>
                  <td><span class="badge bg-success">{{ $row->present_days }}</span></td>
                  <td><span class="badge bg-danger">{{ $row->absent_days }}</span></td>
                  <td><strong class="text-success">₹{{ number_format($row->payment, 2) }}</strong></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No records found.</td></tr>
                @endforelse
              </tbody>
              @if($summary->count())
              <tfoot>
                <tr class="table-success">
                  <th colspan="4" class="text-end">Grand Total</th>
                  <th>₹{{ number_format($grandTotal, 2) }}</th>
                </tr>
              </tfoot>
              @endif
            </table>
          </div>


          {{-- Modal container --}}
<div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="employeeDetailLabel">Employee Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="empDetailBody">
        <div class="text-center p-5">
          <div class="spinner-border" role="status"></div>
          <div class="mt-2 small text-muted">Loading…</div>
        </div>
      </div>
    </div>
  </div>
</div>


          <!-- <h6 class="text-secondary fw-semibold mb-3">Detailed Attendance</h6>
          <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Employee</th>
                  <th>Status</th>
                  <th>Leave Reason</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($records as $r)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ \Carbon\Carbon::parse($r->attendance_date)->format('d-m-Y') }}</td>
                  <td>{{ $r->employee->name ?? '-' }}</td>
                  <td>
                    @if($r->status === 'P')
                      <span class="badge bg-success">Present</span>
                    @elseif($r->status === 'A')
                      <span class="badge bg-danger">Absent</span>
                    @else
                      <span class="badge bg-warning text-dark">Half Day</span>
                    @endif
                  </td>
                  <td>{{ $r->leave_reason ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No records found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div> -->
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const modalEl = document.getElementById('employeeDetailModal');
  const modalBody = document.getElementById('empDetailBody');
  const modalTitle = document.getElementById('employeeDetailLabel');
  const modal = new bootstrap.Modal(modalEl);

  function currentRange() {
    const fromEl = document.querySelector('input[name="from_date"]');
    const toEl   = document.querySelector('input[name="to_date"]');
    return {
      from: fromEl ? fromEl.value : '',
      to:   toEl   ? toEl.value   : '',
    };
  }

  document.querySelectorAll('.js-emp-detail').forEach(btn => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const employeeId = btn.dataset.employeeId;
      const employeeName = btn.dataset.employeeName || 'Employee';
      const { from, to } = currentRange();

      modalTitle.textContent = employeeName + ' — Details';
      modalBody.innerHTML = `
        <div class="text-center p-5">
          <div class="spinner-border" role="status"></div>
          <div class="mt-2 small text-muted">Loading…</div>
        </div>`;

      modal.show();

      try {
        const url = `{{ route('admin.attendance-report.employee-detail') }}`
                  + `?employee_id=${encodeURIComponent(employeeId)}`
                  + `&from=${encodeURIComponent(from)}`
                  + `&to=${encodeURIComponent(to)}`;

        const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
        if (!res.ok) throw new Error('Network error');

        const html = await res.text();
        modalBody.innerHTML = html;
      } catch (err) {
        modalBody.innerHTML = `
          <div class="alert alert-danger m-0">
            Failed to load details. Please try again.
          </div>`;
      }
    });
  });
});
</script>
@endsection
