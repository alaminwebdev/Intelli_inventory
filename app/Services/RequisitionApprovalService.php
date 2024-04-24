<?php

namespace App\Services;


use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use Illuminate\Support\Facades\DB;


use App\Services\IService;
use Carbon\Carbon;
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
        // Increase max_execution_time to 2 hours (7200 seconds)
        ini_set('max_execution_time', 7200);

        // Set max_input_time to 2 hours (7200 seconds)
        ini_set('max_input_time', 7200);

        // Increase memory_limit to unlimited
        ini_set('memory_limit', '-1'); // '-1' indicates unlimited memory

        // Set max_input_vars to 5000
        ini_set('max_input_vars', 5000);

        DB::beginTransaction();
        try {

            $sectionRequisition                         = SectionRequisition::find($id);
            $sectionRequisition->status                 = $request->status;
            $sectionRequisition->recommended_by         = Auth::id();
            $sectionRequisition->recommended_at         = Carbon::now();

            if ($sectionRequisition->save()) {
                if ($request->status == 1) {

                    // Get all form data arrays
                    $productTypesData               = $request->input('product_type');
                    $sectionDemandQuantityData      = $request->input('section_demand_quantity');
                    $recommendedQuantityData        = $request->input('recommended_quantity');
                    $recommendedRemarksData         = $request->input('recommended_remarks');

                    // Loop through the product types data (keys are product IDs, values are product type IDs)
                    foreach ($productTypesData as $productId => $productTypeId) {
                        // Retrieve data for the current product
                        $sectionDemandQuantity      = $sectionDemandQuantityData[$productId];
                        $recommendedQuantity        = $recommendedQuantityData[$productId];
                        $recommendedRemarks         = $recommendedRemarksData[$productId];

                        if ($sectionDemandQuantity !== null) {
                            // Store Data into SectionRequisitionDetails
                            $sectionRequisitionDetails                          = SectionRequisitionDetails::where('section_requisition_id', $id)->where('product_id', $productId)->first();
                            $sectionRequisitionDetails->recommended_quantity    = $recommendedQuantity ?? $sectionDemandQuantity;
                            $sectionRequisitionDetails->recommended_remarks     = $recommendedRemarks;
                            $sectionRequisitionDetails->status                  = 1;
                            $sectionRequisitionDetails->save();
                        }
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

    public function delete($id)
    {
    }
}
