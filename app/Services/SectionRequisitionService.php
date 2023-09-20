<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class SectionRequisitionService
 * @package App\Services
 */
class SectionRequisitionService implements IService
{

    public function getAll($section_id = null, $status = null, $section_ids = null)
    {
        try {
            $query = SectionRequisition::latest();
            if ($section_id) {
                $query->where('section_id', $section_id);
            }
            if ($status) {
                $query->where('status', $status);
            }
            if ($section_ids) {
                $query->whereIn('section_id', $section_ids);
            }
            $data = $query->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getAllBySections($section_ids, $status)
    {
        try {
            $data = SectionRequisition::whereIn('section_id', $section_ids)->where('status', $status)->whereNull('department_requisition_id')->latest()->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getRequisitionProductsByIDs($section_ids)
    {
        try {

            $data =  DB::table('section_requisition_details')
                ->whereIn('section_requisition_details.section_requisition_id', $section_ids)
                ->select(
                    'section_requisition_details.product_id',
                    DB::raw('SUM(section_requisition_details.current_stock) as total_current_stock'),
                    DB::raw('SUM(section_requisition_details.demand_quantity) as total_demand_quantity'),
                )
                ->groupBy('section_requisition_details.product_id')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUniqueRequisitionNo()
    {
        do {
            $requisition_no = rand(10000, 99999);
        } while (SectionRequisition::where('requisition_no', $requisition_no)->exists());

        return $requisition_no;
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->input('data');
            $sectionRequisition = new SectionRequisition();

            $sectionRequisition->requisition_no = $data['requisitionNumber'];
            $sectionRequisition->section_id     = $data['sectionId'];
            $sectionRequisition->user_id        = Auth::id();
            $sectionRequisition->status         = 0;

            if ($sectionRequisition->save()) {
                $productData = $data['productData'];
                foreach ($productData as $productId => $productDetails) {
                    // Retrieve data for the current product
                    $currentStock   = $productDetails['current_stock'] ?? null;
                    $demandQuantity = $productDetails['demand_quantity'] ?? null;
                    $remarks        = $productDetails['remarks'] ?? null;
                    

                    if ($demandQuantity !== null && $demandQuantity > 0) {
                        // Store Data into SectionRequisitionDetails
                        $sectionRequisitionDetails                          = new SectionRequisitionDetails();
                        $sectionRequisitionDetails->section_requisition_id  = $sectionRequisition->id;
                        $sectionRequisitionDetails->requisition_no          = $data['requisitionNumber'];
                        $sectionRequisitionDetails->product_id              = $productId;
                        $sectionRequisitionDetails->current_stock           = $currentStock;
                        $sectionRequisitionDetails->demand_quantity         = $demandQuantity;
                        $sectionRequisitionDetails->remarks                 = $remarks;
                        $sectionRequisitionDetails->status                  = 0;
                        $sectionRequisitionDetails->save();
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
        $data = SectionRequisition::find($id);
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
