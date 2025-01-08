@extends('layouts.mainlayout')
@section('content')
    <!-- Main Content -->
    <div class="container mt-2 bg-white rounded-top">

        <h3
            style="text-decoration: underline; padding-top:25px; font-size: 18px; color: #0044ff; text-underline-offset: 13px; font-weight: bold; padding-bottom: 10px">
            Detail UoM</h3>
        <p>Detail Data UoM</p>

        <!-- Menampilkan Alert untuk Gagal -->


        <form action="{{ route('uom.update', $uom['id']) }}" method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="form-container">
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Uom <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="UoM" name="uom_name" class="form-control"
                            value="{{ $uom['name'] }}" readonly>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Simbol UoM <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" placeholder="Simbol" class="form-control" name="uom_code"
                            {{-- {{ $uom['symbol'] }} --}} value="" readonly>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3">
                        <label for="account_code" class="form-label fw-bold mb-0">Keterangan UoM <span
                                class="text-danger"></span></label>
                    </div>
                    <div class="col-md-9">
                        <textarea cols="30" rows="4" name="description" class="form-control" readonly>{{ $uom['description'] }}</textarea>

                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-md-3"></div> <!-- Kosongkan kolom ini agar button sejajar di sebelah kanan -->
                    <div class="col-md-9 d-flex gap-3"> <!-- Gunakan flexbox agar button sejajar -->
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Kembali</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
