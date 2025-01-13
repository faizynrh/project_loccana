import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import 'datatables.net';
import $ from 'jquery';
import 'bootstrap-icons/font/bootstrap-icons.css';



$(document).ready(function () {
    const tableIds = [
        'tablecoa',
        'tableitems',
        'tableprice',
        'tablegudang',
        'tableuser',
        'tableinformasi',
        'tableuom',
        'tableprincipal',
        'tableCustomer',
        'tabledasarpembelian',
        'tableinvoice',
        'tablerekappo',
        'tablecustomer'
    ];

    tableIds.forEach(function (id) {
        $('#' + id).DataTable();
    });
});

$(document).ready(function () {
    var table = $('#tablepenerimaan').DataTable();

    $('#yearSelect').change(function () {
        var year = $(this).val();
        table.column(1).search(year).draw();
    });

    $('#monthSelect').change(function () {
        var month = $(this).val();
        table.column(2).search(month).draw();
    });
})


