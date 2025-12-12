<div class="modal fade" id="editTankerModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editTankerForm" method="POST">
            @csrf
            @method('POST') <!-- using POST for update as per your routes -->

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tanker</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Godown</label>
                        <select name="godown_id" class="form-control">
                            @foreach($godown as $g)
                                <option value="{{ $g->godown_id }}">{{ $g->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanker Name</label>
                        <input type="text" name="tanker_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanker Code</label>
                        <input type="text" name="tanker_code" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="0">Inside</option>
                            <option value="1">Outside</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </div>

        </form>
    </div>
</div>
