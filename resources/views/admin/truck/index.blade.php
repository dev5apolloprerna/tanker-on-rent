@extends('layouts.app')

@section('title', 'Truck Master')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Truck</h5>
                            <form method="POST" action="{{ route('truck.store') }}">
                                @csrf
                                 <div class="mb-3">
                                    <label class="form-label">Truck Name <span style="color:red;">*</span></label>
                                    <input type="text" name="truck_name" class="form-control" value="{{ old('truck_name') }}">
                                    @if($errors->has('truck_name'))
                                        <span class="text-danger">{{ $errors->first('truck_name') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Truck Number <span style="color:red;">*</span></label>
                                    <input type="text" name="truck_number" class="form-control" value="{{ old('truck_number') }}">
                                    @if($errors->has('truck_number'))
                                        <span class="text-danger">{{ $errors->first('truck_number') }}</span>
                                    @endif
                                </div>
                                
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="reset" class="btn btn-light">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <form id="bulkDeleteForm" method="POST" action="{{ route('truck.bulkDelete') }}">
                        @csrf
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tanker List</h5>
                                <div class="d-flex">
                                    <input type="text" name="truck_name" class="form-control me-2" placeholder="Tanker Name" value="{{ request('truck_name') }}">
                                    <input type="text" name="truck_number" class="form-control me-2" placeholder="Tanker Code" value="{{ request('truck_number') }}">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <button type="submit" class="btn btn-danger btn-sm mb-2" onclick="return confirm('Delete selected?')"> <i class="far fa-trash-alt"></i> Bulk Delete</button>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Status</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trucks as $truck)
                                            <tr>
                                                <td><input type="checkbox" name="ids[]" value="{{ $truck->truck_id }}"></td>
                                                <td>{{ $truck->truck_name }}</td>
                                                <td>{{ $truck->truck_number }}</td>
                                                <td>{{ $truck->status == 0 ? 'Inside' : 'Outside' }}</td>
                                                <td>{{ date('d-m-Y', strtotime($truck->created_at)) }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info editBtn"
                                                        data-id="{{ $truck->truck_id }}"
                                                        data-name="{{ $truck->truck_name }}"
                                                        data-number="{{ $truck->truck_number }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                   <!--  <button type="button"
                                                        class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-id="{{ $truck->truck_id }}"
                                                        data-name="{{ $truck->truck_name }}"
                                                        data-code="{{ $truck->truck_number }}">
                                                    <i class="fas fa-edit"></i>
                                                </button> -->

<!--                                                     <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="{{ $truck->truck_id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button> -->
                                                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $truck->truck_id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {!! $trucks->links() !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.truck.edit-modal')
@endsection


@section('scripts')
<script>
$('#selectAll').click(function() {
    $('input[name="ids[]"]').prop('checked', this.checked);
});

// Single Delete
$('.delete-btn').click(function () {
    if (confirm('Delete this record?')) {
        let id = $(this).data('id');
        $.post("{{ route('truck.delete') }}", {
            id: id,
            _token: '{{ csrf_token() }}'
        }, function (response) {
            if (response.success) {
                location.reload();
            }
        });
    }
});

// Edit Button Click – Only triggers when clicking .edit-btn or modal open button
$(document).on('click', '[data-bs-target="#editTruckModal"]', function () {

    let id   = $(this).data('id');
    let name = $(this).data('name');
    let code = $(this).data('code');

    let form = $('#editTruckForm');
    form.attr('action', "{{ url('admin/tanker') }}/" + id);

    $('#editTruckForm [name="truck_id"]').val(id);
    $('#editTruckForm [name="truck_name"]').val(name);
    $('#editTruckForm [name="truck_number"]').val(code);
});

$(".editBtn").on("click", function () {

    let id = $(this).data("id");
    let name = $(this).data("name");
    let number = $(this).data("number");

    $("#editId").val(id);
    $("#editName").val(name);
    $("#editNumber").val(number);

    $("#editForm").attr("action", "/admin/truck/" + id);

    // Open Bootstrap 5 modal
    var modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
});


</script>
@endsection