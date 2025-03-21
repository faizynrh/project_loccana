<div class="row g-3">
    <div class="col-12">
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_account_id" class="form-label fw-bold mb-0">Parent</label>
            </div>
            <div class="col-md-9">
                <select class="form-select" id="parent_account_id" name="parent_account_id" disabled>
                    <option value="999" {{ $data->data->parent_account_id == 999 ? 'selected' : '' }}>--Tanpa
                        Parent--</option>
                    @foreach ($coa->data as $item)
                        <option value="{{ $item->id }}"
                            {{ $data->data->parent_account_id == $item->id ? 'selected' : '' }}>
                            {{ $item->account_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_code" class="form-label fw-bold mb-0">Kode Akun</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="account_code" value="{{ $data->data->account_code }}"
                    disabled>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="account_name" class="form-label fw-bold mb-0">Nama Akun</label>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" id="edit_account_name" name="account_name"
                    value="{{ $data->data->account_name }}" disabled>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="parent_account_id" class="form-label fw-bold mb-0">Tipe Akun</label>
            </div>
            <div class="col-md-9">
                <select class="form-select" id="account_type_id" name="account_type_id" disabled>
                    @foreach ($coatype->data as $coatype)
                        <option value="{{ $coatype->id }}"
                            {{ $coatype->id == $data->data->account_type_id ? 'selected' : '' }}>
                            {{ $coatype->type_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3 align-items-center">
            <div class="col-md-3">
                <label for="description" class="form-label fw-bold mb-0">Keterangan COA </label>
            </div>
            <div class="col-md-9">
                <textarea class="form-control" id="edit_description" name="description" rows="5" disabled>{{ $data->data->description }}</textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Kembali</button>
        </div>
    </div>
</div>
