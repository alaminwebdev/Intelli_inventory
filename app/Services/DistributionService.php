<?php

namespace App\Services;

use App\Models\DepartmentRequisition;
use App\Models\Distribute;
use App\Models\DistributeDetail;
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
        DB::beginTransaction();
        try {

            $distribute                            = new Distribute();
            $distribute->department_requisition_id = $request->department_requisition_id;
            $distribute->department_id             = $request->department_id;
            $distribute->requisition_no            = $request->requisition_no;
            $distribute->approved_by               = auth()->user()->id;
            $distribute->approved_at               = Carbon::now();
            $distribute->status                    = 1;
            $distribute->save();

            foreach ($request->department_demand_quantity as $key => $data) {
                $distributeDetailes                      = new DistributeDetail();
                $distributeDetailes->department_id       = $request->department_id;
                $distributeDetailes->distribute_id       = $distribute->id;
                $distributeDetailes->product_id          = $key;
                $distributeDetailes->demand_quantity     = $data;
                $distributeDetailes->distribute_quantity = $request->distribute_quantity[$key] ?? 0;
                $distributeDetailes->remarks             = $request->remarks[$key];
                $distributeDetailes->status              = 1;
                $distributeDetailes->save();
            }

            $DepartmentRequisition = DepartmentRequisition::where('requisition_no', $request->requisition_no)->first();

            $DepartmentRequisition->status = 3;
            $DepartmentRequisition->save();

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
