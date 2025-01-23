<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\authentication\ShowDashboard;
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


//MIDDLEWARE
Route::middleware('auth.login')->group(
    function () {
        Route::get('/dashboard', [ShowDashboard::class, 'showDashboard'])->name('dashboard-dev');
        Route::get('/profile', function () {
            return view('profile');
        });
        // ==========================================MASTERDATA========================================
        //items
        Route::get('/items', [ItemController::class, 'index'])->name('items');
        Route::get('/items/add', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items/add', [ItemController::class, 'store'])->name('items.store');
        Route::delete('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/edit/{id}', [ItemController::class, 'update'])->name('items.update');
        Route::get('/items/detail/{id}', [ItemController::class, 'show'])->name('items.detail');


        //PRICE
        Route::get('/price', [PriceController::class, 'index'])->name('price.index');
        Route::get('/price/edit/{id}', [PriceController::class, 'edit'])->name('price.edit');
        Route::put('/price/edit/{id}', [PriceController::class, 'update'])->name('price.update');
        Route::put('/price/approve/{id}', [PriceController::class, 'approve'])->name('price.approve');


        //UOM
        Route::get('/uom', [UomController::class, 'index'])->name('uom.index'); //jika api mati maka gunakan yang bawah
        Route::get('/uom/add', [UomController::class, 'create'])->name('uom.create');
        Route::post('/uom/add', [UomController::class, 'store'])->name('uom.store'); //jika api mati maka gunakan yang bawah'] () {
        Route::delete('/uom/delete/{id}', [UomController::class, 'destroy'])->name('uom.destroy');
        Route::get('/uom/edit/{id}', [UomController::class, 'edit'])->name('uom.edit');
        Route::put('/uom/update/{id}', [UomController::class, 'update'])->name('uom.update');
        Route::get('/uom/detail/{id}', [UomController::class, 'show'])->name('uom.show');
    }
);
