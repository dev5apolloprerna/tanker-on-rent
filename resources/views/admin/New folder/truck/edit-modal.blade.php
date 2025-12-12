<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST">
          @csrf
          @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Truck</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="mb-3">
                        <label class="form-label">Godown</label>
                        <select name="godown_id" id="editgodown_id" class="form-control">
                            @foreach($godown as $g)
                                <option value="{{ $g->godown_id }}">{{ $g->Name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Truck Name</label>
                        <input type="text" id="editName" name="truck_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Truck Number</label>
                        <input type="text" id="editNumber" name="truck_number" class="form-control" required>
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
