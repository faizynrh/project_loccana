<?php

use App\Http\Controllers\penjualan\PenjualanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\COAController;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\authentication\ShowDashboard;
use App\Http\Controllers\procurement\ReportController;
use App\Http\Controllers\authentication\AuthController;
use App\Http\Controllers\cashbank\HutangController;
use App\Http\Controllers\inventory\ReportController as InventoryReportController;
use App\Http\Controllers\inventory\StockController;
use App\Http\Controllers\inventory\StockGudangController;
use App\Http\Controllers\inventory\StockInTransitController;
use App\Http\Controllers\inventory\TransferStockController;
use App\Http\Controllers\masterdata\CustomerController;
use App\Http\Controllers\procurement\InvoiceController;
use App\Http\Controllers\procurement\RekapPOController;
use App\Http\Controllers\masterdata\PrincipalController;
use App\Http\Controllers\penjualan\DasarPenjualanController;
use App\Http\Controllers\penjualan\InvoicePenjualanController;
use App\Http\Controllers\penjualan\RangePriceController;
use App\Http\Controllers\penjualan\ReportPenjualanController;
use App\Http\Controllers\penjualan\ReturnPenjualanController;
use App\Http\Controllers\procurement\PurchaseOrderController;
use App\Http\Controllers\procurement\DasarPembelianController;
use App\Http\Controllers\procurement\PenerimaanBarangController;
use App\Http\Controllers\procurement\ReturnPembelianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return redirect('/');
});


Route::get('/redirect', [AuthController::class, 'redirectToIdentityServer'])->name('oauth.redirect');
Route::get('/callback', [AuthController::class, 'handleCallback'])->name('oauth.callback');
Route::get('/logout', [AuthController::class, 'logout'])->name('oauth.logout');


