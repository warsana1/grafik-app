<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [SaleController::class, 'index'])->name('sales.index');
Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
Route::get('/sales/{id}/edit', [SaleController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{id}', [SaleController::class, 'update'])->name('sales.update');


