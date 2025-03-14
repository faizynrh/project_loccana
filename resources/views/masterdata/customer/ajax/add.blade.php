<div class="col-12">
    <div class="modal-body">
        <form action="{{ route('customer.store') }}" method="POST" id="createForm" onsubmit="disableButton(event)">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Tipe Partner</label>
                    <select type="number" name="partner_type_id" placeholder="Type Partner" class="form-select"
                        id="partner_type_id"
                        style="pointer-events: none;background-color: #f0f0f0;color: #888;cursor: not-allowed;">
                        <option value="" disabled selected>Pilih Tipe</option>
                        @if (isset($partner->data))
                            @foreach ($partner->data as $partner)
                                <option value="{{ $partner->id }}"
                                    {{ $partner->name == 'Customer' ? 'selected' : '' }}>{{ $partner->name }}</option>
                            @endforeach
                        @else
                            <option value="">Data tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="Nama" class="form-control" id="nama"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chart_of_account_id" class="form-label fw-bold">COA</label>
                    <select type="number" name="chart_of_account_id" placeholder="chart_of_account_id"
                        class="form-select" id="partner_type_id" required>
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
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">Contact</label>
                    <input type="text" name="contact_info" placeholder="Contact Info" class="form-control"
                        id="contact_info" required>
                </div>
            </div>
            <div class="row">
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Batal</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
