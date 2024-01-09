<?php

use App\Http\Controllers\Admin\ProductManagement\StockInController;


Route::prefix('/stock-in')->group(function () {
    Route::get('/list', [StockInController::class, 'index'])->name('stock.in.list');
    Route::get('/product-selection', [StockInController::class, 'selectProducts'])->name('stock.in.product.selection');
    Route::post('/check-po', [StockInController::class, 'checkPo'])->name('stock.in.check.po');
    Route::match(['get', 'post'],'/add', [StockInController::class, 'add'])->name('stock.in.add');
    Route::post('/store', [StockInController::class, 'store'])->name('stock.in.store');
    Route::post('/update-po-products', [StockInController::class, 'updatePoProducts'])->name('stock.in.update-po-products');
    Route::get('/edit/{id}', [StockInController::class, 'edit'])->name('stock.in.edit');
    Route::post('/update/{id}', [StockInController::class, 'update'])->name('stock.in.update');
    Route::post('/delete', [StockInController::class, 'delete'])->name('stock.in.delete');
    Route::get('/active/{id}', [StockInController::class, 'active'])->name('stock.in.active');
});


