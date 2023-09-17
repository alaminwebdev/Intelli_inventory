<?php

use App\Http\Controllers\Admin\RequisitionManagement\SectionRequisitionController;
use App\Http\Controllers\Admin\RequisitionManagement\DepartmentRequisitionController;
use App\Http\Controllers\Admin\RequisitionManagement\RequisitionApprovalController;
use App\Http\Controllers\Admin\RequisitionManagement\DistributionController;


Route::prefix('/section-requisition')->group(function () {
    Route::get('/list', [SectionRequisitionController::class, 'index'])->name('section.requisition.list');
    Route::get('/add', [SectionRequisitionController::class, 'add'])->name('section.requisition.add');
    Route::post('/store', [SectionRequisitionController::class, 'store'])->name('section.requisition.store');
    Route::get('/edit/{id}', [SectionRequisitionController::class, 'edit'])->name('section.requisition.edit');
    Route::post('/update/{id}', [SectionRequisitionController::class, 'update'])->name('section.requisition.update');
    Route::post('/delete', [SectionRequisitionController::class, 'delete'])->name('section.requisition.delete');
});


Route::prefix('/department-requisition')->group(function () {
    Route::get('/list', [DepartmentRequisitionController::class, 'index'])->name('department.requisition.list');
    Route::get('/add', [DepartmentRequisitionController::class, 'add'])->name('department.requisition.add');
    Route::post('/store', [DepartmentRequisitionController::class, 'store'])->name('department.requisition.store');
    Route::get('/edit/{id}', [DepartmentRequisitionController::class, 'edit'])->name('department.requisition.edit');
    Route::post('/update/{id}', [DepartmentRequisitionController::class, 'update'])->name('department.requisition.update');
    Route::post('/delete', [DepartmentRequisitionController::class, 'delete'])->name('department.requisition.delete');
});

Route::prefix('/requisition')->group(function () {
    Route::get('/list', [RequisitionApprovalController::class, 'index'])->name('requisition.list');
    Route::get('/edit/{id}', [RequisitionApprovalController::class, 'edit'])->name('requisition.edit');
    Route::post('/update/{id}', [RequisitionApprovalController::class, 'update'])->name('requisition.update');
});

Route::prefix('/distribution-approval')->group(function () {
    Route::get('/list', [DistributionController::class, 'index'])->name('distribution.list');
    Route::get('/edit/{id}', [DistributionController::class, 'edit'])->name('distribution.edit');
    Route::post('/update/{id}', [DistributionController::class, 'update'])->name('distribution.update');
});






