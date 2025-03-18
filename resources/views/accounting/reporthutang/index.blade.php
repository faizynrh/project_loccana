@extends('layouts.app')
@section('content')
    @push('styles')
        <style>
            .cursor-not-allowed {
                cursor: not-allowed;
            }
        </style>
    @endpush
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Report Hutang</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/dashboard">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Report Hutang
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        @include('alert.alert')
                        <div class="row">
                            <div class="d-flex align-items-center mb-2">
                                <form id="searchForm" class="d-flex">
                                    <div class="me-2">
                                        <label for="principal" class="form-label fw-bold mt-2 mb-1 small">Principal</label>
                                        <select class="form-select" style="width: 250px" id="partner_id" name="partner_id"
                                            required>
                                            <option value="0" selected>Semua Principal</option>
                                            @foreach ($partner as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="me-2">
                                        <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                            Awal</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="me-2">
                                        <label for="tanggal" class="form-label fw-bold mt-2 mb-1 small">Tanggal
                                            Akhir</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="mt-1 d-flex justify-content-end">
                                    <button class="btn btn-primary" id="exportBtn">
                                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered mt-3" id="tablereporthutang">
                                <thead>
                                    <tr>
                                        <th scope="col">Principle</th>
                                        <th scope="col">Tanggal Terima</th>
                                        <th scope="col">Order Pembelian</th>
                                        <th scope="col">No Invoice</th>
                                        <th scope="col">Jatuh Tempo</th>

                                        <th scope="col">Umur</th>
                                        <th scope="col">Saldo</th>
                                        <th scope="col">Bulan Berjalan</th>
                                        <th scope="col">Tgl Bayar</th>
                                        <th scope="col">Dibayar</th>
                                        <th scope="col">Sisa</th>
                                        <th scope="col">Sudah Diinvoice</th>
                                        <th scope="col">
                                            < 1 Bulan </th>
                                        <th scope="col">1 Bulan</th>
                                        <th scope="col">2 Bulan</th>
                                        <th scope="col">3 Bulan</th>
                                        <th scope="col">> 3 Bulan</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var dataTable = $('#tablereporthutang').DataTable({
                serverSide: true,
                processing: true,
                info: false,
                paging: false,


                ajax: {
                    url: '{{ route('report_hutang.ajax') }}',
                    type: 'GET',
                    data: function(d) {
                        d.partner = $('#partner_id').val();
                        d.month = $('#monthSelect').val();
                        d.year = $('#yearSelect').val();
                    },
                    dataSrc: function(response) {
                        if (response.mtd) {
                            const formattedNumber = new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(response.mtd);
                            $('#totalPerBulan').html('Rp ' + formattedNumber);
                        }
                        return response.data;
                    }
                },
                columns: [{
                        data: 'name',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'receipt_date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                    date.getDate().toString().padStart(2, '0');
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'date_po',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                return date.getFullYear() + '-' +
                                    (date.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                    date.getDate().toString().padStart(2, '0');
                            }
                            return '-';
                        }
                    },
                    {
                        data: 'invoice_number',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'jatuh_tempo',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'umur',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'saldo',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: 'bulan_berjalan',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: 'tgl_bayar',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'bulan_berjalan',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: 'bayar',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: 'sisa',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: 'min_30',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'd30a',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'd60a',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'd90a',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'd120a',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    },
                    {
                        data: 'jumlah',
                        render: function(data) {
                            return data ? data : '-';
                        }
                    }
                ]

            });

            // Hapus event on change pada select tahun dan bulan agar tidak reload otomatis
            // Tambahkan event handler untuk tombol "Cari" untuk menerapkan filter berdasarkan tahun dan bulan
            $('#filterButton').on('click', function() {
                dataTable.ajax.reload();
            });

            // Saat form Export disubmit, tambahkan informasi total record ke dalam form
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const totalFilteredEntries = dataTable.page.info().recordsDisplay;
                const totalEntries = dataTable.page.info().recordsTotal;

                if (!$('#total_entries').length) {
                    $(this).append('<input type="hidden" id="total_entries" name="total_entries">');
                }
                $('#total_entries').val(totalFilteredEntries);

                if (!$('#total_all_entries').length) {
                    $(this).append('<input type="hidden" id="total_all_entries" name="total_all_entries">');
                }
                $('#total_all_entries').val(totalEntries);

                this.submit();
            });
        });
    </script>
@endpush
