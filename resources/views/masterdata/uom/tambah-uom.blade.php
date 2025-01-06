@extends('layouts.mainlayout')
@section('content')
<!-- Main Content -->
<div class="content">
    <div class="header" style="margin-top: 50px">
        <h3 style="text-decoration: underline; padding-top:30px; font-size: 23px; color: #0044ff; text-underline-offset: 5px; padding-top:30px;">Tambah UoM</h3>
        <p>Harap isi data yang telah ditandai dengan <code>*</code>, dan masukan data dengan benar</p>

        <!-- Menampilkan Alert untuk Sukses atau Gagal -->
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('uom.store') }}" method="POST">
            @csrf
            <div class="form-container">
                <div class="mb-3">
                    <label><strong>UoM *</strong></label>
                    <input type="text" placeholder="UoM" name="uom_name">
                </div>
                <div class="mb-3">
                    <label><strong>Simbol UoM *</strong></label>
                    <input type="text" placeholder="Simbol" name="uom_symbol">
                </div>
                <div class="mb-3">
                    <label><strong>Keterangan UoM *</strong></label>
                    <textarea cols="30" rows="4" name="uom_description"></textarea>
                </div>
                <div class="mb-3">
                    <label></label> <!-- Label kosong untuk menjaga alur flexbox -->
                    <div style="flex: 2; display: flex; gap: 10px;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-primary" onclick="history.back()">Batal</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
