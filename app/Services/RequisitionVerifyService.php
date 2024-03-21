<?php

namespace App\Services;


use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\ProductInformation;
use App\Models\ProductType;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use Illuminate\Support\Facades\DB;
use App\Services\ProductAvailabilityService;

use App\Services\IService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RequisitionVerifyService
 * @package App\Services
 */
class RequisitionVerifyService implements IService
{

    protected $productAvailabilityService;

    public function __construct(ProductAvailabilityService $productAvailabilityService)
    {
        $this->productAvailabilityService = $productAvailabilityService;
    }

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

            $sectionRequisition              = SectionRequisition::find($id);
            $sectionRequisition->verify_by   = Auth::id();
            $sectionRequisition->verify_at   = Carbon::now();
            $sectionRequisition->status      = 6;
            $sectionRequisition->save();

            foreach ($request->verify_quantity as $productId => $verify_quantity_value) {
                $sectionRequisitionDetails                  = SectionRequisitionDetails::where('section_requisition_id', $id)->where('product_id', $productId)->first();
                $sectionRequisitionDetails->verify_quantity = $verify_quantity_value ?? 0;
                $sectionRequisitionDetails->verify_remarks  = $request->remarks[$productId];
                $sectionRequisitionDetails->status          = 6;
                $sectionRequisitionDetails->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function confirm(Request $request)
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

            $sectionRequisition             = SectionRequisition::find($request->id);
            $sectionRequisition->status     = 6;
            $sectionRequisition->verify_by = Auth::id();
            $sectionRequisition->verify_at = Carbon::now();

            if ($sectionRequisition->save()) {
                // Update SectionRequisitionDetails status and verify_quantity for each row
                $details = SectionRequisitionDetails::where('section_requisition_id', $request->id)->get();


                foreach ($details as $detail) {
                    // Get available stock for the product
                    $availableStock = $this->productAvailabilityService->getAvailableStock($detail->product_id, $request->id);

                    // Check if the array is not empty
                    if (!empty($availableStock)) {

                        // Compare available_qty with recommended_quantity
                        if ($availableStock['available_qty'] < $detail->recommended_quantity) {
                            DB::rollBack();
                            return response()->json([
                                'status' => 'error',
                                'message' => 'এই পণ্যের জন্য পর্যাপ্ত স্টক নেই: ' . $availableStock['name'],
                            ]);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'এই পণ্যের জন্য পর্যাপ্ত স্টক নেই: ' . @$detail->product->name,
                        ]);
                    }

                    // Update SectionRequisitionDetails
                    SectionRequisitionDetails::where('id', $detail->id)->update([
                        'status' => 6,
                        'verify_quantity' => $detail->recommended_quantity,
                    ]);
                }
            }
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Successfully Updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
    }
}
