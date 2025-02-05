<div class="row g-3">
    <div class="col-12">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_account_id" class="form-label fw-bold mb-0">Parent</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="account_code" value="{{ $data->data->parent_name }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_code" class="form-label fw-bold mb-0">Kode Akun</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="account_code" value="{{ $data->data->account_code }}"
                    readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_name" class="form-label fw-bold mb-0">Nama Akun</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="edit_account_name" name="account_name"
                    value="{{ $data->data->account_name }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="description" class="form-label fw-bold mb-0">Keterangan COA </label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="edit_description" name="description" rows="5" readonly>{{ $data->data->description }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Back</button>
        </div>
    </div>
</div>
