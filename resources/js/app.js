import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
import 'datatables.net';
import $ from 'jquery';
import 'bootstrap-icons/font/bootstrap-icons.css';



$(document).ready(function () {
    $('#tablecoa').DataTable();
});
$(document).ready(function () {
    $('#tableitems').DataTable();
});
$(document).ready(function () {
    $('#tableprice').DataTable();
});
$(document).ready(function () {
    $('#tablegudang').DataTable();
});
$(document).ready(function () {
    $('#tableuser').DataTable();
});
$(document).ready(function () {
    $('#tableinformasi').DataTable();
});
$(document).ready(function () {
    $('#tableuom').DataTable();
});
$(document).ready(function () {
    $('#tableinformasi').DataTable();
});
$(document).ready(function () {
    $('#tableprincipal').DataTable();
});
$(document).ready(function () {
    $('#tableCustomer').DataTable();
});
$(document).ready(function () {
    $('#tabledasarpembelian').DataTable();
});
$(document).ready(function () {
    $('#tablerekappo').DataTable();
});
$(document).ready(function () {
    $('#tablecustomer').DataTable();
})

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

