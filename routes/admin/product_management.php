<?php

use App\Http\Controllers\Admin\ProductManagement\StockInController;


Route::prefix('/stock-in')->group(function () {
    Route::get('/list', [StockInController::class, 'index'])->name('stock.in.list');
    Route::get('/add', [StockInController::class, 'add'])->name('stock.in.add');
    Route::post('/store', [StockInController::class, 'store'])->name('stock.in.store');
    Route::get('/edit/{id}', [StockInController::class, 'edit'])->name('stock.in.edit');
    Route::post('/update/{id}', [StockInController::class, 'update'])->name('stock.in.update');
    Route::post('/delete', [StockInController::class, 'delete'])->name('stock.in.delete');
});


