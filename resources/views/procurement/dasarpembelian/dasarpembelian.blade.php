@extends('layouts.mainlayout')
@section('content')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}"> --}}
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-3">
            <h5 class="mb-3 text-primary fw-bold text-decoration-underline" style="text-underline-offset: 13px; ">
                Report Dasar Pembelian</h5>
        </div>
        <div class="row g-3">
            <div class="col">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" class="form-select">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
            <div class="col">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="text" class="form-control" placeholder="First nae" aria-label="First name">
            </div>
            <div class="col">
                <label for="inputState" class="form-label">State</label>
                <input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
            </div>
            <div class="col">
                <label for="inputState" class="form-label">button</label>
                <button type="submit" class=" form-control btn btn-primary">Submit</button>
            </div>
        </div>
        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Name Barang</th>
                    <th scope="col">Principle</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">PPN</th>
                    <th scope="col">Jumlah+PPN</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td>1</td>
                    <td><img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2"
                            style="width: 40px; height: 40px;"></td>
                    <td>Adinda Nazmilla</td>
                    <td>dinda</td>
                    <td>Manager</td>
                    <td> Wilayah 2</td>
                    <td><button class="btn btn-sm btn-primary">Aktif</button></td>
                    <td><a href="user/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
@endsection
