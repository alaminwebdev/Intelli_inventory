<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Section;
use App\Models\UserRole;
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
        $data['title']                  = 'চাহিদাপত্রের তালিকা - শাখা';
        $user = Auth::user();

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
            $is_super_admin = in_array(2, $userRoleIds); // Role Id 2 = Super Admin
            $is_maker       = in_array(3, $userRoleIds); // Role Id 3 = Section Requisition Maker
            $is_recommender = in_array(4, $userRoleIds); // Role Id 4 = Verifier/Recommender
            $is_approver    = in_array(5, $userRoleIds); // Role Id 5 = Approver
            $is_distributor = in_array(6, $userRoleIds); // Role Id 6 = Issuer/Distributor

            if ($is_super_admin) {
                $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
            }
            if ($is_maker) {
                $employee = $this->employeeService->getByID($user->employee_id);
                if ($employee->section_id) {
                    $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll($employee->section_id);
                } else {
                    // $data['sectionRequisitions'] = [];
                    $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                    // Extract only the "id" values into a new array
                    $sectionIds = array_map(function ($section) {
                        return $section['id'];
                    }, $sections);

                    if ($sectionIds) {
                        $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll(null, null, $sectionIds);
                    } else {
                        $data['sectionRequisitions']    = [];
                    }
                }
            }
            if ($is_recommender) {
                $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
            }
            if ($is_approver) {
                $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
            }
            if ($is_distributor) {
                $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
            }

        } else {
            $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        }

        return view('admin.requisition-management.section-requisition.list', $data);
    }
    public function selectProducts()
    {
        $data['title']                  = 'পন্য বাছাই করুন';
        $data['product_types']          = $this->productInformationService->getProductTypeAndProducts();
        return view('admin.requisition-management.section-requisition.product-selection', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data['title']                  = 'চাহিদাপত্র যুক্ত করুন';
            $selected_product_ids           = $request->input('selected_products', []);
            $data['selected_products']      = $this->productInformationService->getSpecificProducts($selected_product_ids);
            $data['uniqueRequisitionNo']    = $this->sectionRequisitionService->getUniqueRequisitionNo();

            $user = Auth::user();
            if ($user->id !== 1 && $user->employee_id) {
                $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
                $is_super_admin = in_array(2, $userRoleIds); // Role Id 2 = Super Admin
                if ($is_super_admin) {
                    $data['employee']           = [];
                    $data['sections']           = $this->sectionService->getAll();
                }else{
                    $data['employee']           = $this->employeeService->getByID($user->employee_id);
                    $data['sections']           = $this->sectionService->getSectionsByDepartment($data['employee']->department_id);
                }
            } else {
                $data['employee']           = [];
                $data['sections']           = $this->sectionService->getAll();
            }
            return view('admin.requisition-management.section-requisition.add', $data);
        } else {
            return view('admin.requisition-management.section-requisition.product-selection',);
        }
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
