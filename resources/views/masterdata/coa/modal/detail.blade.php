<div class="modal fade" id="detailCOAModal" tabindex="-1" aria-labelledby="editCOAModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCOAModalLabel">Detail COA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="parent_account_id" class="form-label fw-bold mb-0">Parent </label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="detail_parent_name" name="account_code" readonly>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Kode Akun</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="detail_account_code" name="account_code"
                            readonly>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_name" class="form-label fw-bold mb-0">Nama Akun</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="detail_account_name" name="account_name"
                            readonly>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="description" class="form-label fw-bold mb-0">Keterangan COA </label>
                    </div>
                    <div class="col-md-9">
                        <textarea class="form-control" id="detail_description" name="description" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>
