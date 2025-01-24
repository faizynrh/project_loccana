<?php

use App\Http\Controllers\masterdata\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\CoaController;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\authentication\ShowDashboard;
use App\Http\Controllers\authentication\AuthController;
use App\Http\Controllers\procurement\PenerimaanBarangController;
use App\Http\Controllers\masterdata\PrincipalController;
use App\Http\Controllers\procurement\PurchaseOrderController;

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
        //ITEM
        Route::get('/item', [ItemController::class, 'index'])->name('item.index');
        Route::get('/item/add', [ItemController::class, 'create'])->name('item.create');
        Route::post('/item/add', [ItemController::class, 'store'])->name('item.store');
        Route::delete('/item/delete/{id}', [ItemController::class, 'destroy'])->name('item.destroy');
        Route::get('/item/edit/{id}', [ItemController::class, 'edit'])->name('item.edit');
        Route::put('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');
        Route::get('/item/detail/{id}', [ItemController::class, 'show'])->name('item.detail');

        //USER
        Route::get('/user', function () {
            return view('masterdata.user.index');
        });
        Route::get('/user/add', function () {
            return view('masterdata.user.add');
        });
        Route::get('/user/edit', function () {
            return view('masterdata.user.edit');
        });
        //PRICE
        Route::get('/price', [PriceController::class, 'index'])->name('price.index');
        Route::get('/price/edit/{id}', [PriceController::class, 'edit'])->name('price.edit');
        Route::put('/price/update/{id}', [PriceController::class, 'update'])->name('price.update');
        Route::put('/price/approve/{id}', [PriceController::class, 'approve'])->name('price.approve');

        //UOM
        Route::get('/uom', [UomController::class, 'index'])->name('uom.index'); //jika api mati maka gunakan yang bawah
        Route::get('/uom/add', [UomController::class, 'create'])->name('uom.create');
        Route::post('/uom/add', [UomController::class, 'store'])->name('uom.store'); //jika api mati maka gunakan yang bawah'] () {
        Route::delete('/uom/delete/{id}', [UomController::class, 'destroy'])->name('uom.destroy');
        Route::get('/uom/edit/{id}', [UomController::class, 'edit'])->name('uom.edit');
        Route::put('/uom/update/{id}', [UomController::class, 'update'])->name('uom.update');
        Route::get('/uom/detail/{id}', [UomController::class, 'show'])->name('uom.show');

        //COA
        Route::get('/coa', [CoaController::class, 'index'])->name('coa.index');
        Route::get('/coa/detail/{id}', [CoaController::class, 'show'])->name('coa.detail');
        Route::get('/coa/add', [CoaController::class, 'create'])->name('coa.create');
        Route::post('/coa/add', [CoaController::class, 'store'])->name('coa.store');
        Route::delete('/coa/delete/{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
        Route::get('/coa/edit/{id}', [CoaController::class, 'edit'])->name('coa.edit');
        Route::put('/coa/update/{id}', [CoaController::class, 'update'])->name('coa.update');

        //GUDANG
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
        Route::get('/gudang/add', [GudangController::class, 'create'])->name('gudang.create');
        Route::get('/gudang/edit/{id}', [GudangController::class, 'edit'])->name('gudang.edit');
        Route::put('/gudang/edit/{id}', [GudangController::class, 'update'])->name('gudang.update');
        Route::post('/gudang/add', [GudangController::class, 'store'])->name('gudang.store');
        Route::delete('/gudang/delete/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');

        //principal
        Route::get('/principal', [PrincipalController::class, 'index'])->name('principal.index');
        Route::get('/principal/add', [PrincipalController::class, 'create'])->name('principal.create');
        Route::post('/principal/add', [PrincipalController::class, 'store'])->name('principal.store');
        Route::delete('/principal/delete/{id}', [PrincipalController::class, 'destroy'])->name('principal.destroy');
        Route::get('/principal/edit/{id}', [PrincipalController::class, 'edit'])->name('principal.edit');
        Route::put('/principal/update/{id}', [PrincipalController::class, 'update'])->name('principal.update');
        Route::get('/principal/show/{id}', [PrincipalController::class, 'show'])->name('principal.show');

        // customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/customer/add', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/customer/add', [CustomerController::class, 'store'])->name('customer.store');
        Route::delete('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
        Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/customer/show/{id}', [CustomerController::class, 'show'])->name('customer.show');

        // ===================================== END MASTERDATA ======================================


        // ===================================== PROCUREMENT =========================================

        //penerimaan barang
        Route::get('/penerimaan_barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan_barang.index');
        Route::get('/get-po-details/{id_po}', [PenerimaanBarangController::class, 'getPoDetails'])->name('getdetails');
        Route::get('/penerimaan_barang/add', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
        Route::get('/penerimaan_barang/detail/{id}', [PenerimaanBarangController::class, 'show'])->name('penerimaan_barang.detail');
        Route::delete('/penerimaan_barang/delete/{id}', [PenerimaanBarangController::class, 'destroy'])->name('penerimaan_barang.destroy');
        Route::get('/penerimaan_barang/edit/{id}', [PenerimaanBarangController::class, 'edit'])->name('penerimaan_barang.edit');
        Route::put('/penerimaan_barang/update/{id}', [PenerimaanBarangController::class, 'update'])->name('penerimaan_barang.update');


        Route::get('/purchase_order', [PurchaseOrderController::class, 'index'])->name('purchaseorder.index');
        // Route::get('/get-po-details/{id_po}', [PenerimaanBarangController::class, 'getPoDetails'])->name('getdetails');
        // Route::get('/penerimaan_barang/add', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
        // Route::get('/penerimaan_barang/detail/{id}', [PenerimaanBarangController::class, 'show'])->name('penerimaan_barang.detail');
        // Route::delete('/penerimaan_barang/delete/{id}', [PenerimaanBarangController::class, 'destroy'])->name('penerimaan_barang.destroy');
        // Route::get('/penerimaan_barang/edit/{id}', [PenerimaanBarangController::class, 'edit'])->name('penerimaan_barang.edit');
        // Route::put('/penerimaan_barang/update/{id}', [PenerimaanBarangController::class, 'update'])->name('penerimaan_barang.update');
    }
);
