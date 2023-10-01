<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\SectionRequisition;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\EmployeeService;
use App\Services\SectionService;
use App\Services\SectionRequisitionService;

class DashboardController extends Controller
{
    private $employeeService;
    private $sectionService;
    private $sectionRequisitionService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EmployeeService $employeeService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService
    ) {
        $this->middleware('auth:admin');
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title']              = 'Dashboard';
        $data['pendingRequistion']  = 0;
        $dashboard      = '';

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {

                    case 3: // Role Id 3 = Section Requisition Maker
                        $dashboard  = 'admin.dashboard.section-dashboard';
                        $employee   = $this->employeeService->getByID($user->employee_id);

                        if ($employee->section_id) {
                            $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll($employee->section_id, null, null, null, 10);
                            $data['pendingRequistion']          = SectionRequisition::where('section_id', $employee->section_id)->whereIn('status', [0, 1, 3, 4])->count();
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, [$employee->section_id], 10);
                        } else {
                            $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                            // Extract only the "id" values into a new array
                            $sectionIds = array_map(function ($section) {
                                return $section['id'];
                            }, $sections);

                            if ($sectionIds) {
                                $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll(null, null, $sectionIds, null, 10);
                                $data['pendingRequistion']          = SectionRequisition::whereIn('section_id', $sectionIds)->whereIn('status', [0, 1, 3, 4])->count();
                                $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, 10);
                            } else {
                                $data['sectionRequisitions']        = [];
                                $data['sectionRequisitionProducts'] = [];
                            }
                        }

                        break;
                    case 4: // Role Id 6 = Verifier/Recommender
                        $dashboard  = 'admin.dashboard.recommender-dashboard';
                        $employee   = $this->employeeService->getByID($user->employee_id);
                        $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                        // Extract only the "id" values into a new array
                        $sectionIds = array_map(function ($section) {
                            return $section['id'];
                        }, $sections);

                        if ($sectionIds) {
                            $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll(null, null, $sectionIds, null, 10);
                            $data['pendingRequistion']          = SectionRequisition::whereIn('section_id', $sectionIds)->where('status', 0)->count();
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, 10);
                        } else {
                            $data['sectionRequisitions']        = [];
                            $data['pendingRequistion']          = [];
                            $data['sectionRequisitionProducts'] = [];
                        }

                        break;
                    case 5: // Role Id 7 = Approver
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                    case 6: // Role Id 8 = Issuer/Distributor
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                    default:
                        $dashboard = 'admin.dashboard.dashboard';
                        break;
                }
            }
        } else {
            $dashboard = 'admin.dashboard.dashboard';
        }


        return view($dashboard, $data);
    }
    public function receivedProducts()
    {

        $data['title']                      = 'সর্বশেষ প্রাপ্ত পণ্য';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {
                    case 3: // Role Id 3 = Section Requisition Maker

                        $employee = $this->employeeService->getByID($user->employee_id);

                        if ($employee->section_id) {
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, [$employee->section_id]);
                        } else {
                            $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                            // Extract only the "id" values into a new array
                            $sectionIds = array_map(function ($section) {
                                return $section['id'];
                            }, $sections);

                            if ($sectionIds) {
                                $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds);
                            } else {
                                $data['sectionRequisitionProducts'] = [];
                            }
                        }

                        break;
                    case 4: // Role Id 6 = Verifier/Recommender

                        $employee   = $this->employeeService->getByID($user->employee_id);
                        $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                        // Extract only the "id" values into a new array
                        $sectionIds = array_map(function ($section) {
                            return $section['id'];
                        }, $sections);

                        if ($sectionIds) {
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds);
                        } else {
                            $data['sectionRequisitionProducts'] = [];
                        }

                        break;
                    case 5: // Role Id 7 = Approver
                        
                        break;
                    case 6: // Role Id 8 = Issuer/Distributor
                        
                        break;
                    default:
                        
                        break;
                }
            }
        }
        return view('admin.partials.requisition-products', $data);
    }
}
