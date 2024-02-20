<?php

namespace App\Services;

use App\Models\SectionRequisition;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CurrentStockService;

/**
 * Class ProductAvailabilityService
 * @package App\Services
 */
class ProductAvailabilityService
{
    protected $currentStockService;

    public function __construct(CurrentStockService $currentStockService)
    {
        $this->currentStockService = $currentStockService;
    }

    public function getAvailableStock($product_id, $requisition_id = null)
    {

        try {
            // Get current stock
            $currentStock = $this->currentStockService->getByProductWithSum($product_id);

            // Get reserved stock of requisition
            $reservedStock = $this->getReservedStock($product_id, $requisition_id);

            // Calculate reserved stock
            $availableStock  = [
                'product_id'        => @$currentStock->product_id,
                'name'              => @$currentStock->product_name,
                'unit'              => @$currentStock->unit_name,
                'available_qty'     => max(0, @$currentStock->available_qty - @$reservedStock->req_qty),
            ];

            return $availableStock;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getReservedStock($product_id, $requisition_id = null)
    {
        /**
         *  Working steps of this function
         *  1.  Get reserved stock  which is need to check following conditions
         *      a. product_id id is equal to requested product_id id of requisition
         *      b. Requisition status is Created then requisition qty is demand_quantity
         *      c. Requisition status is Recommended then requisition qty is recommended_quantity
         *      c. Requisition status is Verified then requisition qty is verify_quantity
         *      e. Sum of that quantity is reserved qty of that products
         *  2.  Status
         *      a. Status 0 = Created, 
         *      b. Status 1 = Requisition Recommended,
         *      c. Status 2 = Requisition Reject,
         *      d. Status 3 = Final Approved,
         *      f. Status 4 = Distributed (Stock Update)
         *      g. Status 5 = Received,
         *      h. Status 6 = Verify
         */

        $reserveStock = SectionRequisition::join('section_requisition_details', 'section_requisition_details.section_requisition_id', 'section_requisitions.id')
            ->join('product_information', 'product_information.id', 'section_requisition_details.product_id')
            ->leftJoin('units', 'units.id', 'product_information.unit_id')
            ->whereIn('section_requisitions.status', [0, 1, 6])
            ->when($requisition_id, function ($query, $requisition_id) {
                $query->whereNotIn('section_requisitions.id', [$requisition_id]);
            })
            ->where('section_requisition_details.product_id', $product_id)
            ->select(
                'product_information.id as product_id',
                // DB::raw('SUM(
                //     CASE 
                //         WHEN section_requisitions.status = 1 THEN section_requisition_details.recommended_quantity 
                //         WHEN section_requisitions.status = 6 THEN section_requisition_details.verify_quantity 
                //         ELSE section_requisition_details.demand_quantity 
                //     END
                // ) as req_qty'),
                DB::raw('SUM(COALESCE(section_requisition_details.verify_quantity, section_requisition_details.recommended_quantity, section_requisition_details.demand_quantity)) as req_qty')
            )
            ->groupBy('product_information.id')
            ->first();

        return $reserveStock;
    }
}
