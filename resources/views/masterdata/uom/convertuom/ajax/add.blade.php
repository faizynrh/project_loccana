<div class="row g-3">
    <div class="row g-3">
        <div class="col-12">
            <div class="modal-body">
                <form action="{{ route('convert_uom.store') }}" method="POST" id="createForm"
                    onsubmit="disableButton(event)">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label for="dari" class="form-label">Satuan Asal</label>
                            <select class="form-select" name="dari" id="dari" required>
                                <option value="" selected disabled>Pilih Satuan Asal</option>
                                @foreach ($uom->data as $uoms)
                                    <option value="{{ $uoms->id }}">{{ $uoms->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="conversion_factor" class="form-label">Faktor Konversi</label>
                            <input type="number" class="form-control" id="conversion_factor" name="conversion_factor"
                                placeholder="Masukkan Faktor Konversi" required min="1"
                                oninput="this.value = this.value < 1 ? '' : this.value">
                        </div>
                        <div class="col-md-4">
                            <label for="ke" class="form-label">Satuan Tujuan</label>
                            <select class="form-select" name="ke" id="ke" required>
                                <option value="" selected disabled>Pilih Satuan Tujuan</option>
                                @foreach ($uom->data as $uoms)
                                    <option value="{{ $uoms->id }}">{{ $uoms->name }}</option>
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
