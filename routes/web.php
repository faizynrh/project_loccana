<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\masterdata\UomController;

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
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/profile', function () {
    return view('profile');
});

Route::get('/price', [PriceController::class, 'index'])->name('price');
// Route::get('/uom/add', [UomController::class, 'create'])->name('uom.create');
