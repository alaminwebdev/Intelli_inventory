<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\DepartmentRequisitionDetails;
use App\Models\ProductInformation;
use App\Models\Section;
use App\Models\SectionRequisitionDetails;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Services\ProductTypeService;
use App\Services\DepartmentRequisitionService;
use App\Services\SectionRequisitionService;
use App\Services\RequisitionApprovalService;
use App\Services\EmployeeService;
use App\Services\SectionService;
use Illuminate\Support\Facades\Auth;
use App\RoleEnum;
use Yajra\DataTables\Facades\DataTables;


class RequisitionApprovalController extends Controller
{
    private $productTypeService;
    private $sectionRequisitionService;
    private $departmentRequisitionService;
    private $requisitionApprovalService;
    private $employeeService;
    private $sectionService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService,
        SectionRequisitionService $sectionRequisitionService,
        RequisitionApprovalService $requisitionApprovalService,
        EmployeeService $employeeService,
        SectionService $sectionService
    ) {
        $this->productTypeService               = $productTypeService;
        $this->departmentRequisitionService     = $departmentRequisitionService;
        $this->sectionRequisitionService        = $sectionRequisitionService;
        $this->requisitionApprovalService       = $requisitionApprovalService;
        $this->employeeService                  = $employeeService;
        $this->sectionService                   = $sectionService;
    }
    public function index()
    {
        $data['title']  = 'Recommended Requisition List';
        $user           = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {

            $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
            $is_super_admin = in_array(RoleEnum::SUPER_ADMIN, $userRoleIds); // Role Id 2 = Super Admin
            $is_maker       = in_array(RoleEnum::R_MAKER, $userRoleIds); // Role Id 3 = Section Requisition Maker
            $is_recommender = in_array(RoleEnum::R_RECOMMENDER, $userRoleIds); // Role Id 4 = Verifier/Recommender
            $is_approver    = in_array(RoleEnum::R_APPROVER, $userRoleIds); // Role Id 5 = Approver
            $is_distributor = in_array(RoleEnum::R_DISTRIBUTOR, $userRoleIds); // Role Id 6 = Issuer/Distributor

            if ($is_super_admin) {
                $data['sectionRequisitions']   = $this->sectionRequisitionService->getAll(null, null, null, [0]);
            }else{
                $employee  = $this->employeeService->getByID($user->employee_id);
                $sections  = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();
    
                // Extract only the "id" values into a new array
                $sectionIds = array_map(function ($section) {
                    return $section['id'];
                }, $sections);
    
                if ($sectionIds) {
                    $data['sectionRequisitions']   = $this->sectionRequisitionService->getAll(null, null, $sectionIds, [0]);
                } else {
                    $data['sectionRequisitions']   = [];
                }

            }
        } else {
            $data['sectionRequisitions']   = $this->sectionRequisitionService->getAll(null, null, null, [0]);
        }
        return view('admin.requisition-management.recommended-requisition.list', $data);
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
        $data['title']                      = 'Recommend Requisition';
        $data['editData']                   = $this->sectionRequisitionService->getByID($id);
        $data['requisition_product_types']  = $this->sectionRequisitionService->getRequisitionProductsWithTypeById($id);
        return view('admin.requisition-management.recommended-requisition.add', $data);
    }

    public function update(Request $request, $id)
    {
        $this->requisitionApprovalService->update($request, $id);
        return redirect()->route('admin.recommended.requisition.list')->with('success', 'Data successfully updated!');
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

    public function getRecommendedRequisitionList(Request $request)
    {

        $requisition_statuses = explode(',', $request->requisition_status);

        $user = Auth::user();

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
            $is_super_admin = in_array(RoleEnum::SUPER_ADMIN, $userRoleIds);
            $is_maker       = in_array(RoleEnum::R_MAKER, $userRoleIds);
            $is_recommender = in_array(RoleEnum::R_RECOMMENDER, $userRoleIds);
            $is_approver    = in_array(RoleEnum::R_APPROVER, $userRoleIds);
            $is_distributor = in_array(RoleEnum::R_DISTRIBUTOR, $userRoleIds);

            if ($is_super_admin) {
                $sectionRequisitions   = $this->sectionRequisitionService->getAll(null, null, null, $requisition_statuses);
            } else {
                $employee  = $this->employeeService->getByID($user->employee_id);
                $sections  = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                // Extract only the "id" values into a new array
                $sectionIds = array_map(function ($section) {
                    return $section['id'];
                }, $sections);

                if ($sectionIds) {
                    $sectionRequisitions   = $this->sectionRequisitionService->getAll(null, null, $sectionIds, $requisition_statuses);
                } else {
                    $sectionRequisitions   = [];
                }
            }
        } else {
            $sectionRequisitions   = $this->sectionRequisitionService->getAll(null, null, null, $requisition_statuses);
        }

        return DataTables::of($sectionRequisitions)
            ->editColumn('section', function ($sectionRequisitions) {
                return @$sectionRequisitions->section->name;
            })
            ->editColumn('department', function ($sectionRequisitions) {
                return @$sectionRequisitions->section->department->name;
            })
            ->editColumn('status', function ($sectionRequisitions) {
                return requisitionStatus(@$sectionRequisitions->status);
            })
            ->editColumn('created_at', function ($sectionRequisitions) {
                return date('d-M-Y', strtotime($sectionRequisitions->created_at));
            })
            ->addColumn('action_column', function ($sectionRequisitions) use ($user) {
                $links = '';
                $links .= '<button class="btn btn-sm btn-info view-products mr-1" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="' . $sectionRequisitions->id . '" data-modal-id="productDetailsModal"><i class="fas fa-eye"></i></button>';

                if ($sectionRequisitions->status == 0) {
                    $links .= '<a class="btn btn-sm btn-success mr-1" href="' . route('admin.recommended.requisition.edit', $sectionRequisitions->id) . '"  ><i class="fa fa-edit"></i></a>';
                }
                $links .= '<a class="btn btn-sm btn-primary mr-1" href="' . route('admin.requisition.report', $sectionRequisitions->id) . '" target="_blank"  data-toggle="tooltip" data-placement="bottom" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }
}
