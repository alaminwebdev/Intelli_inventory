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
use App\Services\StockInService;
use App\Services\DistributionService;

class DashboardController extends Controller
{
    private $employeeService;
    private $sectionService;
    private $sectionRequisitionService;
    private $stockInService;
    private $distributionService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        EmployeeService $employeeService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        StockInService $stockInService,
        DistributionService $distributionService
    ) {
        $this->middleware('auth:admin');
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->stockInService               = $stockInService;
        $this->distributionService          = $distributionService;
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
        // dd($user);

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');
            // dd($userRoleIds);

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {

                    case 3: // Role Id 3 = Section Requisition Maker
                        $dashboard  = 'admin.dashboard.section-dashboard';
                        $employee   = $this->employeeService->getByID($user->employee_id);

                        if ($employee->section_id) {
                            $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll($employee->section_id, null, null, null, 10);
                            $data['pendingRequistion']          = SectionRequisition::where('section_id', $employee->section_id)->whereIn('status', [0, 1, 3, 4])->count();
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, [$employee->section_id], 10, 4, 7);
                        } else {
                            $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                            // Extract only the "id" values into a new array
                            $sectionIds = array_map(function ($section) {
                                return $section['id'];
                            }, $sections);

                            if ($sectionIds) {
                                $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll(null, null, $sectionIds, null, 10);
                                $data['pendingRequistion']          = SectionRequisition::whereIn('section_id', $sectionIds)->whereIn('status', [0, 1, 3, 4])->count();
                                $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, 10, 4, 7);
                            } else {
                                $data['sectionRequisitions']        = [];
                                $data['sectionRequisitionProducts'] = [];
                            }
                        }

                        break;
                    case 4: // Role Id 4 = Verifier/Recommender
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
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, 10, 4, 7);
                            $data['mostRequestedProducts']      = $this->sectionRequisitionService->getMostRequestedProducts($sectionIds, null, 10, 7);
                            $data['totalProductsInRequisition'] = $this->sectionRequisitionService->getProductsInRequisitionBySection(null, $sectionIds);
                        } else {
                            $data['sectionRequisitions']        = [];
                            $data['pendingRequistion']          = 0;
                            $data['sectionRequisitionProducts'] = [];
                            $data['mostRequestedProducts']      = [];
                            $data['totalProductsInRequisition'] = [];
                        }

                        break;
                    case 5: // Role Id 5 = Approver
                        $dashboard                              = 'admin.dashboard.approver-dashboard';
                        $data['sectionRequisitions']            = $this->sectionRequisitionService->getAll(null, null, null, null, 10);
                        $data['pendingRequistion']              = SectionRequisition::where('status', 1)->count();
                        $data['sectionRequisitionProducts']     = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, 10, 4, 7);
                        $data['mostRequestedProducts']          = $this->sectionRequisitionService->getMostRequestedProducts(null, null, 10, 7);
                        $data['requisitionInfoByDepartment']    = $this->sectionRequisitionService->getRequisitionInfoByDepartment();
                        $data['mostStockProducts']              = $this->stockInService->getMostStockProducts(null, 10, 7);

                        break;
                    case 6: // Role Id 6 = Issuer/Distributor
                        $dashboard  = 'admin.dashboard.distributor-dashboard';
                        $data['sectionRequisitions']         = $this->sectionRequisitionService->getAll(null, null, null, [4, 5], 10);
                        $data['pendingRequistion']           = SectionRequisition::where('status', 3)->count();
                        $data['mostDistributedProducts']     = $this->distributionService->getMostDistributedProducts(null, null, 10, 7);

                        break;
                    default:
                        $dashboard = 'admin.dashboard.dashboard';
                        $data['sectionRequisitions']            = $this->sectionRequisitionService->getAll(null, null, null, null, 10);
                        $data['pendingRequistion']              = SectionRequisition::count();
                        $data['sectionRequisitionProducts']     = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, 10, 4);
                        $data['mostRequestedProducts']          = $this->sectionRequisitionService->getMostRequestedProducts(null, null, 10);
                        $data['requisitionInfoByDepartment']    = $this->sectionRequisitionService->getRequisitionInfoByDepartment();
                        $data['totalProductsInRequisition']     = $this->sectionRequisitionService->getProductsInRequisitionBySection();
                        $data['mostStockProducts']              = $this->stockInService->getMostStockProducts(null, 10);
                        break;
                }
            }
        } else {

            $dashboard = 'admin.dashboard.dashboard';
            $data['sectionRequisitions']            = $this->sectionRequisitionService->getAll(null, null, null, null, 10);
            $data['pendingRequistion']              = SectionRequisition::count();
            $data['sectionRequisitionProducts']     = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, 10, 4);
            $data['mostRequestedProducts']          = $this->sectionRequisitionService->getMostRequestedProducts(null, null, 10);
            $data['requisitionInfoByDepartment']    = $this->sectionRequisitionService->getRequisitionInfoByDepartment();
            $data['totalProductsInRequisition']     = $this->sectionRequisitionService->getProductsInRequisitionBySection();
            $data['mostStockProducts']              = $this->stockInService->getMostStockProducts(null, 10);
        }

        if (!$dashboard) {
            return view('admin.dashboard.no-role-dashboard');
        }

        return view($dashboard, $data);
    }
    public function receivedProducts()
    {

        $data['title']  = 'Last Received Product';
        $user           = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {
                    case 3: // Role Id 3 = Section Requisition Maker

                        $employee = $this->employeeService->getByID($user->employee_id);

                        if ($employee->section_id) {
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, [$employee->section_id], null, 4);
                        } else {
                            $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                            // Extract only the "id" values into a new array
                            $sectionIds = array_map(function ($section) {
                                return $section['id'];
                            }, $sections);

                            if ($sectionIds) {
                                $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, null, 4);
                            } else {
                                $data['sectionRequisitionProducts'] = [];
                            }
                        }

                        break;
                    case 4: // Role Id 4 = Verifier/Recommender

                        $employee   = $this->employeeService->getByID($user->employee_id);
                        $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                        // Extract only the "id" values into a new array
                        $sectionIds = array_map(function ($section) {
                            return $section['id'];
                        }, $sections);

                        if ($sectionIds) {
                            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, $sectionIds, null, 4);
                        } else {
                            $data['sectionRequisitionProducts'] = [];
                        }

                        break;
                    case 5: // Role Id 5 = Approver
                        $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, null, 4);
                        break;
                    case 6: // Role Id 6 = Issuer/Distributor
                        $data['sectionRequisitionProducts'] = [];
                        break;
                    default:
                        $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, null, 4);
                        break;
                }
            }
        } else {
            $data['sectionRequisitionProducts'] = $this->sectionRequisitionService->getProductRequisitionInfoByID(null, null, null, 4);
        }
        return view('admin.partials.received-products', $data);
    }


    public function stockInProducts()
    {
        $data['title']                  = 'Most Stocked Products';
        $data['mostStockProducts']      = $this->stockInService->getMostStockProducts();
        return view('admin.partials.stock-products', $data);
    }
    // public function distributedProducts()
    // {
    //     $data['title']  = 'সর্বাধিক বিতরণ করা পণ্য';
    //     $user           = Auth::user();
    //     if ($user->id !== 1 && $user->employee_id) {
    //         $employee   = $this->employeeService->getByID($user->employee_id);
    //         $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

    //         // Extract only the "id" values into a new array
    //         $sectionIds = array_map(function ($section) {
    //             return $section['id'];
    //         }, $sections);
    //         $data['mostDistributedProducts'] = $this->distributionService->getMostDistributedProducts($sectionIds);
    //     } else {
    //         $data['mostDistributedProducts'] = $this->distributionService->getMostDistributedProducts();
    //     }
    //     return view('admin.partials.distributed-products', $data);
    // }

    public function getProductsInRequisitionBySection(Request $request)
    {
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee   = $this->employeeService->getByID($user->employee_id);
            $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

            // Extract only the "id" values into a new array
            $sectionIds = array_map(function ($section) {
                return $section['id'];
            }, $sections);
            $totalProductsInRequisition = $this->sectionRequisitionService->getProductsInRequisitionBySection($request, $sectionIds);
        } else {
            $totalProductsInRequisition = $this->sectionRequisitionService->getProductsInRequisitionBySection($request);
        }

        return response()->json($totalProductsInRequisition);
    }
    public function getRequisitionInfoByDepartment(Request $request)
    {
        $requisitionInfo = $this->sectionRequisitionService->getRequisitionInfoByDepartment($request);
        return response()->json($requisitionInfo);
    }
    public function getTotalRequisitionProducts(Request $request)
    {
        $user = Auth::user();

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {

                    case 3: // Role Id 3 = Section Requisition Maker
                        $data = [];
                        break;
                    case 4: // Role Id 4 = Verifier/Recommender
                        $employee   = $this->employeeService->getByID($user->employee_id);
                        $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                        // Extract only the "id" values into a new array
                        $sectionIds = array_map(function ($section) {
                            return $section['id'];
                        }, $sections);

                        $data = $this->sectionRequisitionService->getMostRequestedProducts($sectionIds, $request, 10);
                        break;
                    case 5: // Role Id 5 = Approver
                        $data = $this->sectionRequisitionService->getMostRequestedProducts(null, $request, 10);
                        break;
                    case 6: // Role Id 6 = Issuer/Distributor
                        $data = [];
                        break;
                    default:
                        $data = [];
                        break;
                }
            }
        } else {
            $data = $this->sectionRequisitionService->getMostRequestedProducts(null, $request, 10);
        }
        return response()->json($data);
    }
    public function getTotalStockProducts(Request $request)
    {
        $data = $this->stockInService->getMostStockProducts($request, 10);
        return response()->json($data);
    }

    public function getDistributedProducts(Request $request)
    {
        $user = Auth::user();

        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds = UserRole::where('user_id', $user->id)->pluck('role_id');

            // Check the user's role IDs and set the appropriate dashboard
            foreach ($userRoleIds as $roleId) {
                switch ($roleId) {

                    case 3: // Role Id 3 = Section Requisition Maker
                        $data = [];
                        break;
                    case 4: // Role Id 4 = Verifier/Recommender
                        $data = [];
                        break;
                    case 5: // Role Id 5 = Approver
                        $data = [];
                        break;
                    case 6: // Role Id 6 = Issuer/Distributor
                        // $employee   = $this->employeeService->getByID($user->employee_id);
                        // $sections   = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

                        // // Extract only the "id" values into a new array
                        // $sectionIds = array_map(function ($section) {
                        //     return $section['id'];
                        // }, $sections);

                        // if ($sectionIds) {
                        //     $data = $this->distributionService->getMostDistributedProducts($sectionIds, $request);
                        // }else{
                        //     $data = [];
                        // }
                        $data = $this->distributionService->getMostDistributedProducts(null, $request);
                        break;
                    default:
                        $data = [];
                        break;
                }
            }
        } else {
            $data = $this->distributionService->getMostDistributedProducts(null, $request);
        }
        return response()->json($data);
    }
}
