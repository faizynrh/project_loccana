<div class="modal fade" id="editCOAModal" tabindex="-1" aria-labelledby="editCOAModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCOAModalLabel">Edit COA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span
                        class="text-danger bg-light px-1">*</span>, dan
                    masukkan data dengan benar.</h6>
                <form id="editCOAForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="parent_account_id" class="form-label fw-bold mb-0">Parent <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-select" id="edit_parent_account_id" name="parent_account_id">
                                <option value="" selected disabled>Pilih Parent</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="account_code" class="form-label fw-bold mb-0">Kode Akun<span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="edit_account_code" name="account_code"
                                placeholder="Kode Akun" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="account_name" class="form-label fw-bold mb-0">Nama Akun<span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="edit_account_name" name="account_name"
                                placeholder="Nama Akun" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" id="edit_description" name="description" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save" id="submitButton"
                            onclick="confirmEdit('submitButton', 'editCOAForm')">Submit</button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
