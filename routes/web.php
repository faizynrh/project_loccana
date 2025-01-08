<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\Principal;
use App\Http\Controllers\UomDataController;
use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;
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

// Route::get('/', function () {
//     return view('welcome');
// });

//home
Route::get('/', function () {
    return view('home');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/coba', function () {
    return view('masterdata.coa.edit');
});

//items
Route::get('/items', [ItemController::class, 'index'])->name('items');
Route::get('/items/add', [ItemController::class, 'create'])->name('items.create');
Route::post('/items/add', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
Route::get('/items/edit', function () {
    return view('masterdata.items.edit');
});

//price
// Route::get('/price', function () {
//     return view('masterdata.price.price');
// });
Route::get('/price', [PriceController::class, 'index'])->name('price');

Route::get('/price/edit', function () {
    return view('masterdata.price.edit');
});

//coa
Route::get('/coa', [CoaController::class, 'index'])->name('coa');
Route::get('/coa/detail/{id}', [CoaController::class, 'show'])->name('coa.show');
Route::get('/coa/add', [CoaController::class, 'create'])->name('coa.create');
Route::post('/coa/add', [CoaController::class, 'store'])->name('coa.store');
Route::delete('/coa/{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
Route::get('/coa/edit/{id}', [CoaController::class, 'edit'])->name('coa.edit');
Route::put('/coa/{id}', [CoaController::class, 'update'])->name('coa.update');



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

//customer
route::get('/customer', function () {
    return view('masterdata.customer.customer');
});
route::get('/customer/add', function () {
    return view('masterdata.customer.add-customer');
});
route::get('/customer/edit', function () {
    return view('masterdata.customer.edit-customer');
});

//principal
route::get('/principal', function () {
    return view('masterdata.principal.principal');
});
route::get('/principal/add', function () {
    return view('masterdata.principal.tambah-principal');
});


//gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');

// route::get('/gudang', function () {
//     return view('masterdata.gudang.gudang');
// });

Route::get('/gudang/add', [GudangController::class, 'create'])->name('gudang.create');

Route::post('/gudang/add', [GudangController::class, 'store'])->name('gudang.store');

route::get('/gudang/edit', function () {
    return view('masterdata.gudang.edit');
});

//user
route::get('/user', function () {
    return view('masterdata.user.user');
});
route::get('/user/add', function () {
    return view('masterdata.user.add');
});
