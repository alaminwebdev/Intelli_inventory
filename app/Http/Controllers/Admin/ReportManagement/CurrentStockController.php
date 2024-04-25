<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use PDF;
use IntlDateFormatter;

use App\Services\CurrentStockService;
use Carbon\Carbon;

class CurrentStockController extends Controller
{

    private $currentStockService;

    public function __construct(
        CurrentStockService $currentStockService

    ) {
        $this->currentStockService    = $currentStockService;
    }

    public function index(Request $request)
    {
        $data['title']          = 'Current Stock Report';

        // $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        // $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        // $formatter->setPattern('d-MMMM-y');
        // $data['date_in_bengali'] = $formatter->format($date);

        $date = Carbon::now();
        $data['date_in_english'] = $date->format('d-F-Y');

        $data['current_stock'] = $this->currentStockService->getCurrentStock();
        if ($request->isMethod('post')) {
            if ($request->type == 'pdf') {
                return $this->currentStockPdfReport($data);
            } elseif ($request->type == 'xls') {
                return $this->currentStockExcelDownload($data);
            }
        }

        return view('admin.reports.current-stock-in-list', $data);
    }
    private function currentStockPdfReport($data)
    {
        //return view('admin.reports.current-stock-list-pdf', $data);

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.current-stock-list-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'Current Stock - ' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
