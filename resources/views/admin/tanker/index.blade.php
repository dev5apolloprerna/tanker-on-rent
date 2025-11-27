@extends('layouts.app')

@section('title', 'Tanker Master')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row">

                {{-- LEFT SIDE FORM --}}
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Add Tanker</h5>

                            <form method="POST" action="{{ route('tanker.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Godown<span class="text-danger">*</span></label>
                                    <select name="godown_id" class="form-control">
                                        <option value="">Select Godown</option>
                                        @foreach($godown as $g)
                                            <option value="{{ $g->godown_id }}">{{ $g->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanker Name<span class="text-danger">*</span></label>
                                    <input type="text" name="tanker_name" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanker Code<span class="text-danger">*</span></label>
                                    <input type="text" name="tanker_code" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="0">Inside</option>
                                        <option value="1">Outside</option>
                                    </select>
                                </div>

                                <button class="btn btn-success">Submit</button>
                                <button class="btn btn-light" type="reset">Clear</button>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDE TABLE --}}
                <div class="col-md-8">

                    {{-- SEARCH FORM ONLY --}}
                    <form method="GET" action="{{ route('tanker.index') }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tanker List</h5>

                            <div class="d-flex">
                                <input type="text" name="tanker_name" value="{{ request('tanker_name') }}" class="form-control me-2" placeholder="Tanker Name">
                                <input type="text" name="tanker_code" value="{{ request('tanker_code') }}" class="form-control me-2" placeholder="Tanker Code">
                                <button class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm mb-2">
                                <i class="far fa-trash-alt"></i> Bulk Delete
                            </button>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>Godown</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($tankers as $t)
                                        <tr>
                                            <td><input type="checkbox" class="rowCheck" value="{{ $t->tanker_id }}"></td>
                                            <td>{{ $t->godown->Name ?? '-' }}</td>
                                            <td>{{ $t->tanker_name }}</td>
                                            <td>{{ $t->tanker_code }}</td>
                                            <td>{{ $t->status == 0 ? 'Inside' : 'Outside' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($t->created_at)) }}</td>

                                            <td>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary edit-btn"
                                                    data-id="{{ $t->tanker_id }}"
                                                    data-name="{{ $t->tanker_name }}"
                                                    data-code="{{ $t->tanker_code }}"
                                                    data-godown-id="{{ $t->godown_id }}"
                                                    data-status="{{ $t->status }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTankerModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $t->tanker_id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {!! $tankers->links() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@include('admin.tanker.edit-modal')
@endsection


@section('scripts')
<script>
/* Select All */
$('#selectAll').click(function(){
    $('.rowCheck').prop('checked', this.checked);
});

/* Single Delete */
$('.delete-btn').click(function () {

    if (!confirm("Delete this tanker?")) return;

    let id = $(this).data('id');

    $.post("{{ route('tanker.delete') }}", 
    {
        id: id,
        _token: '{{ csrf_token() }}'
    }, function (res) {
        if (res.success) location.reload();
    });
});

/* Bulk Delete */
$('#bulkDeleteBtn').click(function(){

    let ids = [];
    $('.rowCheck:checked').each(function(){
        ids.push($(this).val());
    });

    if(ids.length === 0){
        alert("Select at least one.");
        return;
    }

    if (!confirm("Delete selected tankers?")) return;

    $.post("{{ route('tanker.bulkDelete') }}", {
        ids: ids,
        _token: '{{ csrf_token() }}'
    }, function(res){
        if(res.success) location.reload();
    });

});

/* EDIT MODAL DATA */
document.addEventListener('click', function(e){

    let btn = e.target.closest('.edit-btn');
    if (!btn) return;

    let id = btn.dataset.id;
    let name = btn.dataset.name;
    let code = btn.dataset.code;
    let godown = btn.dataset.godownId;
    let status = btn.dataset.status;

    let form = document.getElementById('editTankerForm');
    form.action = "/admin/tanker/" + id;

    form.querySelector('[name="tanker_name"]').value = name;
    form.querySelector('[name="tanker_code"]').value = code;
    form.querySelector('[name="godown_id"]').value = godown;
    form.querySelector('[name="status"]').value = status;

});
</script>
@endsection
