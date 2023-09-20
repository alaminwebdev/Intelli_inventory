<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Section;
use Illuminate\Http\Request;

use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;
use App\Services\EmployeeService;
use App\Services\SectionService;
use App\Services\ProductInformationService;
use Illuminate\Support\Facades\Auth;

class SectionRequisitionController extends Controller
{
    private $sectionRequisitionService;
    private $productTypeService;
    private $employeeService;
    private $sectionService;
    private $productInformationService;

    public function __construct(
        SectionRequisitionService $sectionRequisitionService,
        ProductTypeService $productTypeService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        ProductInformationService $productInformationService
    ) {
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->productTypeService           = $productTypeService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->productInformationService    = $productInformationService;
    }
    public function index()
    {
        $data['title']                  = 'চাহিদাপত্রের তালিকা - সেকশন';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee                       = $this->employeeService->getByID($user->employee_id);
            $sectionIds                     = Section::where('department_id', $employee->department_id)->pluck('id');
            $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll(null, null, $sectionIds);
        } else {
            $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        }

        return view('admin.requisition-management.section-requisition.list', $data);
    }
    public function selectProducts()
    {
        $data['title']                  = 'পন্য বাছাই করুন';
        $data['product_types']          = $this->productTypeService->getAll(1);
        return view('admin.requisition-management.section-requisition.product-selection', $data);
    }
    public function processSelectionProducts(Request $request)
    {
        // Retrieve the selected product IDs from the request
        $selectedProductIds = $request->input('selected_products');

        // Redirect to the "add" step for section requisition with selected product IDs
        return redirect()->route('admin.section.requisition.add', ['sp' => $selectedProductIds]);
    }
    public function add(Request $request)
    {
        // Retrieve the selected product IDs from the query parameters
        $selected_product_ids           = $request->input('sp', []);
        $data['selected_products']      = $this->productInformationService->getSpecificProducts($selected_product_ids);

        $data['title']                  = 'চাহিদাপত্র যুক্ত করুন';

        $data['uniqueRequisitionNo']    = $this->sectionRequisitionService->getUniqueRequisitionNo();

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $data['employee']           = $this->employeeService->getByID($user->employee_id);
            $data['sections']           = $this->sectionService->getSectionsByDepartment($data['employee']->department_id);
        } else {
            $data['employee']           = [];
            $data['sections']           = $this->sectionService->getAll();
        }

        return view('admin.requisition-management.section-requisition.add', $data);
    }
    public function store(Request $request)
    {
        $data = $this->sectionRequisitionService->create($request);
        return response()->json($data);
    }
    public function edit($id)
    {
        // $data['title']          = 'Edit Section Requisition';
        // $data['editData']       = $this->sectionRequisitionService->getByID($id);
        // return view('admin.requisition-management.section-requisition.add', $data);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name' => 'required',
        // ]);
        // $this->sectionRequisitionService->update($request, $id);
        // return redirect()->route('admin.section.requisition.list')->with('success', 'Data successfully updated!');
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
}
