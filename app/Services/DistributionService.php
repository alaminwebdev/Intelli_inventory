<?php

namespace App\Services;

use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Services\IService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DistributionService
 * @package App\Services
 */
class DistributionService implements IService
{

    public function getAll($status = null)
    {
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
    }
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {

            $sectionRequisition = SectionRequisition::find($request->section_requisition_id);
            $sectionRequisition->final_approve_by = auth()->user()->id;
            $sectionRequisition->final_created_at = Carbon::now();
            $sectionRequisition->status           = 3;
            $sectionRequisition->save();

            foreach ($request->approve_quantity as $productId => $approve_quantity_value) {
                $sectionRequisitionDetails                         = SectionRequisitionDetails::where('section_requisition_id', $request->section_requisition_id)->where('product_id', $productId)->first();
                $sectionRequisitionDetails->final_approve_quantity = $approve_quantity_value ?? 0;
                $sectionRequisitionDetails->final_approve_remarks  = $request->remarks[$productId];
                $sectionRequisitionDetails->status                 = 3;
                $sectionRequisitionDetails->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {

        try {

            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {

        return true;
    }
}
