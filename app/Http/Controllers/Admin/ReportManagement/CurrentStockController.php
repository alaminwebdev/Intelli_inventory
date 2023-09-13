<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\CurrentStockService;

class CurrentStockController extends Controller
{

    private $currentStockService;

    public function __construct(
        CurrentStockService $currentStockService

    ) {
        $this->currentStockService    = $currentStockService;
    }

    public function index()
    {
        $data['title']          = 'Current Stock Report';
        $data['report_generation_dateTime'] = date('Y-m-d H:i:s');

        $data['current_stock'] = $this->currentStockService->getCurrentStock();
        return view('admin.reports.current-stock-in-list', $data);
    }
}
