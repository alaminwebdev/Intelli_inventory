<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\DepartmentRequisition;
use App\Models\Distribute;
use App\Models\Employee;
use App\Models\Section;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Models\StockInDetail;
use App\Services\DepartmentRequisitionService;
use App\Services\DepartmentService;
use App\Services\DistributionService;
use App\Services\EmployeeService;
use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;
use App\Services\SectionService;
use App\Services\DesignationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DistributionController extends Controller
{
    private $productTypeService;
    private $sectionRequisitionService;
    private $departmentRequisitionService;
    private $departmentService;
    private $employeeService;
    private $sectionService;
    private $designationService;
    private $distributionService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        EmployeeService $employeeService,
        SectionService $sectionService,
        DesignationService $designationService,
        DistributionService $distributionService
    ) {
        $this->productTypeService           = $productTypeService;
        $this->departmentRequisitionService = $departmentRequisitionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
        $this->designationService           = $designationService;
        $this->distributionService          = $distributionService;
    }
    public function index()
    {
        $data['title']  = 'Approved Requisition List';
        // $user = Auth::user();
        // if ($user->id !== 1 && $user->employee_id) {
        //     $employee = $this->employeeService->getByID($user->employee_id);
        //     $sections = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

        //     // Extract only the "id" values into a new array
        //     $sectionIds = array_map(function ($section) {
        //         return $section['id'];
        //     }, $sections);
        //     dd($sectionIds);

        //     if ($sectionIds) {
        //         $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll(null, null, $sectionIds, [1, 3]);
        //     }else{
        //         $data['sectionRequisitions'] = [];
        //     }

        // } else {
        //     $data['sectionRequisitions'] = $this->sectionRequisitionService->getAll(null, null, null, [1, 3]);
        // }
        //$data['sectionRequisitions'] = $this->sectionRequisitionService->getAll(null, 6);

        return view('admin.requisition-management.distribution-approval.list', $data);
    }
    public function add()
    {
        // $data['title']                  = '';
        // $data['product_types']          = $this->productTypeService->getAll(1);
        // $data['departments']            = $this->departmentService->getAll(1);
        // return view('admin.requisition-management.distribution.add', $data);
    }

    public function edit($id)
    {

        $data['title']                      = 'Approve Requisition';
        $data['editData']                   = $this->sectionRequisitionService->getByID($id);
        $data['requisition_product_types']  = $this->sectionRequisitionService->getRequisitionProductsWithTypeById($id, $data['editData']);
        return view('admin.requisition-management.distribution-approval.add', $data);
    }

    public function store(Request $request, DistributionService $distribute)
    {
        $distribute->store($request);
        return redirect()->route('admin.distribution.list')->with('success', 'Data successfully updated!');
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

    public function getApprovedRequisitionList(Request $request)
    {

        $requisition_statuses = explode(',', $request->requisition_status);
        $user = Auth::user();
        $sectionRequisitions   = $this->sectionRequisitionService->getAll(null, null, null, $requisition_statuses);

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

                if ($sectionRequisitions->status == 6) {
                    // $links .= '<a class="btn btn-sm btn-success mr-1" href="' . route('admin.distribution.edit', $sectionRequisitions->id) . '"  ><i class="fa fa-edit"></i></a>';
                    // $links .= '<a class="btn btn-sm btn-success requisition-verify mr-1" data-id="' . $sectionRequisitions->id . '"  data-route="' . route('admin.approved.requisition.confirm') . '"  ><i class="fas fa-check-double"></i></a>';
                }
                $links .= '<a class="btn btn-sm btn-primary mr-1" href="' . route('admin.requisition.report', $sectionRequisitions->id) . '" target="_blank"  data-toggle="tooltip" data-placement="bottom" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function distributeList()
    {
        $data['title'] = 'Distributed Requisition List';

        // $user = Auth::user();
        // if ($user->id !== 1 && $user->employee_id) {
        //     $employee  = $this->employeeService->getByID($user->employee_id);
        //     $sections  = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

        //     // Extract only the "id" values into a new array
        //     $sectionIds = array_map(function ($section) {
        //         return $section['id'];
        //     }, $sections);

        //     if ($sectionIds) {
        //         $data['distributeRequisitions'] = $this->sectionRequisitionService->getAll(null, null, $sectionIds, [3,4]);
        //     }else{
        //         $data['distributeRequisitions'] = [];
        //     }

        // } else {
        //     $data['distributeRequisitions'] = $this->sectionRequisitionService->getAll(null, null, null, [3,4]);
        // }
        //$data['distributeRequisitions'] = $this->sectionRequisitionService->getAll(null, 3);
        return view('admin.requisition-management.distribute.list', $data);
    }



    public function productDistributeEdit($id)
    {
        $data['title']          = 'Distribute Requisition';
        $data['editData']       = $this->sectionRequisitionService->getByID($id);
        $data['designations']   = $this->designationService->getAll(1);
        $data['requisition_product_types']  = $this->sectionRequisitionService->getRequisitionProductsWithTypeById($id, $data['editData']);
        if ($data['editData']->status == 4) {
            return redirect()->route('admin.distribute.list')->with('success', 'ইতিমধ্যে বিতরণ করা হয়েছে');
        }
        return view('admin.requisition-management.distribute.edit', $data);
    }


    public function checkBpNo(Request $request)
    {
        $bpNo       = $request->input('bp_no');
        $employee   = Employee::where('bp_no', $bpNo)->first();

        if ($employee) {
            return response()->json($employee);
        } else {
            return response()->json(null);
        }
    }


    public function productDistributeStore(Request $request)
    {

        // Increase max_execution_time to 2 hours (7200 seconds)
        ini_set('max_execution_time', 7200);

        // Set max_input_time to 2 hours (7200 seconds)
        ini_set('max_input_time', 7200);
        
        // Increase memory_limit to unlimited
        ini_set('memory_limit', '-1'); // '-1' indicates unlimited memory

        // Set max_input_vars to 5000
        ini_set('max_input_vars', 5000);

        $request->validate([
            // 'bp_no'             => 'required',
            'name'              => 'required',
            'designation'       => 'required',
            'phone'             => 'required',
            // 'designation_id'    => 'required',
            // 'email'             => 'required',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->distribute_quantity as $key => $quantity) {
                $stocks = StockInDetail::where('product_information_id', $key)
                    ->where('available_qty', '>', 0)
                    ->get();

                $quantityToDistribute = $quantity;

                foreach ($stocks as $stock) {

                    // Check the status of the associated StockIn
                    $stockInStatus = $stock->stockIn->status;
                    // Check if the StockIn status is 1
                    if ($stockInStatus == 1) {

                        // Check if there's enough quantity to distribute from this stock
                        if ($quantityToDistribute <= $stock->available_qty) {
                            // Sufficient quantity available in this stock
                            StockInDetail::where('id', $stock->id)->update([
                                'available_qty' => $stock->available_qty - $quantityToDistribute,
                                'dispatch_qty'  => $stock->dispatch_qty + $quantityToDistribute,
                            ]);

                            // Insert data into the distribute table
                            $data                               = new Distribute();
                            $data->section_requisition_id       = $request->section_requisition_id;
                            $data->product_id                   = $key;
                            $data->stock_in_detail_id           = $stock->id;
                            $data->distribute_quantity          = $quantityToDistribute;
                            $data->distribute_by                = auth()->user()->id;
                            $data->distribute_at                = Carbon::now();
                            $data->save();

                            // Reduce the quantity left to distribute
                            $quantityToDistribute = 0;

                            break;
                        } else {

                            // Distribute all available quantity in this stock
                            $vva = $stock->available_qty;

                            // Set available_qty to 0 without going negative
                            StockInDetail::where('id', $stock->id)->update([
                                'available_qty' => 0,
                                'dispatch_qty'  => $stock->dispatch_qty + $vva,
                            ]);

                            $data                            = new Distribute();
                            $data->section_requisition_id    = $request->section_requisition_id;
                            $data->product_id                = $key;
                            $data->stock_in_detail_id        = $stock->id;
                            $data->distribute_quantity       = $vva;
                            $data->distribute_by             = auth()->user()->id;
                            $data->distribute_at             = Carbon::now();
                            $data->save();

                            $quantityToDistribute -= $vva;
                        }
                    }
                }
            }

            $sectionRequisition = SectionRequisition::findOrFail($request->section_requisition_id);

            // if ($request->filled('employee_id')) {
            //     $employeeId = $request->employee_id;
            // } else {
            //     $newEmployee                    = new Employee();
            //     $newEmployee->bp_no             = $request->bp_no;
            //     $newEmployee->name              = $request->name;
            //     $newEmployee->email             = $request->email;
            //     $newEmployee->designation_id    = $request->designation_id;
            //     $newEmployee->section_id        = $sectionRequisition->section->id;
            //     $newEmployee->department_id     = $sectionRequisition->section->department->id;
            //     $newEmployee->save();

            //     $employeeId = $newEmployee->id;
            // }

            $sectionRequisition->distribute_by  = Auth::id();
            $sectionRequisition->distribute_at  = Carbon::now();

            // $sectionRequisition->receive_by     = $employeeId;

            $sectionRequisition->receive_at     = Carbon::now();
            $sectionRequisition->name           = $request->name;
            $sectionRequisition->designation    = $request->designation;
            $sectionRequisition->phone          = $request->phone;
            $sectionRequisition->email          = $request->email;

            $sectionRequisition->status         = 4;
            $sectionRequisition->save();


            SectionRequisitionDetails::where('section_requisition_id', $request->section_requisition_id)->update([
                'status' => 4,
            ]);

            DB::commit();
            // return redirect()->route('admin.distribute.list');
            return redirect()->route('admin.requisition.report', $request->section_requisition_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }


    public function getDistributedRequisitionList(Request $request)
    {

        $requisition_statuses   = explode(',', $request->requisition_status);
        $sectionRequisitions    = $this->sectionRequisitionService->getAll(null, null, null, $requisition_statuses, null, $request->from_date, $request->to_date);
        $user                   = Auth::user();

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
                if ($sectionRequisitions->status == 3) {
                    return date('d-M-Y', strtotime($sectionRequisitions->final_approve_at));
                }else{
                    return date('d-M-Y', strtotime($sectionRequisitions->distribute_at));
                }
            })
            ->addColumn('action_column', function ($sectionRequisitions) use ($user) {
                $links = '';
                $links .= '<button class="btn btn-sm btn-info view-products mr-1" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="' . $sectionRequisitions->id . '" data-modal-id="productDetailsModal"><i class="fas fa-eye"></i></button>';

                if ($sectionRequisitions->status == 3) {
                    $links .= '<a class="btn btn-sm btn-success mr-1" href="' . route('admin.distribute.edit', $sectionRequisitions->id) . '"  ><i class="fa fa-edit"></i></a>';
                }
                $links .= '<a class="btn btn-sm btn-primary mr-1" href="' . route('admin.requisition.report', $sectionRequisitions->id) . '" target="_blank"  data-toggle="tooltip" data-placement="bottom" title="PDF"><i class="fas fa-file-pdf"></i></a>';
                return $links;
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->make(true);
    }

    public function confirmApproval(Request $request)
    {
        return $this->distributionService->confirm($request);
    }
}
