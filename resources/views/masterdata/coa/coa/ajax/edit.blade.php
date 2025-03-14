<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form id="editCOAForm" method="POST" action="{{ route('coa.update', $data->data->id) }}"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="parent_account_id" class="form-label fw-bold mb-0">Parent <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="parent_account_id" name="parent_account_id">
                        <option value="" selected disabled>Pilih Parent</option>
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
                    <label for="account_code" class="form-label fw-bold mb-0">Kode Akun<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="edit_account_code" name="account_code"
                        value="{{ $data->data->account_code }}" placeholder="Kode Akun" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_name" class="form-label fw-bold mb-0">Nama Akun<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="edit_account_name" name="account_name"
                        placeholder="Nama Akun" value="{{ $data->data->account_name }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_type_id" class="form-label fw-bold mb-0">Tipe Akun <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" id="account_type_id" name="account_type_id" required>
                        <option value="" selected disabled>Pilih Tipe Akun</option>
                        @foreach ($coatype->data as $type)
                            <option value="{{ $type->id }}"
                                {{ $type->id == $data->data->account_type_id ? 'selected' : '' }}>{{ $type->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Keterangan COA <span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" id="edit_description" name="description" rows="5" required>{{ $data->data->description }}</textarea>
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
