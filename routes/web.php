<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\authentication\AuthController;

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

Route::get('/', function () {});

Route::get('/dashboard', function () {
    return view('masterdata.index');
});

Route::get('/price', [PriceController::class, 'index'])->name('price');
// Route::get('/uom/add', [UomController::class, 'create'])->name('uom.create');
