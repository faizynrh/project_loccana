<div class="row g-3">
    <div class="col-12">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="type_name" class="form-label fw-bold mb-0">Nama</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="type_name" name="type_name"
                    value="{{ $data->data->type_name }}" readonly>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="description" class="form-label fw-bold mb-0">Deskripsi</label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="description" name="description" rows="5" readonly>{{ $data->data->description }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Kembali</button>
        </div>
    </div>
</div>
