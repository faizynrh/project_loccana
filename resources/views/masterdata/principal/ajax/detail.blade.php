<div class="col-12">
    <div class="modal-body">
        <form action="{{ route('principal.update', $data->data->id) }}" method="POST" id="updateForm">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Type Partner</label>
                    <select type="number" name="partner_type_id" placeholder="Type Partner" class="form-control"
                        id="partner_type_id" disabled>
                        <option value="" disabled selected>Pilih Type</option>
                        @if (isset($partner->data))
                            @foreach ($partner->data as $partnerType)
                                <option value="{{ $partnerType->id }}"
                                    {{ $data->data->partner_type_id == $partnerType->id ? 'selected' : '' }}>
                                    {{ $partnerType->name }}</option>
                            @endforeach
                        @else
                            <option value="">Data tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="name" class="form-control" id="nama" required
                        value="{{ $data->data->name }}" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">COA</label>
                    <select name="chart_of_account_id" id="chart_of_account_id" class="form-control" disabled>
                        @if (isset($coa->data))
                            @foreach ((array) $coa->data as $coaItem)
                                <option value="{{ $coaItem->id }}"
                                    {{ $data->data->chart_of_account_id == $coaItem->id ? 'selected' : '' }}>
                                    {{ $coaItem->description }}
                                </option>
                            @endforeach
                        @else
                            <option value="">Data COA tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">Contact Info</label>
                    <input type="text" name="contact_info" placeholder="Contact Info" class="form-control"
                        id="contact_info" disabled value="{{ $data->data->contact_info }}">
                </div>
            </div>
            <div class="row">
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Kembali</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
