<?php

use App\Http\Controllers\Admin\ProductReceiveController;


Route::prefix('/product-receive-information')->group(function () {
    Route::get('/list', [ProductReceiveController::class, 'index'])->name('product.receive.information.list');
    Route::get('/add', [ProductReceiveController::class, 'add'])->name('product.receive.information.add');
    Route::post('/store', [ProductReceiveController::class, 'store'])->name('product.receive.information.store');
    Route::get('/edit/{id}', [ProductReceiveController::class, 'edit'])->name('product.receive.information.edit');
    Route::post('/update/{id}', [ProductReceiveController::class, 'update'])->name('product.receive.information.update');
    Route::post('/delete', [ProductReceiveController::class, 'delete'])->name('product.receive.information.delete');
    Route::get('/get-product-by-type', [ProductReceiveController::class, 'getProductByType'])->name('get.product.by.type');
});

