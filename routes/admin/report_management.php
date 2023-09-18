<?php

use App\Http\Controllers\Admin\ReportManagement\CurrentStockController;

Route::match(['get', 'post'], '/current-stock-in-list', [CurrentStockController::class, 'index'])->name('report.current.stock.in.list');


