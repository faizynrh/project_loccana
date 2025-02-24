<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form id="editrangeprice" method="POST" action="{{ route('range_price.update', $data->data->item_id) }}"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">Kode Akun</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control bg-body-secondary" name="account_code"
                        value="{{ $data->data->item_code }}" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_name" class="form-label fw-bold mb-0">Nama Akun</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control bg-body-secondary" name="account_name"
                        value="{{ $data->data->item_name }}" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Nama Principal</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control bg-body-secondary" name="account_name"
                        value="{{ $data->data->partner_name }}" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Harga<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="number" class="form-control" name="price" value="{{ $data->data->price }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Valid From<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="date" class="form-control w-auto" name="valid_from"
                        value="{{ \Carbon\Carbon::parse($data->data->valid_from)->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="description" class="form-label fw-bold mb-0">Valid To<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="date" class="form-control w-auto" name="valid_to"
                        value="{{ \Carbon\Carbon::parse($data->data->valid_to)->format('Y-m-d') }}" required>
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
