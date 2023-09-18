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

    public function getApprovedRequisitionProductsByType($id, $status = null)
    {
        $productTypeData = [];
        $product_types = ProductType::latest()->where('status', 1)->get();

        foreach ($product_types as $item) {
            $productType = [
                'id' => $item->id,
                'name' => $item->name,
                'products' => [],
            ];

            // Query products for this product type and push them into the products array
            $productIds = ProductInformation::where('product_type_id', $item->id)
                ->latest()
                ->pluck('id');

            $requisitionProducts = DepartmentRequisitionDetails::where('department_requisition_id', $id)
                ->whereIn('product_id', $productIds)
                ->get();

            if (count($requisitionProducts) > 0) {

                foreach ($requisitionProducts as $product) {
                    $productType['products'][$product->product_id] = [
                        'product_id' => $product->product_id,
                        'product_name' => $product->product->name,
                        'current_stock' => $product->current_stock,
                        'demand_quantity' => $product->demand_quantity,
                        'remarks' => $product->remarks,
                        'approve_quantity' => $product->approve_quantity ?? $product->demand_quantity,
                        'approve_remarks' => $product->approve_remarks,
                        'final_approve_quantity' => $product->final_approve_quantity,
                        'final_approve_remarks' => $product->final_approve_remarks,
                    ];
                }
    
                // Push this product type data into the main array AFTER adding products
                $productTypeData[] = $productType;
            }

        }
        return $productTypeData;
    }
}
