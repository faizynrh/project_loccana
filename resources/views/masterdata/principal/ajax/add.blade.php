<div class="col-12">
    <div class="modal-body">
        <form action="{{ route('principal.store') }}" method="POST" id="createForm">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kode" class="form-label fw-bold">Type Partner</label>
                    <select type="number" name="partner_type_id" placeholder="Type Partner" class="form-select"
                        id="partner_type_id" required>
                        <option value="" disabled selected>Pilih Type</option>
                        @if (isset($partnerTypes['data']))
                            @foreach ($partnerTypes['data'] as $type)
                                <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                            @endforeach
                        @else
                            <option value="">Data tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="nama" class="form-label fw-bold">Nama</label>
                    <input type="text" name="nama" placeholder="name" class="form-control" id="nama"
                        required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="chart_of_account_id" class="form-label fw-bold">COA ID</label>
                    <select type="number" name="chart_of_account_id" placeholder="chart_of_account_id"
                        class="form-select" id="partner_type_id" required>
                        <option value="" disabled selected>Pilih COA</option>
                        @if (isset($coaTypes['data']))
                            @foreach ($coaTypes['data'] as $type)
                                <option value="{{ $type['id'] }}">{{ $type['description'] }}</option>
                            @endforeach
                        @else
                            <option value="">Data tidak tersedia</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_info" class="form-label fw-bold">Contact Info</label>
                    <input type="text" name="contact_info" placeholder="Contact Info" class="form-control"
                        id="contact_info" required>
                </div>
            </div>
            <div class="row">
                <div class="modal-footer">
                    <div class="col-md-12 text-end">
                        <button type="button" class="btn btn-primary" id="submitButton"
                            onclick="confirmSubmit('submitButton', 'createForm')">Submit</button>
                        <a href="{{ route('principal.index') }}" class="btn btn-secondary ms-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
