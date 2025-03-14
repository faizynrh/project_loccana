<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <div class="modal-body">
            <form action="{{ route('uom.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
                @csrf
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="uom_name" class="form-label">UOM <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="uom_name" name="uom_name" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="uom_symbol" class="form-label">Simbol UOM <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="uom_symbol" name="uom_symbol" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="description" class="form-label">Keterangan</label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
