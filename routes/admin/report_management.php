<?php

use App\Http\Controllers\Admin\DefaultController;
use App\Http\Controllers\Admin\ReportManagement\CurrentStockController;
use App\Http\Controllers\Admin\ReportManagement\DistributionReportController;
use App\Http\Controllers\Admin\ReportManagement\RequisitionReportController;

Route::match(['get', 'post'], '/current-stock-in-list', [CurrentStockController::class, 'index'])->name('report.current.stock.in.list');
Route::get('/requisition-report/{id}', [DefaultController::class, 'requisitionReport'])->name('requisition.report');
Route::get('/stock-report/{id}', [DefaultController::class, 'stockReport'])->name('stock.report');
Route::match(['get', 'post'], '/product-statistics', [RequisitionReportController::class, 'getProductStatistics'])->name('product.statistics');
Route::match(['get', 'post'], '/expiring-soon-products', [RequisitionReportController::class, 'getExpiringSoonProducts'])->name('product.expiring.soon');
Route::match(['get', 'post'], '/product-distribution-report', [DistributionReportController::class, 'productDistributionReport'])->name('product.distribution.report');



