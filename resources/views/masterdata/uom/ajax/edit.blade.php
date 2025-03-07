<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>,
            dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <div class="modal-body">
            <form action="{{ route('uom.update', $data->data->id) }}" id="editUomForm" method="POST"
                onsubmit="disableButton(event)">
                @csrf
                @method('PUT')
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">UOM <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" class="form-control" value="{{ $data->data->name }}" id="uom_name"
                            name="uom_name" required>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Simbol UOM <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Simbol" class="form-control" name="uom_code"
                            {{-- {{ $uom['symbol'] }} --}} value="" required>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Keterangan UOM <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <textarea cols="30" rows="4" name="description" class="form-control">{{ $data->data->description }}</textarea>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Batal</button>
                </div>
        </div>
        </form>
    </div>
</div>
</div>
</div>
