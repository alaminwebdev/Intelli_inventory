<?php

namespace App\Http\Controllers\Admin\RequisitionManagement;

use App\Http\Controllers\Controller;
use App\Models\DepartmentRequisition;
use App\Models\Distribute;
use App\Models\Section;
use App\Models\SectionRequisition;
use App\Models\StockInDetail;
use App\Services\DepartmentRequisitionService;
use App\Services\DepartmentService;
use App\Services\DistributionService;
use App\Services\EmployeeService;
use App\Services\ProductTypeService;
use App\Services\SectionRequisitionService;
use App\Services\SectionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    private $productTypeService;
    private $sectionRequisitionService;
    private $departmentRequisitionService;
    private $departmentService;
    private $employeeService;
    private $sectionService;

    public function __construct(
        DepartmentRequisitionService $departmentRequisitionService,
        ProductTypeService $productTypeService,
        SectionRequisitionService $sectionRequisitionService,
        DepartmentService $departmentService,
        EmployeeService $employeeService,
        SectionService $sectionService
    ) {
        $this->productTypeService           = $productTypeService;
        $this->departmentRequisitionService = $departmentRequisitionService;
        $this->sectionRequisitionService    = $sectionRequisitionService;
        $this->departmentService            = $departmentService;
        $this->employeeService              = $employeeService;
        $this->sectionService               = $sectionService;
    }
    public function index()
    {
        $data['title']                          = 'অনুমোদিত চাহিদাপত্রের তালিকা';
        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $employee                           = $this->employeeService->getByID($user->employee_id);
            $sections                           = $this->sectionService->getSectionsByDepartment($employee->department_id)->toArray();

            // Extract only the "id" values into a new array
            $sectionIds = array_map(function ($section) {
                return $section['id'];
            }, $sections);

            $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll(null, 1, $sectionIds);
        } else {

            $data['sectionRequisitions']        = $this->sectionRequisitionService->getAll(null, 1);
        }

        return view('admin.requisition-management.distribution.list', $data);
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

        $data['title']         = 'চাহিদাপত্র অনুমোদন করুন';
        $data['editData']      = $this->sectionRequisitionService->getByID($id);
        $data['product_types'] = $this->productTypeService->getAll(1);

        $data['departments']    = $this->departmentService->getAll(1);

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $data['employee']           = $this->employeeService->getByID($user->employee_id);
            $data['sections']           = $this->sectionService->getSectionsByDepartment($data['employee']->department_id);
        } else {
            $data['employee']           = [];
            $data['sections']           = $this->sectionService->getAll();
        }

        return view('admin.requisition-management.distribution.add', $data);
    }

    public function store(Request $request, DistributionService $distribute)
    {
        $distribute->store($request);
        return redirect()->route('admin.pending.distribute.list')->with('success', 'Data successfully updated!');
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

    public function pendingDistribute()
    {
        $data['title']              = 'পন্য বিতরনের তালিকা';
        $data['pendingDistributes'] = $this->sectionRequisitionService->getAll(null, 3);
        return view('admin.requisition-management.distribution.pending', $data);
    }
    public function approveDistribute()
    {
        $data['title']              = 'বিতরণ করা পন্যের এর তালিকা';
        $data['approveDistributes'] = $this->sectionRequisitionService->getAll(null, 4);
        return view('admin.requisition-management.distribution.approve', $data);
    }
    public function productDistributeEdit($id)
    {
        $data['title']         = 'পন্য বিতরন করুন';
        $data['editData']      = $this->sectionRequisitionService->getByID($id);
        $data['product_types'] = $this->productTypeService->getAll(1);

        $data['departments'] = $this->departmentService->getAll(1);

        $user = Auth::user();
        if ($user->id !== 1 && $user->employee_id) {
            $data['employee']           = $this->employeeService->getByID($user->employee_id);
            $data['sections']           = $this->sectionService->getSectionsByDepartment($data['employee']->department_id);
        } else {
            $data['employee']           = [];
            $data['sections']           = $this->sectionService->getAll();
        }

        return view('admin.requisition-management.distribution.distribute', $data);
    }

    public function productDistribute(Request $request)
    {

        DB::beginTransaction();

        try {
            foreach ($request->distribute_quantity as $key => $quantity) {
                $stocks = StockInDetail::where('product_information_id', $key)
                    ->where('available_qty', '>', 0)
                    ->get();

                $quantityToDistribute = $quantity;

                foreach ($stocks as $stock) {
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
                        // $quantityToDistribute -= $stock->available_qty;
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

            SectionRequisition::where('id', $request->section_requisition_id)->update([
                'status' => 4,
            ]);
            DB::commit();
            return redirect()->route('admin.approve.distribute.list');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
