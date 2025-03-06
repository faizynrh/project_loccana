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
    
        // ITEM
        // Route::prefix('/item')->name('item.')->group(function () {
        //     Route::get('/', [ItemController::class, 'index'])->name('index');
        //     Route::get('/ajax', [ItemController::class, 'ajax'])->name('ajax');
        //     Route::get('/add', [ItemController::class, 'create'])->name('create');
        //     Route::post('/add', [ItemController::class, 'store'])->name('store');
        //     Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('destroy');
        //     Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
        //     Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
        //     Route::get('/detail/{id}', [ItemController::class, 'show'])->name('detail');
        // });

        // Route::prefix('/item')->name('item.')->controller(ItemController::class)->group(function () {
        //     Route::get('/', 'index')->name('index');
        //     Route::get('/ajax', 'ajax')->name('ajax');
        //     Route::get('/add', 'create')->name('create');
        //     Route::post('/add', 'store')->name('store');
        //     Route::get('/edit/{id}', 'edit')->name('edit');
        //     Route::put('/update/{id}', 'update')->name('update');
        //     Route::get('/detail/{id}', 'show')->name('detail');
        //     Route::delete('/delete/{id}', 'destroy')->name('destroy');
        // });

        Route::resource('item', ItemController::class)->except(['show']);
        Route::get('item/detail/{id}', [ItemController::class, 'show'])->name('item.detail');
        Route::get('item/ajax', [ItemController::class, 'ajax'])->name('item.ajax');

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
        Route::prefix('/price')->name('price.')->group(function () {
            Route::get('/', [PriceController::class, 'index'])->name('index');
            Route::get('/ajax', [PriceController::class, 'ajax'])->name('ajax');
            Route::get('/edit/{id}', [PriceController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PriceController::class, 'update'])->name('update');
            Route::put('/approve/{id}', [PriceController::class, 'approve'])->name('approve');
        });

        // UOM
        Route::prefix('/uom')->name('uom.')->controller(UomController::class)->group(
            function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajaxuom')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/detail/{id}', 'show')->name('show');
        }
        );


        // COA
        Route::prefix('/coa')->name('coa.')->group(function () {
            Route::get('/', [COAController::class, 'index'])->name('index');
            Route::get('/ajax', [COAController::class, 'ajax'])->name('ajax');
            Route::get('/detail/{id}', [COAController::class, 'show'])->name('detail');
            Route::get('/add', [COAController::class, 'create'])->name('create');
            Route::post('/add', [COAController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [COAController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [COAController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [COAController::class, 'update'])->name('update');
        });

        //GUDANG
        Route::prefix('/gudang')->name('gudang.')->group(function () {
            Route::get('/', [GudangController::class, 'index'])->name('index');
            Route::get('/ajax', [GudangController::class, 'ajax'])->name('ajax');
            Route::get('/add', [GudangController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [GudangController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [GudangController::class, 'update'])->name('update');
            Route::post('/add', [GudangController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [GudangController::class, 'destroy'])->name('destroy');
        });

        // PRINCIPAL
        Route::prefix('/principal')->name('principal.')->controller(PrincipalController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::get('/ajax', 'ajaxprincipal')->name('ajax');
            Route::post('/add', 'store')->name('store');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/show/{id}', 'show')->name('show');
        });


        // CUSTOMER
        Route::prefix('/customer')->name('customer.')->controller(CustomerController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/ajax', 'ajaxcustomer')->name('ajax');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/show/{id}', 'show')->name('show');
        });

        // ===================================== PROCUREMENT =========================================
    
        // PENERIMAAN BARANG
        Route::prefix('/penerimaan_barang')->name('penerimaan_barang.')->group(function () {
            Route::get('/', [PenerimaanBarangController::class, 'index'])->name('index');
            Route::get('/ajax', [PenerimaanBarangController::class, 'ajax'])->name('ajax');
            Route::get('/detailpo/{id_po}', [PenerimaanBarangController::class, 'getPoDetails'])->name('getdetails');
            Route::get('/add', [PenerimaanBarangController::class, 'create'])->name('create');
            Route::post('/add', [PenerimaanBarangController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [PenerimaanBarangController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [PenerimaanBarangController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [PenerimaanBarangController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PenerimaanBarangController::class, 'update'])->name('update');
        });

        // PURCHASE ORDER
        Route::prefix('/purchase_order')->name('purchaseorder.')->controller(PurchaseOrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/generate-po-code', 'generatePOCode');
            Route::get('/detailspurchase/{id_po}', 'getPurchaseOrderDetails')->name('getpurchasedetails');
            Route::get('/getDetailPrinciple/{id}', 'getDetailPrinciple')->name('getDetailPrinciple');
            Route::get('/getDetailWarehouse/{id}', 'getDetailWarehouse')->name('getDetailWarehouse');
            Route::get('/add', 'create')->name('create');
            Route::get('/ajax', 'ajaxpo')->name('ajax');
            Route::post('/add', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/getItemsList/{id}', 'getItemsList')->name('getitem');
            Route::get('/approve/{id}', 'vapprove')->name('vapprove');
            Route::put('/approve/{id}', 'approve')->name('approve');
            Route::put('/reject/{id}', 'reject')->name('reject');
            Route::get('/print/{id}', 'print')->name('print');
            Route::get('/excel/detail/{id}', 'exportExcelDetail')->name('printexceldetail');
            Route::get('/excel', 'exportExcel')->name('printexcel');
        });

        Route::prefix('/invoice_pembelian')->name('invoice_pembelian.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');
            Route::get('/ajax', [InvoiceController::class, 'ajax'])->name('ajax');
            Route::get('/detaildo/{id}', [InvoiceController::class, 'getDODetails'])->name('getdetails');
            Route::get('/add', [InvoiceController::class, 'create'])->name('create');
            Route::post('/add', [InvoiceController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [InvoiceController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [InvoiceController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/dasar_pembelian')->name('dasar_pembelian.')->group(function () {
            Route::get('/', [DasarPembelianController::class, 'index'])->name('index');
            Route::get('/ajax', [DasarPembelianController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [DasarPembelianController::class, 'exportExcel'])->name('exportexcel');
        });

        Route::prefix('/rekap_po')->name('rekap_po.')->group(function () {
            Route::get('/', [RekapPOController::class, 'index'])->name('index');
            Route::get('/ajax', [RekapPOController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [RekapPOController::class, 'exportExcel'])->name('exportexcel');
        });

        Route::prefix('/return_pembelian')->name('return_pembelian.')->group(function () {
            Route::get('/', [ReturnPembelianController::class, 'index'])->name('index');
            Route::get('/ajax', [ReturnPembelianController::class, 'ajax'])->name('ajax');
            Route::get('/detailadd/{id}', [ReturnPembelianController::class, 'detailadd'])->name('detailadd');
            Route::get('/add', [ReturnPembelianController::class, 'create'])->name('create');
            Route::post('/add', [ReturnPembelianController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ReturnPembelianController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ReturnPembelianController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [ReturnPembelianController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [ReturnPembelianController::class, 'destroy'])->name('destroy');
            Route::get('/approve/{id}', [ReturnPembelianController::class, 'detail_approve'])->name('detail_approve');
            Route::put('/approve/{id}', [ReturnPembelianController::class, 'approve'])->name('approve');
        });

        Route::prefix('/report_pembelian')->name('report_pembelian.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/ajax', [ReportController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('exportexcel');
        });


        // ===================================== INVENTORY =========================================
    
        Route::prefix('/stock')->name('stock.')->group(function () {
            Route::get('/', [StockController::class, 'index'])->name('index');
            Route::get('/ajax', [StockController::class, 'ajax'])->name('ajax');
            Route::get('/detail/{id}', [StockController::class, 'show'])->name('detail');
            Route::get('/mutasi/{id}', [StockController::class, 'edit'])->name('mutasi');
            Route::post('/addmutasi', [StockController::class, 'store'])->name('store');
            Route::get('/export-excel', [StockController::class, 'exportExcel'])->name('exportexcel');
        });

        Route::prefix('/stock_gudang')->name('stock_gudang.')->group(function () {
            Route::get('/', [StockGudangController::class, 'index'])->name('index');
            Route::get('/ajax', [StockGudangController::class, 'ajax'])->name('ajax');
            Route::get('/detail/{id}', [StockGudangController::class, 'show'])->name('detail');
        });

        Route::prefix('/stock_in_transit')->name('stock_in_transit.')->group(function () {
            Route::get('/', [StockInTransitController::class, 'index'])->name('index');
            Route::get('/ajax', [StockInTransitController::class, 'ajax'])->name('ajax');
            Route::get('/add', [StockInTransitController::class, 'create'])->name('create');
            Route::post('/store', [StockInTransitController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [StockInTransitController::class, 'show'])->name('detail');
            Route::get('/export-excel', [StockInTransitController::class, 'exportExcel'])->name('exportexcel');
        });

        Route::prefix('/transfer_stock')->name('transfer_stock.')->group(function () {
            Route::get('/', [TransferStockController::class, 'index'])->name('index');
            Route::get('/ajax', [TransferStockController::class, 'ajax'])->name('ajax');
            Route::get('/add', [TransferStockController::class, 'create'])->name('create');
            Route::post('/store', [TransferStockController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [TransferStockController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [TransferStockController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [TransferStockController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [TransferStockController::class, 'destroy'])->name('destroy');
            Route::get('/print/{id}', [TransferStockController::class, 'print'])->name('print');
        });

        Route::prefix('/report_persediaan')->name('report_persediaan.')->group(function () {
            Route::get('/', [InventoryReportController::class, 'index'])->name('index');
            Route::get('/ajax', [InventoryReportController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [InventoryReportController::class, 'exportExcel'])->name('exportexcel');
        });


        // ===================================== PENJUALAN =========================================
    
        Route::prefix('/penjualan')->name('penjualan.')->controller(PenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajaxselling')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/getItemsList/{id}', 'getItemsList')->name('getitem');
            Route::get('/getDetailCustomer/{id}', 'getDetailCustomer')->name('getDetailCustomer');
            Route::get('/getDetailWarehouse/{id}', 'getDetailWarehouse')->name('getDetailWarehouse');
            Route::get('/getStock/{id}', 'getstock')->name('getstock');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/approve/{id}', 'vapprove')->name('vapprove');
            Route::put('/approve/{id}', 'approve')->name('approve');
            Route::get('/print/{id}', 'print')->name('print');
        });

        Route::prefix('/range_price')->name('range_price.')->group(function () {
            Route::get('/', [RangePriceController::class, 'index'])->name('index');
            Route::get('/ajax', [RangePriceController::class, 'ajax'])->name('ajax');
            Route::get('/edit/{id}', [RangePriceController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [RangePriceController::class, 'update'])->name('update');
        });

        Route::prefix('/return_penjualan')->name('return_penjualan.')->group(function () {
            Route::get('/', [ReturnPenjualanController::class, 'index'])->name('index');
            Route::get('/ajax', [ReturnPenjualanController::class, 'ajax'])->name('ajax');
            Route::get('/add', [ReturnPenjualanController::class, 'create'])->name('create');
            Route::get('/detail_invoice/{id}', [ReturnPenjualanController::class, 'getinvoiceDetails'])->name('getinvoiceDetails');
            Route::post('/store', [ReturnPenjualanController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [ReturnPenjualanController::class, 'show'])->name('detail');
            Route::get('/edit/{id}', [ReturnPenjualanController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ReturnPenjualanController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ReturnPenjualanController::class, 'destroy'])->name('destroy');
            Route::get('/approve/{id}', [ReturnPenjualanController::class, 'detail_approve'])->name('detail_approve');
            Route::put('/approve/{id}', [ReturnPenjualanController::class, 'approve'])->name('approve');
            Route::put('/reject/{id}', [ReturnPenjualanController::class, 'reject'])->name('reject');
        });

        Route::prefix('/invoice_penjualan')->name('invoice_penjualan.')->group(function () {
            Route::get('/', [InvoicePenjualanController::class, 'index'])->name('index');
            Route::get('/ajax', [InvoicePenjualanController::class, 'ajax'])->name('ajax');
            Route::get('/detail_selling/{id}', [InvoicePenjualanController::class, 'getdetails'])->name('getdetails');
            Route::get('/add', [InvoicePenjualanController::class, 'create'])->name('create');
            Route::post('/store', [InvoicePenjualanController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [InvoicePenjualanController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [InvoicePenjualanController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [InvoicePenjualanController::class, 'show'])->name('detail');
            Route::delete('/delete/{id}', [InvoicePenjualanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/dasar_penjualan')->name('dasar_penjualan.')->group(function () {
            Route::get('/', [DasarPenjualanController::class, 'index'])->name('index');
            Route::get('/ajax', [DasarPenjualanController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [DasarPenjualanController::class, 'exportExcel'])->name('exportexcel');
        });

        Route::prefix('/report_penjualan')->name('report_penjualan.')->group(function () {
            Route::get('/', [ReportPenjualanController::class, 'index'])->name('index');
            Route::get('/ajax', [ReportPenjualanController::class, 'ajax'])->name('ajax');
            Route::get('/export-excel', [ReportPenjualanController::class, 'exportExcel'])->name('exportexcel');
        });

        // ===================================== CASHBANK =========================================
    
        Route::prefix('/hutang')->name('hutang.')->group(function () {
            Route::get('/ajax', [HutangController::class, 'ajax'])->name('ajax');
            Route::get('/ajaxpembayaran', [HutangController::class, 'ajaxpembayaran'])->name('ajaxpembayaran');
            Route::get('/', [HutangController::class, 'index'])->name('index');
            Route::get('/detail_hutang/{id}', [HutangController::class, 'showhutang'])->name('detail');
            Route::get('/pembayaran', [HutangController::class, 'pembayaran'])->name('pembayaran');
            Route::get('/pembayaran/add', [HutangController::class, 'create'])->name('create');
            Route::get('/getinvoice/{id}', [HutangController::class, 'getinvoice'])->name('getinvoice');
            Route::post('/pembayaran/store', [HutangController::class, 'store'])->name('store');
            Route::get('/pembayaran/edit/{id}', [HutangController::class, 'edit'])->name('edit');
            Route::put('/pembayaran/update/{id}', [HutangController::class, 'update'])->name('update');
            Route::get('/pembayaran/approve/{id}', [HutangController::class, 'detail_approve'])->name('detail_approve');
            Route::put('/pembayaran/approve/{id}', [HutangController::class, 'approve'])->name('approve');
            Route::put('/pembayaran/reject/{id}', [HutangController::class, 'reject'])->name('reject');
            Route::get('/pembayaran/detail_pembayaran/{id}', [HutangController::class, 'showpembayaran'])->name('detail');
            Route::delete('/pembayaran/delete/{id}', [HutangController::class, 'destroy'])->name('destroy');
            Route::get('/pembayaran/print/{id}', [HutangController::class, 'print'])->name('print');
        });
    }


);
