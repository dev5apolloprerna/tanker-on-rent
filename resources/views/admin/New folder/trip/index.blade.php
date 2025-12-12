@extends('layouts.app')

@section('title', 'Trip Master')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Trip List</h4>

                    <a href="{{ route('trip.create') }}" class="btn btn-success btn-sm">
                        + Add Trip
                    </a>
                </div>

                {{-- SEARCH --}}
                <form method="GET" action="{{ route('trip.index') }}">
                    <div class="card-body d-flex gap-2 row">

                       <div class="col-md-2">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date"
                                   value="{{ request('from_date') }}"
                                   class="form-control">
                        </div>

                        {{-- To Date --}}
                        <div class="col-md-2">
                            <label class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date"
                                   value="{{ request('to_date') }}"
                                   class="form-control">
                        </div>

                          <div class="col-md-2">
                            <label class="form-label">Truck</label>
                            <select name="truck_id" id="truck_id" class="form-select">
                                <option value="">All Trucks</option>
                                @foreach($trucks as $t)
                                    <option value="{{ $t->truck_id }}"
                                        {{ request('truck_id') == $t->truck_id ? 'selected' : '' }}>
                                        {{ $t->truck_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                      <!--   <input type="text" name="product"
                               value="{{ request('product') }}"
                               placeholder="Product"
                               class="form-control">

                        <input type="text" name="source"
                               value="{{ request('source') }}"
                               placeholder="Source"
                               class="form-control">

                        <input type="text" name="destination"
                               value="{{ request('destination') }}"
                               placeholder="Destination"
                               class="form-control"> -->
                               <div class="col-md-2 mt-4"> 
                                   
                                    <button class="btn btn-primary">Search</button>
                                    <a href="{{ route('trip.index') }}" class="btn btn-light">Reset</a>
                               </div>

                    </div>
                </form>

                <div class="card-body">

                    <div class="row mb-3 align-items-center">
                        
                        {{-- Left: Bulk Delete Button --}}
                        <div class="col-md-6">
                            <button class="btn btn-danger btn-sm" id="bulkDeleteBtn">
                                <i class="fa fa-trash"></i> Bulk Delete
                            </button>
                        </div>

                        {{-- Right: Export to Excel --}}
                        <div class="col-md-6 text-end">
                            <button onclick="genrateToexcel()" type="button" class="btn btn-success btn-sm">
                                <i class="fa fa-file-excel"></i> Export to Excel
                            </button>
                        </div>

                    </div>

                        @if($trips->count())
                            @php
                                $totalWeight = $trips->sum(function($t) {
                                    return (float) preg_replace('/[^0-9.]/', '', $t->weight);
                                });
                                $totalTons = $totalWeight / 1000;
                            @endphp

                    <div class="text-end mt-2">
                    <span class="badge bg-success me-3" style="font-size: small;">Total Weight: {{ number_format($totalWeight, 2) }} kg</span>
                    <span class="badge bg-danger me-3" style="font-size: small;">Total Tons: {{ number_format($totalTons, 2) }} (ટન) </span>
                    </div>

                        @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Date</th>
                                <th>Truck</th>
                                <th>Driver</th>
                                <th>Product</th>
                                <th>Route</th>
                                <th>No of Packet</th>
                                <th>Weight</th>
                                <th width="90">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)


                            <tr>
                                <td><input type="checkbox" class="rowCheck" value="{{ $trip->trip_id }}"></td>
                                <td>{{ date('d-m-Y',strtotime($trip->trip_date)) }}</td>
                                <td>{{ $trip->truck->truck_name ?? '-' }}</td>
                                <td>{{ $trip->driver->driver_name ?? '-' }}</td>
                                <td>{{ $trip->product }}</td>
                                <td>{{ $trip->source }} → {{ $trip->destination }}</td>
                                <td>{{ $trip->no_of_bags ?? '0' }}</td>
                                <td>{{ $trip->weight }}</td>

                                <td>
                                    <a href="{{ route('trip.edit', $trip->trip_id) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm deleteBtn"

                                            data-id="{{ $trip->trip_id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {!! $trips->appends(request()->query())->links() !!}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$('#selectAll').click(function() {
    $('.rowCheck').prop('checked', this.checked);
});

$('.deleteBtn').click(function () {
    if (!confirm("Delete this trip?")) return;

    $.post("{{ route('trip.delete') }}", {
        id: $(this).data('id'),
        _token: '{{ csrf_token() }}'
    }, function(res) {
        if (res.success) location.reload();
    });
});

$('#bulkDeleteBtn').click(function () {
    let ids = [];

    $('.rowCheck:checked').each(function () {
        ids.push($(this).val());
    });

    if (ids.length === 0) {
        alert("Please select at least one record");
        return;
    }

    if (!confirm("Delete selected trips?")) return;

    $.post("{{ route('trip.bulkDelete') }}", {
        ids: ids,
        _token: '{{ csrf_token() }}'
    }, function (res) {
        if (res.success) location.reload();
    });
});

 function genrateToexcel()
    {
        var fromdate = $('#from_date').val();
        var todate = $('#to_date').val();
        var truckid = $('#truck_id').val();
        var Url = "{{route('trip.exportData',[":fromdate",":todate",":truckid"])}}";
        Url = Url.replace(':fromdate', fromdate);
        Url = Url.replace(':todate', todate);
        Url = Url.replace(':truckid', truckid);
        window.location.href = Url;
    }
</script>
@endsection
