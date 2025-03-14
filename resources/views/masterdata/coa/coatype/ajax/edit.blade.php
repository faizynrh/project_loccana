<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form id="editCOAForm" method="POST" action="{{ route('coa_type.update', $data->data->id) }}"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="type_name" class="form-label fw-bold mb-0">Nama<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="type_name" name="type_name" placeholder="Kode Akun"
                        value="{{ $data->data->type_name }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Deskripsi<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ $data->data->description }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save" id="submitButton">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Batal</button>
            </div>
        </form>
    </div>
</div>
