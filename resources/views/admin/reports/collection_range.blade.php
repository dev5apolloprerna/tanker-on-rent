@extends('layouts.app')
@section('title','Collection Details')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
          Collection Details ({{ \Carbon\Carbon::parse($from)->format('d M') }} – {{ \Carbon\Carbon::parse($to)->format('d M Y') }})
        </h4>
        <a href="{{ route('reports.collection', ['from'=>$from,'to'=>$to]) }}" class="btn btn-sm btn-primary">Back to Summary</a>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Source</th>
                  <th>Ref</th>
                  <th>Customer</th>
                  <th>Service</th>
                  <th>Comment</th>
                  <th class="text-end">Amount (₹)</th>
                  <th>Time</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $i => $r)
                  <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tx_date)->format('d M Y') }}</td>
                    <td>
                      @if($r->src === 'daily') <span class="badge bg-secondary">Daily Order</span>
                      @else <span class="badge bg-info">Order</span> @endif
                    </td>
                    <td>{{ $r->ref_id }}</td>
                    <td>{{ $r->customer_name ?? '—' }}</td>
                    <td>{{ $r->service ?? '—' }}</td>
                    <td>{{ $r->comment ?? '' }}</td>
                    <td class="text-end">₹{{ number_format((float)$r->amount, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tx_time)->format('d M Y h:i A') }}</td>
                  </tr>
                @empty
                  <tr><td colspan="9" class="text-center text-muted">No entries</td></tr>
                @endforelse
              </tbody>
              <tfoot>
               <!--  <tr>
                  <th colspan="7" class="text-end">Daily Orders Subtotal</th>
                  <th class="text-end">₹{{ number_format($daily_subtotal, 2) }}</th>
                  <th></th>
                </tr>
                <tr>
                  <th colspan="7" class="text-end">Orders Subtotal</th>
                  <th class="text-end">₹{{ number_format($order_subtotal, 2) }}</th>
                  <th></th>
                </tr> -->
                <tr class="table-dark">
                  <th colspan="7" class="text-end">Grand Total</th>
                  <th class="text-end">₹{{ number_format($total_amount, 2) }}</th>
                  <th>{{ $count }} entries</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
