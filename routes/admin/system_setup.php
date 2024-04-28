<?php


use App\Http\Controllers\Admin\SystemSetup\UnitController;
use App\Http\Controllers\Admin\SystemSetup\SupplierController;
use App\Http\Controllers\Admin\SystemSetup\ProductTypeController;
use App\Http\Controllers\Admin\SystemSetup\ProductInformationController;


Route::prefix('/unit')->group(function () {
    Route::get('/list', [UnitController::class, 'index'])->name('unit.list');
    Route::get('/add', [UnitController::class, 'add'])->name('unit.add');
    Route::post('/store', [UnitController::class, 'store'])->name('unit.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [UnitController::class, 'edit'])->name('unit.edit');
    Route::post('/update/{id}', [UnitController::class, 'update'])->name('unit.update')->middleware('checkUserRole');
    Route::post('/delete', [UnitController::class, 'delete'])->name('unit.delete')->middleware('checkUserRole');
});

Route::prefix('/supplier')->group(function () {
    Route::get('/list', [SupplierController::class, 'index'])->name('supplier.list');
    Route::get('/add', [SupplierController::class, 'add'])->name('supplier.add');
    Route::post('/store', [SupplierController::class, 'store'])->name('supplier.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update')->middleware('checkUserRole');
    Route::post('/delete', [SupplierController::class, 'delete'])->name('supplier.delete')->middleware('checkUserRole');
});

Route::prefix('/product-type')->group(function () {
    Route::get('/list', [ProductTypeController::class, 'index'])->name('product.type.list');
    Route::get('/add', [ProductTypeController::class, 'add'])->name('product.type.add');
    Route::post('/store', [ProductTypeController::class, 'store'])->name('product.type.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [ProductTypeController::class, 'edit'])->name('product.type.edit');
    Route::post('/update/{id}', [ProductTypeController::class, 'update'])->name('product.type.update')->middleware('checkUserRole');
    Route::post('/delete', [ProductTypeController::class, 'delete'])->name('product.type.delete')->middleware('checkUserRole');
});

Route::prefix('/product-information')->group(function () {
    Route::get('/list', [ProductInformationController::class, 'index'])->name('product.information.list');
    Route::get('/add', [ProductInformationController::class, 'add'])->name('product.information.add');
    Route::post('/store', [ProductInformationController::class, 'store'])->name('product.information.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [ProductInformationController::class, 'edit'])->name('product.information.edit');
    Route::post('/update/{id}', [ProductInformationController::class, 'update'])->name('product.information.update')->middleware('checkUserRole');
    Route::post('/delete', [ProductInformationController::class, 'delete'])->name('product.information.delete')->middleware('checkUserRole');
});