//MIDDLEWARE
Route::middleware('auth.login')->group(
    function () {
        Route::get('/dashboard', [ShowDashboard::class, 'showDashboard'])->name('dashboard-dev');
        Route::get('/profile', function () {
            return view('profile');
        });


        // ==========================================MASTERDATA========================================

        Route::prefix('/item')->name('item.')->controller(ItemController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        // USER
        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/', function () {
                return view('masterdata.user.index');
            });
            Route::get('/add', function () {
                return view('masterdata.user.add');
            });
            Route::get('/edit', function () {
                return view('masterdata.user.edit');
            });
        });

        // PRICE
        Route::prefix('/price')->name('price.')->controller(PriceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::put('/approve/{id}', 'approve')->name('approve');
        });

        // UOM
        Route::prefix('/uom')->name('uom.')->group(
            function () {
                Route::get('/', [UomController::class, 'index'])->name('index');
                Route::get('/ajax', [UomController::class, 'ajaxuom'])->name('ajax');
                Route::get('/add', [UomController::class, 'create'])->name('create');
                Route::post('/add', [UomController::class, 'store'])->name('store');
                Route::delete('/delete/{id}', [UomController::class, 'destroy'])->name('destroy');
                Route::get('/edit/{id}', [UomController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [UomController::class, 'update'])->name('update');
                Route::get('/detail/{id}', [UomController::class, 'show'])->name('show');
            }
        );


        // COA
        Route::prefix('/coa')->name('coa.')->controller(COAController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        //GUDANG
        Route::prefix('/gudang')->name('gudang.')->controller(GudangController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/edit/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        // PRINCIPAL
        Route::prefix('/principal')->name('principal.')->group(function () {
            Route::get('/', [PrincipalController::class, 'index'])->name('index');
            Route::get('/add', [PrincipalController::class, 'create'])->name('create');
            Route::get('/ajax', [PrincipalController::class, 'ajaxprincipal'])->name('ajax');
            Route::post('/add', [PrincipalController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [PrincipalController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [PrincipalController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PrincipalController::class, 'update'])->name('update');
            Route::get('/show/{id}', [PrincipalController::class, 'show'])->name('show');
        });

        // CUSTOMER
        Route::prefix('/customer')->name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/add', [CustomerController::class, 'create'])->name('create');
            Route::post('/add', [CustomerController::class, 'store'])->name('store');
            Route::get('/ajax', [CustomerController::class, 'ajaxcustomer'])->name('ajax');
            Route::delete('/delete/{id}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CustomerController::class, 'update'])->name('update');
            Route::get('/show/{id}', [CustomerController::class, 'show'])->name('show');
        });

        // ===================================== PROCUREMENT =========================================

        // PENERIMAAN BARANG
        Route::prefix('/penerimaan_barang')->name('penerimaan_barang.')->controller(PenerimaanBarangController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detailpo/{id_po}', 'getPoDetails')->name('getdetails');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        // PURCHASE ORDER
        Route::prefix('/purchase_order')->name('purchaseorder.')->group(function () {
            Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
            Route::get('/generate-po-code', [PurchaseOrderController::class, 'generatePOCode']);
            Route::get('/detailspurchase/{id_po}', [PurchaseOrderController::class, 'getPurchaseOrderDetails'])->name('getpurchasedetails');
            Route::get('/getDetailPrinciple/{id}', [PurchaseOrderController::class, 'getDetailPrinciple'])->name('getDetailPrinciple');
            Route::get('/getDetailWarehouse/{id}', [PurchaseOrderController::class, 'getDetailWarehouse'])->name('getDetailWarehouse');
            Route::get('/add', [PurchaseOrderController::class, 'create'])->name('create');
            Route::get('/ajax', [PurchaseOrderController::class, 'ajaxpo'])->name('ajax');
            Route::post('/add', [PurchaseOrderController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [PurchaseOrderController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [PurchaseOrderController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PurchaseOrderController::class, 'update'])->name('update');
            Route::get('/getItemsList/{id}', [PurchaseOrderController::class, 'getItemsList'])->name('getitem');
            Route::get('/approve/{id}', [PurchaseOrderController::class, 'vapprove'])->name('vapprove');
            Route::put('/approve/{id}', [PurchaseOrderController::class, 'approve'])->name('approve');
            Route::put('/reject/{id}', [PurchaseOrderController::class, 'reject'])->name('reject');
            Route::get('/print/{id}', [PurchaseOrderController::class, 'print'])->name('print');
            Route::get('/excel/detail/{id}', [PurchaseOrderController::class, 'exportExcelDetail'])->name('printexceldetail');
            Route::get('/excel', [PurchaseOrderController::class, 'exportExcel'])->name('printexcel');
        });

        Route::prefix('/invoice_pembelian')->name('invoice_pembelian.')->controller(InvoiceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detaildo/{id}', 'getDODetails')->name('getdetails');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('/dasar_pembelian')->name('dasar_pembelian.')->controller(DasarPembelianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });

        Route::prefix('/rekap_po')->name('rekap_po.')->controller(RekapPOController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });

        Route::prefix('/return_pembelian')->name('return_pembelian.')->controller(ReturnPembelianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detailadd/{id}', 'detailadd')->name('detailadd');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/approve/{id}', 'detail_approve')->name('detail_approve');
            Route::put('/approve/{id}', 'approve')->name('approve');
        });

        Route::prefix('/report_pembelian')->name('report_pembelian.')->controller(ReportController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });


        // ===================================== INVENTORY =========================================

        Route::prefix('/stock')->name('stock.')->controller(StockController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/mutasi/{id}', 'edit')->name('mutasi');
            Route::post('/addmutasi', 'store')->name('store');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });

        Route::prefix('/stock_gudang')->name('stock_gudang.')->controller(StockGudangController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detail/{id}', 'show')->name('detail');
        });

        Route::prefix('/stock_in_transit')->name('stock_in_transit.')->controller(StockInTransitController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });

        Route::prefix('/transfer_stock')->name('transfer_stock.')->controller(TransferStockController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/print/{id}', 'print')->name('print');
        });

        Route::prefix('/report_persediaan')->name('report_persediaan.')->controller(InventoryReportController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });


        // ===================================== PENJUALAN =========================================

        Route::prefix('/penjualan')->name('penjualan.')->group(function () {
            Route::get('/', [PenjualanController::class, 'index'])->name('index');
            Route::get('/ajax', [PenjualanController::class, 'ajaxselling'])->name('ajax');
            Route::get('/add', [PenjualanController::class, 'create'])->name('create');
            Route::post('/add', [PenjualanController::class, 'store'])->name('store');
            Route::get('/getItemsList/{id}', [PenjualanController::class, 'getItemsList'])->name('getitem');
            Route::get('/getDetailCustomer/{id}', [PenjualanController::class, 'getDetailCustomer'])->name('getDetailCustomer');
            Route::get('/getDetailWarehouse/{id}', [PenjualanController::class, 'getDetailWarehouse'])->name('getDetailWarehouse');
            Route::get('/getStock/{id}', [PenjualanController::class, 'getstock'])->name('getstock');
            Route::delete('/delete/{id}', [PenjualanController::class, 'destroy'])->name('destroy');
            Route::get('/detail/{id}', [PenjualanController::class, 'show'])->name('detail');
            Route::get('/edit/{id}', [PenjualanController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PenjualanController::class, 'update'])->name('update');
            Route::get('/approve/{id}', [PenjualanController::class, 'vapprove'])->name('vapprove');
            Route::put('/approve/{id}', [PenjualanController::class, 'approve'])->name('approve');
            Route::get('/print/{id}', [PenjualanController::class, 'print'])->name('print');
        });

        Route::prefix('/range_price')->name('range_price.')->controller(RangePriceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
        });

        Route::prefix('/return_penjualan')->name('return_penjualan.')->controller(ReturnPenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::get('/detail_invoice/{id}', 'getinvoiceDetails')->name('getinvoiceDetails');
            Route::post('/store', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/approve/{id}', 'detail_approve')->name('detail_approve');
            Route::put('/approve/{id}', 'approve')->name('approve');
            Route::put('/reject/{id}', 'reject')->name('reject');
        });

        Route::prefix('/invoice_penjualan')->name('invoice_penjualan.')->controller(InvoicePenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detail_selling/{id}', 'getdetails')->name('getdetails');
            Route::get('/add', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        Route::prefix('/dasar_penjualan')->name('dasar_penjualan.')->controller(DasarPenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });

        Route::prefix('/report_penjualan')->name('report_penjualan.')->controller(ReportPenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/export-excel', 'exportExcel')->name('exportexcel');
        });


        // ===================================== CASHBANK =========================================

        Route::prefix('/hutang')->name('hutang.')->controller(HutangController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/detail/{id}', 'showhutang')->name('detail');
            Route::get('/getinvoice/{id}', 'getinvoice')->name('getinvoice');

            Route::prefix('/pembayaran')->name('pembayaran.')->group(function () {
                Route::get('/', 'pembayaran')->name('index');
                Route::get('/ajax', 'ajaxpembayaran')->name('ajax');
                Route::get('/add', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::put('/update/{id}', 'update')->name('update');
                Route::get('/approve/{id}', 'detail_approve')->name('detail_approve');
                Route::put('/approve/{id}', 'approve')->name('approve');
                Route::put('/reject/{id}', 'reject')->name('reject');
                Route::get('/detail/{id}', 'showpembayaran')->name('detail');
                Route::delete('/delete/{id}', 'destroy')->name('destroy');
                Route::get('/print/{id}', 'print')->name('print');
            });
        });
    }


);
