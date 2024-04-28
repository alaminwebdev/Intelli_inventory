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
use App\RoleEnum;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use DateTime;
use DateTimeZone;
use PDF;
use IntlDateFormatter;

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
        $data['title']                  = 'Requisition List';
        $user = Auth::user();

        // if ($user->id !== 1 && $user->employee_id) {
        //     $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
        //     $is_super_admin = in_array(RoleEnum::SUPER_ADMIN, $userRoleIds); // Role Id 2 = Super Admin
        //     $is_maker       = in_array(RoleEnum::R_MAKER, $userRoleIds); // Role Id 3 = Section Requisition Maker
        //     $is_recommender = in_array(RoleEnum::R_RECOMMENDER, $userRoleIds); // Role Id 4 = Verifier/Recommender
        //     $is_approver    = in_array(RoleEnum::R_APPROVER, $userRoleIds); // Role Id 5 = Approver
        //     $is_distributor = in_array(RoleEnum::R_DISTRIBUTOR, $userRoleIds); // Role Id 6 = Issuer/Distributor

        //     if ($is_super_admin) {
        //         $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        //     }
        //     if ($is_maker) {
        //         $employee = $this->employeeService->getByID($user->employee_id);
        //         if ($employee->section_id) {
        //             $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll($employee->section_id);
        //         } else {
        //             // $data['sectionRequisitions'] = [];
        //             $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

        //             // Extract only the "id" values into a new array
        //             $sectionIds = array_map(function ($section) {
        //                 return $section['id'];
        //             }, $sections);

        //             if ($sectionIds) {
        //                 $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll(null, null, $sectionIds);
        //             } else {
        //                 $data['sectionRequisitions']    = [];
        //             }
        //         }
        //     }
        //     if ($is_recommender) {
        //         $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        //     }
        //     if ($is_approver) {
        //         $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        //     }
        //     if ($is_distributor) {
        //         $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        //     }

        // } else {
        //     $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll();
        // }

        return view('admin.requisition-management.section-requisition.list', $data);
    }
    public function selectProducts()
    {
        $data['title']                  = 'Select Product';
        $data['product_types']          = $this->productInformationService->getProductTypeAndProducts();
        return view('admin.requisition-management.section-requisition.product-selection', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $data['title']                  = 'Add Requisition';
            $selected_product_ids           = $request->input('selected_products', []);
            $data['selected_products']      = $this->productInformationService->getSpecificProducts($selected_product_ids);
            $data['uniqueRequisitionNo']    = $this->sectionRequisitionService->getUniqueRequisitionNo();

            $user = Auth::user();
            if ($user->id !== 1 && $user->employee_id) {
                $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
                $is_super_admin = in_array(RoleEnum::SUPER_ADMIN, $userRoleIds); // Role Id 2 = Super Admin
                if ($is_super_admin) {
                    $data['employee']           = [];
                    $data['sections']           = $this->sectionService->getAll();
                } else {
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

    public function getRequisitionList(Request $request)
    {

        $user = Auth::user();

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
            $is_super_admin = in_array(RoleEnum::SUPER_ADMIN, $userRoleIds);
            $is_maker       = in_array(RoleEnum::R_MAKER, $userRoleIds);
            $is_recommender = in_array(RoleEnum::R_RECOMMENDER, $userRoleIds);
            $is_approver    = in_array(RoleEnum::R_APPROVER, $userRoleIds);
            $is_distributor = in_array(RoleEnum::R_DISTRIBUTOR, $userRoleIds);
            $is_verifier    = in_array(RoleEnum::R_VERIFIER, $userRoleIds);

            if ($is_super_admin) {
                $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
            }
            if ($is_maker) {
                $employee = $this->employeeService->getByID($user->employee_id);
                if ($employee->section_id) {
                    $sectionRequisitions = $this->sectionRequisitionService->getAll($employee->section_id, null, null, [$request->requisition_status]);
                } else {
                    $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                    // Extract only the "id" values into a new array
                    $sectionIds = array_map(function ($section) {
                        return $section['id'];
                    }, $sections);

                    if ($sectionIds) {
                        $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, $sectionIds, [$request->requisition_status]);
                    } else {
                        $sectionRequisitions    = [];
                    }
                }
            }
            if ($is_recommender) {
                $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
            }
            if ($is_approver) {
                $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
            }
            if ($is_distributor) {
                $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
            }
            if ($is_verifier) {
                $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
            }
        } else {
            $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, [$request->requisition_status]);
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
                $links .= '<button class="btn btn-sm btn-info view-products mr-1" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id=" ' . $sectionRequisitions->id . ' " data-modal-id="productDetailsModal"><i class="far fa-eye"></i></button>';
                $links .= '<a class="btn btn-sm btn-primary mr-1" href=" ' . route('admin.requisition.report', $sectionRequisitions->id) . ' " target="_blank"><i class="fas fa-file-pdf"></i></a>';
                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function getRequisitionListInPDF(Request $request)
    {
        $requisition_statuses           = explode(',', $request->requisition_status);
        $data['sectionRequisitions']    = $this->sectionRequisitionService->getAll(null, null, null, $requisition_statuses, null, $request->date_from, $request->date_to);
        
        $date = Carbon::now();
        $data['date_in_english'] = $date->format('d-F-Y');

        if ($request['date_from'] != null) {
            $data['date_from']      = date('d-F-Y', strtotime($request['date_from']));
        } else {
            $data['date_from']      = null;
        }
        if ($request['date_to'] != null) {
            $data['date_to']    = date('d-F-Y', strtotime($request['date_to']));
        } else {
            $data['date_to']    = null;
        }

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.requisition-list-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'Requisition list -' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }
}
