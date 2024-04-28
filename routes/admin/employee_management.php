<?php

use App\Http\Controllers\Admin\EmployeeManagement\DesignationController;
use App\Http\Controllers\Admin\EmployeeManagement\DepartmentController;
use App\Http\Controllers\Admin\EmployeeManagement\SectionController;
use App\Http\Controllers\Admin\EmployeeManagement\EmployeeController;

Route::prefix('/employee-designation')->group(function () {
    Route::get('/list', [DesignationController::class, 'index'])->name('employee.designation.list');
    Route::get('/add', [DesignationController::class, 'add'])->name('employee.designation.add');
    Route::post('/store', [DesignationController::class, 'store'])->name('employee.designation.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [DesignationController::class, 'edit'])->name('employee.designation.edit');
    Route::post('/update/{id}', [DesignationController::class, 'update'])->name('employee.designation.update')->middleware('checkUserRole');
    Route::post('/delete', [DesignationController::class, 'delete'])->name('employee.designation.delete')->middleware('checkUserRole');
});

Route::prefix('/department')->group(function () {
    Route::get('/list', [DepartmentController::class, 'index'])->name('department.list');
    Route::get('/add', [DepartmentController::class, 'add'])->name('department.add');
    Route::post('/store', [DepartmentController::class, 'store'])->name('department.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('department.update')->middleware('checkUserRole');
    Route::post('/delete', [DepartmentController::class, 'delete'])->name('department.delete')->middleware('checkUserRole');
});

Route::prefix('/section')->group(function () {
    Route::get('/list', [SectionController::class, 'index'])->name('section.list');
    Route::get('/add', [SectionController::class, 'add'])->name('section.add');
    Route::post('/store', [SectionController::class, 'store'])->name('section.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('section.edit');
    Route::post('/update/{id}', [SectionController::class, 'update'])->name('section.update')->middleware('checkUserRole');
    Route::post('/delete', [SectionController::class, 'delete'])->name('section.delete')->middleware('checkUserRole');
});

Route::prefix('/employee')->group(function () {
    Route::get('/list', [EmployeeController::class, 'index'])->name('employee.list');
    Route::get('/add', [EmployeeController::class, 'add'])->name('employee.add');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware('checkUserRole');
    Route::post('/delete', [EmployeeController::class, 'delete'])->name('employee.delete')->middleware('checkUserRole');
});
