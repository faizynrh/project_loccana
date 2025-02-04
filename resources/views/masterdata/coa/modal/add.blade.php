<div class="modal fade" id="addCOAModal" tabindex="-1" aria-labelledby="addCOAModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCOAModalLabel">Add COA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span
                        class="text-danger bg-light px-1">*</span>, dan
                    masukkan data dengan benar.</h6>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('coa.store') }}" method="POST" id="createForm">
                    @csrf
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="parent_account_id" class="form-label fw-bold mb-0">Parent <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <select class="form-select" id="parent_account_id" name="parent_account_id">
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
                            <input type="text" class="form-control" id="account_code" name="account_code"
                                placeholder="Kode Akun" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="account_name" class="form-label fw-bold mb-0">Nama Akun<span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="account_name" name="account_name"
                                placeholder="Nama Akun" required>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-3">
                            <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                                    class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitButton"
                            onclick="confirmSubmit('submitButton', 'createForm')">Submit</button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
