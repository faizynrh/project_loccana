<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\CoaController;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\authentication\ShowDashboard;
use App\Http\Controllers\authentication\AuthController;
use App\Http\Controllers\masterdata\CustomerController;
use App\Http\Controllers\masterdata\PrincipalController;
use App\Http\Controllers\procurement\PurchaseOrderController;
use App\Http\Controllers\procurement\DasarPembelianController;
use App\Http\Controllers\procurement\InvoiceController;
use App\Http\Controllers\procurement\PenerimaanBarangController;
use App\Http\Controllers\procurement\RekapPOController;
use App\Http\Controllers\procurement\ReturnController;

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
        Route::prefix('/item')->name('item.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::get('/ajax', [ItemController::class, 'ajax'])->name('ajax');
            Route::get('/add', [ItemController::class, 'create'])->name('create');
            Route::post('/add', [ItemController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ItemController::class, 'update'])->name('update');
            Route::get('/detail/{id}', [ItemController::class, 'show'])->name('detail');
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
        Route::prefix('/price')->name('price.')->group(function () {
            Route::get('/', [PriceController::class, 'index'])->name('index');
            Route::get('/ajax', [PriceController::class, 'ajax'])->name('ajax');
            Route::get('/edit/{id}', [PriceController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [PriceController::class, 'update'])->name('update');
            Route::put('/approve/{id}', [PriceController::class, 'approve'])->name('approve');
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
        Route::prefix('/coa')->name('coa.')->group(function () {
            Route::get('/', [CoaController::class, 'index'])->name('index');
            Route::get('/ajax', [CoaController::class, 'ajax'])->name('ajax');
            Route::get('/detail/{id}', [CoaController::class, 'show'])->name('detail');
            Route::get('/add', [CoaController::class, 'create'])->name('create');
            Route::post('/add', [CoaController::class, 'store'])->name('store');
            Route::delete('/delete/{id}', [CoaController::class, 'destroy'])->name('destroy');
            Route::get('/edit/{id}', [CoaController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [CoaController::class, 'update'])->name('update');
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
        Route::prefix('/purchase_order')->name('purchaseorder.')->group(function () {
            Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
            Route::get('/generate-po-code', [PurchaseOrderController::class, 'generatePOCode']);
            Route::get('/detailspurchase/{id_po}', [PurchaseOrderController::class, 'getPurchaseOrderDetails'])->name('getpurchasedetails');
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
        });


        Route::prefix('/dasar_pembelian')->name('dasar_pembelian.')->group(function () {
            Route::get('/', [DasarPembelianController::class, 'index'])->name('index');
            Route::get('/ajax', [DasarPembelianController::class, 'ajax'])->name('ajax');
        });

        Route::prefix('/rekap_po')->name('rekap_po.')->group(function () {
            Route::get('/', [RekapPOController::class, 'index'])->name('index');
            Route::get('/ajax', [RekapPOController::class, 'ajax'])->name('ajax');
        });

        Route::prefix('/invoice')->name('invoice.')->group(function () {
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


    }
);
Route::prefix('/return')->name('return.')->group(function () {
    Route::get('/', [ReturnController::class, 'index'])->name('index');
    Route::get('/ajax', [ReturnController::class, 'ajax'])->name('ajax');
    Route::get('/add', [ReturnController::class, 'create'])->name('create');
    Route::get('/detail/{id}', [ReturnController::class, 'show'])->name('detail');
    Route::delete('/delete/{id}', [ReturnController::class, 'destroy'])->name('destroy');
});
