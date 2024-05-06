<?php

namespace App\Services;

use App\Models\ProductInformation;
use App\Models\ProductPoInfo;
use App\Models\ProductType;
use App\Models\SectionRequisition;
use App\Models\SectionRequisitionDetails;
use App\Models\StockInDetail;
use App\Services\IService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\CurrentStockService;

/**
 * Class ProductInformationService
 * @package App\Services
 */
class ProductInformationService implements IService
{
    private $currentStockService;

    public function __construct(
        CurrentStockService $currentStockService

    ) {
        $this->currentStockService    = $currentStockService;
    }

    public function getAll($statuses = null)
    {
        try {
            $data = ProductInformation::join('product_types', 'product_types.id', 'product_information.product_type_id')
                ->join('units', 'units.id', 'product_information.unit_id')
                ->select(
                    'product_information.*',
                    'units.name as unit',
                    'product_types.name as product_type',
                )
                ->when($statuses, function ($query, $statuses) {
                    $query->whereIn('product_information.status', $statuses);
                })
                //->latest()
                ->orderBy('id', 'asc')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getSpecificProducts($ids = null)
    {
        try {
            $data = ProductInformation::whereIn('id', $ids)->where('status', 1)->orderBy('id', 'asc')->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function getPoProducts($po_no, $product_ids = null)
    {
        try {
            $data =  DB::table('product_information')
                ->select(
                    'product_information.id as product_id',
                    'product_information.name as product',
                    'units.name as unit',
                    DB::raw('MAX(stock_in_details.po_qty) as po_qty'),
                    DB::raw('SUM(stock_in_details.receive_qty) as receive_qty'),
                    DB::raw('MIN(stock_in_details.reject_qty) as reject_qty')
                )
                ->leftJoin('stock_in_details', 'product_information.id', '=', 'stock_in_details.product_information_id')
                ->leftJoin('units', 'units.id', '=', 'product_information.unit_id')
                ->where('stock_in_details.po_no', '=', $po_no)
                ->when($product_ids, function ($query, $product_ids) {
                    if ($product_ids != null) {
                        $query->whereIn('stock_in_details.product_information_id', $product_ids);
                    }
                })
                // ->where('stock_in_details.reject_qty', '>', 0)
                ->groupBy('product_information.id', 'product_information.name', 'units.name')
                ->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductsByTypeId($ids)
    {
        try {
            $data = ProductInformation::whereIn('product_type_id', $ids)->where('status', 1)->orderBy('id', 'asc')->get();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getProductTypeAndProducts()
    {
        try {
            $productTypeData    = [];
            $product_types      = ProductType::where('status', 1)->orderBy('id', 'asc')->get();

            foreach ($product_types as $item) {
                $productType = [
                    'id'        => $item->id,
                    'name'      => $item->name,
                    'products'  => [],
                ];

                // Query products for this product type and push them into the products array
                $products = ProductInformation::where('product_type_id', $item->id)
                    ->where('status', 1)
                    ->orderBy('id', 'asc')
                    ->get();

                if (count($products) > 0) {

                    foreach ($products as $product) {
                        $productType['products'][$product->id] = [
                            'id'                => $product->id,
                            'name'              => $product->name,
                            'unit'              => $product->unit->name,
                            'code'              => $product->code,
                        ];
                    }
                    // Push this product type data into the main array AFTER adding products
                    $productTypeData[] = $productType;
                }
            }
            return $productTypeData;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $data               = new ProductInformation();
            $data->code             = $request->code;
            $data->name             = $request->name;
            $data->product_type_id  = $request->product_type_id;
            $data->unit_id          = $request->unit_id;
            $data->status           = $request->status ?? 0;
            $data->save();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getByID($id)
    {
        $data = ProductInformation::find($id);
        return $data;
    }
    public function update(Request $request, $id)
    {
        try {
            $data                   = ProductInformation::find($id);
            $data->code             = $request->code;
            $data->name             = $request->name;
            $data->product_type_id  = $request->product_type_id;
            $data->unit_id          = $request->unit_id;
            $data->status           = $request->status ?? 0;
            $data->save();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = ProductInformation::find($id);
        $user->delete();
        return true;
    }

    public function getProductStatistics($section_ids = null, $request = null)
    {

        // Initialize an empty array to store the formatted data
        $formattedData  = [];
        $fromDate       = date('Y-m-d', strtotime($request['date_from'] ?? 'today'));
        $toDate         = date('Y-m-d', strtotime($request['date_to'] ?? 'today'));

        $totalSectionRequisition = SectionRequisition::when($section_ids, function ($q, $section_ids) {
            $q->whereIn('section_id', $section_ids);
        })
            ->when($request, function ($q, $request) use ($fromDate, $toDate) {
                if (($request['date_from'] != null || $request['date_to'] != null)) {
                    // $q->whereDate('created_at', '>=', $fromDate);
                    // $q->whereDate('created_at', '<=', $toDate);
                    $q->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);
                }
            })
            ->pluck('id');


        if ($totalSectionRequisition) {
            $productStatistics = SectionRequisitionDetails::whereIn('section_requisition_details.section_requisition_id', $totalSectionRequisition)
                ->join('product_information', 'product_information.id', 'section_requisition_details.product_id')
                ->leftjoin('units', 'units.id', 'product_information.unit_id')
                ->leftjoin('distributes', function ($join) use($request,$fromDate, $toDate) {
                    $join->on('distributes.product_id', '=', 'product_information.id')
                        ->on('distributes.section_requisition_id', '=', 'section_requisition_details.section_requisition_id');
                    
                        if ((@$request['date_from'] != null || @$request['date_to'] != null)) {
                            $join->whereBetween('distributes.created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);
                        }
                })
                ->select(
                    'section_requisition_details.product_id as product_id',
                    'product_information.name as product',
                    'units.name as unit',
                    DB::raw('SUM(distributes.distribute_quantity) as total_distribute_qty'),
                    DB::raw('SUM(demand_quantity) as total_demand_quantity')
                )
                ->groupBy('section_requisition_details.product_id', 'product_information.name', 'units.name')
                ->orderByDesc('total_distribute_qty')
                ->get();


            // Iterate through the retrieved data and format it
            foreach ($productStatistics as $product) {
                // Fetch current stock for the product
                $currentStock = $this->currentStockService->getByProductWithSum($product->product_id);

                // Fetch stock which was for that date
                if ((@$request['date_from'] != null || @$request['date_to'] != null)) {
                    $temporaryStock = $this->currentStockService->getTemporaryStock($product->product_id, $fromDate, $toDate, $totalSectionRequisition);
                } else {
                    $temporaryStock = (int) @$currentStock->available_qty;
                }

                $formattedData[] = [
                    'id'                    => $product->product_id,
                    'product'               => $product->product,
                    'unit'                  => $product->unit,
                    'demand_quantity'       => (int) $product->total_demand_quantity,
                    'distribute_quantity'   => (int) $product->total_distribute_qty,
                    'current_stock'         => (int) @$currentStock->available_qty,
                    'temporary_stock'       => $temporaryStock,
                ];
            }
        }

        // Return the formatted data
        return $formattedData;
    }

    public function getExpiringSoonProducts($productIds, $days)
    {

        $today = Carbon::now();
        $daysLater = $today->copy()->addDays($days);

        $expiringProducts = StockInDetail::where(function ($query) use ($today, $daysLater) {
            $query->whereNull('expire_date') // Include products with NULL expiration dates
                ->orWhereBetween('expire_date', [$today, $daysLater]);
        })
            ->whereIn('stock_in_details.product_information_id', $productIds)
            ->join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
            ->leftjoin('units', 'units.id', 'product_information.unit_id')
            ->select(
                'product_information_id',
                'product_information.name as product',
                'units.name as unit',
                'stock_in_details.expire_date as expire_date',
                'stock_in_details.po_no as po_no'
            )
            ->get();
        return $expiringProducts;
    }
}
