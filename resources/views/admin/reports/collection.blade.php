@extends('layouts.app')
@section('title','Daily Collection Report')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Daily Collection Report</h5>
          <div>
            <a class="btn btn-sm btn-outline-primary"
               href="{{ route('reports.collection.range', ['from'=>$from,'to'=>$to]) }}">
              View All Details ({{ \Carbon\Carbon::parse($from)->format('d M') }} – {{ \Carbon\Carbon::parse($to)->format('d M Y') }})
            </a>
          </div>
        </div>

        <div class="card-body">
          <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
              <label class="form-label">From</label>
              <input type="date" name="from" value="{{ $from }}" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">To</label>
              <input type="date" name="to" value="{{ $to }}" class="form-control">
            </div>
            <div class="col-md-6">
              <button class="btn btn-primary">Search</button>
              <a href="{{ route('reports.collection') }}" class="btn btn-danger">Reset (This Month)</a>
            </div>
          </form>

          <div class="table-responsive mt-3">
            <table class="table table-bordered align-middle">
              <thead class="table-primary">
                <tr>
                  <th style="width:180px">Date</th>
                  <th class="text-end" style="width:220px">Total Collection (₹)</th>
                  <th class="text-center" style="width:120px">Entries</th>
                  <th style="width:150px">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rows as $r)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($r->tx_date)->format('d M Y') }}</td>
                    <td class="text-end">₹{{ number_format($r->total_amount, 2) }}</td>
                    <td class="text-center">{{ $r->total_entries }}</td>
                    <td>
                      <a class="btn btn-sm btn-info" href="{{ route('reports.collection.day', $r->tx_date) }}">
                        View Details
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr class="table-dark">
                  <th>Grand Total</th>
                  <th class="text-end">₹{{ number_format($grand_total, 2) }}</th>
                  <th class="text-center">{{ $grand_entries }}</th>
                  <th></th>
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
