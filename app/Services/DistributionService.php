<?php

namespace App\Services;

use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Services\IService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DistributionService
 * @package App\Services
 */
class DistributionService implements IService {

    public function getAll($status = null) {
        try {

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request) {
        try {

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id) {

    }
    public function store(Request $request) {
        $departmentRequisition = DepartmentRequisition::find($request->department_requisition_id);
        DB::beginTransaction();
        try {

            $departmentRequisition->final_approve_by = auth()->user()->id;
            $departmentRequisition->final_created_at = Carbon::now();
            $departmentRequisition->status           = 3;
            $departmentRequisition->save();

            foreach ($request->distribute_quantity as $key => $data) {
                $DepartmentRequisitionDetails                         = DepartmentRequisitionDetails::where('department_requisition_id', $request->department_requisition_id)->where('product_id', $key)->first();
                $DepartmentRequisitionDetails->final_approve_quantity = $data ?? 0;
                $DepartmentRequisitionDetails->final_approve_remarks  = $request->remarks[$key];
                $DepartmentRequisitionDetails->status                 = 3;
                $DepartmentRequisitionDetails->save();
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id) {

        try {

            return true;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id) {

        return true;
    }
}
