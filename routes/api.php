<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\DealerCreditController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/dealer', 'as' => 'dealer.'], function() {
    Route::post('/create', [DealerCreditController::class, 'create'])->name('dealer-create');
    Route::get('/', [DealerCreditController::class, 'index'])->name('dealer-index');
    Route::put('/{id}', [DealerCreditController::class, 'update'])->name('dealer-update');
    Route::delete('/{id}', [DealerCreditController::class, 'delete'])->name('dealer-delete');
});

Route::group(['prefix' => '/bank', 'as' => 'bank.'], function() {
    Route::post('/create', [BankController::class, 'create'])->name('bank-create');
});
