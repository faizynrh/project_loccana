import $ from 'jquery';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import dt from 'datatables.net';
import 'bootstrap-icons/font/bootstrap-icons.css';


$(document).ready(function () {
    const tableIds = [
        'tablecoa',
        'tableinformasi',
        'tableprincipal',
        'tableCustomer',
        'tabledasarpembelian',
        'tablerekappo',
        'tablecustomer',
        'tablepenerimaan',
    ];

    tableIds.forEach(function (id) {
        $('#' + id).DataTable();
    });
});

$(document).ready(function () {

    var table = $('#tableinvoice').DataTable();

    $('#filter-bulan').on('change', function () {
        var selectedMonth = $(this).val();
        var regex = selectedMonth ? '^\\d{4}-' + selectedMonth + '-\\d{2}$' : '';
        table.column(3).search(regex, true, false).draw();
    });
    $('#filter-tahun').on('change', function () {
        var selectedYear = $(this).val();
        table.column(3).search(selectedYear ? selectedYear : '', true, false).draw();
    });
    $('#filter-invoice').on('change', function () {
        var selectedinvoice = $(this).val();
        table.column(7).search(selectedinvoice ? selectedinvoice : '', true, false).draw();
    });
});


// columns: [
//     { data: 'id' },
//     { data: 'item_code' },
//     { data: 'item_name' },
//     { data: 'item_description' },
//     { data: 'uom_name' },
// ],
