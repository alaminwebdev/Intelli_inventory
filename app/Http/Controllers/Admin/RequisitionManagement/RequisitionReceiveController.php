<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EmployeeService;
use App\Services\RequisitionReceiveService;
use App\Services\SectionRequisitionService;
use App\Services\SectionService;
use Illuminate\Support\Facades\Auth;

class RequisitionReceiveController extends Controller
{
    private $sectionRequisitionService;
    private $employeeService;
    private $sectionService;
    private $requisitionReceiveService;

    public function __construct(
        SectionRequisitionService $sectionRequisitionService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        RequisitionReceiveService $requisitionReceiveService,
    ) {
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->requisitionReceiveService    = $requisitionReceiveService;
    }
    public function index()
    {
        $data['title']  = 'চাহিদাপত্র গ্রহনের তালিকা';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee = $this->employeeService->getByID($user->employee_id);
            $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();
            
            // Extract only the "id" values into a new array
            $sectionIds = array_map(function ($section) {
                return $section['id'];
            }, $sections);
            
            if ($sectionIds) {
                $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll(null, null, $sectionIds, [4,5]);
            }else{
                $data['sectionRequisitions'] = [];
            }

        } else {
            $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll(null, null, null, [4,5]);
        }

        return view('admin.requisition-management.section-requisition-receive.list', $data);
    }
    public function add(){}

    public function edit($id)
    {

        $data['title']                      = 'চাহিদাপত্র গ্রহন করুন';
        $data['editData']                   = $this->sectionRequisitionService->getByID($id);
        $data['requisition_product_types']  = $this->sectionRequisitionService->getRequisitionProductsWithTypeById($id);
        return view('admin.requisition-management.section-requisition-receive.edit', $data);
    }

    public function store(Request $request) {}

    public function update(Request $request, $id)
    {
        $this->requisitionReceiveService->update($request, $id);
        return redirect()->route('admin.section.requisition.receive.list')->with('success', 'চাহিদাপত্র গ্রহন করা হয়েছে!');
    }

    public function delete(Request $request){}


}
