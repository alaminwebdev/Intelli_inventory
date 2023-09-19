<?php

namespace App\Services;


use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Models\SectionRequisition;
use Illuminate\Support\Facades\DB;


use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RequisitionApprovalService
 * @package App\Services
 */
class RequisitionApprovalService implements IService
{

    public function getAll()
    {
    }

    public function create(Request $request)
    {
    }

    public function getByID($id)
    {
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $departmentRequisition                  = DepartmentRequisition::find($id);
            $departmentRequisition->status          = $request->status;

            if ($departmentRequisition->save()) {
                if ($request->status == 1) {

                    // Get all form data arrays
                    $productTypesData               = $request->input('product_type');
                    $departmentDemandQuantityData   = $request->input('department_demand_quantity');
                    $approveQuantityData            = $request->input('approve_quantity');
                    $remarksData                    = $request->input('remarks');
                    $approveRemarksData             = $request->input('approve_remarks');

                    // Loop through the product types data (keys are product IDs, values are product type IDs)
                    foreach ($productTypesData as $productId => $productTypeId) {
                        // Retrieve data for the current product
                        $departmentDemandQuantity   = $departmentDemandQuantityData[$productId];
                        $approveQuantity            = $approveQuantityData[$productId];
                        $remarks                    = $remarksData[$productId];
                        $approveRemarks             = $approveRemarksData[$productId];

                        if ($departmentDemandQuantity !== null) {
                            // Store Data into DepartmentRequisitionDetails
                            $departmentRequisitionDetails                               = DepartmentRequisitionDetails::where('department_requisition_id', $id)->where('product_id', $productId)->first();
                            $departmentRequisitionDetails->approve_quantity             = $approveQuantity ?? $departmentDemandQuantity;
                            $departmentRequisitionDetails->remarks                      = $remarks;
                            $departmentRequisitionDetails->approve_remarks              = $approveRemarks;
                            $departmentRequisitionDetails->status                       = 1;
                            $departmentRequisitionDetails->save();
                        }
                    }
                }

                // Store department requisition status into SectionRequisition
                SectionRequisition::where('department_requisition_id', $id)->update(['status' =>  $request->status]);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
    }
}
