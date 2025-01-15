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
        $(document).ready(function() {
            $('#usertable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('user') }}',
                    type: 'GET',
                    data: function(d) {
                        console.log('DataTables data sent:',
                            d); // Debug untuk melihat data yang dikirim
                    },
                    dataType: 'json'
                }
            });
        });
    </script>
    <!-- Pastikan urutan benar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
