<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('price.update', $data->data->item_id) }}" method="POST" id="updateForm"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="{{ $data->data->item_code }}" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" value="{{ $data->data->item_name }}" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargaatas" class="form-label fw-bold mb-0">Harga<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="price" name="price"
                        value="{{ $data->data->price }}" placeholder="Harga Atas" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargaatas" class="form-label fw-bold mb-0">Valid From<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="date" class="form-control" id="valid_from" name="valid_from"
                        value="{{ $data->data->valid_from }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="hargaatas" class="form-label fw-bold mb-0">Valid To<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="date" class="form-control" id="valid_to" name="valid_to"
                        value="{{ $data->data->valid_to }}" required>
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
