@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">Price Management</h5>
        </div>
        <table class="table table-striped table-bordered mt-3" id="tablecoa">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Nama Principal</th>
                    <th scope="col">Harga Poko</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Status</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>AIT0101</td>
                    <td>Aldes 50/10 WG 20.00 gr</td>
                    <td>PT. ADVANSIA INDOTANI</td>
                    <td>1.724.118</td>
                    <td>1.670.000</td>
                    <td>Setuju</td>
                    <td><a href="price/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-success" title="Lihat">
                            <i class="bi bi-check"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td><a href="price/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-success" title="Lihat">
                            <i class="bi bi-check"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td><a href="price/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
