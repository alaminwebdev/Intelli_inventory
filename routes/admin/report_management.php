<?php

use App\Http\Controllers\Admin\DefaultController;
use App\Http\Controllers\Admin\ReportManagement\CurrentStockController;

Route::match(['get', 'post'], '/current-stock-in-list', [CurrentStockController::class, 'index'])->name('report.current.stock.in.list');
Route::get('/requisition-report/{id}', [DefaultController::class, 'requisitionReport'])->name('requisition.report');


