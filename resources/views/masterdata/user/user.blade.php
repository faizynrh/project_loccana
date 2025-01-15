@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-3 bg-white rounded-top">
        <div class="p-2">
            <h5 class="fw-bold ">List User</h5>
        </div>
        <a href="/user/add" class="btn btn-primary btn-lg fw-bold mt-1 mb-2">+</a>
        <table class="table table-striped table-bordered mt-3" id="usertable">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Name User</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Role</th>
                    <th scope="col">Wilayah</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
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
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        $('#usertable').DataTable({
            serverSide: true,
            processing: true,
            stateSave: true,
            ajax: {
                url: "{{ route('user') }}",
                type: "GET",
                contentType: 'application/json',
                dataType: 'json',
                data: function(d) {
                    console.log("Length: ", d.length);
                    console.log("Start: ", d.start);
                    console.log("AJAX Request Triggered");
                    return {
                        length: d.length, // jumlah data per halaman
                        start: d.start, // offset data
                        search: d.search.value, // jika diperlukan, misalnya untuk pencarian
                    };
                }
            },
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
@endsection
