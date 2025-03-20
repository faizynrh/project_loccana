<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('gudang.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="name" class="form-label fw-bold mb-0">Nama Gudang <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" placeholder="Nama Gudang" required
                        minlength="3">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Deskripsi Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="description" placeholder="Deskripsi Gudang"
                        required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="location" class="form-label fw-bold mb-0">Alamat Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" name="location" rows="5" required></textarea>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="location" class="form-label fw-bold mb-0">Kapasitas Gudang<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" name="capacity" placeholder="Kapasitas" required
                        min="1">
                </div>
            </div>
            <div class="row">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                </div>
            </div>
        </form>
        </form>
    </div>
</div>
