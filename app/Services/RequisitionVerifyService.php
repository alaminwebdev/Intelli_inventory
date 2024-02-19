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
 * Class RequisitionVerifyService
 * @package App\Services
 */
class RequisitionVerifyService implements IService
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
