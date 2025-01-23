<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\masterdata\UomController;
use App\Http\Controllers\masterdata\ItemController;
use App\Http\Controllers\masterdata\PriceController;
use App\Http\Controllers\authentication\ShowDashboard;
use App\Http\Controllers\authentication\AuthController;
use App\Http\Controllers\masterdata\CoaController;

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
    }
);
