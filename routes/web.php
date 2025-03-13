<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\COAController;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\cashbank\HutangController;
use App\Http\Controllers\inventory\StockController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\cashbank\PiutangController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\authentication\ShowDashboard;
use App\Http\Controllers\procurement\ReportController;
use App\Http\Controllers\authentication\AuthController;
use App\Http\Controllers\masterdata\CustomerController;
use App\Http\Controllers\penjualan\PenjualanController;
use App\Http\Controllers\procurement\InvoiceController;
use App\Http\Controllers\procurement\RekapPOController;
use App\Http\Controllers\masterdata\PrincipalController;
use App\Http\Controllers\penjualan\RangePriceController;
use App\Http\Controllers\inventory\StockGudangController;
use App\Http\Controllers\inventory\TransferStockController;
use App\Http\Controllers\cashbank\JurnalPemasukanController;
use App\Http\Controllers\inventory\StockInTransitController;
use App\Http\Controllers\penjualan\DasarPenjualanController;
use App\Http\Controllers\penjualan\ReportPenjualanController;
use App\Http\Controllers\penjualan\ReturnPenjualanController;
use App\Http\Controllers\procurement\PurchaseOrderController;
use App\Http\Controllers\cashbank\JurnalPengeluaranController;
use App\Http\Controllers\penjualan\InvoicePenjualanController;
use App\Http\Controllers\procurement\DasarPembelianController;
use App\Http\Controllers\procurement\ReturnPembelianController;
use App\Http\Controllers\accounting\JurnalPenyesuaianController;
use App\Http\Controllers\procurement\PenerimaanBarangController;
use App\Http\Controllers\inventory\ReportController as InventoryReportController;

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


Route::view('/', 'home')->name('home');

Route::redirect('/login', '/');

Route::prefix('/')->name('oauth.')->group(function () {
    Route::get('redirect', [AuthController::class, 'redirectToIdentityServer'])->name('redirect');
    Route::get('callback', [AuthController::class, 'handleCallback'])->name('callback');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::get('/loading', function () {
//     return view('loading.loadingpage');
// })->name('loading-screen');

//MIDDLEWARE
Route::middleware('auth.login')->group(
    function () {
        Route::get('/dashboard', [ShowDashboard::class, 'showDashboard'])->name('dashboard-dev');
        Route::view('/profile', 'profile')->name('profile');

        // ==========================================MASTERDATA========================================


        // ITEM
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
        Route::prefix('user')->name('user.')->group(function () {
            Route::view('/', 'masterdata.user.index')->name('index');
            Route::view('/add', 'masterdata.user.add')->name('add');
            Route::view('/edit', 'masterdata.user.edit')->name('edit');
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

        Route::prefix('/penjualan')->name('penjualan.')->controller(PenjualanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/generate-po-code', 'generateCode');
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
        Route::prefix('/hutang')->name('hutang.')->controller(HutangController::class)->group(
            function () {
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
            }
        );

        Route::prefix('/piutang')->name('piutang.')->controller(PiutangController::class)->group(
            function () {
                Route::get('/', 'index')->name('index');
                Route::get('/ajax', 'ajax')->name('ajax');
                Route::get('/detail/{id}', 'showpiutang')->name('detail');

                Route::prefix('/pembayaran')->name('pembayaran.')->group(
                    function () {
                        Route::get('/', 'pembayaran')->name('index');
                        Route::get('/ajax', 'ajaxpembayaran')->name('ajax');
                        Route::get('/add', 'create')->name('create');
                        Route::post('/store', 'store')->name('store');
                        Route::get('/detail/{id}', 'showpembayaran')->name('detail');
                        Route::get('/getinvoice/{id}', 'getinvoice')->name('getinvoice');
                        Route::get('/approve/{id}', 'detail_approve')->name('detail_approve');
                        Route::get('/edit/{id}', 'edit')->name('edit');
                        Route::put('/update/{id}', 'update')->name('update');
                        Route::put('/approve/{id}', 'approve')->name('approve');
                        Route::delete('/delete/{id}', 'destroy')->name('destroy');
                        Route::get('/print/{id}', 'print')->name('print');

                        Route::prefix('/giro')->name('giro.')->group(
                            function () {
                                Route::get('/', 'giro')->name('index');
                            }
                        );
                    }
                );
            }
        );

        Route::prefix('/jurnalpemasukan')->name('jurnalpemasukan.')->controller(JurnalPemasukanController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            // Route::get('/getItemsList/{id}', 'getItemsList')->name('getitem');
            // Route::get('/getDetailCustomer/{id}', 'getDetailCustomer')->name('getDetailCustomer');
            // Route::get('/getDetailWarehouse/{id}', 'getDetailWarehouse')->name('getDetailWarehouse');
            // Route::get('/getStock/{id}', 'getstock')->name('getstock');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            // Route::get('/detail/{id}', 'show')->name('detail');
            // Route::get('/edit/{id}', 'edit')->name('edit');
            // Route::put('/update/{id}', 'update')->name('update');
            // Route::get('/approve/{id}', 'vapprove')->name('vapprove');
            // Route::put('/approve/{id}', 'approve')->name('approve');
            // Route::get('/print/{id}', 'print')->name('print');
        });

        Route::prefix('/jurnal_pengeluaran')->name('jurnal_pengeluaran.')->controller(JurnalPengeluaranController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/print/{id}', 'print')->name('print');
        });

        Route::prefix('/jurnal_penyesuaian')->name('jurnal_penyesuaian.')->controller(JurnalPenyesuaianController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/ajax', 'ajax')->name('ajax');
            Route::get('/add', 'create')->name('create');
            Route::post('/add', 'store')->name('store');
            Route::get('/detail/{id}', 'show')->name('detail');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/print/{id}', 'print')->name('print');
        });
    }


);
