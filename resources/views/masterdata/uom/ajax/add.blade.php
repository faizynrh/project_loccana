<div class="row g-3">
    <div class="col-12">
        <h5 class="modal-title" id="uomModalLabel">Tambah UOM</h5>
    </div>
    <div class="col-12">
        <div class="modal-body">
            <form action="{{ route('uom.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
                @csrf
                <div class="mb-3">
                    <label for="uom_name" class="form-label">UOM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="uom_name" name="uom_name" required>
                </div>
                <div class="mb-3">
                    <label for="uom_symbol" class="form-label">Simbol UOM <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="uom_symbol" name="uom_symbol" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
