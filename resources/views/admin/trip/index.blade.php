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
                    <div class="card-body d-flex gap-2">

                        <input type="date" name="trip_date"
                               value="{{ request('trip_date') }}"
                               class="form-control w-25">

                        <input type="text" name="product"
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
                               class="form-control">

                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>

                <div class="card-body">

                    <button class="btn btn-danger btn-sm mb-2" id="bulkDeleteBtn">
                        <i class="fa fa-trash"></i> Bulk Delete
                    </button>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Date</th>
                                <th>Truck</th>
                                <th>Driver</th>
                                <th>Product</th>
                                <th>Route</th>
                                <th>Weight</th>
                                <th width="90">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                            <tr>
                                <td><input type="checkbox" class="rowCheck" value="{{ $trip->trip_id }}"></td>
                                <td>{{ $trip->trip_date }}</td>
                                <td>{{ $trip->truck->truck_name ?? '-' }}</td>
                                <td>{{ $trip->driver->driver_name ?? '-' }}</td>
                                <td>{{ $trip->product }}</td>
                                <td>{{ $trip->source }} → {{ $trip->destination }}</td>
                                <td>{{ $trip->weight }}</td>

                                <td>
                                    <a href="{{ route('trip.edit', $trip->trip_id) }}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <button class="btn btn-danger btn-sm deleteBtn"
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
</script>
@endsection
