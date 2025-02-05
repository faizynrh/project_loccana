<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('price.update', $data->data->id) }}" method="POST" id="updateForm"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data->data->kode_item }}</label>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data->data->nama_item }}</label>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargaatas" class="form-label fw-bold mb-0">Harga Atas<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="harga_atas" name="harga_atas"
                        value="{{ $data->data->harga_atas }}" placeholder="Harga Atas">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargabawah" class="form-label fw-bold mb-0">Harga Bawah<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="harga_bawah" name="harga_bawah"
                        value="{{ $data->data->harga_bawah }}" placeholder="Harga Bawah">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargapokok" class="form-label fw-bold mb-0">Harga Pokok
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control bg-body-secondary" id="harga_pokok" name="harga_pokok"
                        value="{{ $data->data->harga_pokok }}" placeholder="Harga Pokok" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargabeli" class="form-label fw-bold mb-0">Harga Beli<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="harga_beli" name="harga_beli"
                        value="{{ $data->data->harga_beli }}"placeholder="Harga Beli">
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
