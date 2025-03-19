<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>, dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <div class="modal-body">
            <form action="{{ route('asset.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="asset_name" class="form-label fw-bold">Nama Asset <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_name" name="asset_name" required
                            placeholder="Masukkan Nama Asset">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="asset_type" class="form-label fw-bold">Tipe Asset <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="asset_type" name="asset_type" required
                            placeholder="Masukkan Tipe Asset">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="acquisition_date" class="form-label fw-bold">Tanggal Perolehan <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="acquisition_date" name="acquisition_date"
                            required placeholder="Masukkan Tanggal Perolehan">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="acquisition_cost" class="form-label fw-bold">Harga Perolehan <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="acquisition_cost" name="acquisition_cost"
                            required placeholder="Masukkan Harga Perolehan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="accumulated_depreciation" class="form-label fw-bold">Accumulated
                            Depreciation <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="accumulated_depreciation"
                            name="accumulated_depreciation" required placeholder="Masukkan Akumulasi Depresiasi">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="depreciation_rate" class="form-label fw-bold">Depreciation Rate <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate"
                            required placeholder="Masukkan Persentase Depresiasi">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <input type="text" class="form-control bg-body-secondary" value="active" id="status"
                            name="status" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="chart_of_account_id" class="form-label fw-bold">COA <span
                                class="text-danger">*</span></label>
                        <select type="number" name="coa_id" placeholder="coa_id" class="form-select"
                            id="partner_type_id" required>
                            <option value="" disabled selected>Pilih COA</option>
                            @if (isset($coa->data))
                                @foreach ($coa->data as $coa)
                                    <option value="{{ $coa->id }}">{{ $coa->description }}</option>
                                @endforeach
                            @else
                                <option value="">Data tidak tersedia</option>
                            @endif
                        </select>
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
</div>
