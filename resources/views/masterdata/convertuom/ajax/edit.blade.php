<div class="row g-3">
    <div class="row g-3">
        <div class="col-12">
            <div class="modal-body">
                <form action="{{ route('convert_uom.update', $data->data->id) }}" method="POST" id="editConvertUomForm"
                    onsubmit="disableButton(event)">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="dari_edit" class="form-label">Satuan Asal</label>
                            <select class="form-select" name="dari" id="dari_edit" required>
                                <option value="" selected disabled>Pilih Satuan Asal</option>
                                @foreach ($uom->data as $uoms)
                                    <option value="{{ $uoms->id }}"
                                        {{ $data->data->from_uom_id == $uoms->id ? 'selected' : '' }}>
                                        {{ $uoms->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="conversion_factor_edit" class="form-label">Faktor Konversi</label>
                            <input type="number" class="form-control" id="conversion_factor_edit"
                                name="conversion_factor" placeholder="Masukkan Faktor Konversi" required
                                value="{{ $data->data->conversion_factor }}">
                        </div>
                        <div class="col-md-4">
                            <label for="ke_edit" class="form-label">Satuan Tujuan</label>
                            <select class="form-select" name="ke" id="ke_edit" required>
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
                        <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
