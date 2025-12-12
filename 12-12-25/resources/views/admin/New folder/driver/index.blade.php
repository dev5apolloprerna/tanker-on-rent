@extends('layouts.app')
@section('title', 'Driver Master')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">

                {{-- LEFT SIDE FORM --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h4 class="card-title mb-3">Add Driver</h4>

                            <form action="{{ route('driver.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Driver Name</label>
                                    <input type="text" name="driver_name" class="form-control" required>
                                </div>

                                <button class="btn btn-primary w-100">Save</button>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE LISTING --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between mb-2">
                                <h4 class="card-title">Driver List</h4>

                               
                            </div>

                            <div class="table-responsive">
                                 <button id="bulkDeleteBtn" class="btn btn-danger btn-sm" disabled>
                                   <i class="far fa-trash-alt"></i>Bulk Delete
                                </button>
                                <table class="table table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th width="40"><input type="checkbox" id="selectAll"></th>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($drivers as $i => $d)
                                        <tr>
                                            <td><input type="checkbox" class="rowCheck" value="{{ $d->driver_id }}"></td>
                                            <td>{{ $i+1 }}</td>
                                            <td>{{ $d->driver_name }}</td>

                                            <td>
                                                <button class="btn btn-info btn-sm editBtn"
                                                    data-id="{{ $d->driver_id }}"
                                                    data-name="{{ $d->driver_name }}">
                                                    <i class="fa fa-edit"></i>
                                                </button>

                                                <button class="btn btn-danger btn-sm singleDelete"
                                                    data-id="{{ $d->driver_id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No Drivers Found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>


            {{-- EDIT MODAL --}}
            <div class="modal fade" id="editModal" tabindex="-1">
                <div class="modal-dialog">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Edit Driver</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <input type="hidden" id="editId">

                                <div class="mb-3">
                                    <label class="form-label">Driver Name</label>
                                    <input type="text" id="editName" name="driver_name" class="form-control" required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
// -------------------- SELECT ALL --------------------
$("#selectAll").on("change", function () {
    $(".rowCheck").prop("checked", $(this).prop("checked"));
    toggleBulkBtn();
});

$(".rowCheck").on("change", toggleBulkBtn);

function toggleBulkBtn() {
    let any = $(".rowCheck:checked").length > 0;
    $("#bulkDeleteBtn").prop("disabled", !any);
}

// -------------------- EDIT MODAL --------------------
$(".editBtn").on("click", function () {
    let id = $(this).data("id");
    let name = $(this).data("name");

    $("#editId").val(id);
    $("#editName").val(name);

    $("#editForm").attr("action", "/admin/driver/" + id);

    new bootstrap.Modal(document.getElementById('editModal')).show();
});

// -------------------- SINGLE DELETE --------------------
$(".singleDelete").on("click", function () {
    if (!confirm("Delete this driver?")) return;

    $.post("{{ route('driver.delete') }}", {
        _token: "{{ csrf_token() }}",
        id: $(this).data("id")
    }, function () {
        location.reload();
    });
});

// -------------------- BULK DELETE --------------------
$("#bulkDeleteBtn").on("click", function () {
    if (!confirm("Delete selected drivers?")) return;

    let ids = [];
    $(".rowCheck:checked").each(function () {
        ids.push($(this).val());
    });

    $.post("{{ route('driver.bulkDelete') }}", {
        _token: "{{ csrf_token() }}",
        ids: ids
    }, function () {
        location.reload();
    });

});
</script>
@endsection
