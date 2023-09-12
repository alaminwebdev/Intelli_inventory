<?php

use App\Http\Controllers\Admin\StockInController;



Route::prefix('/stock-in-product')->group(function () {
    Route::get('/list', [StockInController::class, 'index'])->name('stock.in.product.list');
    Route::get('/add', [StockInController::class, 'add'])->name('stock.in.product.add');
    Route::post('/store', [StockInController::class, 'store'])->name('stock.in.product.store');
    Route::get('/edit/{id}', [StockInController::class, 'edit'])->name('stock.in.product.edit');
    Route::post('/update/{id}', [StockInController::class, 'update'])->name('stock.in.product.update');
    Route::post('/delete', [StockInController::class, 'delete'])->name('stock.in.product.delete');
});


