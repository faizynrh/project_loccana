<div class="row g-3">
    <div class="row g-3">
        <div class="col-12">
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="dari" class="form-label">Satuan Asal</label>
                        <select class="form-control" name="dari" id="dari" disabled>
                            <option value="" selected disabled>Pilih Satuan Asal</option>
                            @foreach ($uom->data as $uoms)
                                <option value="{{ $uoms->id }}"
                                    {{ $data->data->from_uom_id == $uoms->id ? 'selected' : '' }}>{{ $uoms->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="conversion_factor" class="form-label">Faktor Konversi</label>
                        <input type="number" class="form-control" id="conversion_factor" name="conversion_factor"
                            placeholder="Masukkan Faktor Konversi" disabled
                            value="{{ $data->data->conversion_factor }}">
                    </div>
                    <div class="col-md-4">
                        <label for="ke" class="form-label">Satuan Tujuan</label>
                        <select class="form-control" name="ke" id="ke" disabled>
                            <option value="" selected disabled>Pilih Satuan Tujuan</option>
                            @foreach ($uom->data as $uoms)
                                <option value="{{ $uoms->id }}"
                                    {{ $data->data->to_uom_id == $uoms->id ? 'selected' : '' }}>{{ $uoms->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
