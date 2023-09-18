<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\DepartmentRequisitionDetails;
use App\Models\ProductInformation;
use Illuminate\Http\Request;
use App\Services\ProductTypeService;
use App\Services\DepartmentRequisitionService;
use App\Services\SectionRequisitionService;
use App\Services\RequisitionApprovalService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Auth;

use DateTime;
use DateTimeZone;
use PDF;
use IntlDateFormatter;

class RequisitionApprovalController extends Controller
{
    private $productTypeService;
    private $sectionRequisitionService;
    private $departmentRequisitionService;
    private $requisitionApprovalService;
    private $employeeService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService,
        SectionRequisitionService $sectionRequisitionService,
        RequisitionApprovalService $requisitionApprovalService,
        EmployeeService $employeeService
    ) {
        $this->productTypeService               = $productTypeService;
        $this->departmentRequisitionService     = $departmentRequisitionService;
        $this->sectionRequisitionService        = $sectionRequisitionService;
        $this->requisitionApprovalService       = $requisitionApprovalService;
        $this->employeeService              = $employeeService;
    }
    public function index()
    {
        $data['title']                      = 'সুপারিশকৃত চাহিদাপত্রের তালিকা';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee                           = $this->employeeService->getByID($user->employee_id);
            $data['departmentRequisitions']     = $this->departmentRequisitionService->getAll($employee->department_id);
        } else {
            $data['departmentRequisitions']     = $this->departmentRequisitionService->getAll();
        }
        return view('admin.requisition-management.requisition.list', $data);
    }
    public function add()
    {
        // $data['title']                  = 'Add Department Requisition';
        // return view('admin.requisition-management.department-requisition.add', $data);
    }
    public function store(Request $request)
    {
        // $this->departmentRequisitionService->create($request);
        // return redirect()->route('admin.department.requisition.list')->with('success', 'Data successfully inserted!');
    }

    public function edit($id)
    {
        $data['title']          = 'চাহিদাপত্র হালনাগাদ করুন';
        $data['editData']       = $this->departmentRequisitionService->getByID($id);
        $data['product_types']  = $this->productTypeService->getAll(1);

        return view('admin.requisition-management.requisition.add', $data);
    }

    public function update(Request $request, $id)
    {
        $this->requisitionApprovalService->update($request, $id);
        return redirect()->route('admin.requisition.list')->with('success', 'Data successfully updated!');
    }

    public function delete(Request $request)
    {
        // $deleted = $this->sectionRequisitionService->delete($request->id);
        // if ($deleted) {
        //     return response()->json(['status' => 'success', 'message' => 'Successfully Deleted']);
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sorry something wrong']);
        // }
    }
    public function requisitionApprovalReport($id)
    {
        $date                   = new DateTime('now', new DateTimeZone('Asia/Dhaka')); // Set your desired timezone
        $formatter              = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d-MMMM-y'); // Customize the date format if needed
        $data['date_in_bengali'] = $formatter->format($date);

        $data['requisitionApprovalProducts']  = $this->requisitionApprovalService->getApprovedRequisitionProductsByType($id);
        $data['requestedRequisitionInfo']                     = $this->departmentRequisitionService->getByID($id);

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.approved-requisition-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'বর্তমান স্টক-' . $data['date_in_bengali'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
