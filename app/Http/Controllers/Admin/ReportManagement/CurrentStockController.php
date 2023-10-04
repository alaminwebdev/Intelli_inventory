<?php

namespace App\Http\Controllers\Admin\ReportManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use PDF;
use IntlDateFormatter;

use App\Services\CurrentStockService;


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
        $data['title']          = 'বর্তমান মজুদ রিপোর্ট';

        $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka')); // Set your desired timezone
        $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d-MMMM-y'); // Customize the date format if needed
        $data['date_in_bengali'] = $formatter->format($date);

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
    
        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.current-stock-list-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'বর্তমান মজুদ-' . $data['date_in_bengali'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
