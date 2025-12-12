{{-- resources/views/admin/attendance-report/_employee_detail.blade.php --}}
<div>
  <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
    <div>
      <h5 class="mb-1">{{ $employee->name }}</h5>
      <small class="text-muted">
        {{ \Carbon\Carbon::parse($from)->format('d M Y') }} – {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
      </small>
    </div>
    <div class="text-end">
      <div class="mb-1">
        <span class="badge bg-success me-1">Present: {{ $present }}</span>
        <span class="badge bg-warning text-dark me-1">Half: {{ $half }}</span>
        <span class="badge bg-danger">Absent: {{ $absent }}</span>
      </div>
      <div>
        <span class="me-3 text-muted">Daily Wages: ₹{{ number_format($wage, 2) }}</span>
        <strong class="text-success">Payable: ₹{{ number_format($payment, 2) }}</strong>
      </div>
    </div>
  </div>

  <hr class="my-3">

  <div class="table-responsive">
    <table class="table table-sm table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th style="width:60px;">#</th>
          <th style="width:140px;">Date</th>
          <th>Status</th>
          <th>Leave Reason</th>
        </tr>
      </thead>
      <tbody>
      @forelse($records as $i => $r)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ \Carbon\Carbon::parse($r->attendance_date)->format('d-m-Y') }}</td>
          <td>
            @switch($r->status)
              @case('P') <span class="badge bg-success">Present</span> @break
              @case('A') <span class="badge bg-danger">Absent</span> @break
              @default    <span class="badge bg-warning text-dark">Half Day</span>
            @endswitch
          </td>
          <td>{{ $r->leave_reason ?? '-' }}</td>
        </tr>
      @empty
        <tr><td colspan="4" class="text-center text-muted">No records found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
