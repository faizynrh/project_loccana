    <div class="row g-3">
        <div class="col-12">
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_code" class="form-label fw-bold mb-0">Nama Lengkap</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control"
                        value="{{ $data->name->givenName }} {{ $data->name->familyName }}" disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_name" class="form-label fw-bold mb-0">Username</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="edit_account_name" value="{{ $data->userName }}"
                        disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label for="account_name" class="form-label fw-bold mb-0">Email</label>
                </div>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="edit_account_name" value="{{ $data->emails[0] }}"
                        disabled>
                </div>
            </div>
            <div class="row mb-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label fw-bold mb-0">Roles</label>
                </div>
                <div class="col-md-9">
                    <ul class="list-group">
                        @foreach ($data->roles as $role)
                            <li class="list-group-item"><strong>{{ $role->display }}</strong></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Kembali</button>
            </div>
        </div>
    </div>
