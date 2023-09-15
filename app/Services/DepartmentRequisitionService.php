<?php

namespace App\Services;


use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\SectionRequisition;
use Illuminate\Support\Facades\DB;


use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class DepartmentRequisitionService
 * @package App\Services
 */
class DepartmentRequisitionService implements IService
{

    public function getAll($department_id = null, $status = null)
    {
        try {
            $query = DepartmentRequisition::latest();
            if ($department_id) {
                $query->where('section_id', $department_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getUniqueRequisitionNo()
    {
        do {
            $requisition_no = rand(10000, 99999);
        } while (DepartmentRequisition::where('requisition_no', $requisition_no)->exists());

        return $requisition_no;
    }

    public function create(Request $request)
    {

        DB::beginTransaction();
        try {

            $departmentRequisition = new DepartmentRequisition();

            $departmentRequisition->requisition_no  = $request->requisition_no;
            $departmentRequisition->user_id         = Auth::id();
            $departmentRequisition->status = 0;

            if ($departmentRequisition->save()) {
                // Get all form data arrays
                $productTypesData               = $request->input('product_type');
                $sectionCurrentStockData        = $request->input('section_current_stock');
                $sectionDemandQuantityData      = $request->input('section_demand_quantity');
                $departmentCurrentStockData     = $request->input('department_current_stock');
                $departmentDemandQuantityData   = $request->input('department_demand_quantity');
                $remarksData                    = $request->input('remarks');

                // Loop through the product types data (keys are product IDs, values are product type IDs)
                foreach ($productTypesData as $productId => $productTypeId) {
                    // Retrieve data for the current product
                    $sectionCurrentStock        = $sectionCurrentStockData[$productId];
                    $sectionDemandQuantity      = $sectionDemandQuantityData[$productId];
                    $departmentCurrentStock     = $departmentCurrentStockData[$productId];
                    $departmentDemandQuantity   = $departmentDemandQuantityData[$productId];
                    $remarks                    = $remarksData[$productId];

                    if ($departmentDemandQuantity !== null || $sectionDemandQuantity !== null) {
                        // Store Data into DepartmentRequisitionDetails
                        $departmentRequisitionDetails                               = new DepartmentRequisitionDetails();
                        $departmentRequisitionDetails->department_requisition_id    = $departmentRequisition->id;
                        $departmentRequisitionDetails->product_id                   = $productId;
                        $departmentRequisitionDetails->current_stock                = $departmentCurrentStock ?? $sectionCurrentStock;
                        $departmentRequisitionDetails->demand_quantity              = $departmentDemandQuantity ?? $sectionDemandQuantity;
                        $departmentRequisitionDetails->remarks                      = $remarks;
                        $departmentRequisitionDetails->status                       = 0;
                        $departmentRequisitionDetails->save();
                    }
                }

                // Store department requisition id into SectionRequisition
                if ($request->has('section_requisition_id')) {
                    foreach ($request->section_requisition_id as $key => $value) {
                        $storeDepartmentRequisitionId                               = SectionRequisition::find($value);
                        $storeDepartmentRequisitionId->department_requisition_id    = $departmentRequisition->id;
                        $storeDepartmentRequisitionId->save();
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = DepartmentRequisition::find($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        // try {
        //     $data                 = Section::find($id);
        //     $data->name           = $request->name;
        //     $data->department_id  = $request->department_id;
        //     $data->sort           = $request->sort;
        //     $data->status         = $request->status;
        //     $data->save();
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function delete($id)
    {
        // $user = Section::find($id);
        // $user->delete();
        // return true;
    }
}
