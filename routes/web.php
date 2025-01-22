<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowDashboard;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\masterdata\CoaController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\masterdata\UomDataController;
use App\Http\Controllers\procurement\ReportController;
use App\Http\Controllers\procurement\ReturnController;
use App\Http\Controllers\masterdata\CustomerController;
use App\Http\Controllers\procurement\InvoiceController;
use App\Http\Controllers\procurement\RekappoController;
use App\Http\Controllers\masterdata\PrincipalController;
use App\Http\Controllers\procurement\DasarPembelianController;
use App\Http\Controllers\procurement\PenerimaanBarangController;
use App\Http\Controllers\PurchaseOrderController;

Route::get('/redirect', [AuthController::class, 'redirectToIdentityServer'])->name('oauth.redirect');
Route::get('/callback', [AuthController::class, 'handleCallback'])->name('oauth.callback');
Route::get('/logout', [AuthController::class, 'logout'])->name('oauth.logout');
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/login', function () {
    return redirect('/');
});

Route::middleware('auth.login')->group(
    function () {
        Route::get('/dashboard', [ShowDashboard::class, 'showDashboard'])->name('dashboard-dev');
        Route::get('/profile', function () {
            return view('profile');
        });

        // ===================================== MASTERDATA ==========================================
        //items
        Route::get('/items', [ItemController::class, 'index'])->name('items');
        Route::get('/items/add', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items/add', [ItemController::class, 'store'])->name('items.store');
        Route::delete('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/edit/{id}', [ItemController::class, 'update'])->name('items.update');
        Route::get('/items/detail/{id}', [ItemController::class, 'show'])->name('items.detail');

        //price
        Route::get('/price', [PriceController::class, 'index'])->name('price');
        Route::get('/price/edit/{id}', [PriceController::class, 'edit'])->name('price.edit');
        Route::put('/price/edit/{id}', [PriceController::class, 'update'])->name('price.update');
        Route::put('/price/approve/{id}', [PriceController::class, 'approve'])->name('price.approve');

        //coa
        Route::get('/coa', [CoaController::class, 'index'])->name('coa');
        Route::get('/coa/detail/{id}', [CoaController::class, 'show'])->name('coa.detail');
        Route::get('/coa/add', [CoaController::class, 'create'])->name('coa.create');
        Route::post('/coa/add', [CoaController::class, 'store'])->name('coa.store');
        Route::delete('/coa/delete/{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
        Route::get('/coa/edit/{id}', [CoaController::class, 'edit'])->name('coa.edit');
        Route::put('/coa/edit/{id}', [CoaController::class, 'update'])->name('coa.update');

        //gudang
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');
        Route::get('/gudang/add', [GudangController::class, 'create'])->name('gudang.create');
        Route::get('/gudang/edit/{id}', [GudangController::class, 'edit'])->name('gudang.edit');
        Route::put('/gudang/edit/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::post('/gudang/add', [GudangController::class, 'store'])->name('gudang.store');
        Route::delete('/gudang/delete/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');

        // uom
        Route::get('/uom', [UomDataController::class, 'index'])->name('uom.index'); //jika api mati maka gunakan yang bawah
        Route::get('/uom-tambah', [UomDataController::class, 'create'])->name('uom.create');
        Route::post('/uom-tambah', [UomDataController::class, 'store'])->name('uom.store'); //jika api mati maka gunakan yang bawah'] () {
        Route::delete('/uom-delete/{id}', [UomDataController::class, 'destroy'])->name('uom.destroy');
        Route::get('/uom/edit/{id}', [UomDataController::class, 'edit'])->name('uom.edit');
        Route::put('/uom/update/{id}', [UomDataController::class, 'update'])->name('uom.update');
        Route::get('/uom/show/{id}', [UomDataController::class, 'show'])->name('uom.show');

        // informasi
        route::get('/informasi', function () {
            return view('masterdata.informasi.informasi');
        });
        route::get('/tambah-informasi', function () {
            return view('masterdata.informasi.tambah-informasi');
        });

        //principal
        Route::get('/principal', [PrincipalController::class, 'index'])->name('principal.index');
        Route::get('/principal-tambah', [PrincipalController::class, 'create'])->name('principal.create');
        Route::post('/principal-tambah', [PrincipalController::class, 'store'])->name('principal.store');
        Route::delete('/principal-delete/{id}', [PrincipalController::class, 'destroy'])->name('principal.destroy');
        Route::get('/principal/edit/{id}', [PrincipalController::class, 'edit'])->name('principal.edit');
        Route::put('/principal/update/{id}', [PrincipalController::class, 'update'])->name('principal.update');
        Route::get('/principal/show/{id}', [PrincipalController::class, 'show'])->name('principal.show');

        // customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/customer-tambah', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/customer-tambah', [CustomerController::class, 'store'])->name('customer.store');
        Route::delete('/customer-delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');

        //gudang
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');

        //user
        // route::get('/user', function () {
        //     return view('masterdata.user.user');
        // });
        route::get('/user/add', function () {
            return view('masterdata.user.add');
        });

        // ===================================== END MASTERDATA ======================================


        // ===================================== PROCUREMENT =========================================
        // Purchase Order
        Route::get('/purchase_order', [PurchaseOrderController::class, 'index'])->name('puerchase_order.index');


        //penerimaan barang
        Route::get('/penerimaan_barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan_barang');
        Route::get('/get-po-details/{id_po}', [PenerimaanBarangController::class, 'getPoDetails'])->name('getdetails');
        Route::get('/penerimaan_barang/add', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
        Route::get('/penerimaan_barang/detail/{id}', [PenerimaanBarangController::class, 'show'])->name('penerimaan_barang.detail');
        Route::delete('/penerimaan_barang/delete/{id}', [PenerimaanBarangController::class, 'destroy'])->name('penerimaan_barang.destroy');
        Route::get('/penerimaan_barang/edit/{id}', [PenerimaanBarangController::class, 'edit'])->name('penerimaan_barang.edit');
        Route::put('/penerimaan_barang/update/{id}', [PenerimaanBarangController::class, 'update'])->name('penerimaan_barang.update');

        //dasarpembelian
        Route::get('/dasarpembelian', [DasarPembelianController::class, 'index'])->name('dasarpembelian');

        //report
        Route::get('/report', [ReportController::class, 'index'])->name('report');

        //return
        Route::get('/return', [ReturnController::class, 'index'])->name('return');
        Route::delete('/return/delete/{id}', [ReturnController::class, 'destroy'])->name('return.destroy');
        Route::get('/return/detail/{id}', [ReturnController::class, 'show'])->name('return.detail');
        route::get('/return/add', function () {
            return view('procurement.return.add');
        });


        //rekap po
        Route::get('/rekappo', [RekappoController::class, 'index'])->name('rekappo.index');

        // invoice
        Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::delete('/invoice-delete/{no_invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
        Route::get('/invoice-tambah', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::post('/invoice-tambah', [InvoiceController::class, 'store'])->name('invoice.store');
        Route::get('/invoice/edit/{no_invoice}', [InvoiceController::class, 'edit'])->name('invoice.edit');
        Route::put('/invoice/update/{no_invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
        Route::get('/invoice/detail/{no_invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    }
);

Route::get('/user', [UserController::class, 'index'])->name('user');
