<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartmentRequisitionDetails;
use App\Models\Distribute;
use App\Models\ProductInformation;
use App\Models\SectionRequisitionDetails;
use App\Models\UserRole;
use Illuminate\Http\Request;

use App\Services\ProductInformationService;
use App\Services\ProductTypeService;
use App\Services\UnitService;
use App\Services\SupplierService;
use App\Services\SectionService;
use App\Services\SectionRequisitionService;
use App\Services\EmployeeService;
use App\Services\DepartmentRequisitionService;
use App\Services\StockInService;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use IntlDateFormatter;

class DefaultController extends Controller
{
    private $productInformationService;
    private $productTypeService;
    private $unitService;
    private $supplierService;
    private $sectionService;
    private $sectionRequisitionService;
    private $employeeService;
    private $departmentRequisitionService;
    private $stockInService;

    public function __construct(
        ProductInformationService $productInformationService,
        ProductTypeService $productTypeService,
        UnitService $unitService,
        SupplierService $supplierService,
        SectionService $sectionService,
        SectionRequisitionService $sectionRequisitionService,
        EmployeeService $employeeService,
        DepartmentRequisitionService $departmentRequisitionService,
        StockInService $stockInService

    ) {
        $this->productInformationService    = $productInformationService;
        $this->productTypeService           = $productTypeService;
        $this->unitService                  = $unitService;
        $this->supplierService              = $supplierService;
        $this->sectionService               = $sectionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->employeeService              = $employeeService;
        $this->departmentRequisitionService = $departmentRequisitionService;
        $this->stockInService               = $stockInService;
    }

    public function getProductsByType(Request $request)
    {
        $data = $this->productInformationService->getProductsByTypeId([$request->product_type_id]);
        return response()->json($data);
    }
    public function getSectionsByDepartment(Request $request)
    {
        $data = $this->sectionService->getSectionsByDepartment($request->department_id);
        return response()->json($data);
    }
    public function getProductsBySectionRequisition(Request $request)
    {
        $data = $this->sectionRequisitionService->getRequisitionProductsByIDs($request->selectedRequisitionIds);
        return response()->json($data);
    }
    public function getSectionsRequisitionsByDepartment(Request $request)
    {
        $sections   = $this->sectionService->getSectionsByDepartment($request->department_id)->pluck('id');
        $data       = $this->sectionRequisitionService->getAllBySections($sections, 0);
        return response()->json($data);
    }
    public function getEmployeeById(Request $request)
    {
        $data = $this->employeeService->getByID($request->employee_id);
        return response()->json($data);
    }
    public function getStockInDetailsByStockId(Request $request)
    {
        $data = $this->stockInService->getStockDetails($request->stock_id);
        return response()->json($data);
    }
    public function getRequistionDetailsById(Request $request)
    {
        $data = $this->sectionRequisitionService->getProductRequisitionInfoByID($request->requisition_id);
        return response()->json($data);
    }
    public function getDistributeRequistionByStatus(Request $request)
    {
        // $user = Auth::user();
        // if ($user->id !== 1 && $user->employee_id) {
        //     $employee  = $this->employeeService->getByID($user->employee_id);
        //     $sections  = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

        //     // Extract only the "id" values into a new array
        //     $sectionIds = array_map(function ($section) {
        //         return $section['id'];
        //     }, $sections);

        //     if ($sectionIds) {
        //         $distributeRequisitions = $this->sectionRequisitionService->getAll(null, $request->requistition_status, $sectionIds);
        //     }else{
        //         $distributeRequisitions = [];
        //     }

        // } else {
        //     $distributeRequisitions = $this->sectionRequisitionService->getAll(null, $request->requistition_status);
        // }
        $distributeRequisitions = $this->sectionRequisitionService->getAll(null, $request->requistition_status);
        $data                   = view('admin.requisition-management.distribute.list-by-status')->with('distributeRequisitions', $distributeRequisitions)->render();
        return response()->json($data);
    }
    public function getRequistionByStatus(Request $request)
    {
        $requisitions = $this->sectionRequisitionService->getAll(null,null,null, $request->requistition_status);
        $data         = view('admin.requisition-management.distribution-approval.list-by-status')->with('requisitions', $requisitions)->render();
        return response()->json($data);
    }


