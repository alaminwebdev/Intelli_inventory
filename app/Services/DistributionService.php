<?php

namespace App\Services;

use App\Models\DepartmentRequisition;
use App\Models\DepartmentRequisitionDetails;
use App\Models\Distribute;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Services\IService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            $sectionRequisition                     = SectionRequisition::find($request->section_requisition_id);
            $sectionRequisition->final_approve_by   = Auth::id();
            $sectionRequisition->final_approve_at   = Carbon::now();
            $sectionRequisition->status             = 3;
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

    public function getMostDistributedProducts($section_ids = null, $request = null, $take = null, $days = null)
    {

        // Initialize an empty array to store the formatted data
        $formattedData = [];

        $totalSectionRequisition = SectionRequisition::when($section_ids, function ($q, $section_ids) {
            $q->whereIn('section_id', $section_ids);
        })
            ->when($request, function ($q, $request) {
                if (($request['date_from'] != null || $request['date_to'] != null)) {
                    $fromDate   = date('Y-m-d', strtotime($request['date_from']));
                    $toDate     = date('Y-m-d', strtotime($request['date_to']));
                    $q->whereDate('updated_at', '>=', $fromDate);
                    $q->whereDate('updated_at', '<=', $toDate);
                }
            })
            ->when($days, function ($q, $days) {
                $days_ago = now()->subDays($days);
                $q->whereDate('updated_at', '>=', $days_ago);
            })
            ->pluck('id');


        if ($totalSectionRequisition) {
            $mostDistributedProducts = Distribute::whereIn('section_requisition_id', $totalSectionRequisition)
                ->join('product_information', 'product_information.id', 'distributes.product_id')
                ->leftjoin('units', 'units.id', 'product_information.unit_id')
                ->select(
                    'product_id',
                    'product_information.name as product',
                    'units.name as unit',
                    DB::raw('SUM(distribute_quantity) as total_distribute_qty')
                )
                ->groupBy('distributes.product_id', 'product_information.name', 'units.name')
                ->orderByDesc('total_distribute_qty')
                ->when($take, function ($q, $take) {
                    $q->take($take);
                })
                ->get();

            // Modify the product names to keep only the unique first word and append an index when needed
            $uniqueProducts = [];
            
            // Iterate through the retrieved data and format it
            foreach ($mostDistributedProducts as $product) {

                $firstWord = strtok($product->product, ' ');

                // $formattedData[] = [
                //     'product'   => $product->product . ' (' . $product->unit . ')',
                //     'quantity'  => (int) $product->total_distribute_qty,
                // ];
                if (!isset($uniqueProducts[$firstWord])) {
                    $uniqueProducts[$firstWord] = [
                        'product_short'     => $firstWord,
                        'product'           => $product->product . ' (' . $product->unit . ')',
                        'quantity'          => (int) $product->total_distribute_qty,
                    ];
                } else {

                    // If the first word already exists, append an index to the first word
                    $index = 1;
                    while (isset($uniqueProducts[$firstWord . '_' . $index])) {
                        $index++;
                    }
    
                    $uniqueProducts[$firstWord . '_' . $index] = [
                        'product_short'     => $firstWord . '_' . $index,
                        'product'           => $product->product . ' (' . $product->unit . ')',
                        'quantity'          => (int) $product->total_distribute_qty,
                    ];
                }
            }
            // Convert the uniqueProducts array back to an array of values
            $formattedData = array_values($uniqueProducts);
        }

        // Return the formatted data
        return $formattedData;
    }

    public function update(Request $request, $id)
    {

        // try {
        //     return true;
        // } catch (Exception $e) {
        //     return $e->getMessage();
        // }
    }

    public function delete($id)
    {

        // return true;
    }
}
