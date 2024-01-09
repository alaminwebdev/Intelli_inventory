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
 * Class RequisitionReceiveService
 * @package App\Services
 */
class RequisitionReceiveService implements IService
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

            $sectionRequisition             = SectionRequisition::find($id);
            $sectionRequisition->status     = 5;
            $sectionRequisition->receive_by = Auth::id();
            $sectionRequisition->receive_at = Carbon::now();

            if ($sectionRequisition->save()) {
                SectionRequisitionDetails::where('section_requisition_id', $id)->update([
                    'status' => 5,
                ]);
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
