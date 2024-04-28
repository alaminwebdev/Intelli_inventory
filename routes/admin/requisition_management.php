<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DefaultController;
use App\Http\Controllers\Admin\RequisitionManagement\DepartmentRequisitionController;
use App\Http\Controllers\Admin\RequisitionManagement\DistributionController;
use App\Http\Controllers\Admin\RequisitionManagement\RequisitionApprovalController;
use App\Http\Controllers\Admin\RequisitionManagement\SectionRequisitionController;
use App\Http\Controllers\Admin\RequisitionManagement\RequisitionReceiveController;
use App\Http\Controllers\Admin\RequisitionManagement\RequisitionVerifyController;

Route::prefix('/section-requisition')->group(function () {
    Route::get('/list', [SectionRequisitionController::class, 'index'])->name('section.requisition.list');
    Route::get('/product-selection', [SectionRequisitionController::class, 'selectProducts'])->name('section.requisition.product.selection');
    Route::match(['get', 'post'],'/add', [SectionRequisitionController::class, 'add'])->name('section.requisition.add');
    Route::post('/store', [SectionRequisitionController::class, 'store'])->name('section.requisition.store')->middleware('checkUserRole');
    Route::get('/edit/{id}', [SectionRequisitionController::class, 'edit'])->name('section.requisition.edit');
    Route::post('/update/{id}', [SectionRequisitionController::class, 'update'])->name('section.requisition.update')->middleware('checkUserRole');
    Route::post('/delete', [SectionRequisitionController::class, 'delete'])->name('section.requisition.delete')->middleware('checkUserRole');
    Route::get('get-requisition-list', [SectionRequisitionController::class, 'getRequisitionList'])->name('get.requisition.list.datatable');
});

Route::prefix('/section-requisition-receive')->group(function () {
    Route::get('/list', [RequisitionReceiveController::class, 'index'])->name('section.requisition.receive.list');
    Route::get('/edit/{id}', [RequisitionReceiveController::class, 'edit'])->name('section.requisition.receive.edit');
    Route::post('/update/{id}', [RequisitionReceiveController::class, 'update'])->name('section.requisition.receive.update');
});

Route::prefix('/department-requisition')->group(function () {
    Route::get('/list', [DepartmentRequisitionController::class, 'index'])->name('department.requisition.list');
    Route::get('/add', [DepartmentRequisitionController::class, 'add'])->name('department.requisition.add');
    Route::post('/store', [DepartmentRequisitionController::class, 'store'])->name('department.requisition.store');
    Route::get('/edit/{id}', [DepartmentRequisitionController::class, 'edit'])->name('department.requisition.edit');
    Route::post('/update/{id}', [DepartmentRequisitionController::class, 'update'])->name('department.requisition.update');
    Route::post('/delete', [DepartmentRequisitionController::class, 'delete'])->name('department.requisition.delete');
});
 
// After Requisition verify it will go to next stage - Requisition Recommendation
Route::prefix('/verify-requisition')->group(function () {
    Route::get('/list', [RequisitionVerifyController::class, 'index'])->name('verified.requisition.list');
    Route::get('/edit/{id}', [RequisitionVerifyController::class, 'edit'])->name('verified.requisition.edit');
    Route::post('/update/{id}', [RequisitionVerifyController::class, 'update'])->name('verified.requisition.update')->middleware('checkUserRole');
    Route::post('/confirm/', [RequisitionVerifyController::class, 'confirm'])->name('verified.requisition.confirm')->middleware('checkUserRole');
    Route::get('get-verified-requisition-list', [RequisitionVerifyController::class, 'getVerifiedRequisitionList'])->name('get.verified.requisition.list.datatable');
});


// RequisitionApprovalController is responsible for Requisition Recommendation, after that it will go to next stage - Requisition/Distribution Approval
Route::prefix('/recommended-requisition')->group(function () {
    Route::get('/list', [RequisitionApprovalController::class, 'index'])->name('recommended.requisition.list');
    Route::get('/edit/{id}', [RequisitionApprovalController::class, 'edit'])->name('recommended.requisition.edit');
    Route::post('/update/{id}', [RequisitionApprovalController::class, 'update'])->name('recommended.requisition.update')->middleware('checkUserRole');
    Route::get('get-recommended-requisition-list', [RequisitionApprovalController::class, 'getRecommendedRequisitionList'])->name('get.recommended.requisition.list.datatable');
});

Route::prefix('/distribution-approval')->group(function () {
    Route::get('/list', [DistributionController::class, 'index'])->name('distribution.list');
    Route::get('/edit/{id}', [DistributionController::class, 'edit'])->name('distribution.edit');
    Route::post('/store', [DistributionController::class, 'store'])->name('distribution.update')->middleware('checkUserRole');
    Route::get('get-approved-requisition-list', [DistributionController::class, 'getApprovedRequisitionList'])->name('get.approved.requisition.list.datatable');
    Route::post('/confirm/', [DistributionController::class, 'confirmApproval'])->name('approved.requisition.confirm')->middleware('checkUserRole');
});

Route::prefix('/distribute')->group(function () {
    Route::get('/list', [DistributionController::class, 'distributeList'])->name('distribute.list');
    Route::get('/edit/{id}', [DistributionController::class, 'productDistributeEdit'])->name('distribute.edit');
    Route::post('/store', [DistributionController::class, 'productDistributeStore'])->name('distribute.store')->middleware('checkUserRole');
    Route::get('/check-bp-no', [DistributionController::class, 'checkBpNo'])->name('check.bp-no');
    Route::get('get-distributed-requisition-list', [DistributionController::class, 'getDistributedRequisitionList'])->name('get.distributed.requisition.list.datatable');
});

Route::post('get-requisition-list-in-pdf', [SectionRequisitionController::class, 'getRequisitionListInPDF'])->name('get.requisition.list.in.pdf');


