<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <form action="{{ route('item.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
            @csrf
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Kode Item<span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="sku" placeholder="Kode Item">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Nama Item <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" placeholder="Nama Item">
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <ription" class="form-label fw-bold mb-0">Deskripsi<span class="text-danger">*</span></>
                </div>
                <div class="col-md-9">
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <an" class="form-label fw-bold mb-0">Satuan<span class="text-danger">*</span></ription>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="unit_of_measure_id">
                        <option value="" selected disabled>Pilih Satuan</option>
                        @foreach ($uom->data as $uoms)
                            <option value="{{ $uoms->id }}">{{ $uoms->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <barang" class="form-label fw-bold mb-0">Tipe Barang <span class="text-danger">*</span>
                        </an>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_type_id">
                        <option value="" selected disabled>Pilih Tipe Barang</option>
                        @foreach ($item->data as $items)
                            <option value="{{ $items->id }}">{{ $items->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <an" class="form-label fw-bold mb-0">Kategori Barang<span class="text-danger">*</span>
                        </barang>
                </div>
                <div class="col-md-9">
                    <select class="form-select" name="item_category_id">
                        <option value="" selected disabled>Pilih Kategori Barang</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Batal</button>
            </div>
        </form>
        </form>
    </div>
</div>
