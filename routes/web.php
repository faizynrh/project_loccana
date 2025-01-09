<?php

<<<<<<< HEAD
=======

>>>>>>> 70cef363d12cf6520c6dfd0ae512f783038d8835
use App\Http\Controllers\masterdata\CoaController;
use App\Http\Controllers\masterdata\GudangController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\UomDataController;
use App\Http\Controllers\masterdata\CustomerController;
use App\Http\Controllers\masterdata\PrincipalController;
<<<<<<< HEAD
=======

>>>>>>> 70cef363d12cf6520c6dfd0ae512f783038d8835
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

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/profile', function () {
    return view('profile');
});


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
Route::put('/price/approve/{id}', [PriceController::class, 'approve'])->name('price.approve');


//coa
Route::get('/coa', [CoaController::class, 'index'])->name('coa');
Route::get('/coa/detail/{id}', [CoaController::class, 'show'])->name('coa.detail');
Route::get('/coa/add', [CoaController::class, 'create'])->name('coa.create');
Route::post('/coa/add', [CoaController::class, 'store'])->name('coa.store');
Route::delete('/coa/delete{id}', [CoaController::class, 'destroy'])->name('coa.destroy');
Route::get('/coa/edit/{id}', [CoaController::class, 'edit'])->name('coa.edit');
Route::put('/coa/edit/{id}', [CoaController::class, 'update'])->name('coa.update');

//gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');
Route::get('/gudang/add', [GudangController::class, 'create'])->name('gudang.create');
Route::get('/gudang/edit/{id}', [GudangController::class, 'edit'])->name('gudang.edit');
Route::post('/gudang/add', [GudangController::class, 'store'])->name('gudang.store');
Route::delete('/gudang/delete{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');



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
    return view('masterdata.customer.tambah-customer');
});
route::get('/customer/edit', function () {
    return view('masterdata.customer.edit-customer');
});

//principal
Route::get('/principal', [PrincipalController::class, 'index'])->name('principal.index');
route::get('/principal/add', function () {
    return view('masterdata.principal.tambah-principal');
});

<<<<<<< HEAD
=======

//gudang
Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');
>>>>>>> 70cef363d12cf6520c6dfd0ae512f783038d8835


//user
route::get('/user', function () {
    return view('masterdata.user.user');
});
route::get('/user/add', function () {
    return view('masterdata.user.add');
});


//dasarpembelian
route::get('/dasarpembelian', function () {
    return view('procurement.dasarpembelian.dasarpembelian');
});


//rekap po
route::get('/rekappo', function () {
    return view('procurement.rekappo.rekappo');
});
