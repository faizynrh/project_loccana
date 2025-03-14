<div class="row g-3">
    <div class="col-12">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold mb-0">Nama</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" value="{{ $data->data->name }}" disabled>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label fw-bold mb-0">Deskripsi</label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" name="description" rows="5" disabled>{{ $data->data->description }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Kembali</button>
        </div>
    </div>
</div>
</div>