    public function getRequistionByStatusForRecommender(Request $request)
    {
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $userRoleIds    = UserRole::where('user_id', $user->id)->pluck('role_id')->toArray();
            $is_super_admin = in_array(2, $userRoleIds); // Role Id 2 = Super Admin
            $is_maker       = in_array(3, $userRoleIds); // Role Id 3 = Section Requisition Maker
            $is_recommender = in_array(4, $userRoleIds); // Role Id 4 = Verifier/Recommender
            $is_approver    = in_array(5, $userRoleIds); // Role Id 5 = Approver
            $is_distributor = in_array(6, $userRoleIds); // Role Id 6 = Issuer/Distributor

            if ($is_super_admin) {
                $requisitions = $this->sectionRequisitionService->getAll(null,null,null, $request->requistition_status);
            }else{
                $employee  = $this->employeeService->getByID($user->employee_id);
                $sections  = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();
    
                // Extract only the "id" values into a new array
                $sectionIds = array_map(function ($section) {
                    return $section['id'];
                }, $sections);
    
                if ($sectionIds) {
                    $requisitions = $this->sectionRequisitionService->getAll(null,null,$sectionIds, $request->requistition_status);
                }else{
                    $requisitions = [];
                }
            }

        } else {
            $requisitions = $this->sectionRequisitionService->getAll(null,null,null, $request->requistition_status);
        }
        $data = view('admin.requisition-management.recommended-requisition.list-by-status')->with('requisitions', $requisitions)->render();
        return response()->json($data);
    }

    public function requisitionReport($id)
    {

        $date = Carbon::now();
        $data['date_in_english'] = $date->format('d-F-Y');

        $productTypeData    = [];
        $product_types      = $this->productTypeService->getAll(1);

        foreach ($product_types as $item) {
            $productType = [
                'id'        => $item->id,
                'name'      => $item->name,
                'products'  => [],
            ];

            // Query products for this product type and push them into the products array
            $productIds = ProductInformation::where('product_type_id', $item->id)
                ->latest()
                ->pluck('id');

            $requisitionProducts = SectionRequisitionDetails::where('section_requisition_id', $id)
                ->whereIn('product_id', $productIds)
                ->get();

            if (count($requisitionProducts) > 0) {

                foreach ($requisitionProducts as $product) {

                    // Get the total distribute_quantity for this product_id and section_requisition_id
                    $totalDistributeQuantity = Distribute::where('section_requisition_id', $id)
                        ->where('product_id', $product->product_id)
                        ->sum('distribute_quantity');

                    $productType['products'][$product->product_id] = [
                        'product_id'                => $product->product_id,
                        'product_name'              => $product->product->name,
                        'current_stock'             => $product->current_stock,
                        'demand_quantity'           => $product->demand_quantity,
                        'remarks'                   => $product->remarks,
                        'recommended_quantity'      => $product->recommended_quantity,
                        'recommended_remarks'       => $product->recommended_remarks,
                        'final_approve_quantity'    => $product->final_approve_quantity,
                        'final_approve_remarks'     => $product->final_approve_remarks,
                        'total_distribute_quantity' => $totalDistributeQuantity ?? 'N/A',
                    ];
                }

                // Push this product type data into the main array AFTER adding products
                $productTypeData[] = $productType;
            }
        }
        $data['requisitionProducts']            = $productTypeData;
        $data['requestedRequisitionInfo']       = $this->sectionRequisitionService->getByID($id);

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.requisition-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'Requisition - ' . $data['date_in_english'] . '.pdf';
        return $pdf->stream($fileName);
    }
    
    public function stockReport($id)
    {
        $date                       = new DateTime('now', new DateTimeZone('Asia/Dhaka')); // Set your desired timezone
        $formatter                  = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d-MMMM-y'); // Customize the date format if needed
        $data['date_in_bengali']    = $formatter->format($date);

        $data['stock_info']     = $this->stockInService->getByID($id);
        $data['stock_details']  = $this->stockInService->getStockDetails($id);

        // return view('admin.reports.stock-pdf', $data);

        // Generate a PDF
        $pdf = PDF::loadView('admin.reports.stock-pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');

        $fileName = 'ক্রয় অর্ডার-' . $data['stock_info']->po_no . '.pdf';
        return $pdf->stream($fileName);
    }
}
