<div class="row g-3">
    <div class="col-12">
        <h6 class="mb-3">Harap isi data yang telah ditandai dengan <span class="text-danger bg-light px-1">*</span>,
            dan
            masukkan data dengan benar.</h6>
    </div>
    <div class="col-12">
        <div class="modal-body">
            <form action="{{ route('asset.update', $data->data[0]->id) }}" id="editAssetForm" method="POST"
                onsubmit="disableButton(event)">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="asset_name" class="form-label fw-bold">Nama Asset</label>
                        <input type="text" class="form-control" id="asset_name" name="asset_name"
                            value="{{ $data->data[0]->asset_name }}" placeholder="Masukkan Nama Asset" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="asset_type" class="form-label fw-bold">Tipe Asset</label>
                        <input type="text" class="form-control" id="asset_type" name="asset_type"
                            value="{{ $data->data[0]->asset_type }}" placeholder="Masukkan Tipe Asset" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="acquisition_date" class="form-label fw-bold">Tanggal Perolehan</label>
                        <input type="date" class="form-control" id="acquisition_date" name="acquisition_date"
                            value="{{ $data->data[0]->acquisition_date }}" placeholder="Masukkan Tanggal Perolehan"
                            disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="acquisition_cost" class="form-label fw-bold">Harga Perolehan</label>
                        <input type="text" class="form-control" id="acquisition_cost" name="acquisition_cost"
                            value="{{ $data->data[0]->acquisition_cost }}" placeholder="Masukkan Harga Perolehan">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="accumulated_depreciation" class="form-label fw-bold">Accumulated
                            Depreciation</label>
                        <input type="text" class="form-control" id="accumulated_depreciation"
                            name="accumulated_depreciation" value="{{ $data->data[0]->accumulated_depreciation }}"
                            placeholder="Masukkan Akumulasi Depresiasi">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="depreciation_rate" class="form-label fw-bold">Depreciation Rate</label>
                        <input type="text" class="form-control" id="depreciation_rate" name="depreciation_rate"
                            value="{{ $data->data[0]->depreciation_rate }}"
                            placeholder="Masukkan Persentase Depresiasi">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <input type="text" class="form-control bg-body-secondary" value="test update" id="status"
                            name="status" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="coa_id" class="form-label fw-bold">COA</label>
                        <select name="coa_id" id="coa_id" class="form-select">
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
            </form>
        </div>
    </div>
</div>
