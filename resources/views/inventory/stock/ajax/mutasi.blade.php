<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('stock.store', $data->data->item_id) }}" method="POST" id="updateForm"
            onsubmit="disableButton(event)">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <input type="hidden" class="form-control bg-body-secondary" id="item_id" name="item_id"
                        value="{{ $data->data->item_id }}" readonly>
                    <label for="kodeitem" class="form-label fw-bold mb-0">Kode Item </label>
                </div>
                <div class="col-md-9">
                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data->data->kode_stock }}</label>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Nama Item </label>
                </div>
                <div class="col-md-9">
                    <label for="namaitem" class="form-label fw-bold mb-0">{{ $data->data->nama_stock }}</label>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Quantity</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control bg-body-secondary" id="qty" name="qty"
                        value="{{ $data->data->qty_per_box }}" readonly>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Tanggal Mutasi<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="date" class="form-control" id="date_mutation" name="date_mutation"
                        value="{{ \Carbon\Carbon::today()->toDateString() }}">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Jenis Mutasi<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="jenis_mutasi">
                        <option value="" selected disabled>Pilih Jenis Mutasi</option>
                        <option value="0">Mutasi Masuk</option>
                        <option value="1">Mutasi Keluar</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Jumlah Mutasi (Lt/Kg)<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="qty_mutasi" name="qty_mutasi"
                        placeholder="Jumlah Mutasi">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="namaitem" class="form-label fw-bold mb-0">Keterangan Mutasi<span
                            class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" rows="4" id="mutation_reason" name="mutation_reason"></textarea>
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
