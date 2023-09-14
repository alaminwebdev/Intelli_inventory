<?php

use App\Http\Controllers\Admin\RequisitionManagement\SectionRequisitionController;


Route::prefix('/section-requisition')->group(function () {
    Route::get('/list', [SectionRequisitionController::class, 'index'])->name('section.requisition.list');
    Route::get('/add', [SectionRequisitionController::class, 'add'])->name('section.requisition.add');
    Route::post('/store', [SectionRequisitionController::class, 'store'])->name('section.requisition.store');
    Route::get('/edit/{id}', [SectionRequisitionController::class, 'edit'])->name('section.requisition.edit');
    Route::post('/update/{id}', [SectionRequisitionController::class, 'update'])->name('section.requisition.update');
    Route::post('/delete', [SectionRequisitionController::class, 'delete'])->name('section.requisition.delete');
});
