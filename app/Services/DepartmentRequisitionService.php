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
                $query->where('department_id', $department_id);
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
            $data = $request->input('data');

            $departmentRequisition                  = new DepartmentRequisition();
            $departmentRequisition->requisition_no  = $data['requisitionNo'];
            $departmentRequisition->user_id         = Auth::id();
            $departmentRequisition->department_id   = $data['departmentId'];
            $departmentRequisition->status          = 0;

            if ($departmentRequisition->save()) {
                $productData = $data['productData'];

                foreach ($productData as $productId => $productDetails) {
                    // Retrieve data for the current product
                    $sectionCurrentStock        = $productDetails['section_current_stock'] ?? null;
                    $sectionDemandQuantity      = $productDetails['section_demand_quantity'] ?? null;
                    $departmentCurrentStock     = $productDetails['department_current_stock'] ?? null;
                    $departmentDemandQuantity   = $productDetails['department_demand_quantity'] ?? null;
                    $remarks                    = $productDetails['remarks'] ?? null;

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

                $sectionRequisitionIds = $data['sectionRequisitionIds'] ?? null;

                if ($sectionRequisitionIds && is_array($sectionRequisitionIds)) {
                    // Store department requisition id into SectionRequisition
                    foreach ($sectionRequisitionIds as $key => $value) {
                        $storeDepartmentRequisitionId                               = SectionRequisition::find($value);
                        if ($storeDepartmentRequisitionId) {
                            // Associate this Section Requisition with the Department Requisition
                            $storeDepartmentRequisitionId->department_requisition_id = $departmentRequisition->id;
                            $storeDepartmentRequisitionId->save();
                        }
                    }
                }
            }
            DB::commit();
            return response()->json(['success' => 'Requisition Information Inserted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
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
