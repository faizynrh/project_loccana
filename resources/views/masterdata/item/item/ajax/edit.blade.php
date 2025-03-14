<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('item.update', $data->data->id) }}" method="POST" id="updateForm"
            onsubmit="disableButton(event)">
            @csrf
            @method('PUT')
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Kode Item<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="sku" placeholder="Kode Item"
                        value="{{ $data->data->item_code }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Nama Item <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" placeholder="Nama Item"
                        value="{{ $data->data->item_name }}" required>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Satuan<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="unit_of_measure_id" required>
                        <option value="" selected disabled>Pilih Satuan</option>
                        @foreach ($uom->data as $uoms)
                            <option value="{{ $uoms->id }}"
                                {{ $data->data->uom_id == $uoms->id ? 'selected' : '' }}>
                                {{ $uoms->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Tipe Barang <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_type_id">
                        <option value="" selected disabled>Pilih Tipe Barang</option required>
                        @foreach ($item->data as $items)
                            <option value="{{ $items->id }}"
                                {{ $data->data->item_type_id == $items->id ? 'selected' : '' }}>
                                {{ $items->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Deskripsi <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" name="description" rows="5">{{ $data->data->item_description }}</textarea>
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
