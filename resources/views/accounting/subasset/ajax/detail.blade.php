<div class="row g-3">
    <div class="col-12">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="asset_name" class="form-label fw-bold">Nama Asset</label>
                    <input type="text" class="form-control" id="asset_name" name="asset_name"
                        value="{{ $data->data[0]->asset_name }}" disabled placeholder="Masukkan Nama Asset">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="asset_type" class="form-label fw-bold">Tipe Asset</label>
                    <input type="text" class="form-control" id="asset_type" name="asset_type"
                        value="{{ $data->data[0]->asset_type }}" disabled placeholder="Masukkan Tipe Asset">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="acquisition_date" class="form-label fw-bold">Tanggal Perolehan</label>
                    <input type="date" class="form-control" id="acquisition_date" name="acquisition_date"
                        value="{{ $data->data[0]->acquisition_date }}" disabled
                        placeholder="Masukkan Tanggal Perolehan">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="acquisition_cost" class="form-label fw-bold">Harga Perolehan</label>
                    <input type="text" class="form-control" id="acquisition_cost" name="acquisition_cost"
                        value="{{ $data->data[0]->acquisition_cost }}" disabled placeholder="Masukkan Harga Perolehan">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="accumulated_depreciation" class="form-label fw-bold">Accumulated
                        Depreciation</label>
                    <input type="text" class="form-control" id="accumulated_depreciation"
                        name="accumulated_depreciation" value="{{ $data->data[0]->accumulated_depreciation }}" disabled
                        placeholder="Masukkan Akumulasi Depresiasi">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="depreciation_rate" class="form-label fw-bold">Depreciation Rate</label>
                    <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate"
                        value="{{ $data->data[0]->depreciation_rate }}" disabled
                        placeholder="Masukkan Persentase Depresiasi">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <input type="text" class="form-control bg-body-secondary" value="{{ $data->data[0]->status }}"
                        id="status" name="status" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="chart_of_account_id" class="form-label fw-bold">COA</label>
                    <select name="chart_of_account_id" id="chart_of_account_id" class="form-control" disabled>
                        @if (isset($coa->data))
                            @foreach ((array) $coa->data as $coaItem)
                                <option value="{{ $coaItem->id }}"
                                    {{ $data->data[0]->coa_id == $coaItem->id ? 'selected' : '' }}>
                                    {{ $coaItem->description }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Data COA tidak tersedia</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
