@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white">
        <h5>Items</h5>
        <form class="d-flex align-items-center justify-content-between" role="search">
            <a href="items/add" class="btn btn-primary">+ Tambah Item</a>
        </form>
        <table class="table table-striped table-bordered mt-3" id="tableitems">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Item</th>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">UoM</th>
                    <th scope="col">Unit Box</th>
                    <th scope="col">Principal</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Usep</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <a href="items/edit" class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-success" title="Lihat">
                            <i class="bi bi-eye"></i>
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
                    <td>
                        <button class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-success" title="Lihat">
                            <i class="bi bi-eye"></i>
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
                    <td>
                        <button class="btn btn-sm btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-success" title="Lihat">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
