<?php

use App\Http\Controllers\Admin\DefaultController;
use App\Http\Controllers\Admin\RequisitionManagement\DepartmentRequisitionController;
use App\Http\Controllers\Admin\RequisitionManagement\DistributionController;
use App\Http\Controllers\Admin\RequisitionManagement\RequisitionApprovalController;
use App\Http\Controllers\Admin\RequisitionManagement\SectionRequisitionController;

Route::prefix('/section-requisition')->group(function () {
    Route::get('/list', [SectionRequisitionController::class, 'index'])->name('section.requisition.list');
    Route::get('/product-selection', [SectionRequisitionController::class, 'selectProducts'])->name('section.requisition.product.selection');
    Route::match(['get', 'post'],'/add', [SectionRequisitionController::class, 'add'])->name('section.requisition.add');
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


// RequisitionApprovalController is responsible for Requisition Recommendation, after that it will go to next stage - Requisition/Distribution Approval
Route::prefix('/recommended-requisition')->group(function () {
    Route::get('/list', [RequisitionApprovalController::class, 'index'])->name('recommended.requisition.list');
    Route::get('/edit/{id}', [RequisitionApprovalController::class, 'edit'])->name('recommended.requisition.edit');
    Route::post('/update/{id}', [RequisitionApprovalController::class, 'update'])->name('recommended.requisition.update');
});

Route::prefix('/distribution-approval')->group(function () {
    Route::get('/list', [DistributionController::class, 'index'])->name('distribution.list');
    Route::get('/edit/{id}', [DistributionController::class, 'edit'])->name('distribution.edit');
    Route::post('/store', [DistributionController::class, 'store'])->name('distribution.update');
});

Route::prefix('/distribute')->group(function () {
    Route::get('/pending-distribute-list', [DistributionController::class, 'pendingDistribute'])->name('pending.distribute.list');
    Route::get('/approve-distribute-list', [DistributionController::class, 'approveDistribute'])->name('approve.distribute.list');
    Route::get('/pending-distribute-edit/{id}', [DistributionController::class, 'productDistributeEdit'])->name('distribution.distribute.edit');
    Route::post('/distribute', [DistributionController::class, 'productDistribute'])->name('distribution.distribute');
});

