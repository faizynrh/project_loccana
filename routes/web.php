<?php

use App\Http\Controllers\CoaController;
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

Route::get('/', function () {
    return view('welcome');
});

//home
Route::get('/home', function () {
    return view('home');
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
Route::get('/coa/edit', function () {
    return view('masterdata.coa.edit');
});
