<?php

use App\Http\Controllers\CoaController;
use App\Http\Controllers\UomDataController;
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

//profile
Route::get('/profile', function () {
    return view('profile');
});

Route::get('/coba', function () {
    return view('masterdata.coa.edit');
});

//items
Route::get('/items', function () {
    return view('masterdata.items.items');
});
Route::get('/items/add', function () {
    return view('masterdata.items.add');
});
Route::get('/items/edit', function () {
    return view('masterdata.items.edit');
});

//price
Route::get('/price', function () {
    return view('masterdata.price.price');
});
Route::get('/price/edit', function () {
    return view('masterdata.price.edit');
});

//coa
Route::get('/coa', [CoaController::class, 'index'])->name('coa');

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


//gudang
route::get('/gudang', function () {
    return view('masterdata.gudang.gudang');
});

route::get('/gudang/add', function () {
    return view('masterdata.gudang.add');
});

route::get('/gudang/edit', function () {
    return view('masterdata.gudang.edit');
});
