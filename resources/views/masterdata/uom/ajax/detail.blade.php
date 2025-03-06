<div class="row g-3">
    <div class="col-12">
        <div class="modal-body">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">Uom <span class="text-danger"></span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" placeholder="UoM" name="uom_name" class="form-control"
                        value="{{ $data->data->name }}" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">Simbol UoM <span
                            class="text-danger"></span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" placeholder="Simbol" class="form-control" name="uom_code"
                        {{-- {{ $uom['symbol'] }} --}} value="" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">Keterangan UoM <span
                            class="text-danger"></span></label>
                </div>
                <div class="col-md-9">
                    <textarea cols="30" rows="4" name="description" class="form-control" readonly>{{ $data->data->description }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Kembali</button>
            </div>
        </div>
    </div>
</div>
