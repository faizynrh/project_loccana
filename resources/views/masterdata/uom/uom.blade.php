@extends('layouts.mainlayout')
@section('content')
    <div class="container mt-2 bg-white rounded-top">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h3 style="font-size: 18px; padding-top:25px; font-weight: 700">Unit of Measurement</h3>
        <div class="d-flex justify-content-between align-items-center">
            <a href="/uom-tambah" class="btn btn-primary"><strong>+</strong></a>
        </div>
        <div class="input-group">
            <span class="input-group-text"><i class="ni ni-zoom-split-in"></i></span>
            <input class="form-control" placeholder="Search" id="searchUomTable" type="text">
        </div>

        <table class="table table-striped table-bordered mt-3" id="tableuom">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Simbol</th>
                    <th scope="col">Description</th>
                    <th scope="col">Option</th>
                </tr>
            </thead>
            <tbody class="fw-bold text-gray-600" style="border:none;">

            </tbody>

        </table>
        <div class="d-flex justify-content-between my-3">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Data ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete' + id).submit();
                }
            });
        }

        var tableUom = $('#uomTable').DataTable({
            processing: true,
            serverSide: true,
            "searching": true,
            "ordering": false,
            ajax: {
                "url": "{{ url('/uom') }}",
                "error": function(response) {
                    Swal.fire(
                        'Error',
                        response.statusText,
                        'warning'
                    )
                }
            },
            drawCallback: function(settings) {
                var api = this.api();
                if (api.data().length === 0 && !api.page.info().recordsTotal) {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    var cari = $('#searchUomTable').val();
                    toastr.warning("Data '" + cari + "' yang anda dicari tidak ditemukan!");
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'symbol',
                    name: 'symbol'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            "bLengthChange": false,
            "bFilter": true,
            "bInfo": false
        });

        tableUom.on('draw.dt', function() {
            $('#searchUomTable').focus();
        });
    </script>
@endsection
